<?php
include 'cek_role.php';
include 'koneksi.php';
$msg = "";
$con = mysqli_connect("localhost", "root", "", "lrpm");
session_start();
cek_role(@$_SESSION['tipe'], "creator");

if (!isset($_SESSION['id_number'])) {
    header("Location: login-creator.php");
    exit();
}
$country = json_decode(file_get_contents("resources/country.json"), true);

$check_db = $mysqli->query("SELECT * FROM tbl_karya WHERE status = 'Continue' AND id_user = '" . $_SESSION['user_id'] . "'");
if ($check_db->num_rows > 0) {
    $obj = $check_db->fetch_object();
    $delete_db = $mysqli->query("DELETE FROM tbl_karya WHERE id_karya = '" . $obj->id_karya . "'");
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $status = "Continue";
    $jenis_ciptaan = $mysqli->real_escape_string($_POST["jenis_ciptaan"]);
    $judul_ciptaan = $mysqli->real_escape_string($_POST["judul_ciptaan"]);
    $tempat_ciptaan = $mysqli->real_escape_string($_POST["tempat_ciptaan"]);
    $tanggal_ciptaan = $mysqli->real_escape_string($_POST["tanggal_ciptaan"]);
    $uraian_ciptaan = $mysqli->real_escape_string($_POST["uraian_ciptaan"]);
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
    $email_kuasa = $mysqli->real_escape_string($_POST["hp_kuasa"]);

    $mysqli->query("INSERT INTO `karya`(`user_id`, `status`, `jenis_ciptaan`, `judul_ciptaan`, `tempat_ciptaan`, `tanggal_ciptaan`, `uraian_ciptaan`,
        `nama_pemegang`, `kewarganegaraan_pemegang`, `alamat_pemegang`, `telp_pemegang`, `hp_pemegang`, `email_pemegang`,
        `nama_kuasa`, `kewarganegaraan_kuasa`, `alamat_kuasa`, `telp_kuasa`, `hp_kuasa`, `email_kuasa`)
        VALUES($user_id, '$status', '$jenis_ciptaan', '$judul_ciptaan', '$tempat_ciptaan', '$tanggal_ciptaan', '$uraian_ciptaan',
        '$nama_pemegang', '$kewarganegaraan_pemegang', '$alamat_pemegang', '$telp_pemegang', '$hp_pemegang', '$email_pemegang',
        '$nama_kuasa', '$kewarganegaraan_kuasa', '$alamat_kuasa', '$telp_kuasa', '$hp_kuasa', '$email_kuasa'
        )");

    $submission_id = $mysqli->insert_id;

    $total_form = (int)$_POST['total-form'];
    for ($i = 1; $i < $total_form + 1; $i++) {
        $nama = $mysqli->real_escape_string($_POST["nama_pencipta-" . $i]);
        $kewarganegaraan = $mysqli->real_escape_string($_POST["kewarganegaraan_pencipta-" . $i]);
        $alamat = $mysqli->real_escape_string($_POST["alamat_pencipta-" . $i]);
        $telp = $mysqli->real_escape_string($_POST["telp_pencipta-" . $i]);
        $hp = $mysqli->real_escape_string($_POST["hp_pencipta-" . $i]);
        $email = $mysqli->real_escape_string($_POST["email_pencipta-" . $i]);

        $mysqli->query("INSERT INTO `pencipta`(`submission_id`, `nama`, `kewarganegaraan`, `alamat`, `telp`, `hp`, `email`, `order`)
            VALUES ('$submission_id','$nama', '$kewarganegaraan', '$alamat', '$telp', '$hp', '$email', $i)");
    }

    header("location: creator-pengalihan.php?id=" . $submission_id);
    die();
}

$result = mysqli_query($con, "SELECT * FROM tbl_users where id_user = '" . $_SESSION['user_id'] . "'");
$res = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>LRPM - Register Creator</title>
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
                <!--                use alert -->
                <?php if ($msg != "") {
                    ?><br>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $msg; ?>
                    </div>
                <?php } ?>

                <div class="col-12 col-md-8 my-3 px-3 px-sm-0">
                    <h2 class="font-weight-bold text-center">FORM PERMOHONAN</h2>
                    <h4 class="font-weight-bold text-center">HAK CIPTA</h4>
                    <br><br>
                    <p class="text-center text-warning">Ket: (*) Wajib diisi semua dengan benar</p>
                    <form method="POST">
                        <div id="form-submission-main">
                            <div class="bg-trans box-rad px-3 px-sm-4 box-reg my-1 py-4">
                                <div id="form-ciptaan">
                                    <h6 class="font-weight-bold">KARYA CIPTAAN</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Jenis Ciptaan*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="jenis_ciptaan" placeholder="Masukkan Jenis Ciptaan"
                                                       required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Judul Ciptaan*</label>
                                            <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm"
                                                              name="judul_ciptaan"
                                                              required placeholder="Masukkan Judul Ciptaan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tempat*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="tempat_ciptaan"
                                                       placeholder="Masukkan Tempat Diciptakan"
                                                       required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Waktu*</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control form-control-sm"
                                                       name="tanggal_ciptaan" placeholder="Masukkan Waktu Diciptakan"
                                                       required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Uraian Ciptaan*</label>
                                            <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm"
                                                              name="uraian_ciptaan"
                                                              placeholder="Masukkan Uraian Ciptaan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold">PEMEGANG HAK CIPTA</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="nama_pemegang" placeholder="Masukkan Nama" required
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">kewarganegaraan*</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm"
                                                        name="kewarganegaraan_pemegang" required>
                                                    <option value="" disabled>Pilih kewarganegaraan</option>
                                                    <?php foreach ($country['data'] as $data) { ?>
                                                        <option value="<?= $data['location'] ?>"><?= $data['location'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat*</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm" name="alamat_pemegang"
                                                          required placeholder="Masukkan Alamat"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="telp_pemegang" placeholder="Masukkan Nomor Telepon"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Handphone*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="hp_pemegang" placeholder="Masukkan Nomor Handphone"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email*</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control form-control-sm"
                                                       name="email_pemegang" placeholder="Masukkan Email"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold">PEMEGANG KUASA</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="nama_kuasa" placeholder="Masukkan Nama" required
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">kewarganegaraan*</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm"
                                                        name="kewarganegaraan_kuasa" required>
                                                    <option value="" disabled>Pilih kewarganegaraan</option>
                                                    <?php foreach ($country['data'] as $data) { ?>
                                                        <option value="<?= $data['location'] ?>"><?= $data['location'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat*</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm" name="alamat_kuasa"
                                                          required placeholder="Masukkan Alamat"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="telp_kuasa" placeholder="Masukkan Nomor Telepon"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Handphone*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="hp_kuasa"
                                                       placeholder="Masukkan Nomor Handphone" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email*</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control form-control-sm"
                                                       name="email_kuasa" placeholder="Masukkan Email"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-1">
                                <div class="bg-trans box-rad px-3 px-sm-4 box-reg my-5 py-4 ">
                                    <h5 class="text-center font-weight-bold" id="title">DATA PEMOHON 1</h5>
                                    <h6 class="font-weight-bold">PENCIPTA</h6>
                                    <div class="ml-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="nama_pencipta-1" placeholder="Masukkan Nama" required
                                                       autocomplete="off" value="<?= $res['name'] ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kewarganegaraan*</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm"
                                                        name="kewarganegaraan_pencipta-1" required>
                                                    <option value="" disabled>Pilih kewarganegaraan</option>
                                                    <?php foreach ($country['data'] as $data) { ?>
                                                        <option value="<?= $data['location']; ?>"><?= $data['location']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat*</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm" name="alamat_pencipta-1"
                                                          required placeholder="Masukkan Alamat"
                                                          readonly><?= htmlspecialchars($res['alamat']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Telepon*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="telp_pencipta-1" placeholder="Masukkan Nomor Telepon"
                                                       autocomplete="off" value="<?= $res['no_telp'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">No Handphone*</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="hp_pencipta-1" placeholder="Masukkan Nomor Handphone"
                                                       autocomplete="off" value="<?= $res['hp_pencipta'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email*</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control form-control-sm"
                                                       name="email_pencipta-1" placeholder="Masukkan Email"
                                                       autocomplete="off" value="<?= $res['email'] ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input name="total-form" value="1" type="hidden" id="input-total-form"/>
                        </div>
                        <div class="bg-trans box-rad px-3 px-sm-4 box-reg my-5 py-3 ">
                            <div class="row mt-1">
                                <div class="col text-left" id="div-karya-baru">
                                    <button type="button" class="btn btn-info" id="btn-tambah-karya-baru">Add Form</button>
                                    <button class="btn btn-info" disabled="disabled" id="btn-kurangi-karya-baru">Less From</button>
                                </div>
                                <div class="col text-right">
                                    <button class="btn btn-success" type="submit" name="submit">Next</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        const btnTambahKaryaBaru = document.querySelector("#btn-tambah-karya-baru");
        const btnKurangiKaryaBaru = document.querySelector("#btn-kurangi-karya-baru");
        const formSubmissionMain = document.querySelector("#form-submission-main");
        const inputTotalForm = document.querySelector("#input-total-form");
        const maxForm = 3;

        function getTotalForm() {
            for (let i = 3; i >= 1; i--) {
                if (formSubmissionMain.querySelector("#form-" + i) != null) {
                    return i;
                }
            }
            return 1;
        }

        function onFormNumberChange() {
            const totalForm = getTotalForm();
            if (totalForm === maxForm) {
                btnTambahKaryaBaru.disabled = true;
            } else {
                btnTambahKaryaBaru.disabled = false;
            }

            if (totalForm > 1) {
                btnKurangiKaryaBaru.disabled = false;
            } else {
                btnKurangiKaryaBaru.disabled = true;
            }

            inputTotalForm.value = totalForm;
        }

        function changeHTMLName(html, nextFormNumber) {
            html.querySelectorAll('*').forEach((node) => {
                if (node.tagName !== "OPTION" && node.value) {
                    node.setAttribute("value", "");
                    if (node.tagName === "SELECT") {
                        node.selectedIndex = 0;
                    } else {
                        node.innerText = "";
                    }
                }
                if (node.readOnly) {
                    node.readOnly = false;
                }
                const name = node.getAttribute("name");
                if (name) {
                    node.setAttribute("name", name.replace(/-1$/, "-" + nextFormNumber));
                }
            });
            console.log(html.innerHTML);
            return html.innerHTML;
        }

        btnTambahKaryaBaru.addEventListener("click", event => {
            event.preventDefault();
            const child = document.createElement("div");
            const nextFormNumber = getTotalForm() + 1;

            child.setAttribute("id", "form-" + nextFormNumber);
            child.innerHTML = changeHTMLName(formSubmissionMain.querySelector("#form-1").cloneNode(true), nextFormNumber);
            child.querySelector("#title").innerText = "DATA PEMOHON " + nextFormNumber;
            formSubmissionMain.appendChild(child);
            onFormNumberChange();
        });

        btnKurangiKaryaBaru.addEventListener("click", event => {
            event.preventDefault();
            formSubmissionMain.querySelector("#form-" + getTotalForm()).remove();
            onFormNumberChange();
        });
    </script>
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

    </html>
<?php
$msg = "";
?>