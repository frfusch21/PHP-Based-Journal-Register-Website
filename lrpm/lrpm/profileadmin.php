<?php
include 'koneksi.php';
$msg = '';
session_start();
$con = mysqli_connect("localhost", "root", "", "lrpm");

if (!isset($_SESSION['id_number'])) {
    header("Location: login-creator.php");
    exit();
}

$country = json_decode(file_get_contents("resources/country.json"), true);

$check_db = $mysqli->query("SELECT * FROM tbl_users WHERE id_user = '" . $_SESSION['user_id'] . "'");
if ($check_db->num_rows != 1) {
    $obj = $check_db->fetch_object();
    header("location: login-creator.php?id=" . $obj->id_user);
}
if (isset($_POST['submit'])) {
    $id_user = $_SESSION['user_id'];
    $id_number = $mysqli->real_escape_string(($_POST["id_number"]));
//    $id_nik = $mysqli->real_escape_string($_POST["id_nik"]);
    $name = $mysqli->real_escape_string($_POST["name"]);
    $departement = $mysqli->real_escape_string($_POST["departement"]);
//    $email = $mysqli->real_escape_string($_POST["email"]);
//    $alamat = $mysqli->real_escape_string($_POST["alamat"]);
//    $no_telp = $mysqli->real_escape_string($_POST["no_telp"]);
//    $hp_pencipta = $mysqli->real_escape_string($_POST["hp_pencipta"]);

//    `id_nik`='id_nik',`email`='$email',`alamat`='$alamat',`no_telp`='$no_telp',`hp_pencipta`='$hp_pencipta', `id_number` = '$id_number',
    $mysqli->query("UPDATE `tbl_users` SET `name`='$name', `departement` = '$departement' WHERE `id_user` = $id_user");
}

$result = mysqli_query($con, "SELECT * FROM tbl_users where id_user = '" . $_SESSION['user_id'] . "'");
$res = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LRPM - Profile Admin</title>
        <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
        <meta name="keywords"
              content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="msapplication-TileColor" content="#384272">
        <meta name="theme-color" content="#384272">
        <link rel="shortcut icon" type="image/png" sizes="32x32" href="resources/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="resources/css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
              rel="stylesheet">


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
                    <h4 class="my-1 mb-2 text-center">President University</h4>
                    <div class="bg-trans box-rad px-3 px-sm-4 my-5 pt-3 text-center">
                        <form class="py-1" id="form" method="POST">
                            <h4 class="text-center p-2 mb-4 bg-info text-white">PROFILE USER</h4>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Your ID</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="id_number" placeholder="ID Number"
                                           value="<?= $res['id_number'] ?>" required readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="name"
                                           placeholder="Masukkan Nama" value="<?= $res['name'] ?>" required
                                           autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Departement</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="departement" placeholder="Departement"
                                           value="<?= $res['departement'] ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="login-creator.php" class="btn btn-success mb-2 mt-3">Back</a>
                                    <input type="submit" name="submit" value="Save" class="btn btn-main mb-2 mt-3"/>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js "
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 "
            crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js "
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM "
            crossorigin="anonymous "></script>
    <script type="text/javascript "
            src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#register").click(function (e) {
                e.preventDefault()
                $("#form").submit()
            })
            // $("#register").click(function(e){
            //     e.preventDefault()
            //     alert('asd')
            // })
        })
    </script>
    </body>
    </html>
<?php
$msg = '';
?>