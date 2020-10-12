<?php
// koneksi ke database
 $conn = mysqli_connect("localhost","root","", "lrpm");

 function query($query){
 	global $conn;
 	$result = mysqli_query($conn, $query);
 	$rows = [];
 	while( $row = mysqli_fetch_assoc($result)){
 		$rows[] = $row;
 	}

 	return $rows;
 }

 function search($keyword){
 	$query = "SELECT * FROM tbl_karyawan
 				WHERE
 			 id_number LIKE '%$keyword%' OR 
 			 name LIKE '%$keyword%' OR
 			 departement LIKE '%$keyword%' OR
 			 tipe LIKE '%$keyword%' OR
 			";
 	return query($query);
 }

 function tambah($data){
 	global $conn;
	$id_number = $data["id_number"];
	$name= $data["name"];
	$departement= $data["departement"];
	$tipe = $data["tipe"];

		$query = "INSERT INTO tbl_karyawan 
				VALUES
				('', '$id_number', '$name', '$departement', '$tipe')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
 }

function hapus($id_karyawan){
	global $conn;
	mysqli_query($conn, "DELETE FROM tbl_karyawan WHERE id_karyawan = $id_karyawan");
	
	return mysqli_affected_rows($conn);
}

function ubah($data){
	global $conn;
	$id_karyawan = $data["id_karyawan"];
	$id_number = $data["id_number"];
	$name= $data["name"];
	$departement= $data["departement"];
	$tipe = $data["tipe"];

		$query = "UPDATE tbl_karyawan SET
					id_number = '$id_number', 
					name = '$name', 
					departement = '$departement', 
					tipe = '$tipe'
				  WHERE id_karyawan = $id_karyawan
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}
?>