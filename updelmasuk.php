<?php

require 'ceklogin.php';

//edit data barang masuk
if(isset($_POST['editdatabarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm']; //idmasuk
    $idp = $_POST['idp']; //idproduk

    //cari tahu qty sekarang berapa
    $caritahu = mysqli_query($k,"select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu sock sekarang berapa
    $caristock = mysqli_query($k,"select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if($qty >= $qtysekarang){
        //kalau inputan lebih besar dari qty yg tercatat
        //hitung selisihnya
        $selisih = $qty - $qtysekarang;
        $newstock = $stocksekarang + $selisih;

        $query1 = mysqli_query($k,"update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idp'");

        if($query1 && $query2){
            header('location:masuk.php');
        }else{
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';
    }
    }else{
        //kalau lebih kecil
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstock = $stocksekarang - $selisih;

        $query1 = mysqli_query($k,"update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idp'");

        if($query1 && $query2){
            header('location:masuk.php');
        }else{
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';
        }  
    }
}

//hapus data barang masuk
if(isset($_POST['hapusdatabarangmasuk'])){
    $idm = $_POST['idm']; //idmasuk
    $idp = $_POST['idp']; //idpelanggan

    //cari tahu qty sekarang berapa
    $caritahu = mysqli_query($k,"select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu sock sekarang berapa
    $caristock = mysqli_query($k,"select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //hitung selisihnya
    $newstock = $stocksekarang - $qtysekarang;

    $query1 = mysqli_query($k,"delete from masuk where idmasuk='$idm'");
    $query2 = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idp'");
        if($query1 && $query2){
            header('location:masuk.php');
        }else{
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
        ';
    }
}

?>