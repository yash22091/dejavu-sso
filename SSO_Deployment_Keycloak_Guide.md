
# System Requirements

- **Linux server** (Debian 9 or later, Ubuntu 18.04+, or CentOS 7+)
- **Apache 2.4+** with **PHP 7.0+**
- **MySQL/MariaDB 5.7+**
- **Internet connectivity** for downloading dependencies
- **Existing Keycloak server** with administrator access

# Basic Knowledge

- Basic understanding of Linux commands (`cd`, `ls`, `nano`/`vim`, `systemctl`)
- Familiarity with editing configuration files in PHP
- Admin access to your server and Keycloak

# Required PHP Extensions

Install the required PHP extensions:

```bash
sudo apt-get update
sudo apt-get install php php-mysql php-curl php-json php-mbstring php-xml php-zip
```

# Composer Installation

Download and install Composer:

```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify installation
composer --version
```

# SSO Deployment & Keycloak Configuration Guide

## 1. Download SSO Package
- Download the SSO zip file containing all necessary files from your storage (S3, OneDrive, etc.).

## 2. Copy to Dejavu Engine Server
- Transfer the downloaded zip file to your Dejavu engine server.

## 3. Unzip the Package
- Unzip the file in your desired directory:
  ```bash
  unzip sso_package.zip
  ```

## 4. Copy Files to Decoify Application
- Navigate to the unzipped folder and run:
  ```bash
  cp composer.json loginView.php logout.php oidc_login.php .env /var/www/html/Decoify/
  cp -r vendor/ /var/www/html/Decoify/
  cp main-sidebar.php /var/www/html/Decoify/template/
  ```

## 5. Restart Apache
- Restart the Apache server to apply changes:
  ```bash
  systemctl restart apache2
  ```

## 6. Configure SSO in `.env`
- Check the `.env` file:
  - If `SSO_ENABLE=false`, the SSO button will not be shown.
  - For testing, set `SSO_ENABLE=true` and restart Apache. The SSO button will appear.
- Update necessary Keycloak configuration values in `.env` (see Keycloak section below).
- Restart Apache after any `.env` changes.

---

## 7. Keycloak Server Configuration
> **Note:** You need admin access to your Keycloak server.

### 1. Access Keycloak Admin Console
- Open: `http://your-keycloak-server:8080`
- Login with admin credentials.

### 2. Create a New Realm
- Click “Master” dropdown (top-left).
- Click “Create Realm”.
- Realm name: `decoify-realm` (or your preferred name).
- Click “Create”.
- **Note:** Save the realm name for later.

### 3. Create a Client
- Go to Clients → Create client.
- Fill in:
  - Client ID: `decoify-client`
  - Client Type: OpenID Connect
  - Client authentication: ON
- Click “Next”.
- Capability settings:
  - Standard flow: ON
  - Direct access grants: ON
  - Implicit flow: OFF
- Click “Next”.
- Login settings:
  - Valid redirect URIs: `http://your-server-ip/Decoify/oidc_login.php`
  - Valid post logout redirect URIs: `http://your-server-ip/Decoify/loginView.php`
  - Web origins: `http://your-server-ip`
- Click “Save”.

### 4. Get Client Secret
- Go to Clients → `decoify-client` → Credentials tab.
- Copy the Client Secret (needed for `.env`).
- **Important:** Keep this secret secure.

### 5. Create Test Users
- Go to Users → Create new user.
- Fill in:
  - Username: `test.user@company.com`
  - Email: `test.user@company.com`
  - First name: Test
  - Last name: User
  - Email verified: ON
- Click “Create”.
- Go to Credentials tab → Set password.
- Set password, Temporary: OFF.
- Click “Save”.

### 6. Configure User Attributes (Optional)
- Go to Users → Select user → Attributes tab.
- Add custom attributes:
  - department: IT
  - role: admin
  - company: YourCompany

### 7. Configure Client Scopes (Optional)
- Go to Client scopes.
- Create custom scopes for additional user attributes.
- Assign scopes to your client under Clients → `decoify-client` → Client scopes.

---

**After completing these steps, your SSO system should be ready for use and integrated with Keycloak.**
