<?php

require 'ceklogin.php';

//mengubah data detail pesanan
if(isset($_POST['editdetailpesanan'])){
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp']; //idmasuk
    $idpr = $_POST['idpr']; //idproduk
    $idp = $_POST['idp']; //idpesanan

    //cari tahu qty sekarang berapa
    $caritahu = mysqli_query($k,"select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu sock sekarang berapa
    $caristock = mysqli_query($k,"select * from produk where idproduk='$idpr'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if($qty && $qtysekarang){
        //kalau inputan user lebih besar daripada qty yg tercatat
        //hitung selisih
        $selisih = $qty - $qtysekarang;
        $newstock = $stocksekarang - $selisih;

        $query1 = mysqli_query($k,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idpr'");

        if($query1 && $query2){
            header('location:view.php?idp='.$idp);
        }else{
        echo '
            <script>alert("Gagal");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            '; 

        }
    }else{
        //kalau lebih kecil
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstock = $stocksekarang + $selisih;

        $query1 = mysqli_query($k,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idpr'");

        if($query1 && $query2){
            header('location:view.php?idp='.$idp);
        }else{
        echo '
            <script>alert("Gagal");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            '; 
        }
    }
}

//Menghapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $idorder = $_POST['idorder'];

    //cek qty
    $cek1 = mysqli_query($k,"select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stock sekarang
    $cek3 = mysqli_query($k,"select * from  produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];

    $hitung = $stocksekarang + $qtysekarang;

    $update = mysqli_query($k,"update produk set stock='$hitung' where idproduk='$idpr'"); //update stock
    $hapus = mysqli_query($k,"delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    $insertbarang = mysqli_query($k,"insert into masuk (idproduk,qty) values ('$idproduk','$qty')");

    if($update && $hapus){
        header('location:view.php?idp='.$idorder);
    }else{
       echo '
        <script>alert("Gagal menghapus barang");
        window.location.href="view.php?idp='.$idorder.'"
        </script>
        '; 
    }
}

?>