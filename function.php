<?php

session_start();

//Bikin Koneksi
$k = mysqli_connect('localhost','root','','kasir');

//Login
if(isset($_POST['login'])){
    //variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($k,"SELECT * FROM user WHERE username='$username' and password='$password'");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        //Jika datanya ditemukan
        //Berhasil login

        $_SESSION['login'] = 'True' ;
        header('location:index.php');
    }else{
        //Data tidak ditemukan
        //Gagal login
        echo '
        <script>alert("Username atau Password salah");
        window.location.href="login.php"
        </script>
        ';
    }
}

//menambah stock
if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($k,"insert into produk (namaproduk,deskripsi,stock,harga) values ('$namaproduk',
    '$deskripsi','$stock','$harga')");

    if($insert){
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal menambah barang baru");
        window.location.href="stock.php"
        </script>
        '; 
    }
}

//menambah pelanggan
if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];


    $insert = mysqli_query($k,"insert into pelanggan (namapelanggan,notelp,alamat) values ('$namapelanggan',
    '$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    }else{
       echo '
        <script>alert("Gagal menambah pelanggan baru");
        window.location.href="pelanggan.php"
        </script>
        '; 
    }
}

//menambah pesanan (order)
if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($k,"insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if($insert){
        header('location:index.php');
    }else{
       echo '
        <script>alert("Gagal menambah pesanan baru");
        window.location.href="index.php"
        </script>
        '; 
    }
}

//produk dipilih dipesanan
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp']; //idpesanan
    $qty = $_POST['qty']; //jumlah


    //hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($k,"select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stock barang saat ini

    if($stocksekarang >= $qty){

        //kurangin stocknya dengan jumlah yang akan dikeluarkan
        $selisih = $stocksekarang - $qty;

        //stocknya cukup
        $insert = mysqli_query($k,"insert into detailpesanan (idpesanan,idproduk,qty) values ('$idp','$idproduk','$qty')");
        $update = mysqli_query($k,"update produk set stock='$selisih' where idproduk='$idproduk'");

        if($insert && $update){
        header('location:view.php?idp='.$idp);
        }else{
        echo '
          <script>alert("Gagal menambah pesanan baru");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            '; 
        }
    }else{
        //stock gk cukup
        echo '
          <script>alert("Stok Barang tidak cukup");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            '; 
    }
    
}

//Menambah Barang Masuk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    //cari tahu sock sekarang berapa
    $caristock = mysqli_query($k,"select * from produk where idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //hitung
    $newstock = $stocksekarang+$qty;

    $insertb = mysqli_query($k,"insert into masuk (idproduk,qty) values ('$idproduk','$qty')");
    $updatetb = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idproduk'");

    if($insertb && $updatetb){
        header('location:masuk.php');
    }else{
       echo '
        <script>alert("Gagal menambah barang masuk");
        window.location.href="masuk.php"
        </script>
        '; 
    }
}

?>