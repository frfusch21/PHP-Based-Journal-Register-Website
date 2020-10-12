<?php
include 'cek_role.php';
session_start();
cek_role(@$_SESSION['tipe'], "creator");

$msg = "";
include 'koneksi.php';
$result = $mysqli->query("SELECT * FROM karya WHERE user_id = ".$_SESSION['user_id']) or die($mysqli->error);
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - Activity Tracking</title>
    <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
    <meta name="keywords" content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
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
                            <a href="home-creator.php" class="menu-link">Home</a>
                            <a href="tracking.php" class="menu-link">Activity Tracking</a>
                            <a href="flow.php" class="menu-link">Flow</a>
                            <a href="logout.php" class="menu-link">Logout</a>
                            <a href="profile.php"><img src="resources/images/icon9.png"/></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12  col-md-10 ">
                    <div class="bg-trans box-rad px-3 px-sm-4 my-5 py-3 ">

                        <div class="d-block ">
                            <h4 class="font-weight-bold text-center py-3">ACTIVITY TRACKING</h4>
                            <div class="box-table my-2">
                                <table class="table tbl-cst">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Judul Ciptaan</th>
                                            <th scope="col">Tanggal Penciptaan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Certificate</th>
                                            <th scope="col">Website</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while($res = $result->fetch_array())
                                        {
                                        ?>
                                        <tr>
                                            <td><?= $res['judul_ciptaan']; ?></td>
                                            <td><?= date("l, d-M-Y", strtotime($res['tanggal_ciptaan'])); ?></td>
                                            <td><?php
                                        if ($res['status'] === "Continue")
                                        {
                                        ?>
                                            <a href="creator-pengalihan.php?id=<?= $res['id']; ?>">Continue</a>
                                        <?php } else { ?>
                                            <?= $res['status']; ?>
                                        <?php
                                        }
                                        ?></td>
                                            <td>
                                                <?php if($res['file_sertifikat'] === null){ ?>
                                                    Unavailable
                                                <?php }else {?>
                                                <a href="sertifikat/<?=$res['file_sertifikat']?>">Download</a>
                                                <?php } ?>
                                            </td>
                                            <td><a href="<?= $res['link'] ?>"><?= $res['link'] ?></a>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <form id="formdownload" method="POST">
        <input type="hidden" name="id">
        <input type="hidden" name="download_sertifikat">
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btndownload").click(function(e) {
                e.preventDefault();
                $("input[name='id']").val($(this).attr('id'))
                $("#formdownload").submit();
            })
            $("#btncari").click(function () {

            $("#formcari").submit();
            })
        });
    </script>
</body>

</html>