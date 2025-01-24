<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "toko");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Cek apakah keranjang kosong
if (empty($_SESSION['keranjang']) || !isset($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang kosong, silakan memilih produk dulu');</script>";
    echo "<script>location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>One Warr Garage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <?php if (isset($_SESSION["customer"])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif ?>
            <li><a href="checkout.php">Checkout</a></li>
        </ul>
    </div>
</nav>

<section class="konten">
<div class="container">
    <h1>Keranjang Belanja</h1>
    <?php if (isset($_SESSION["keranjang"]) && count($_SESSION["keranjang"]) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subharga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $nomor = 1;
                $total_belanja = 0;
                foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): 
                    $stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
                    $stmt->bind_param("i", $id_produk);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $pecah = $result->fetch_assoc();

                    if (!$pecah) {
                        echo "<script>alert('Produk dengan ID $id_produk tidak ditemukan.');</script>";
                        echo "<script>location='keranjang.php';</script>";
                        exit;
                    }

                    $subharga = $pecah["harga_produk"] * $jumlah;
                ?>
                <tr>
                    <td><?php echo $nomor++; ?></td>
                    <td><?php echo $pecah['nama_produk']; ?></td>
                    <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                    <td><?php echo $jumlah; ?></td>
                    <td>Rp. <?php echo number_format($subharga); ?></td>
                    <td>
                        <a href="hapuskeranjang.php?id=<?php echo urlencode($id_produk); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus Produk</a>
                    </td>
                </tr>
                <?php 
                $stmt->close();
                endforeach; 
                ?>
            </tbody>
        </table>
        <div class="text-right">
            <h3>Total Belanja: Rp. <?php echo number_format($total_belanja); ?></h3>
        </div>
        <a href="index.php" class="btn btn-default">Lanjut Belanja</a>
        <a href="checkout.php" class="btn btn-primary">Checkout</a>
    <?php else: ?>
        <p>Keranjang Anda kosong. Silakan tambah produk ke keranjang.</p>
        <a href="index.php" class="btn btn-default">Kembali ke Home</a>
    <?php endif; ?>
</div>
</section>
</body>
</html>
