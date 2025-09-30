<?php

if (!isset($_SESSION)) {
    session_start();
}

// Check if user logged in via SSO
$is_sso_login = isset($_SESSION['login_method']) && $_SESSION['login_method'] === 'sso';
$id_token = isset($_SESSION['id_token']) ? $_SESSION['id_token'] : null;

// Destroy the session
session_destroy();

// If SSO login, redirect to Keycloak logout to clear SSO session
if ($is_sso_login) {
    // Load environment variables for Keycloak logout
    require_once __DIR__ . '/config/env.php';
    $env = load_env(__DIR__ . '/.env');
    
    if (isset($env['KEYCLOAK_BASE_URL']) && isset($env['KEYCLOAK_REALM'])) {
        $logout_url = rtrim($env['KEYCLOAK_BASE_URL'], '/') . '/realms/' . $env['KEYCLOAK_REALM'] . '/protocol/openid-connect/logout';
        
        // Construct proper redirect URI
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $base_path = dirname($_SERVER['SCRIPT_NAME']);
        $redirect_uri = $protocol . '://' . $host . $base_path . '/loginView.php';
        
        // Add parameters for Keycloak logout
        $params = array();
        $params['post_logout_redirect_uri'] = $redirect_uri;
        
        // Add ID token hint if available
        if ($id_token) {
            $params['id_token_hint'] = $id_token;
        }
        
        $logout_url .= '?' . http_build_query($params);
        
        header('Location: ' . $logout_url);
        exit;
    }
}

// Regular logout - redirect to login page
header('Location: loginView.php');
exit;

?>
