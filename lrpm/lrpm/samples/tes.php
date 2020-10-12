<?php 
$mysqli = new mysqli("localhost","root","","lrpm");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}
$result = $mysqli->query("select * from karya where id='14'") or die($mysqli->error);
$data = $result->fetch_assoc() or die($mysqli->error);;


$data2['nama']="Universitas Presiden";
$data2['kewarganegaraan'] = '-';
$data2['alamat'] = 'Jl. Ki Hajar Dewantara, Jababeka, Cikarang Baru - Cikarang, Bekasi 17550 - Jawa Barat, Indonesia';
$data2['telepon'] = '021-89109762';
$data2['hp_or_email'] = 'lrpmpu@president.ac.id';

$data3['nama']="";
$data3['kewarganegaraan'] = '';
$data3['alamat'] = '';
$data3['telepon'] = '';
$data3['hp_or_email'] = '';


?>