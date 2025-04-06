<?php
//////////////////untuk menyimpan sementara menu yang dipilih ketabel temp_transaksi_pemesanan
if (isset($_POST['add_temp'])) {
    if(isset($_POST['id_menuku']) && isset($_POST['jumlah']) && isset($_POST['harga'])) {
        $id_menuku = $_POST['id_menuku'];
        // cek sisa dari menu yang dipilih
        $d = mysqli_fetch_array($mysqli->query("SELECT * FROM stok WHERE id_menu=$id_menuku"));
        $sisa = $d['sisa'];
        // jika sisa =0 atau statusnya habis, maka tidak bisa disimpan ke tabel pemesanan
        if ($sisa == 0) {
            echo "<script> alert('Menu Yang Anda Pesan Sudah habis'); </script>";
        } else {
            $total = $_POST['jumlah'] * $_POST['harga'];
            $tgl = date('Y-m-d');
            $query = $mysqli->query("INSERT INTO temp_transaksi_pemesanan (id, tgl, id_menu, id_harga, jumlah, total) VALUES (NULL, '$tgl', '$_POST[id_menuku]', '$_POST[id_harga]', '$_POST[jumlah]', '$total')");
            echo "<script>window.location='customer.php'</script>";
        }
    } else {
        echo "<script>alert('Terdapat masalah dengan data yang dikirim');</script>";
    }
}

if (isset($_POST['update_pesanan'])) {
    if(isset($_POST['id_menu']) && isset($_POST['jumlah']) && isset($_POST['harga']) && isset($_POST['kd_transaksi']) && isset($_POST['no_meja']) && isset($_POST['atas_nama'])) {
        $jumlah_menu = count($_POST['id_menu']);
        $kd_transaksi = $_POST['kd_transaksi'];
        $no_meja = $_POST['no_meja'];
        $atas_nama = $_POST['atas_nama'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $id_menu = $_POST['id_menu'];
        $tgl = date('Y-m-d');

        for ($i = 0; $i < $jumlah_menu; $i++) {
            $total[$i] = $jumlah[$i] * $harga[$i];
            $d = mysqli_fetch_array($mysqli->query("SELECT * FROM stok WHERE id_menu=$id_menu[$i]"));
            $sisa = $d['sisa'];
            if ($sisa > 0 && $jumlah[$i] <= $sisa) {
                $masukkan = $mysqli->query("UPDATE temp_transaksi_pemesanan SET jumlah='$jumlah[$i]', total='$total[$i]' WHERE id_menu=$id_menu[$i]");
            } else {
                echo "<script> alert('Pesanan Anda melebihi stok yang tersedia'); </script>";
            }
        }
        echo "<script>window.location='customer.php'</script>";
    } else {
        echo "<script>alert('Terdapat masalah dengan data yang dikirim');</script>";
    }
}

if (isset($_POST['add'])) {
    if(isset($_POST['id_menu']) && isset($_POST['jumlah']) && isset($_POST['harga']) && isset($_POST['kd_transaksi']) && isset($_POST['no_meja']) && isset($_POST['atas_nama']) && isset($_POST['total'])) {
        $kd_transaksi = $_POST['kd_transaksi'];
        $no_meja = $_POST['no_meja'];
        $atas_nama = $_POST['atas_nama'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $id_menu = $_POST['id_menu'];
        $total = $_POST['total'];
        $tgl = date('Y-m-d');
        $jumlah_menu = count($_POST['id_menu']);

        $query = $mysqli->query("INSERT INTO transaksi_pemesanan (id, kd_transaksi, tgl, nomer_meja, atas_nama, total) VALUES (NULL, '$kd_transaksi', '$tgl', '$no_meja', '$atas_nama', '$total')");
        if ($query) {
            $id_pemesanan = $mysqli->insert_id; // Pastikan menggunakan $mysqli, bukan hasil query
            for ($i = 0; $i < $jumlah_menu; $i++) {
                $masukkan = $mysqli->query("INSERT INTO transaksi_pemesanan_detail (id, id_pemesanan, id_menu, porsi) VALUES (NULL, '$id_pemesanan', '$id_menu[$i]', '$jumlah[$i]')");
                $update_stok = $mysqli->query("UPDATE stok SET sisa=sisa-$jumlah[$i] WHERE id_menu=$id_menu[$i]");
            }
            $delete_temp_transaksi_pemesanan = $mysqli->query("DELETE FROM temp_transaksi_pemesanan");
            echo " <center> <div class='alert alert-success'>
                <h3><span id='TotalBayar'>Pesanan Anda Berhasil, Dan Akan segera di antar ke meja anda. Terimakasih</span></h3>
              </div> 
    <meta http-equiv='refresh' content='3; url=customer.php' />";
        } else {
            echo "<script>alert('Gagal menambahkan pesanan');</script>";
        }
    } else {
        echo "<script>alert('Terdapat masalah dengan data yang dikirim');</script>";
    }
}
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuku Coffee Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300&family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Montserrat', sans-serif;
        }
        .header, .footer {
            background-color: #4b2e1e;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .header h1, .footer h4 {
            margin: 0;
            font-family: 'Josefin Sans', sans-serif;
        }
        .menu-card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .menu-card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .menu-card .card-body {
            padding: 10px;
            background-color: #fff;
        }
        .menu-card .card-title {
            font-size: 18px;
            color: #4b2e1e;
        }
        .menu-card .card-text {
            font-size: 16px;
            color: #6f4e37;
        }
        .order-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .order-form h4 {
            margin-bottom: 20px;
            color: #4b2e1e;
        }
        .btn-primary {
            background-color: #d9ad7c;
            border-color: #d9ad7c;
            color: #4b2e1e;
        }
        .btn-primary:hover {
            background-color: #b88a63;
            border-color: #b88a63;
            color: #fff;
        }
        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
            color: #fff;
        }
        .btn-secondary {
            background-color: #f1e3c6;
            border-color: #f1e3c6;
            color: #6f4e37;
        }
        .btn-secondary:hover {
            background-color: #d6c7a1;
            border-color: #d6c7a1;
            color: #fff;
        }
        .pagination .page-link {
            color: #4b2e1e;
        }
        .pagination .page-item.active .page-link {
            background-color: #4b2e1e;
            border-color: #4b2e1e;
        }
        /* Tabel Pesanan Tema Coffee */
        .pesanan-table {
            background-color: #f2e5d8;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .pesanan-table th,
        .pesanan-table td {
            color: #4b2e1e;
        }

        .pesanan-table th {
            background-color: #d9ad7c;
            border-color: #d9ad7c;
        }

        .pesanan-table tbody tr:nth-child(even) {
            background-color: #f1e3c6;
        }

        .pesanan-table tbody tr:hover {
            background-color: #e0cba3;
        }

        .pesanan-table .btn-primary {
            background-color: #b88a63;
            border-color: #b88a63;
            color: #fff;
        }

        .pesanan-table .btn-primary:hover {
            background-color: #9e7451;
            border-color: #9e7451;
            color: #fff;
        }
        .btn-warning {
    background-color: #6f4e37;
    border-color: #6f4e37;
    color: #fff;
}

.btn-warning:hover {
    background-color: #4b2e1e;
    border-color: #4b2e1e;
    color: #fff;
}

.btn-success {
    background-color: #6f4e37;
    border-color: #6f4e37;
    color: #fff;
}

.btn-success:hover {
    background-color: #4b2e1e;
    border-color: #4b2e1e;
    color: #fff;
}


    </style>
</head>
<body>
    <div class="header">
        <h1>Fuku Coffee</h1>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4">Silahkan Pilih Menu Makanan dan Minuman Anda</h2>
                <div class="row">
                

                    <?php
                    error_reporting(0);
                    $batas = 12;
                    $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                    $posisi = ($halaman - 1) * $batas;

                    $tampil = $mysqli->query("SELECT a.*, a.id as id_menu, b.*, c.*, c.id as id_harga, d.* FROM menu a 
                        INNER JOIN kategori_menu b on a.id_kategori = b.id JOIN harga c ON a.id = c.id_menu INNER JOIN stok d ON a.id = d.id_menu
                        order by a.id asc LIMIT $posisi, $batas");
                    $no = 1;
                    while ($r = mysqli_fetch_array($tampil)) {
                    ?>
                        <div class="col-md-4">
                            <form role="form" method="POST" action="">
                                <div class="card menu-card">
                                    <img src="<?php echo "upload/menu/" . $r['gambar']; ?>" class="card-img-top" alt="<?php echo $r['nama_menu']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $r['nama_menu']; ?></h5>
                                        <p class="card-text">Rp. <?php echo number_format($r['harga'], 0, '.', '.'); ?></p>
                                        <input type="hidden" name="harga" value="<?php echo $r['harga']; ?>">
                                        <input type="hidden" name="id_harga" value="<?php echo $r['id_harga']; ?>">
                                        <input type="hidden" name="id_menuku" value="<?php echo $r['id_menu']; ?>">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit" name='add_temp' class="btn btn-primary btn-block">Pilih</button>
                                        <?php if ($r['sisa'] == 0 || $r['sisa'] <= 0) { ?>
                                            <button type="button" class="btn btn-danger btn-block" disabled>Habis</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-secondary btn-block" disabled>Sisa: <?php echo $r['sisa']; ?></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php
                        $no++;
                    }
                    ?>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        $tampil2 = $mysqli->query("SELECT a.*,a.id as id_menu, b.*, c.*, c.id as id_harga, d.* FROM menu a 
                            INNER JOIN kategori_menu b on a.id_kategori = b.id JOIN harga c ON a.id = c.id_menu INNER JOIN stok d ON a.id = d.id_menu
                            order by a.id asc");
                        $jmldata = mysqli_num_rows($tampil2);
                        $jumHalaman = ceil($jmldata / $batas);

                        if ($halaman > 1) echo "<li class='page-item'><a class='page-link' href='?halaman=" . ($halaman - 1) . "'>Sebelumnya</a></li>";

                        for ($i = 1; $i <= $jumHalaman; $i++) {
                            if ($i == $halaman)
                                echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                            else
                                echo "<li class='page-item'><a class='page-link' href='?halaman=$i'>$i</a></li>";
                        }

                        if ($halaman < $jumHalaman) echo "<li class='page-item'><a class='page-link' href='?halaman=" . ($halaman + 1) . "'>Selanjutnya</a></li>";
                        ?>
                    </ul>
                </nav>
            </div>

            <div class="col-md-4">
                <div class="order-form">
                    <h4>Pesanan Anda</h4>
                    <?php
                    $cart = $mysqli->query("SELECT a.*,b.*,c.*,a.id as id_temp FROM temp_transaksi_pemesanan a 
                        INNER JOIN menu b on a.id_menu=b.id JOIN harga c ON a.id_harga=c.id
                        order by a.id desc");
                    $no = 1;
                    ?>
                    <form role="form" method="POST" action="">
                        <table class="table table-bordered table-hover pesanan-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sub = 0;
                                while ($r = mysqli_fetch_array($cart)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $r['nama_menu']; ?></td>
                                        <td>
                                            <input type="hidden" name="id_menu[]" value="<?php echo $r['id_menu']; ?>">
                                            <input type="number" name="jumlah[]" class="form-control" value="<?php echo $r['jumlah']; ?>">
                                            <input type="hidden" name="harga[]" value="<?php echo $r['harga']; ?>">
                                        </td>
                                        <td>Rp. <?php echo number_format($r['total'], 0, '.', '.'); ?></td>
                                    </tr>
                                <?php
                                    $sub += $r['total'];
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <form role="form" method="POST" action="">
                        <h5>Total: Rp. <?php echo number_format($sub, 0, '.', '.'); ?></h5>
                        <input type="hidden" name="total" value="<?php echo $sub; ?>">
                        <input type="hidden" name="kd_transaksi" value="<?php echo date('YmdHis'); ?>">
                        <div class="form-group">
                            <label for="no_meja">No. Meja</label>
                            <input type="text" class="form-control" name="no_meja" id="no_meja" required>
                        </div>
                        <div class="form-group">
                            <label for="atas_nama">Atas Nama</label>
                            <input type="text" class="form-control" name="atas_nama" id="atas_nama" required>
                        </div>
                        <button type="submit" name="update_pesanan" class="btn btn-warning btn-block">Update Pesanan</button>
                        <button type="submit" name="add" class="btn btn-success btn-block">Konfirmasi Pesanan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="footer mt-5">
        <h4>&copy; 2024 Fuku Coffee</h4>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
