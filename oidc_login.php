<?php
// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if vendor/autoload.php exists
if (!file_exists('vendor/autoload.php')) {
    die('SSO dependencies not installed. Please contact administrator.');
}

require 'vendor/autoload.php';
require_once __DIR__ . '/config/env.php';

session_start();

// Load environment variables
$env = load_env(__DIR__ . '/.env');

if (!isset($env['SSO_ENABLE']) || $env['SSO_ENABLE'] !== 'true') {
    die('SSO is disabled. Please contact administrator.');
}

// Validate required config
$required_vars = array('KEYCLOAK_BASE_URL', 'KEYCLOAK_REALM', 'KEYCLOAK_CLIENT_ID', 'KEYCLOAK_CLIENT_SECRET', 'KEYCLOAK_REDIRECT_URI');
foreach ($required_vars as $var) {
    if (empty($env[$var])) {
        die("SSO configuration incomplete: $var is missing. Please contact administrator.");
    }
}

// Keycloak config from .env
$provider_url = rtrim($env['KEYCLOAK_BASE_URL'], '/') . '/realms/' . $env['KEYCLOAK_REALM'];
$client_id = $env['KEYCLOAK_CLIENT_ID'];
$client_secret = $env['KEYCLOAK_CLIENT_SECRET'];
$redirect_uri = $env['KEYCLOAK_REDIRECT_URI'];
$scope = array('openid', 'email', 'profile');

use Jumbojett\OpenIDConnectClient;

// OIDC Configuration

try {
    $oidc = new OpenIDConnectClient(
        $provider_url,
        $client_id,
        $client_secret
    );
    $oidc->setRedirectURL($redirect_uri);
    $oidc->addScope($scope);
    
    // Add debugging
    error_log("OIDC: Starting authentication");
    error_log("OIDC: Provider URL: " . $provider_url);
    error_log("OIDC: Redirect URI: " . $redirect_uri);
    
    $oidc->authenticate();
    
    error_log("OIDC: Authentication successful");

    // Get ID token for logout
    $idToken = $oidc->getIdToken();
    error_log("OIDC: ID Token retrieved: " . ($idToken ? "Yes" : "No"));

    $email = $oidc->requestUserInfo('email');
    $name  = $oidc->requestUserInfo('name');
    $userInfo = $oidc->requestUserInfo();
    
    error_log("OIDC: User email: " . $email);
    error_log("OIDC: User info: " . json_encode($userInfo));
    error_log("OIDC: Full userInfo dump: " . print_r($userInfo, true));
    
        // Set all SSO users as admin by default
        $role = 'admin';
        error_log("OIDC: Setting default role as admin for SSO users");    if (empty($email)) {
        throw new Exception("Email not received from provider.");
    }

    error_log("OIDC: Starting database operations");
    require_once 'db.php';
    $mysqli = db_connect();
    
    if (!$mysqli) {
        throw new Exception("Database connection failed");
    }
    
    error_log("OIDC: Database connected successfully");
    $stmt = $mysqli->prepare("SELECT * FROM Users WHERE Username = ? AND Status = 1;");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    error_log("OIDC: User query executed, rows found: " . $result->num_rows);

    if ($result->num_rows === 0) {
        // Create new user with role from Keycloak
        error_log("OIDC: Creating new user with role: " . $role);
        $status = 1;
        $insert = $mysqli->prepare("INSERT INTO Users (Username, Password, Role, Status) VALUES (?, '', ?, ?)");
        $insert->bind_param("ssi", $email, $role, $status);
        $insert->execute();
        $insert->close();
        error_log("OIDC: User created successfully");
        $stmt = $mysqli->prepare("SELECT * FROM Users WHERE Username = ? AND Status = 1;");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // Update existing user's role from Keycloak
        error_log("OIDC: Updating existing user with role: " . $role);
        $update = $mysqli->prepare("UPDATE Users SET Role = ? WHERE Username = ? AND Status = 1");
        $update->bind_param("ss", $role, $email);
        $update->execute();
        $update->close();
        $stmt = $mysqli->prepare("SELECT * FROM Users WHERE Username = ? AND Status = 1;");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $user = $result->fetch_assoc();
    if (!$user) {
        throw new Exception("User creation or fetch failed.");
    }

    error_log("OIDC: User data retrieved: " . json_encode($user));
    error_log("OIDC: Setting up session");

        if (function_exists('random_bytes')) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(10));
        } else {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(10));
        }
    $_SESSION['user_name'] = $user['Username'];
    $_SESSION['role'] = $user['Role'];
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['user_is_logged_in'] = true;
    $_SESSION['login_method'] = 'sso';
    $_SESSION['keycloak_roles'] = $roles;
    $_SESSION['id_token'] = $idToken; // Store ID token for logout

    error_log("OIDC: Session set up successfully, redirecting based on role: " . $_SESSION['role']);
    
            // All SSO users get admin access - redirect to main dashboard
        error_log("OIDC: Redirecting admin to add-server-decoys.php");
        header('Location: add-server-decoys.php');
        exit;

} catch (Exception $e) {
    error_log("OIDC ERROR: " . $e->getMessage());
    echo "<h3>SSO Login Failed</h3>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Error Details:</strong></p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "<p><a href='loginView.php'>Back to Login</a></p>";
    echo "<p><a href='oidc_login.php'>Try SSO Again</a></p>";
    exit;
}
