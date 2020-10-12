<?php
include 'cek_role.php';
session_start();
cek_role(@$_SESSION['tipe'], "admin");
include 'koneksi.php';

$result = $mysqli->query("SELECT DISTINCT year(tanggal_ciptaan) as year FROM `karya`");

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - View Year</title>
    <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
    <meta name="keywords" content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="msapplication-TileColor" content="#384272">
    <meta name="theme-color" content="#384272">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="resources/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <link rel="stylesheet" type="text/css" href="vendor/fontawesome/css/all.min.css">
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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12  col-md-7 my-3 px-3 px-sm-0 d-flex align-items-center">
                    <div class="  px-3 py-4 w-100 text-center ">
                        <h1 class="font-weight-bold">PEMOHONAN HAK CIPTA</h1>
                        <h4 class="txt-main my-2 mb-4">President University</h4>

                        <form class=" py-3" id="formcari" action="view2.php">
                            <div class="input-group mb-3 box-cari-outer">
                                <input type="text" class="form-control" name="q" placeholder="Data Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append btn-cari">
                                    <a href="#" id="btncari" class="btn btn-main"><img src="resources/images/search.svg" class="mini-icon" /></a>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <?php while ($res = $result->fetch_array()) { ?>
                                <div class="col-3 mb-3">
                                    <a href="select-month.php?year=<?=$res['year']?>" class="text-white">
                                        <div class="card bg-trans">
                                            <div class="card-body">
                                                <h5 class="card-title"><i class="fa fa-3x fa-file-alt"></i></h5>
                                                <p class="card-text"><?=$res['year']?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btncari").click(function() {
                $("#formcari").submit();
            })
        })
    </script>
</body>

</html>