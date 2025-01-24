<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "toko");

//jika ada pelanggan  blm login
if (!isset($_SESSION["customer"])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); location='login.php';</script>";
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Toko Jaje Bali</title>
    <link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
     <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="keranjang.php">Keranjang</a></li>

        <!--jika belum sudah login-->
        <?php if (isset($_SESSION["customer"])): ?>
            <li><a href="logout.php">Logout</a></li>

        <!--jika belum login-->
    <?php else: ?>
        <li><a href="login.php">Login</a></li>
            
        <?php endif ?>
        
        <li><a href="checkout.php">Checkout</a></li>    
    </ul>
</div>
</nav>

<section class="konten">
<div class="container">
	<h1>Checkout</h1>

	<?php if (isset($_SESSION["keranjang"]) && count($_SESSION["keranjang"]) > 0): ?>
		<table class="table table-bordered">
	    <thead>
	        <tr>
	            <th>No</th>
	            <th>Produk</th>
	            <th>Harga</th>
	            <th>Jumlah</th>
	            <th>Subharga</th>	
	          
	        </tr>
	    </thead>
	    <tbody>
		<?php 
		$nomor = 1;
		$total_belanja = 0; // Inisialisasi total belanja
		?>
		<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
		    
		    <?php 
		    // Mengambil data produk berdasarkan id_produk dengan prepared statement
		    $stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
		    $stmt->bind_param("i", $id_produk); // "i" untuk integer
		    $stmt->execute();
		    $result = $stmt->get_result();
		    $pecah = $result->fetch_assoc();
		    
		    // Menghitung subharga (harga produk * jumlah)
		    $subharga = $pecah["harga_produk"] * $jumlah;
		    $total_belanja += $subharga; // Menambahkan subharga ke total belanja
		    ?>

		    <tr>
		        <td><?php echo $nomor; ?></td>
		        <td><?php echo $pecah['nama_produk']; ?></td>
		        <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
		        <td><?php echo $jumlah; ?></td>
		        <td>Rp. <?php echo number_format($subharga); ?></td>
		        
		    </tr>

		    <?php $nomor++; ?>
		<?php endforeach; ?>
		</tbody>
		</table>
		
		<!-- Menampilkan Total Belanja -->
		<div class="text-right">
			<h3>Total Belanja: Rp. <?php echo number_format($total_belanja); ?></h3>
		</div>
		
		<a href="index.php" class="btn btn-default">Lanjut Belanja</a>
		<a href="pembayaran.php" class="btn btn-primary">Pembayaran</a>
	
	<?php else: ?>
		<p>Keranjang Anda kosong. Silakan tambah produk ke keranjang.</p>
		<a href="index.php" class="btn btn-default">Kembali ke Home</a>
	<?php endif; ?>
</div>
</section>


</body>
</html>