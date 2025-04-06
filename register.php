<?php
session_start();

// Koneksi ke database menggunakan PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=db_coffee', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['register'])) {
    // Validasi form
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['nama']) || empty($_POST['notelp']) || empty($_POST['alamat'])) {
        echo "<div class='text-center alert alert-danger' role='alert'>Silakan lengkapi semua field.</div>";
    } else {
        // Sanitize input
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
        $notelp = filter_input(INPUT_POST, 'notelp', FILTER_SANITIZE_STRING);
        $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
        $id_akses = $_POST['id_akses'];

        // Check if username already exists
        $query = $db->prepare("SELECT * FROM customers WHERE username = ?");
        $query->execute([$username]);

        if ($query->rowCount() > 0) {
            echo "<div class='text-center alert alert-danger' role='alert'>Username Sudah Terdaftar! <a href='login.php'>Login</a></div>";
        } else {
            // Prepare and execute the insertion query
            $kd_customer = kd_cust_pemesanan();
            $sql = "INSERT INTO customers (nama, username, password, kd_customer, notelp, alamat, id_akses) 
                    VALUES (:nama, :username, :password, :kd_customer, :notelp, :alamat, :id_akses)";
            $stmt = $db->prepare($sql);

            // Bind parameters to query
            $params = [
                ":nama" => $nama,
                ":username" => $username,
                ":password" => $password,
                ":kd_customer" => $kd_customer,
                ":notelp" => $notelp,
                ":alamat" => $alamat,
                ":id_akses" => $id_akses
            ];

            // Execute the query
            $saved = $stmt->execute($params);

            // Redirect or inform the user
            if ($saved) {
                header("Location: login.php");
                exit();
            } else {
                echo "<div class='text-center alert alert-danger' role='alert'>Proses Gagal! Silakan coba lagi.</div>";
            }
        }
    }
}

function kd_cust_pemesanan() {
    // Fungsi dummy untuk menghasilkan ID customer unik
    return "CUS" . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>REG APLIKASI PEMESANAN FUKU COFFEE</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <style>
        /* CSS styling */
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <p>REGISTRASI PEMESANAN</p>
            <form action="" method="POST">
                <?php $kd_cust = kd_cust_pemesanan(); ?>
                <input type="hidden" name="kd_customer" class="form-control" value="<?php echo $kd_cust; ?>" />
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                    <span class="glyphicon glyphicon-comment form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="notelp" class="form-control" placeholder="No Telepon" required>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                    <span class="glyphicon glyphicon-home form-control-feedback"></span>
                </div>
                <input type="hidden" name="id_akses" class="form-control" value="4">
                <input type="submit" class="btn btn-success btn-block" name="register" value="Daftar" />
            </form>
            <div class="social-auth-links text-center mt-2 mb-3">
                <a href="login.php" class="btn btn-block btn-primary">
                    <i class="fa fa-sign-in mr-2"></i> Login
                </a>
            </div>
        </div>
    </div>
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
