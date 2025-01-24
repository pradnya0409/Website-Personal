<h2>Data Pelanggan</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>Username</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>	
        </tr>
    </thead>
    <tbody>
    	<?php $nomor=1;?>
    	<?php $ambil=$koneksi->query("SELECT * FROM pelanggan"); ?>
    	<?php while ($pecah = $ambil->fetch_assoc()) { ?>
	    <tr>
		    <td><?php echo $nomor; ?></td>
		    <td><?php echo $pecah['nama_customer']; ?></td>
		    <td><?php echo $pecah['username_customer']; ?></td>
		    <td><?php echo $pecah['tlpn_customer']; ?></td>
		    <td><?php echo $pecah['alamat_customer']; ?></td>
		    <td>
		    	<a href="" class="btn btn-danger">Hapus</a>
		    </td>
	    </tr>
	    <?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>