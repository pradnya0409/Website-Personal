<h2>Detail Pelanggan</h2>

<?php 
// Pastikan id_pembelian yang diterima adalah angka
$id_pembelian = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Mengambil data pembelian dan customer
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN customer ON pembelian.id_customer = customer.id_customer WHERE pembelian.id_pembelian = '$id_pembelian'");
$detail = $ambil->fetch_assoc();

// Menampilkan data detail pembelian
if ($detail) {
    echo "<strong>" . $detail['nama_customer'] . "</strong><br>";
    echo "<p>Telepon: " . $detail['tlpn_customer'] . "<br>Email: " . $detail['email_customer'] . "</p>";
    echo "<p>Tanggal Pembelian: " . $detail['tanggal_pembelian'] . "<br>Total: Rp. " . number_format($detail['total_pembelian']) . "</p>";
} else {
    echo "Detail pembelian tidak ditemukan.";
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Jumlah Pembelian</th>
            <th>Subtotal</th>	
        </tr>
    </thead>
    <tbody>
        <?php 
        // Menampilkan produk yang dibeli
        $nomor = 1;
        $ambil = $koneksi->query("SELECT * FROM pembelian_produk JOIN produk ON pembelian_produk.id_produk = produk.id_produk WHERE pembelian_produk.id_pembelian = '$id_pembelian'");
        
        while ($pecah = $ambil->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['nama_produk']; ?></td>
                <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                <td><?php echo $pecah['jumlah']; ?></td>
                <td>Rp. <?php echo number_format($pecah['harga_produk'] * $pecah['jumlah']); ?></td>
            </tr>
        <?php 
            $nomor++; 
        } 
        ?>
    </tbody>
</table>
