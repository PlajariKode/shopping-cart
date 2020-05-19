<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'shopping-cart');

if (!$conn) {
    die ("Koneksi gagal. " . mysqli_connect_error()); // close koneksi
  }

  if (!isset($_GET['cari'])) {
    $query = mysqli_query($conn, "SELECT * FROM tb_produk");
  } else {
    $query = mysqli_query($conn, "SELECT * FROM tb_produk WHERE nama_produk LIKE '%" . $_GET['cari'] . "%'");
  }

  ?>

  <!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Shopping Cart</title>
  </head>
  <body>

    <div class="container mt-5">
      <div class="row mb-2">
        <div class="col">
          <h4>Daftar Produk</h4>
        </div>
        <div class="col">
          <form class="form-inline pull-right" action="" method="GET">
            <div class="form-group mx-sm-3 mb-2">
              <input type="text" name="cari" class="form-control" placeholder="Cari Produk">
            </div>
            <button type="submit" class="btn btn-success mb-2">Cari</button>
          </form>
        </div>
      </div>

        <table class="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Harga</th>
              <th scope="col">Stok</th>
              <th scope="col">Pembelian</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $no = 1;
            while ($dt = $query->fetch_assoc()) :
              ?>

            <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
              <input type="hidden" name="id_produk" value="<?= $dt['id']; ?>"></input>
              <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><?= $dt['nama_produk']; ?></td>
                <td><?= $dt['harga']; ?></td>
                <td><?= $dt['stok']; ?></td>
                <td width="106">
                  <input class="form-control form-control-sm" type="number" name="pembelian" value="1" min="1" max="<?= $dt['stok']; ?>"></td>
                <td>
                  <button class="btn btn-primary btn-sm" type="submit" name="submit">
                    <i class="fa fa-shopping-cart"></i>
                  </button>
                </td>
              </tr>
            </form>

            <?php endwhile; ?>

          </tbody>
        </table>


      <hr>
      
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Detail <i class="fa fa-shopping-cart"></i>
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Produk dalam cart</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <?php require_once 'cart.php'; ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
  </html>