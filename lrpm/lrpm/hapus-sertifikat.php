<?php
include 'koneksi.php';
if (isset($_GET['id'])) {
    $id = $mysqli->real_escape_string($_GET['id']);
    $query = $mysqli->query("SELECT file_sertifikat FROM tbl_karya WHERE id_karya = '$id'") or die($mysqli->error());
    while($result = $query->fetch_array()){
        $file_sertifikat = $result['file_sertifikat'];
    }
    echo $file_sertifikat;
    unlink('sertifikat/'.$file_sertifikat);
    $update = $mysqli->query("UPDATE tbl_karya SET file_sertifikat = '' WHERE id_karya = '$id'");
    header("location: view.php");
}
?>