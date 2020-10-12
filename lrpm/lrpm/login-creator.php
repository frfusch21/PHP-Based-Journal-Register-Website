<?php
include 'cek_session.php';
$msg = '';
if (isset($_POST["id_number"]) && isset($_POST["password"])) {
    include 'koneksi.php';
    $id_number = $mysqli->real_escape_string(trim($_POST["id_number"]));
    $password = $mysqli->real_escape_string(trim($_POST["password"]));
    if ($result = $mysqli->query("SELECT * FROM `tbl_users` where id_number='" . $id_number . "' AND password=MD5('" . $password . "') AND tipe='creator'")) {
        if ($result->num_rows > 0) {
            $obj = $result->fetch_object();
            $_SESSION['id_number'] = $obj->id_number;
            $_SESSION['user_id'] = $obj->id_user;
            $_SESSION['tipe'] = $obj->tipe;
            // Free result set
            $result->free_result();
            header("Location: home-creator.php");
            exit();
        } else {
            $msg = "ID atau password salah";
        }
    } else {
        $msg = "Error 500";
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - Login Creator</title>
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
    <section class="content my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12  col-md-8 box-login my-3 px-4 px-sm-0 text-center ">
                    <a href="index.php"><h3 class="my-1 font-weight-bold text-center">PERMOHONAN HAK CIPTA</h3></a>
                    <h4 class="my-1 mb-1 text-center">President University</h4>
                    <br><br>
                    <center><h6>Please create account if you don't have.</h6></center>
                    <center><h6>Click register to create an account.</h6></center>
                   <div class="bg-trans box-rad px-3 px-sm-4 my-4 pt-3 text-center">
                        <form class="py-1" id="form" method="POST">
                            <h4 class="text-center p-2 mb-4 bg-info text-white">LOGIN ACCOUNT</h4>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Your ID</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" name="id_number" placeholder="ID Number" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control form-control-sm" name="password" placeholder="Your Password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" name="submit" class="btn btn-main">Login</button>
                                </div>
                            </div>
                            <p class="my-3">New Account ? &nbsp;<a href="register-creator.php">Register</a></p>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#login").click(function(e) {
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
$msg = "";
?>