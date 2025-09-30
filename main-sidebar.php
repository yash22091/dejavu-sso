<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="UIElements/dist/img/dummy-img.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <script type="text/javascript">
        jQuery(document).ready(function($){
          // Get current path and find target link
          var path = window.location.pathname.split("/").pop();
          
          // select side menu based on page
          if ( path == 'list-decoys.php' || path == 'add-server-decoys.php' || path == 'add-client-decoys.php') {
            var target = $('.mainnav');
            // Add active class to target link
            target.addClass('active');
          }

          if ( path == 'list-decoys.php') {
            var target = $('.list-decoys');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'add-server-decoys.php') {
            var target = $('.add-server-decoys');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'add-client-decoys.php') {
            var target = $('.add-client-decoys');
            // Add active class to target link
            target.addClass('menu-link-active');
          }

          if ( path == 'add-vlans.php' || path == 'del-vlans.php' || path == 'addFiles.php' || path == 'addCerts.php')  {
            var target = $('.nwmenu');
            // Add active class to target link
            target.addClass('active');
          }
          if ( path == 'add-vlans.php') {
            var target = $('.add-vlan');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'del-vlans.php') {
            var target = $('.del-vlans');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'addFiles.php') {
            var target = $('.addFiles');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'addCertss.php') {
            var target = $('.addCertss');
            // Add active class to target link
            target.addClass('menu-link-active');
          }

          if ( path == 'search.php' || path == 'loggraph.php' || path == 'manageAlerts.php' || path == 'events.php') {
            var target = $('.logmenu');
            // Add active class to target link
            target.addClass('active');
          }
          if ( path == 'search.php') {
            var target = $('.search');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'loggraph.php') {
            var target = $('.loggraph');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'manageAlerts.php') {
            var target = $('.manageAlerts');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'events.php') {
            var target = $('.events');
            // Add active class to target link
            target.addClass('menu-link-active');
          }




          if ( path == 'crumbDecoy.php' || path == 'crumbHash.php' || path == 'crumbKerb.php' || path == 'honeyfiles.php') {
            var target = $('.breadmenu');
            // Add active class to target link
            target.addClass('active');
          }
          if ( path == 'crumbDecoy.php') {
            var target = $('.crumbDecoy');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'crumbHash.php') {
            var target = $('.crumbHash');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'crumbKerb.php') {
            var target = $('.crumbKerb');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'honeyfiles.php') {
            var target = $('.honeyfiles');
            // Add active class to target link
            target.addClass('menu-link-active');
          }



          if ( path == 'deviceSettings.php' || path == 'manageUsers.php' || path == 'cloudSettings.php' || path == 'backupSettings.php') {
            var target = $('.settings');
            // Add active class to target link
            target.addClass('active');
          }
          if ( path == 'manageUsers.php') {
            var target = $('.manageUsers');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'deviceSettings.php') {
            var target = $('.deviceSettings');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'cloudSettings.php') {
            var target = $('.cloudSettings');
            // Add active class to target link
            target.addClass('menu-link-active');
          }
          if ( path == 'backupSettings.php') {
            var target = $('.backupSettings');
            // Add active class to target link
            target.addClass('menu-link-active');
          }



        });
      </script>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview mainnav">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <i class="fa-solid fa-bars  menu-main-icon fa"></i>
        <div class="menu-hide">
        <span>Toggle navigation</span>
        </div>
        
      </a>
        </li>
        

        <li class="treeview nwmenu">
          <a href="#" class="active-menu">
        <i class="fa fa-files-o menu-main-icon"></i>
        <div class="menu-hide">
            <span>N/W and File Managment</span>
            <span class="pull-right-container">
              <i class="fas fa-caret-down menu-icon"></i>
            </span>
      </div>
          </a>
          <ul class="treeview-menu">
            <li class="menu-vis menu-inner-link">N/W and File Managment</li>
            <li class="add-vlans menu-inner-link"><a href="add-vlans.php"><i class="fa-regular fa-circle"></i> Add Vlan</a></li>
            <li class="del-vlans menu-inner-link"><a href="del-vlans.php"><i class="fa-regular fa-circle"></i> Delete Vlan</a></li>
            <li class="addFiles menu-inner-link"><a href="addFiles.php"><i class="fa-regular fa-circle"></i> Manage File Structure</a></li>
	        <li class="addCerts menu-inner-link"><a href="addCerts.php"><i class="fa-regular fa-circle"></i> Manage Certificates</a></li>
          </ul>
        </li>
        <li class="treeview mainnav">
          <a href="#" class="active-menu">
     <i class="fa fa-dashboard menu-main-icon"></i> 
     <div class="menu-hide">
            <span class="">Decoy Management</span>
            <span class="pull-right-container">
            <i class="fas fa-caret-down menu-icon"></i>
            </span>
      </div>
          </a>
          <ul class="treeview-menu">
            <li class="menu-vis menu-inner-link">Decoy Management</li>
            <li class="list-decoys menu-inner-link"><a href="list-decoys.php"><i class="fa-regular fa-circle"></i> Manage Decoys</a></li>
            <li class="add-server-decoys menu-inner-link"><a href="add-server-decoys.php"><i class="fa-regular fa-circle"></i> Add Server Decoy</a></li>
            <li class="add-client-decoys menu-inner-link"><a href="add-client-decoys.php"><i class="fa-regular fa-circle"></i> Add Client Decoy</a></li>
            
          </ul>
        </li>
        <li class="treeview breadmenu">
          <a href="#" class="active-menu">
          <i class="fa fa-th menu-main-icon"></i> 
          <div class="menu-hide">
          <span>Breadbcrumbs</span>
            <span class="pull-right-container">
            <i class="fas fa-caret-down menu-icon"></i>
            </span>
      </div>
          </a>
          <ul class="treeview-menu">
            <li class="menu-vis menu-inner-link">Breadbcrumbs</li>
            <li class="crumbDecoy menu-inner-link"><a href="crumbDecoy.php"><i class="fa-regular fa-circle"></i> Add Decoy to Domain</a></li>
            <li class="crumbHash menu-inner-link"><a href="crumbHash.php"><i class="fa-regular fa-circle"></i> Create HoneyHash</a></li>
            <li class="crumbKerb menu-inner-link"><a href="crumbKerb.php"><i class="fa-regular fa-circle"></i> Kerberoast HoneyAccount</a></li>
            <li class="honeyfiles menu-inner-link"><a href="honeyfiles.php"><i class="fa-regular fa-circle"></i> HoneyFiles</a></li> 
          </ul>
        </li>
        <li class="treeview settings">
          <a href="updateSettings.php" class="active-menu">
           <i class="fa fa-microchip menu-main-icon"></i>
           <div class="menu-hide">
            <span>Settings</span>
            <span class="pull-right-container">
            <i class="fas fa-caret-down menu-icon"></i>
            </span>
      </div>
          </a>
          <ul class="treeview-menu">
            <li class="menu-vis menu-inner-link">Settings</li>
          <li class="manageUsers menu-inner-link"><a href="manageUsers.php"><i class="fa-regular fa-circle"></i> User Management</a></li>
            <li class="deviceSettings menu-inner-link"><a href="deviceSettings.php"><i class="fa-regular fa-circle"></i> Device Settings</a></li>
            <li class="cloudSettings menu-inner-link"><a href="cloudSettings.php"><i class="fa-regular fa-circle"></i> Connection & Logging</a></li>
            <li class="backupSettings menu-inner-link"><a href="backupSettings.php"><i class="fa-regular fa-circle"></i> Backup & Upgrade</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
