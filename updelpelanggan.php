<?php

require 'ceklogin.php';

//edit pelanggan
if(isset($_POST['editpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $idpl = $_POST['idpl']; //idpelanggan

    $query = mysqli_query($k,"update pelanggan set namapelanggan='$namapelanggan', notelp='$notelp', alamat='$alamat' where idpelanggan='$idpl'");
    if($query){
        header('location:pelanggan.php');
    }else{
        echo '
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//hapus pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl']; //idpelanggan

    $query = mysqli_query($k,"delete from pelanggan where idpelanggan='$idpl'");
    if($query){
        header('location:pelanggan.php');
    }else{
        echo '
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}


?>