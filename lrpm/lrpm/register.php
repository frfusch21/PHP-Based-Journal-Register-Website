<?php
include 'cek_role.php';
session_start();
cek_role(@$_SESSION['tipe'], "admin");
$msg = '';
$info = "info";
if (isset($_POST["id_number"]) && isset($_POST["password"]) && isset($_POST["name"]) && isset($_POST["email"])) {
    include 'koneksi.php';
    $id_number = $mysqli->real_escape_string(trim($_POST["id_number"]));
    $password = $mysqli->real_escape_string(trim($_POST["password"]));
    $name = $mysqli->real_escape_string(trim($_POST["name"]));
    $email = $mysqli->real_escape_string(trim($_POST["email"]));


    if ($id_number == '' || $password == '' || $name == '' || $email == '') {
        $msg = "Data harus diisi semua";
        $info = "danger";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg .= "Email tidak valid";
            $info = 'danger';
        } else {
            if ($mysqli->query("INSERT INTO tbl_users(id_number,password,tipe,email,name) VALUES('$id_number',MD5('$password'),'admin','$email','$name')")) {
                $msg = "Berhasil membuat akun admin dengan ID {$id_number}";
                $info = "success";
            } else {
                $msg = "Registrasi gagal, silahkan piilih ID atau email yang berbeda";
                $info = "danger";
            }
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - Register Admin</title>
    <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
    <meta name="keywords" content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
    <meta name="author" content="Ahmad Faisal Aziz">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="msapplication-TileColor" content="#384272">
    <meta name="theme-color" content="#384272">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="resources/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">


</head>

<body class="bg">
    <section class="header">
        <div class="bg-trans">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="menu-top">
                            <a href="index.php" class="menu-link">Home</a>
                            <a href="register.php" class="menu-link">New Admin</a>
                            <a href="view.php" class="menu-link">View Data</a>
                            <a href="logout.php" class="menu-link">Logout</a>
                            <a href="profileadmin.php"><img src="resources/images/icon9.png"/></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 box-login col-md-8 my-3 px-3 px-sm-0  ">
                    <h3 class="my-1 font-weight-bold text-center">PERMOHONAN HAK CIPTA</h3>
                    <h4 class="my-1 mb-1 text-center">President University</h4>
                    <div class="bg-trans box-rad px-3 px-sm-4 my-5 pt-3 text-center">
                        <form class="py-1" id="form" method="POST">
                            <h4 class="text-center p-2 mb-4 bg-info text-white">ADD NEW ADMIN</h4>
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Your ID</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" onkeyup="isi_otomatis()" name="id_number" id="id_number" placeholder="ID Number" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Fullname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Departement</label>
                                <div class="col-sm-8">
                                    <input type="departement" class="form-control" name="departement" id="dept" placeholder="Departement" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Confirm Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password" onchange="checkPasswordMatch()" required>
                                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                </div>
                            </div>
                             <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <a href="home-admin.php" class="btn btn-success mt-3">Back</a>
                                        <button type="submit" name="register" class="btn btn-main mt-3">Register</button>
                                    </div>
                                </div>
                            </div>

                            <?php if ($msg != "") {
                            ?><br>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $msg; ?>
                                </div>
                            <?php } ?>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">
            function isi_otomatis(){
                var id_number = $("#id_number").val();
                $.ajax({
                    url: 'proses-ajax.php',
                    data:"id_number="+id_number ,
                }).success(function (data) {
                    var json = data,
                    obj = JSON.parse(json);
                    $('#name').val(obj.name);
                    $('#dept').val(obj.departement);
                });
            }
        </script>
    
    <script>
    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#password1").val();

        if (password != confirmPassword){
            $("#divCheckPasswordMatch").html("Passwords do not match!");
        }else{
            $("#divCheckPasswordMatch").html("Passwords match.");
        }
    }
    </script>
</body>

</html>