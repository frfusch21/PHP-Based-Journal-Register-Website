<?php
require 'function.php';
$tbl_karyawan = query("SELECT * FROM tbl_karyawan");

?>
 

<!DOCTYPE html>
<html>
	<head>
		<title>Data Puis</title>
		<style>
			
			/*menulist*/
		header nav
			position: fixed; 
			width: 100%;
			height: 50px;
			background: rgba(0,0,0,0.6);
			padding: 0 20px;
			box-sizing: border-box;
			z-index: 2;
		}
		 
		header nav ul
		{
			float: left;
			display: flex;
			margin: 0;
			padding: 0;
		}

		header nav ul li
		{
			list-style: none;
		}

		header nav ul li a
		{
			position: relative;
			display: block;
			height : 50px;
			line-height: 50px;
			padding : 0 20px;
			box-sizing: border-box;
			color: #fff;
			text-decoration: none;
			text-transform: uppercase;
			transition: .5s;
		}

		header nav ul li a:hover
		{
			color: #262626;
		}
		header nav ul li a:before
		{
			content:'';
			position:absolute;
			top:0;
			left:0;
			width:100%;
			height:50px;
			background:#fff;
			transform-origin: right;
			z-index: -1;
			transform:scaleX(0);
			transition: transform .5s;
		}
		header nav ul li a:hover:before
		{
		    ransform-origin: left;
			transform:scaleX(1);
		}
		/*menu list*/

		@media print{

		}

		</style>
	</head>
	

	<body>
	<h1>Table Data</h1>
		<a href="newdata.php">Add New Form</a>

		<br>
		<div id="container">
		<table border="1" cellpadding="10" cellspacing="0">
			<tr>
				<th>No</th>
				<th>Id Number</th>
				<th>Id NIK</th>
				<th>Name</th>
				<th>Departement</th>
				<th>Tipe</th>
				<th>Email</th>
				<th>Alamat</th>
				<th>No Telphone</th>
				<th>No Handphone</th>
				<th>Keterangan</th>
			</tr>
			<?php $i = 1; ?>
			<?php foreach( $tbl_karyawan as $row):
			?>
			<tr>
				<td><?= $i ?></td>
				<td><?=$row["id_number"]; ?></td>
				<td><?=$row["id_nik"]; ?></td>
				<td><?=$row["name"]; ?></td>
				<td><?=$row["departement"]; ?></td>
				<td><?=$row["tipe"]; ?></td>
				<td><?=$row["email"]; ?></td>
				<td><?=$row["alamat"]; ?></td>
				<td><?=$row["no_telp"]; ?></td>
				<td><?=$row["no_hp"]; ?></td>
				<td>
					<a href="ubah.php?id_karyawan=<?= $row["id_karyawan"]; ?>">Edit</a>
					<a href="hapus.php?id_karyawan=<?= $row["id_karyawan"]; ?>">Hapus</a>
				</td>
			</tr>
			<?php $i++; ?>
			<?php endforeach; ?>
		</table>
		</div>
	
	<script src="js/script.js"></script>
	</body>
</html>		

