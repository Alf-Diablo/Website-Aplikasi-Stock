<?php

require 'ceklogin.php';

//hapus order
if(isset($_POST['hapusorder'])){
    $idorder = $_POST['idorder']; //idorder

    $cekdata = mysqli_query($k,"select * from detailpesanan dp where idpesanan='$idorder'");

    while($ido=mysqli_fetch_array($cekdata)){
        //balikin stock
        $qty = $ido['qty'];
        $idproduk = $ido['idproduk'];
        $iddp = $ido['iddetailpesanan'];

        //cari tahu sock sekarang berapa
        $caristock = mysqli_query($k,"select * from produk where idproduk='$idproduk'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        $newstock = $stocksekarang + $qty;
        $queryupdate = mysqli_query($k,"update produk set stock='$newstock' where idproduk='$idproduk'");

        //hapus data
        $querydelete = mysqli_query($k,"delete from detailpesanan where iddetailpesanan='$iddp'");

    }

    $query = mysqli_query($k,"delete from pesanan where idorder='$idorder'");
    if($queryupdate && $querydelete && $query){
        header('location:index.php');
    }else{
        echo '
        <script>alert("Berhasil di hapus");
        window.location.href="index.php"
        </script>
        ';
    }
}

?>