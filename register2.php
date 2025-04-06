<?php
session_start();
require_once("koneksiPDO.php");

if (isset($_POST['register'])) {

    // Filter dan validasi input
    $kd_customer = $_POST['kd_customer'];
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Menggunakan password_hash untuk keamanan
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $notelp = filter_input(INPUT_POST, 'notelp', FILTER_SANITIZE_STRING);
    $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
    $id_akses = $_POST['id_akses'];

    // Cek apakah username sudah terdaftar
    $query = $db->prepare("SELECT * FROM customers WHERE username = ?");
    $query->execute([$username]);

    if ($query->rowCount() > 0) {
        echo "<div class='text-center alert alert-danger' role='alert'>Username Sudah Terdaftar! <a href='login.php'>Login</a></div>";
    } else {
        // Menyiapkan dan menjalankan query untuk menyimpan data baru
        $sql = "INSERT INTO customers (nama, username, password, kd_customer, notelp, alamat, id_akses) 
                VALUES (:nama, :username, :password, :kd_customer, :notelp, :alamat, :id_akses)";
        $stmt = $db->prepare($sql);

        // Bind parameter ke query
        $params = [
            ":nama" => $nama,
            ":username" => $username,
            ":password" => $password,
            ":kd_customer" => $kd_customer,
            ":notelp" => $notelp,
            ":alamat" => $alamat,
            ":id_akses" => $id_akses
        ];

        // Jalankan query
        $saved = $stmt->execute($params);

        // Redirect jika berhasil atau tampilkan pesan kesalahan
        if ($saved) {
            header("Location: login.php");
            exit();
        } else {
            echo "<div class='text-center alert alert-danger' role='alert'>Proses Gagal! Silakan coba lagi.</div>";
        }
    }
}

function kd_cust_pemesanan() {
    // Fungsi dummy untuk menghasilkan ID pelanggan
    return "CUS" . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}
?>
