<?php
include 'cek_role.php';
include 'koneksi.php';
$msg = "";
session_start();
cek_role(@$_SESSION['tipe'], "admin");

if (!isset($_SESSION['id_number'])) {
    header("Location: login-creator.php");
    exit();
}
$country = json_decode(file_get_contents("resources/country.json"), true);

$check_db = $mysqli->query("SELECT * FROM karya WHERE status = 'Continue' AND user_id = '" . $_SESSION['user_id'] . "'");
if ($check_db->num_rows > 0) {
    $obj = $check_db->fetch_object();
    header("location: creator-pengalihan.php?id=" . $obj->id_karya);
}

$id = $mysqli->real_escape_string(trim($_GET['id']));

if (isset($_POST['submit'])) {
    $id_user = $_SESSION['user_id'];

    $pencipta_posted = [];
    for ($i = 1; $i <= 3; $i++) {
        array_push($pencipta_posted, [
            'id' => $mysqli->real_escape_string($_POST["id_pencipta-$i"]),
            'nama' => $mysqli->real_escape_string($_POST["nama_pencipta-$i"]),
            'kewarganegaraan' => $mysqli->real_escape_string($_POST["kewarganegaraan_pencipta-$i"]),
            'alamat' => $mysqli->real_escape_string($_POST["alamat_pencipta-$i"]),
            'telp' => $mysqli->real_escape_string($_POST["telp_pencipta-$i"]),
            'hp' => $mysqli->real_escape_string($_POST["hp_pencipta-$i"]),
            'email' => $mysqli->real_escape_string($_POST["email_pencipta-$i"])
        ]);

        $i_next = $i + 1;
        if (!isset($_POST["nama_pencipta-$i_next"])) {
            break;
        }
    }
    //
    $nama_pemegang = $mysqli->real_escape_string($_POST["nama_pemegang"]);
    $kewarganegaraan_pemegang = $mysqli->real_escape_string($_POST["kewarganegaraan_pemegang"]);
    $alamat_pemegang = $mysqli->real_escape_string($_POST["alamat_pemegang"]);
    $telp_pemegang = $mysqli->real_escape_string($_POST["telp_pemegang"]);
    $hp_pemegang = $mysqli->real_escape_string($_POST["hp_pemegang"]);
    $email_pemegang = $mysqli->real_escape_string($_POST["email_pemegang"]);
    //
    $nama_kuasa = $mysqli->real_escape_string($_POST["nama_kuasa"]);
    $kewarganegaraan_kuasa = $mysqli->real_escape_string($_POST["kewarganegaraan_kuasa"]);
    $alamat_kuasa = $mysqli->real_escape_string($_POST["alamat_kuasa"]);
    $telp_kuasa = $mysqli->real_escape_string($_POST["telp_kuasa"]);
    $hp_kuasa = $mysqli->real_escape_string($_POST["hp_kuasa"]);
    $email_kuasa = $mysqli->real_escape_string($_POST["email_kuasa"]);
    //
    $judul_ciptaan = $mysqli->real_escape_string($_POST["judul_ciptaan"]);
    $jenis_ciptaan = $mysqli->real_escape_string($_POST["jenis_ciptaan"]);
    $tempat_ciptaan = $mysqli->real_escape_string($_POST["tempat_ciptaan"]);
    $tanggal_ciptaan = $mysqli->real_escape_string($_POST["tanggal_ciptaan"]);
    $uraian_ciptaan = $mysqli->real_escape_string($_POST["uraian_ciptaan"]);
    $status = $mysqli->real_escape_string($_POST["status"]);
    $link = $mysqli->real_escape_string($_POST["linkGen"]);


    $file_karya2 = $mysqli->real_escape_string($_POST["file_karya2"]);
    $file_sertifikat2 = $mysqli->real_escape_string($_POST["file_sertifikat2"]);

    if ($_FILES['file_karya']['name'] != '') {
        $temp_karya = $_FILES['file_karya']['tmp_name'];
        $name_karya = rand(0, 9999) . $_FILES['file_karya']['name'];
        $size_karya = $_FILES['file_karya']['size'];
        $type_karya = $_FILES['file_karya']['type'];
        $folder_karya = "dokumen/";
        if ($type_karya == 'application/pdf') {
            if ($size_karya < 20971520) {
                move_uploaded_file($temp_karya, $folder_karya . $name_karya);
                $file_karya = $name_karya;
            } else {
                echo "<script>alert('File too large. File must be less than 20 Mb!')</script>";
                die();
            }
        } else {
            echo "<script>alert('(Karya) You can only upload file pdf!')</script>";
            die();
        }
    } else {
        $file_karya = $file_karya2;
    }

    if ($_FILES['file_sertifikat']['name'] != '') {
        $temp_sertifikat = $_FILES['file_sertifikat']['tmp_name'];
        $name_sertifikat = rand(0, 9999) . $_FILES['file_sertifikat']['name'];
        $size_sertifikat = $_FILES['file_sertifikat']['size'];
        $type_sertifikat = $_FILES['file_sertifikat']['type'];
        $folder_sertifikat = "sertifikat/";
        if ($type_sertifikat == 'application/pdf') {
            if ($size_sertifikat < 20971520) {
                move_uploaded_file($temp_sertifikat, $folder_sertifikat . $name_sertifikat);
                $file_sertifikat = $name_sertifikat;
            } else {
                echo "<script>alert('File too large. File must be less than 20 Mb!')</script>";
                die();
            }
        } else {
            echo "<script>alert('(Certificate) You can only upload file pdf!')</script>";
            die();
        }
    } else {
        $file_sertifikat = $file_sertifikat2;
    }

    foreach ($pencipta_posted as $pencipta) {
        $mysqli->query("UPDATE pencipta SET nama = '${pencipta['nama']}', alamat = '${pencipta['alamat']}',
                      telp = '${pencipta['telp']}', hp = '${pencipta['hp']}',
                      kewarganegaraan = '${pencipta['kewarganegaraan']}', email = '${pencipta['email']}'
                    WHERE id = ${pencipta['id']}");
    }

    $mysqli->query("UPDATE karya SET
                nama_pemegang = '$nama_pemegang', kewarganegaraan_pemegang = '$kewarganegaraan_pemegang',
                   alamat_pemegang = '$alamat_pemegang', telp_pemegang = '$telp_pemegang',
                   hp_pemegang = '$hp_pemegang', email_pemegang = '$email_pemegang',
                 
                 nama_kuasa = '$nama_kuasa',
                   kewarganegaraan_kuasa = '$kewarganegaraan_kuasa', alamat_kuasa = '$alamat_kuasa',
                   telp_kuasa = '$telp_kuasa', hp_kuasa = '$hp_kuasa', email_kuasa = '$email_kuasa',
                   
                 jenis_ciptaan = '$jenis_ciptaan', judul_ciptaan = '$judul_ciptaan',
                   tempat_ciptaan = '$tempat_ciptaan',tanggal_ciptaan = '$tanggal_ciptaan',
                   uraian_ciptaan = '$uraian_ciptaan',file_karya = '$file_karya', file_sertifikat = '$file_sertifikat',
                   status = '$status', 'link' = '$link'
                    WHERE id = '$id'");

    echo "<script>alert('Data berhasil diubah!'); window.location = 'index.php';</script>";
    die();
}

$karya = $mysqli->query("SELECT * FROM karya WHERE id = $id")->fetch_object();
$id_karya = $karya->id;

$pencipta = [];
$res = $mysqli->query("SELECT * FROM pencipta WHERE submission_id = $id_karya ORDER BY `order`");
while ($t = $res->fetch_assoc()) {
    array_push($pencipta, $t);
}
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>LRPM - Form Detail Admin</title>
        <meta name="description" content="LRPM - Lembaga Riset dan Pengabdian kepada Masyarakat ">
        <meta name="keywords"
              content="LRPM (Lembaga Riset dan Pengabdian kepada Masyarakat) or Research Institute and Community Service (RICS) of President University is established based on the SK Rektor Nomor: 021/R//SK/PU/10 dan SK Ketua Yayasan Pendidikan Universitas Presiden No: 034/SK/YPUP/ES/X/2013.">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="msapplication-TileColor" content="#384272">
        <meta name="theme-color" content="#384272">
        <link rel="shortcut icon" type="image/png" sizes="32x32" href="resources/images/favicon.png">
        <link rel="stylesheet" type="text/css" href="vendor/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="resources/css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
              rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="vendor/smartwizard/dist/css/smart_wizard_all.min.css">


    </head>
    <style>
        .box-form {
            max-width: 800px;
            margin: 0 auto;
        }
        input[type=file][readonly] {
            pointer-events: none;
            /* touch-action: none; */
        }
    </style>

    <body class="bg">
    <section class="header ">
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
                <div class="col-12 col-md-9 my-3 px-3 px-sm-0  ">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="bg-trans box-rad px-1 px-sm-4 box-form my-5 py-4 ">
                            <?php if ($msg != "") {
                                ?><br>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $msg; ?>
                                </div>
                            <?php } ?>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pemohon"
                                       role="tab" aria-controls="home" aria-selected="true">1. Data Pemohon</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#pengalihan" role="tab"
                                       aria-controls="profile" aria-selected="false">2. Surat Pengalihan Hak Cipta</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#pernyataan" role="tab"
                                       aria-controls="contact" aria-selected="false">3. Surat Pernyataan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#sertifikat" role="tab"
                                       aria-controls="contact" aria-selected="false">4. Upload Sertifikat</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pemohon" role="tabpanel"
                                     aria-labelledby="pemohon-tab">
                                    <br>
                                    <h5 class="text-center font-weight-bold">DATA PEMOHON</h5>
                                    <h6 class="font-weight-bold">I. PEMEGANG HAK CIPTA</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="nama_pemegang" placeholder="Masukkan Nama"
                                                       value="<?= $karya->nama_pemegang; ?>" required autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kewarganegaraan</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm"
                                                        name="kewarganegaraan_pemegang" required>
                                                    <option value="" disabled>Pilih kewarganegaraan</option>
                                                    <?php foreach ($country['data'] as $data) { ?>
                                                        <option value="<?= $data['location'] ?>" <?= ($data['location'] === $karya->kewarganegaraan_pemegang) ? 'selected' : ''; ?>><?= $data['location'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm"
                                                          name="alamat_pemegang"
                                                          required
                                                          placeholder="Masukkan Alamat"
                                                ><?= htmlspecialchars($karya->alamat_pemegang); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="telp_pemegang"
                                                       placeholder="Masukkan Nomor Telepon"
                                                       value="<?= $karya->telp_pemegang; ?>" autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Handphone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="hp_pemegang"
                                                       placeholder="Masukkan Nomor Handphone"
                                                       value="<?= $karya->hp_pemegang; ?>" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control form-control-sm"
                                                       name="email_pemegang"
                                                       placeholder="Masukkan Email"
                                                       value="<?= $karya->email_pemegang; ?>" autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold">II. KUASA</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="nama_kuasa" placeholder="Masukkan Nama"
                                                       value="<?= $karya->nama_kuasa; ?>" required autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kewarganegaraan</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm"
                                                        name="kewarganegaraan_kuasa" required>
                                                    <option value="" disabled>Pilih kewarganegaraan</option>
                                                    <?php foreach ($country['data'] as $data) { ?>
                                                        <option value="<?= $data['location'] ?>" <?= ($data['location'] === $karya->kewarganegaraan_kuasa) ? 'selected' : ''; ?>><?= $data['location'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm"
                                                          name="alamat_kuasa"
                                                          required
                                                          placeholder="Masukkan Alamat"><?= $karya->alamat_kuasa; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="telp_kuasa"
                                                       placeholder="Masukkan Nomor Telepon"
                                                       value="<?= $karya->telp_kuasa; ?>" autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Handphone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="hp_kuasa"
                                                       placeholder="Masukkan Nomor Handphone"
                                                       value="<?= $karya->hp_kuasa; ?>" autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="email_kuasa" placeholder="Masukkan Email"
                                                       value="<?= $karya->email_kuasa; ?>" autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold">III. CIPTAAN</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jenis Ciptaan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="jenis_ciptaan"
                                                       placeholder="Masukkan Jenis Ciptaan"
                                                       value="<?= $karya->jenis_ciptaan; ?>" required autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Judul Ciptaan</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm"
                                                          name="judul_ciptaan"
                                                          required
                                                          placeholder="Masukkan Judul Ciptaan"
                                                ><?= htmlspecialchars($karya->judul_ciptaan); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tempat Diciptakan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="tempat_ciptaan"
                                                       placeholder="Masukkan Tempat Diciptakan"
                                                       value="<?= $karya->tempat_ciptaan; ?>" required
                                                       autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tanggal Diciptakan</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control form-control-sm"
                                                       name="tanggal_ciptaan"
                                                       placeholder="Masukkan Waktu Diciptakan"
                                                       value="<?= $karya->tanggal_ciptaan; ?>" required
                                                       autocomplete="off"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Uraian Ciptaan</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm"
                                                          name="uraian_ciptaan"
                                                          placeholder="Masukkan Uraian Ciptaan"
                                                ><?= htmlspecialchars($karya->uraian_ciptaan); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($pencipta as $idx => $pencipta_single) {
                                        ?>
                                        <h6 class="font-weight-bold">PENCIPTA <?= $idx + 1; ?></h6>
                                        <input type="hidden"
                                               name="id_pencipta-<?= $idx + 1; ?>"
                                               value="<?= $pencipta_single['id']; ?>"
                                        >
                                        <div class="ml-3">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nama</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                           name="nama_pencipta-<?= $idx + 1; ?>"
                                                           placeholder="Masukkan Nama"
                                                           value="<?= $pencipta_single['nama']; ?>" required
                                                           autocomplete="off"
                                                    >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Kewarganegaraan</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-control-sm"
                                                            name="kewarganegaraan_pencipta-<?= $idx + 1; ?>" required>
                                                        <option value="" disabled>Pilih kewarganegaraan</option>
                                                        <?php foreach ($country['data'] as $data) { ?>
                                                            <option value="<?= $data['location'] ?>" <?= ($data['location'] === $pencipta_single['kewarganegaraan']) ? 'selected' : ''; ?>><?= $data['location'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Alamat</label>
                                                <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm"
                                                          name="alamat_pencipta-<?= $idx + 1; ?>"
                                                          required
                                                          placeholder="Masukkan Alamat"
                                                ><?= htmlspecialchars($pencipta_single['alamat']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">No Telepon</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                           name="telp_pencipta-<?= $idx + 1; ?>"
                                                           placeholder="Masukkan Nomor Telepon"
                                                           value="<?= htmlspecialchars($pencipta_single['telp']); ?>"
                                                           autocomplete="off"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">No Handphone</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                           name="hp_pencipta-<?= $idx + 1; ?>"
                                                           placeholder="Masukkan Nomor Handphone"
                                                           value="<?= $pencipta_single['hp']; ?>" autocomplete="off"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control form-control-sm"
                                                           name="email_pencipta-<?= $idx + 1; ?>"
                                                           placeholder="Masukkan Email"
                                                           value="<?= $pencipta_single['email']; ?>" autocomplete="off"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="text-right col-12">
                                            <button type="button" class="next-tab btn btn-info">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pengalihan" role="tabpanel"
                                     aria-labelledby="pengalihan-tab">
                                    <br>
                                    <h5 class="text-center font-weight-bold">SURAT PENGALIHAN HAK CIPTA</h5>
                                    Yang bertanda tangan di bawah ini :<br>
                                    <table class="table table-borderless text-white">
                                        <tr>
                                            <td style="width: 20%">Nama</td>
                                            <td style="width: 80%;">: &nbsp;<?= $pencipta[0]['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: &nbsp;<?= $pencipta[0]['alamat']; ?></td>
                                        </tr>
                                    </table>
                                    Adalah Pihak I selaku pencipta, dengan ini menyerahkan karya ciptaan saya kepada
                                    <table class="table table-borderless text-white">
                                        <tr>
                                            <td style="width: 20%">Nama</td>
                                            <td style="width: 80%;">: &nbsp;<?= $karya->nama_pemegang ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: &nbsp;<?= $karya->alamat_pemegang ?></td>
                                        </tr>
                                    </table>
                                    <p class="text-justify">Adalah Pihak II selaku Pemegang Hak Cipta
                                        berupa <?= $karya->jenis_ciptaan ?> - <?= $karya->judul_ciptaan ?> untuk
                                        didaftarkan di Direktorat Hak Cipta, Desain Industri, Desain Tata Letak dan
                                        Sirkuit Terpadu dan Rahasia Dagang, Direktorat Jenderal Hak Kekayaan
                                        Intelektual, Kementerian Hukum dan Hak Asasi Manusia R.I.</p>
                                    <p class="text-justify">Demikianlah surat pengalihan hak ini kami buat, agar dapat
                                        dipergunakan sebagaimana mestinya.</p>
                                    <div class="row">
                                        <div class="text-left col-6">
                                            <span class="btn btn-danger previous-tab">Back</span>
                                        </div>
                                        <div class="text-right col-6">
                                            <span class="btn btn-info next-tab">Next</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pernyataan" role="tabpanel"
                                     aria-labelledby="pernyataan-tab">
                                    <br>
                                    <h5 class="text-center font-weight-bold">SURAT PERNYATAAN</h5>
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
                                    <div class="form-group">
                                        <label for="upload-file">File Karya</label>
                                        <?php
                                        if ($karya->file_karya) {
                                            ?>
                                            <input type="hidden" name="file_karya2"
                                                   value="<?= $karya->file_karya; ?>">
                                            <?php
                                        }
                                        ?>
                                        <input type="file" class="form-control-file" name="file_karya"
                                               id="upload-file"><br>
                                        <a class="btn btn-warning" href="dokumen/<?= $karya->file_karya ?>"><i
                                                    class="fa fa-file-alt"></i> <?= $karya->file_karya ?></a>
                                    </div>
                                    <div class="row">
                                        <div class="text-left col-6">
                                            <span class="btn btn-danger previous-tab">Back</span>
                                        </div>
                                        <div class="text-right col-6">
                                            <span class="btn btn-info next-tab">Next</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sertifikat" role="tabpanel"
                                     aria-labelledby="sertifikat-tab">
                                    <br>
                                    <h5 class="text-center font-weight-bold">STATUS PEMOHON</h5>
                                    <label>Status Pemohon</label>
                                    <div class ="row">
                                    <div class ="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="waiting"
                                               value="Waiting" <?php if ($karya->status == 'Waiting') echo 'checked="checked"'; if($karya->status == 'Published')echo 'disabled="disabled"'; ?> />
                                        <label class="form-check-label" for="uploaded">
                                            Waiting
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="uploaded"
                                               value="Data Has Been Upload" <?php if ($karya->status == 'Data Has Been Upload') echo 'checked="checked"'; if($karya->status == 'Published')echo 'disabled="disabled"';?> />
                                        <label class="form-check-label" for="uploaded">
                                            Data Has Been Upload
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="payment"
                                               value="Waiting for Payment" <?php if ($karya->status == 'Waiting for Payment') echo 'checked="checked"'; if($karya->status == 'Published')echo 'disabled="disabled"';?> />
                                        <label class="form-check-label" for="payment">
                                            Waiting for Payment
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="confirm"
                                               value="Waiting for Confirmation" <?php if ($karya->status == 'Waiting for Confirmation') echo 'checked="checked"'; if($karya->status == 'Published')echo 'disabled="disabled"';?>>
                                        <label class="form-check-label" for="confirm">
                                            Waiting for Confirmation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="certificate"
                                               value="Certificate Release" <?php if ($karya->status == 'Certificate Release') echo 'checked="checked"'; if($karya->status == 'Published')echo 'disabled="disabled"';?>>
                                        <label class="form-check-label" for="certificate">
                                            Certificate Release
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="published"
                                               value="Published" <?php if ($karya->status == 'Published') echo 'checked="checked"'; ?>>
                                        <label class="form-check-label" for="published">
                                            Published
                                        </label>
                                        &nbsp;&nbsp;<input type="text" name="linkGen" id="linkGen" placeholder="Insert Link"><?= $karya->link ?>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input check1" type="radio" name="status"
                                               id="canceled"
                                               value="Canceled" <?php if ($karya->status == 'Canceled') echo 'checked="checked"'; if($karya->status == 'Published')echo 'disabled="disabled"';?>>
                                        <label class="form-check-label" for="canceled">
                                            Canceled
                                        </label>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="form-group mt-4 row">

                                        <div class="form-group col-8">
                                            <label for="upload-file">Unggah E-Certificate</label>
                                            <input type="hidden" name="file_sertifikat2"
                                                   value="<?= $karya->file_sertifikat ?>">
                                            <!-- <input type="file" class="form-control-file" name="file_sertifikat" id="upload-file"><br> -->
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                           name="file_sertifikat" id="file_sertifikat"
                                                           aria-describedby="inputGroupFileAddon01" readonly>
                                                    <label class="custom-file-label" for="inputGroupFile01">Pilih File
                                                        Dokumen</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">

                                            <?php if ($karya->file_sertifikat != '') { ?>
                                                <div class="mb-4"></div>
                                                <a class="btn btn-block btn-warning"
                                                   href="sertifikat/<?= $karya->file_sertifikat ?>"><i
                                                            class="fa fa-file-alt"></i> <?= $karya->file_sertifikat ?>
                                                </a>
                                            <?php } ?>
                                        </div>

                                        <div class="row mt-4 col-12">
                                            <div class="col-6 text-center">
<!--                                                source_doc/formulir_permohonan_hak_cipta.doc-->
                                                <a class="btn btn-info"
                                                   href="download_data.php?id=<?= $id; ?>">Download Data</a>
                                            </div>
                                            <div class="col-6 text-center">
                                                <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"
                                                   href="hapus-sertifikat.php?id=<?= $id ?>">Delete Data</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-right col-12">
                                            <button name="submit" type="submit" class="btn btn-info">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js "
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 "
            crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js "
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM "
            crossorigin="anonymous "></script>
    <script type="text/javascript " src="vendor/smartwizard/dist/js/jquery.smartWizard.min.js "></script>
    </body>
    <script>
        /**** JQuery *******/
    $(document).ready(function() {
        $('#linkGen').hide();

        $('.next-tab').click(function () {
            $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
        });

        $('.previous-tab').click(function () {
            $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
        });

        $('.check1').click(function(){
            cer = $(this).val();
            console.log(cer);
            if (cer == 'Certificate Release') {
                $('#file_sertifikat').attr('readonly', false);
                $('#linkGen').hide();
            }else if (cer == 'Published'){
                $('#file_sertifikat').attr('readonly', true);
                $('#linkGen').show();
            }else{
                $('#file_sertifikat').attr('readonly', true);
                $('#linkGen').hide();
            }
        });
    });
    
    </script>

    </html>
<?php
$msg = "";
?>