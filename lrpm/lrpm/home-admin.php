<?php
include 'cek_role.php';
session_start();
cek_role(@$_SESSION['tipe'], "admin");

include 'koneksi.php';

$page = (isset($_GET['page']))? (int) $_GET['page'] : 1;

$limit = 10;

$limitStart = ($page - 1) * $limit;

$karya_res = $mysqli->query("SELECT * FROM karya ORDER BY tanggal_ciptaan DESC LIMIT ".$limitStart.",".$limit);
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>LRPM - Activity Tracking</title>
    <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
    <meta name="keywords"
          content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="msapplication-TileColor" content="#384272">
    <meta name="theme-color" content="#384272">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="resources/images/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <link rel="stylesheet" type="text/css" href="vendor/fontawesome/css/all.min.css">
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
            <div class="col-12  col-md-7 my-3 px-3 px-sm-0 d-flex align-items-center">
                <div class="  px-3 py-4 w-100 text-center ">
                    <h1 class="font-weight-bold">WELCOME TO LRPM</h1>
                    <h4 class="txt-main my-2 mb-4">President University</h4>
                    <p>LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service
                        (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan
                        SK Ketua Yayasan Pendidikan Universitas
                        Presiden No: 034/SK/YPUP/ES/X/2013.</p>
                    <p>It is a part of academic units that carry out the most basic tasks and functions of universities
                        in the fields of research and community service.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6  col-md-12 ">
                <div class="bg-trans box-rad px-3 px-sm-6 my-2 py-3 ">
                    <h4 class="font-weight-bold text-center py-3">TABLE PEMOHON</h4>
                    <form class=" py-3" id="formcari" action="view2.php">
                        <div class="input-group mb-1 box-cari-outer">
                            <input type="text" class="form-control" name="q" placeholder="Data Search"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append btn-cari">
                                <a href="#" id="btncari" class="btn btn-main"><img src="resources/images/search.svg" class="mini-icon"></a>
                            </div>
                        </div>
                    </form>
                    <div class="box-table my-2">
                        <table class="table tbl-cst">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Pencipta</th>
                                <th scope="col">Judul Ciptaan</th>
                                <th scope="col">Tanggal Publilsh</th>
                                <th scope="col">Status</th>
                                <th scope="col text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($karya = $karya_res->fetch_array())
                            {
                                $id_karya = $karya['id'];

                                $pencipta = [];
                                
                                $res = $mysqli->query("SELECT * FROM pencipta WHERE submission_id = $id_karya ORDER BY `created_at` DESC");

                                while ($t = $res->fetch_assoc())
                                {
                                    array_push($pencipta, $t);
                                }
                            ?>
                                <tr>
                                    <td><?= $karya['id']; ?></td>
                                    <td><?= $pencipta[0]['nama']; ?></td>
                                    <td><?= $karya['judul_ciptaan']; ?></td>
                                    <td><?= date("l, d-M-Y", strtotime($karya['tanggal_ciptaan'])); ?></td>
                                    <td><?= $karya['status']; ?></td>
                                    <td>
                                        <a href="form-edit.php?id=<?= $karya['id']; ?>" class="btn btn-warning"><i
                                                    class="fa fa-edit"></i></a>
                                        <a href="delete-form-admin.php?id=<?= $karya['id']; ?>"
                                           onclick="confirm('Apakah anda yakin ingin menghapus data ini?')"
                                           class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div align="left">
                            <ul class="pagination">
                            <?php if($page == 1){ ?>        
                                <li class="disabled"><a href="#">Previous</a></li>
                            <?php }else{ 
                                $LinkPrev = ($page > 1)? $page - 1 : 1;
                            ?>
                                <li><a href="home-admin.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
                            <?php
                                }
                            ?>  
                            <?php
                                $res = $mysqli->query("SELECT * FROM karya");
                                $JumlahData = mysqli_num_rows($res);
                                $jumlahPage = ceil($JumlahData / $limit); 
                                $jumlahNumber = 1; 
                                $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; 
                                $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; 
      
                                for($i = $startNumber; $i <= $endNumber; $i++){
                                $linkActive = ($page == $i)? ' class="active"' : '';
                            ?>
                                <li<?php echo $linkActive; ?>><a href="home-admin.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                                }
                            ?>
      
                        <!-- link Next Page -->
                            <?php if($page == $jumlahPage){ ?>
                                <li class="disabled"><a href="#">Next</a></li>
                            <?php }else{
                                $linkNext = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
                            ?>
                                <li><a href="index.php?page=<?php echo $linkNext; ?>">Next</a></li>
                            <?php
                                }
                            ?>
                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<form method="POST" id="formhapus">
    <input type="hidden" name="karya_id_hapus">
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js "
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 "
        crossorigin="anonymous "></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js "
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM "
        crossorigin="anonymous "></script>
<script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btncari").click(function () {

            $("#formcari").submit();
        })
        $(".btnhapus").click(function (e) {
            e.preventDefault();
            let karya_id = $(this).attr('karya_id')
            if (confirm('Hapus karya dengan judul ' + $("td[name='karya[" + karya_id + "]'").text() + '?')) {
                $("input[name='karya_id_hapus']").val(karya_id);
                $("#formhapus").submit();
            }
        })
    })
</script>
</body>

</html>