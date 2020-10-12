<?php 
require 'function.php';

//ambil data di url
$id_karyawan = $_GET["id_karyawan"];
//query data mahasiswa berdasarkan id 
$karyawan = query("SELECT * FROM tbl_karyawan WHERE id_karyawan=$id_karyawan")[0];


if( isset($_POST["submit"])){

	if( ubah($_POST) > 0 ){
		echo "
			<script>
			alert('Data Berhasil Diubah!');
			document.location.href = 'tabeldata.php';
			</script>
			";
	} else {
		echo "
			<script>
			alert('Data Gagal Diubah!');
			document.location.href = 'tabeldata.php';
			</script>
		";
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Form Data</title>
	<div id="cover">
			<h1>Form Data</h1>
		</div>
	<style>
		body
		{
			margin: 0;
			padding: 0;
			font-family: sans-serif;
			background: #696969;  
		}
		/*menulist*/
		header nav
		{
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


		.container{
			width: 730px;
			margin-left: 300px;
		}


		fieldset{
			border: 3px solid #bbb;
		    border-radius: 3px;
		    margin-bottom: 30px;
		}

		legend{
			padding-right: 20px;
		    padding-left: 20px;
		    color: #bbb;
		    margin-bottom: 20px;
		}

		.form-container{
			background: #fbfbfb;
			padding: 20px;
			position: relative;
		    border-radius: 3px;
		    margin-bottom: 30px;
		}
		h1 {
			margin-left: 35%;
			margin-top: 9%;
			font-size: 40px;
			color: #FAFAD2;
		}
		.form-grup{
			margin-bottom: 20px;
			margin-right: 20px;
		}
		.form-grup:after, .form-group:before{
			display: table;
			content: "";
		}

		.form-grup:after{
			clear: both;
		}

		.label{
			float: left;
			width: 30%;
			border: 0;
			font-weight: 900;
		    color: grey;
		    font-size: 12px;
		}


		.label label{
			display: inline-block;
		    vertical-align: -webkit-baseline-middle;
		}

		.input{
			float: left;
			width: 70%;
			border: 10px;
		}

		input[type="text"] {
		    width: 100px;
		    border:40px;
		}

		button[type=submit] {
		  background: #696969;
		  font-family: Arial;
		  color: white;
		  padding: 10px 30px;
		  text-decoration: none;
		  float: right;
		  margin-left: 5px;
		  font-size: 13px;
		  text-transform: uppercase;
		  border-radius: 12px;
		  cursor:pointer;
		}

		button[type=submit]:hover {
		  background:#2F4F4F;
		  text-decoration: none;
		}

		.btn{
		  background: #696969;
		  font-family: Arial;
		  color: white;
		  padding: 10px 30px;
		  text-decoration: none;
		  float: right;
		  margin-left: 5px;
		  font-size: 13px;
		  text-transform: uppercase;
		  border-radius: 12px;
		  cursor:pointer;
		}
		.btn-one:hover{
		  background:#2F4F4F;
		  text-decoration: none;
		}
 
	</style>
</head>
<body>

	<div class = "container">
		<div class="form-container" style="top: 20px; left: 50px;margin-left:10%; border-top-width: 30px; border-left-width: 30px;border-right-width: 30px; padding-top:10px; width: 600px; height:170px;">
		<form action="" method="post" autocomplete="on" id="form1" >
			<input type="hidden" name="id_karyawan" value="<?= $karyawan["id_karyawan"]; ?>">
				
				<div class="from-grup">
					<div class = "label">
						<label for="id_number"> Id Number </label>
					</div>
					<div class = "input">
						<input type = "text" name ="id_number" placeholder="Id Number" autofocus style="width: 300px;height:30px"required value="<?= $karyawan["id_number"]; ?>">
					</div>
				</div>

				<div class="from-grup">
					<div class = "label">
						<label for="name"> Name </label>
					</div>
					<div class = "input">
						<input type = "text" name ="name" placeholder="Full Name" autofocus style="width: 300px;height:30px"required value="<?= $karyawan["name"]; ?>">
					</div>
				</div>

				<div class="from-grup">
					<div class = "label">
						<label for="departement"> Departement </label>
					</div>
					<select class="form-control" style="width: 300px;height:30px" name="departement" value="<?= $karyawan["departement"]; ?>">>
  						<option>Information Technology</option>
  						<option>Information System</option>
  						<option>Visual Communication Design</option>
  						<option>Business Administration</option>
  						<option>Management</option>
  						<option>Actuarial Science</option>
  						<option>Accounting</option>
  						<option>International Relations</option>
  						<option>Law</option>
  						<option>Primary School Teacher Education</option>
  						<option>Communication</option>
  						<option>Industial Engineering</option>
  						<option>Mechanical Engineering</option>
  						<option>Environmental Enhineering</option>
  						<option>Civil Engineering</option>
  						<option>Electrical Engineering</option>
  						<option>LRPM</option>
					</select>
				</div>
				<div class="from-grup">
					<div class = "label">
						<label for="tipe"> Tipe </label>
					</div>
					<select class="form-control" style="width: 300px;height:30px" name="tipe" value="<?= $karyawan["tipe"]; ?>"> >
  						<option>Dean Faculty</option>
						<option>Head of Study</option>
  						<option>Lecturer</option>
  						<option>LRPM</option>
					</select>
				</div>
                <div class="row justify-content-center">
                	<br>
                   	<div class="col-sm">
                   		<a href="tabeldata.php">Go To Table</a>
                       	<button type="submit" name="submit" class="btn btn-main mt-3">Edit</button>
                    </div>
                </div>
					
			</form>

</body>
</html>