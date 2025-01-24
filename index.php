<?php
session_start();
//koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "toko");
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

<!-- konten -->

<section class="konten">
<div class="container">
	<h1>Daftar Produk</h1>

	<h2>Toko Jajan Khas Bali</h2>

	<div class="row">

		<?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
		<?php while($perproduk = $ambil->fetch_assoc()){ ?>
		
		<div class="col-md-3">
			<div class="thumbnail">
				<img src="foto_produk/<?php echo $perproduk['foto_produk']; ?>" alt="">
				<div class="caption">
					<h3><?php echo $perproduk['nama_produk']; ?></h3>
					<h5>Rp. <?php echo number_format($perproduk['harga_produk']); ?></h5>
					<a href="beli.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-primary">Beli</a>
				</div>
			</div>
		</div>
	<?php } ?>
	


	</div>
</div>
</section>



</body>
</html>