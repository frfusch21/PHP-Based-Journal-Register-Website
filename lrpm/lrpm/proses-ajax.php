<?php
include 'koneksi.php';
$con = mysqli_connect("localhost","root","", "lrpm");
$id_number = $_GET['id_number'];
$query = mysqli_query($con, "select * from tbl_karyawan where id_number='$id_number'");
$mahasiswa = mysqli_fetch_array($query);
$data = array(
    'name'      =>  $mahasiswa['name'],
    'departement'      =>  $mahasiswa['departement'],
);
 echo json_encode($data);
?>