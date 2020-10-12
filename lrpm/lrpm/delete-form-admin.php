<?php
include 'koneksi.php';
if (isset($_GET['id'])) {
    $id = $mysqli->real_escape_string(trim($_GET['id']))
    $karya_res = $mysqli->query("SELECT * FROM karya WHERE id = '$id'")->fetch_object();
    $delete = $mysqli->query("DELETE FROM karya WHERE id = '$id'");
    $year = date("Y", strtotime($karya_res->tanggal_ciptaan));
    $month = date("j", strtotime($karya_res->tanggal_ciptaan));
    header("location: view2.php?year=$year&month=$month");
}
?>