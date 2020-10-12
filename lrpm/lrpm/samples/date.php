<?php 
date_default_timezone_set("Asia/Jakarta");
$namaBulan = array("Januari","Februaru","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
echo $namaBulan[date('m')-1];
?>