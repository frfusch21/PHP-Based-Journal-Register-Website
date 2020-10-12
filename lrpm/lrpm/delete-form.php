<?php
include 'koneksi.php';
if (isset($_GET['id'])) {
    $id = $mysqli->real_escape_string(trim($_GET['id']));
    $delete = $mysqli->query("DELETE FROM karya WHERE id = '$id'");
    header("location: form-reg.php");
}
?>