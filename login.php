<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOGIN APLIKASI PEMESANAN FUKU COFFEE</title>
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
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <style>
    body {
   
   font-family: 'Raleway', sans-serif;
      background-image: url('BACKGROUND.jpg');
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      background-position: center;
      min-height: 100vh;
      /* Sesuaikan dengan warna kopi */
  }

    .login-box {
      background-color: rgba(255, 255, 255, 0.7); /* Tambahkan transparansi pada kotak login */
      border-radius: 10px;
      box-shadow: rgb(255, 255, 240);
      padding: 15px;
      margin-top: 10%;
    }

    .login-box-body {
      background-color: transparent; /* Atur latar belakang kotak login menjadi transparan */
      padding: 10px;
      border-radius: 5px;
    }

    .login-box h4,
    .login-box h5 {
      color: #8B4513; /* Sesuaikan dengan warna kopi */
      font-family: 'Caveat', cursive; /* Ubah font untuk judul */
    }

    .form-control {
      border-radius: 5px;
      border: 1px solid #8B4513; /* Sesuaikan dengan warna kopi */
    }

    .btn-success,
    .btn-primary {
      background-color: #8B4513; /* Sesuaikan dengan warna kopi */
      border: none;
      border-radius: 3px;
      font-family: 'Caveat', cursive; /* Ubah font untuk tombol */
    }

    .btn-success:hover,
    .btn-primary:hover {
      background-color: #A0522D; /* Sesuaikan dengan warna kopi */
    }

    .fa-user,
    .glyphicon-lock {
      color: #d2b48c; /* Sesuaikan dengan warna kopi */
    }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="background-image: url('10237_ Free Sketchup Milk Tea Interior Model Download By Kts NghiaThan.jpeg');" >
  <div class="login-box">
    <div class="login-box-body">
      <h4>
        <center><strong>APLIKASI PEMESANAN MENU
          <p> COFFEE SHOP </p></strong></center>
      </h4>
      <h5>
        <center><strong>FUKU COFFEE</strong></center>
      </h5>
      <p class="login-box-msg"></p>

      <form action="page/cek_login.php" method="post">
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="Masukan Username" required>
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="pass" class="form-control" placeholder="Masukan Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
          </div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-success btn-block btn-flat">Login</button>
          </div>
          <?php
          include "config/koneksi.php"
          ?>
        </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="register.php" class="btn btn-block btn-primary">
          <i class="fa fa-sign-in mr-2"></i> Daftar Sekarang
        </a>
      </div>

    </div>
  </div>

  <!-- jQuery 2.1.4 -->
  <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-brown',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</body>

</html>
