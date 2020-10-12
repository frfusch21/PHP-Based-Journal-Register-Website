<?php
include 'cek_role.php';
$msg = "";
session_start();
cek_role(@$_SESSION['tipe'], "creator");

if (!isset($_SESSION['id_number'])) {
    header("Location: login-creator.php");
    exit();
}

include 'koneksi.php';
if (isset($_POST['submit'])) {
    $id = $mysqli->real_escape_string(trim($_POST['id']));
    $temp = $_FILES['file_karya']['tmp_name'];
    $name = rand(0, 9999) . $_FILES['file_karya']['name'];
    $size = $_FILES['file_karya']['size'];
    $type = $_FILES['file_karya']['type'];
    $folder = "dokumen/";
    if ($type == 'application/pdf') {
        if ($size < 20971520) {
            move_uploaded_file($temp, $folder . $name);
            $mysqli->query("UPDATE karya SET file_karya = '$name', status = 'Waiting' WHERE id='$id'");
            echo "<script>alert('Sukses upload karya!'); window.location = 'home-creator.php';</script>";
            // header('location:home-creator.php');
        } else {
            echo "<script>alert('File too large. File must be less than 20 Mb!')</script>";
        }
    } else {
        echo "<script>alert('You can only upload file pdf!')</script>";
    }
}

if (!isset($_GET['id'])) {
    header("location: home-creator.php");
}
$id = $mysqli->real_escape_string(trim($_GET['id']));

$id = $mysqli->real_escape_string(trim($_GET['id']));
$karya = $mysqli->query("SELECT * FROM karya WHERE id = $id")->fetch_object();
$id_karya = $karya->id;

$pencipta = [];
$res = $mysqli->query("SELECT * FROM pencipta WHERE submission_id = $id_karya ORDER BY `order`");
while ($t = $res->fetch_assoc())
{
    array_push($pencipta, $t);
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - Surat Pernyataan</title>
    <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
    <meta name="keywords" content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="msapplication-TileColor" content="#384272">
    <meta name="theme-color" content="#384272">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="resources/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="vendor/smartwizard/dist/css/smart_wizard_all.min.css">


</head>

<body class="bg">
    <section class="header ">
        <div class="bg-trans">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="menu-top">
                            <a href="index.php" class="menu-link">Home</a>
                            <a href="tracking.php" class="menu-link">Activity Tracking</a>
                            <a href="flow.php" class="menu-link">Flow</a>
                            <a href="logout.php" class="menu-link">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 my-3 px-3 px-sm-0  ">
                    <div class="bg-trans box-rad px-3 px-sm-4 box-reg my-5 py-4 ">
                        <h5 class="font-weight-bold text-center">SURAT PERNYATAAN</h5>
                        Yang bertanda tangan di bawah ini :<br>
                        <table class="table table-borderless text-white">
                            <tr>
                                <td style="width: 20%">Nama</td>
                                <td style="width: 80%;">: &nbsp;<?= $pencipta[0]['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>Kewarganegaraan</td>
                                <td>: &nbsp;<?= $pencipta[0]['kewarganegaraan']; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: &nbsp;<?= $pencipta[0]['alamat']; ?></td>
                            </tr>
                            <tr>
                                <td>Jenis Ciptaan</td>
                                <td>: &nbsp;<?= $karya->jenis_ciptaan; ?></td>
                            </tr>
                            <tr>
                                <td>Judul Ciptaan</td>
                                <td>: &nbsp;<?= $karya->judul_ciptaan; ?></td>
                            </tr>
                        </table>
                        <form method="POST" action="?id=<?=$id?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="upload-file">File Karya</label>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="file" class="form-control-file" name="file_karya" id="upload-file" required>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-success" name="submit" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="vendor/smartwizard/dist/js/jquery.smartWizard.min.js "></script>
    <script type="text/javascript">
    </script>
</body>

</html>
<?php
$msg = "";
?>