<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "toko");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
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

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login Customer</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button class="btn btn-primary" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
// jika ada tombol login
if (isset($_POST["login"]))
{

    $email = $_POST["email"];
    $password = $_POST["password"];

    $ambil = $koneksi->query("SELECT * FROM customer WHERE email_customer = '$email' AND password_customer = '$password'");

    $akunyangcocok = $ambil->num_rows;

    if ($akunyangcocok==1) 
    {
        $akun = $ambil->fetch_assoc();
        $_SESSION["customer"] = $akun;
        echo "<script>alert('anda suskses login'); </script>";
        echo "<script>location='index.php';</script>";
    }
    else
    {
        echo "<script>alert('anda gagal login, periksa akun anda'); </script>";
        echo "<script>location='login.php';</script>";
    }

}


?>



</body>
</html>
  