<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "config/koneksi.php";
// include "../config/function.php";
include "config/fungsi_indotgl.php";
session_start();

// Pastikan sesi dimulai dengan benar
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Ganti dengan halaman login Anda
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>APLIKASI PEMESANAN MENU FUKU COFFEE</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/skin-brown.min.css">
  <!-- Boostrap Sub Menu -->
  <link rel="stylesheet" href="dist/css/bootstrap-submenu.min.css">
  <!-- Boostrap and JS Slider -->
  <link href="dist/slider/js-image-slider.css" rel="stylesheet" type="text/css" />
  <script src="dist/slider/js-image-slider.js" type="text/javascript"></script>
  <script src="plugins/slider/js/jssor.slider-21.1.6.min.js" type="text/javascript"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f3e5ab;
      color: #4b2e1e;
    }
    .navbar-static-top {
      background-color: #4b2e1e;
    }
    .navbar-brand {
      color: #f3e5ab !important;
    }
    .navbar-nav>li>a {
      color: #f3e5ab !important;
    }
    .navbar-nav>li>a:hover {
      background-color: #6f4e37 !important;
      color: #ffffff !important;
    }
    .main-footer {
      background-color: #4b2e1e;
      color: #f3e5ab;
    }
    .user-menu>.dropdown-menu>.user-header {
      background-color: #6f4e37;
    }
    .user-menu>.dropdown-menu>.user-header>p {
      color: #f3e5ab;
    }
    .user-menu>.dropdown-menu>.user-footer .btn-default {
      background-color: #4b2e1e;
      color: #f3e5ab;
      border-color: #4b2e1e;
    }
    .user-menu>.dropdown-menu>.user-footer .btn-default:hover {
      background-color: #6f4e37;
      color: #ffffff;
      border-color: #6f4e37;
    }
  </style>
</head>

<body class="hold-transition skin-brown layout-top-nav layout-boxed sidebar-mini">
  <div class="">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <?php
                  $profil = mysqli_fetch_array($mysqli->query("select * from users where username = '" . $_SESSION['username'] . "'"));
                  ?>
                  <img src="dist/img/avatar5.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"> <?php echo strtoupper($_SESSION['username']); ?> </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/avatar5.png" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $_SESSION['username']; ?> - Pelanggan
                      <small>APLIKASI PEMESANAN MENU FUKU COFFEE</small>
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="page/logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-custom-menu -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>

    <!-- Main content -->
    <?php include "HalamanAwal.php"; ?>
    <!-- /.content -->

    <footer class="main-footer">
      <div class="container">
        <div class="pull-right hidden-xs">
          <b></b>
        </div>
        <strong><a href="#" style="color: #f3e5ab;">FUKU COFFEE</a></strong>
      </div><!-- /.container -->
    </footer>
  </div><!-- ./wrapper -->

  <!-- jQuery 2.1.4 -->
  <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="plugins/fastclick/fastclick.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="dist/js/bootstrap-submenu.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $(".dropdown-submenu").click(function(event) {
        // stop bootstrap.js to hide the parents
        event.stopPropagation();
        // hide the open children
        $(this).find(".dropdown-submenu").removeClass('open');
        // add 'open' class to all parents with class 'dropdown-submenu'
        $(this).parents(".dropdown-submenu").addClass('open');
        // this is also open (or was)
        $(this).toggleClass('open');
      });
    });
  </script>

</body>

</html>
