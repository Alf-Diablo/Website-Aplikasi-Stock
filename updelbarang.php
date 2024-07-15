<?php

require 'ceklogin.php';

//edit barang
if(isset($_POST['editbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp']; //idproduk

    $query = mysqli_query($k,"update produk set namaproduk='$namaproduk', deskripsi='$deskripsi', harga='$harga' where idproduk='$idp'");
    if($query){
        header('location:stock.php');
    }else{
        echo '
        <script>alert("Gagal");
        window.location.href="stock.php"
        </script>
        ';
    }
}

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp']; //idproduk

    $query = mysqli_query($k,"delete from produk where idproduk='$idp'");
    if($query){
        header('location:stock.php');
    }else{
        echo '
        <script>alert("Gagal");
        window.location.href="stock.php"
        </script>
        ';
    }
}

?>