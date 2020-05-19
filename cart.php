<?php

if (isset($_POST['id_produk'], $_POST['pembelian'])) {
	
	$id = $_POST['id_produk'];
	$pembelian = $_POST['pembelian'];

	$produk = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id = '$id'");
	$dt_produk = $produk->fetch_assoc();

	if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

	$index = -1;
	$cart = unserialize(serialize($_SESSION['cart']));

	// jika produk sudah ada dalam cart maka pembelian akan diupdate
	for ($i=0; $i<count($cart); $i++) {
		if ($cart[$i]['id_produk'] == $id) {
			$index = $i;
			$_SESSION['cart'][$i]['pembelian'] = $pembelian;
			break;
		}
	}

	// jika produk belum ada dalam cart
	if ($index == -1) {
		$_SESSION['cart'][] = [
								'id_produk' => $id,
								'nama_produk' => $dt_produk['nama_produk'],
								'pembelian' => $pembelian
							];
		$_SESSION['pesan'] = "Produk ditambahkan kedalam cart";
	}
}
?>

<table class="table table-bordered">
	<tr align="center">
		<th>#</th>
		<th>Nama Produk</th>
		<th>Pembelian</th>
		<th>Aksi</th>
	</tr>

	<?php
	if(isset($_SESSION['cart'])) {
		$cart = unserialize(serialize($_SESSION['cart']));
		$index = 0;
		$no = 1;

		for ($i=0; $i<count($cart); $i++) {
		?>

	<tr>
		<td><?= $no++; ?></td>
		<td><?= $cart[$i]['nama_produk']; ?></td>
		<td align="center"><?= $cart[$i]['pembelian']; ?></td>
		<td align="center">
			<a href="?index=<?= $index; ?>">Batal</a>		
		</td>
	</tr>

	<?php
		$index++;
		}

		// hapus produk dalam cart
		if(isset($_GET['index'])) {
			$cart = unserialize(serialize($_SESSION['cart']));
			unset($cart[$_GET['index']]);
			$cart = array_values($cart);
			$_SESSION['cart'] = $cart;
		}
	}
	?>

</table>

<?php
	if (isset($_GET['index'])) {
		echo "<script>window.location.href = 'index.php';</script>";
	}
?>