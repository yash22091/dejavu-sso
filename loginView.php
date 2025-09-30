<!-- Header.php. Contains header content -->
<?php 
include 'template/header.php';

// Check if SSO is enabled from environment
require_once __DIR__ . '/config/env.php';
$env = load_env(__DIR__ . '/.env');
$sso_enabled = isset($env['SSO_ENABLE']) && strtolower($env['SSO_ENABLE']) === 'true';
?>
<body class="hold-transition login-page">
<div class="fullwh is-flex is-flex-direction-row is-align-items-center is-justify-content-center">
  <div class="w-34 is-align-items-center is-justify-content-center is-flex is-flex-direction-column roboto-regular">
      <div class="white-box pb-5 is-justify-content-center">
      <img class="p-5 is-align-items-center pb-2 fullw omdr-logo" src="UIElements/dist/img/xdr-logo-1.png" alt="OMDR Logo">
      <?php if(isset($_GET["pass"]) && $_GET["pass"] == 'fail')
    {
    ?>
      <p class="text-red">Invalid Username/Password</p>
    <?php
    }
    ?>
    <div class="pl-2 pr-2 max-350">
    <form action="login.php" method="post">
      <div class="form-group has-feedback sign-card-content">
        <input type="username" name="username" class="form-control input" placeholder="Username">
          <i class="fa-regular fa-user icon-login-page"></i>
      </div>
      <div class="form-group has-feedback sign-card-content">
        <input type="password" name="password" class="form-control input" placeholder="Password">
          <i class="fa-solid fa-key icon-login-page"></i>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat text-center">Sign In</button>
        </div>
      </div>
    </form>
    <?php if ($sso_enabled): ?>
    <div class="row mt-3">
      <div class="col-xs-12">
  <a href="oidc_login.php" class="btn btn-primary btn-block btn-flat text-center" style="text-align: center; display: flex; align-items: center; justify-content: center;">Sign In with SSO</a>
      </div>
    </div>
    <?php endif; ?>
    </div>
    </div>
  </div>
  <div class="w-66 is-flex is-justify-content-center bg-login"></div>
</div>
<div class="login-box" style="display:none">
  <div class="login-logo">
    <b>Deception</b> | Engine
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in</p>
  
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
</html>
