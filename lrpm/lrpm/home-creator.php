
<?php
include 'cek_role.php';
include 'koneksi.php';
$con = mysqli_connect("localhost","root","", "lrpm");
session_start();
cek_role(@$_SESSION['tipe'],"creator");

if (!isset($_SESSION['id_number'])) {
    header("Location: login-creator.php");
    exit();
}

$sql = "SELECT * FROM tbl_users where id_user = '".$_SESSION['user_id']."'";
$result = mysqli_query($con,$sql);
$load = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - Creator Homepage</title>
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
             <div class="col-5 col-sm-5 col-md-5 col-lg-5">
                    <p style=font-size:20px>Welcome, &nbsp;<?= $load['name'] ?> </p>
                
                </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12  col-md-6 my-3 px-3 px-sm-0 d-flex align-items-center">
                    <div class="px-3 py-4 w-100 text-center ">
                        <h1 class="font-weight-bold">PERMOHONAN HAK CIPTA </h1>
                        <h4 class="txt-main my-2 mb-4">President University</h4>
                        <p>LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas
                            Presiden No: 034/SK/YPUP/ES/X/2013.</p>
                        <p>It is a part of academic units that carry out the most basic tasks and functions of universities in the fields of research and community service.</p>
                        <br>
                        <h4 class="txt-main p-3 mb-2 bg-warning text-dark">Can You Create the Form for Hak Cipta?</h4>
                        <p class="txt-main p-3 mb-2 bg-info text-white">Click This Button</p>
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                        width="26" height="26"
                        viewBox="0 0 172 172"
                        style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#cccccc"><path d="M138.92308,97.24099c-18.52824,27.77945 -47.6256,52.92308 -48.94351,53.59495c-0.67188,0.64604 -2.66166,1.31791 -3.97957,1.31791c-1.31791,0 -3.30769,-0.67187 -4.6256,-1.31791c-1.3179,-0.67187 -30.4411,-26.46154 -48.96935,-53.59495c-1.31791,-1.98978 -1.31791,-4.6256 -0.64604,-7.26142c1.98979,-2.66166 3.95373,-3.97957 6.61538,-3.97957h24.47176c0,0 3.30769,-57.54868 5.29747,-60.21033c2.63582,-3.30769 10.56912,-5.94351 17.85637,-5.94351c7.28726,0 14.54868,2.63582 17.21034,5.94351c1.96394,2.66165 5.94351,60.21033 5.94351,60.21033h24.47176c2.66166,0 4.6256,1.31791 5.96935,3.97957c1.3179,1.96394 0.64603,4.6256 -0.67188,7.26142z"></path></g></g></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                        width="26" height="26"
                        viewBox="0 0 172 172"
                        style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#cccccc"><path d="M138.92308,97.24099c-18.52824,27.77945 -47.6256,52.92308 -48.94351,53.59495c-0.67188,0.64604 -2.66166,1.31791 -3.97957,1.31791c-1.31791,0 -3.30769,-0.67187 -4.6256,-1.31791c-1.3179,-0.67187 -30.4411,-26.46154 -48.96935,-53.59495c-1.31791,-1.98978 -1.31791,-4.6256 -0.64604,-7.26142c1.98979,-2.66166 3.95373,-3.97957 6.61538,-3.97957h24.47176c0,0 3.30769,-57.54868 5.29747,-60.21033c2.63582,-3.30769 10.56912,-5.94351 17.85637,-5.94351c7.28726,0 14.54868,2.63582 17.21034,5.94351c1.96394,2.66165 5.94351,60.21033 5.94351,60.21033h24.47176c2.66166,0 4.6256,1.31791 5.96935,3.97957c1.3179,1.96394 0.64603,4.6256 -0.67188,7.26142z"></path></g></g></svg>
                        <br><br>
                        <a href="form-reg.php" class="btn btn-main mt-1">Form Hak Cipta</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>

</body>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btndownload").click(function(e) {
                e.preventDefault();
                $("input[name='karya_id']").val($(this).attr('karya_id'))
                $("#formdownload").submit();
            })
        });
    </script>

</html>