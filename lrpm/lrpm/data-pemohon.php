<?php
include 'cek_role.php';
session_start();
cek_role(@$_SESSION['tipe'],"admin");
$msg="";
$msg2="";
$info2="info";
include 'koneksi.php';

if(isset($_POST['hapus_file']) && isset($_GET['karya_id'])){
    $karya_id = $mysqli->real_escape_string(trim($_GET['karya_id']));
    
    $result = $mysqli->query("select ciptaan_path from karya where id='$karya_id'") or die($mysqli->error);
    $obj = $result->fetch_object();
    $sql="delete from karya where id='$karya_id'";
    $mysqli->query($sql) or die($mysqli->error);
    @unlink("./resources/$obj->ciptaan_path");
    header("Location: view.php");
    exit();
}
if(isset($_POST['download_file']) && isset($_GET['karya_id'])){
    $karya_id = $mysqli->real_escape_string(trim($_GET['karya_id']));
    $result = $mysqli->query("select * from karya where id='$karya_id'") or die($mysqli->error);
    $obj = $result->fetch_object();
    header('Content-Disposition: attachment; filename="'.$obj->real_filename.'"');
    readfile("./resources/$obj->ciptaan_path");
    exit();
}
if(isset($_POST['download_sertifikat']) && isset($_GET['karya_id'])){
    $karya_id = $mysqli->real_escape_string(trim($_GET['karya_id']));
    $result = $mysqli->query("select * from sertifikat where karya_id='$karya_id'") or die($mysqli->error);
    $obj = $result->fetch_object();
    header('Content-Disposition: attachment; filename="'.$obj->real_filename.'"');
    readfile("./resources/sertifikat/$obj->sertifikat_path");
    exit();
}
if(isset($_POST['download_data']) && isset($_GET['karya_id'])){
    $karya_id = $mysqli->real_escape_string(trim($_GET['karya_id']));
    $mysqli->query("SET lc_time_names = 'id_ID';");
    $result = $mysqli->query("select *,date_format(karya.tanggal, \"%d %M %Y\") as tanggal from karya where id='$karya_id'") or die($mysqli->error);
    $data = $result->fetch_assoc() or die($mysqli->error);;
    //print_r($data);die;
    $data2['nama']="Universitas Presiden";
    $data2['kewarganegaraan'] = '-';
    $data2['alamat'] = 'Jl. Ki Hajar Dewantara, Jababeka, Cikarang Baru - Cikarang, Bekasi 17550 - Jawa Barat, Indonesia';
    $data2['telepon'] = '021-89109762';
    $data2['hp_or_email'] = 'lrpmpu@president.ac.id';

    $data3['nama']="";
    $data3['kewarganegaraan'] = '';
    $data3['alamat'] = '';
    $data3['telepon'] = '';
    $data3['hp_or_email'] = '';

    include 'download_data.php';
    
}
if(isset($_GET['karya_id'])){

    $karya_id = $mysqli->real_escape_string($_GET['karya_id']);
    if(isset($_POST['status_id'])){
        $status_id = $mysqli->real_escape_string($_POST['status_id']);
        $sql = "UPDATE karya SET status_id='$status_id' WHERE id='$karya_id'";
        if(!$mysqli->query($sql))die($mysqli->error);
    }
    $mysqli->query("SET lc_time_names = 'id_ID';");
    $sql = "SELECT karya.nama,karya.kewarganegaraan,karya.alamat,karya.telepon,karya.hp_or_email,karya.judul,karya.jenis,karya.tempat,karya.status_id,karya.id as karya_id,date_format(karya.tanggal, \"%d %M %Y\") as tanggal2,karya.ciptaan_path,karya.real_filename as real_filename_ciptaan, status.*,sertifikat.sertifikat_path,sertifikat.real_filename as real_filename_sertifikat FROM karya inner join status on karya.status_id=status.id left join sertifikat on sertifikat.karya_id=karya.id WHERE karya.id='$karya_id';";
    if($result = $mysqli->query($sql)){
        if($result->num_rows==0)die("Data tidak ada");
        $data = $result->fetch_assoc();
        if(isset($_POST['status_id'])){
            $msg = "Berhasil mengganti status ke \"".$data['text']."\"";
        }
        //print_r($data);die;
    }else{
        print_r($mysqli->error);
        die;
    }
    //file
    if(isset($_FILES['file']) && $_FILES['file']['error']==0){
        $whitelist = ['pdf','jpg','png'];
        $exp = explode('.', $_FILES['file']['name']);
        $format = strtolower(end($exp));
        if(!in_array($format, $whitelist)){
            $msg2 ="Ekstensi yang diperbolehkan: ".implode(',', $whitelist);
            $info2 = 'danger';
        }else{
            $path = sha1($_FILES['file']['tmp_name']." ".strtotime("now")).".".$format; 
            $real_filename = $mysqli->real_escape_string($_FILES['file']['name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], "./resources/sertifikat/{$path}")){
                $result = $mysqli->query("select * from sertifikat where karya_id='$karya_id'") or die($mysqli->error);
                if($result->num_rows>0){
                    $obj = $result->fetch_object();
                    @unlink("./resources/sertifikat/$obj->sertifikat_path");
                    $mysqli->query("delete from sertifikat where karya_id='$karya_id'") or die($mysqli->error); //hapus
                }

                $sql="INSERT INTO sertifikat VALUES(null, '$karya_id', '$path','$real_filename');";
                if($mysqli->query($sql)){
                    $msg2 ="Berhasil upload sertifikat";
                    $info2 = 'success';
                    $result=$mysqli->query("select * from sertifikat where karya_id='$karya_id'") or die($mysqli->error);
                    $data['real_filename_sertifikat'] = $result->fetch_object()->real_filename;
                }else{
                    $msg2 ="Data gagal diinput: ".$mysqli->error;
                    $info2 = 'danger';
                }
                
                
            }else{
                $msg2 ="File gagal diupload";
                $info2 = 'danger';
            }
        }
        //
       
    }

}else{
    die("Error");
}

// if(isset($_POST['karya_id']) && isset($_POST['status_id'])){
//     $karya_id = $mysqli->real_escape_string($_POST['karya_id']);
//     $status_id = $mysqli->real_escape_string($_POST['status_id']);
//     $sql = "UPDATE karya SET status_id='$status_id' WHERE id='$karya_id'";
//     if()
//     if($result = $mysqli->query($sql)){
//         $msg="Berhasil mengganti status";
//         exit();
//     }else{
//         print_r($mysqli->error);
//         die;
//     }
// }
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LRPM - Register Creator</title>
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
    <section class="header ">
        <div class="bg-trans">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="menu-top">
                            <a href="register.php" class="menu-link">Add Admin</a>
                            <a href="view.php" class="menu-link">View Data</a>
                            <a href="index.php" class="menu-link">Home</a>
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
                <div class="col-12  col-md-7 my-3 px-3 px-sm-0  ">
                    <?php if($msg!=""){
    ?><br><div class="alert alert-success" role="alert">
  <?php echo $msg; ?>
</div>
<?php } ?>

<?php if($msg2!=""){
    ?><br><div class="alert alert-<?=$info2;?>" role="alert">
  <?php echo $msg2; ?>
</div>
<?php } ?>
                    <div class="bg-trans box-rad px-3 px-sm-4 box-reg my-5 py-4 ">

                        <h4>Data Pemohon</h4>
                        
                            <div class="box-form p-3  my-3">
                                <h5 class="txt-main">Pencipta :</h5>

                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Nama*</label>
                                    <div class="col-sm-8 ">
                                        <input type="text " readonly class="form-control " placeholder=" " value="<?=$data['nama'];?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Kewarganegaraan*</label>
                                    <div class="col-sm-8 ">
                                        <input type="text " readonly class="form-control " placeholder=" " value="<?=$data['kewarganegaraan'];?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Alamat*</label>
                                    <div class="col-sm-8 ">
                                        <textarea class="form-control " readonly rows="3 "><?=$data['alamat'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Telepon*</label>
                                    <div class="col-sm-8 ">
                                        <input type="number " readonly class="form-control " placeholder=" " value="<?=$data['telepon'];?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Email*</label>
                                    <div class="col-sm-8 ">
                                        <input type="text " readonly class="form-control " placeholder=" " value="<?=$data['hp_or_email'];?>">
                                    </div>
                                </div>

                            </div>

                            <div class="box-form p-3 my-3">
                                <h5 class="txt-main ">Karya :</h5>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Jenis Ciptaan</label>
                                    <div class="col-sm-8 ">
                                        <input type="text " readonly class="form-control " placeholder=" " value="<?=$data['jenis'];?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Judul Ciptaan</label>
                                    <div class="col-sm-8 ">
                                        <input type="text " readonly class="form-control " name="judul" placeholder=" " value="<?=$data['judul'];?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-4 col-form-label ">Tanggal dan tempat  
                                        Diumumkannya
                                        pertama kali 
                                        
                                        </label>
                                    <div class="col-sm-8 ">
                                        <input type="text " readonly class="form-control " placeholder=" " value="<?=$data['tempat'].', '.$data['tanggal2'];?>">
                                    </div>
                                </div>

                            </div>

                            <div class="box-form p-3 my-3">
                                <h5 class="txt-main ">File Karya:</h5>
                                <div class="form-group row ">

                                    <div class="col-sm-6 ">
                                        <a href="#" class="type-file" id="btndownload_file">
                                            <img src="resources/images/document.svg" class="doc-img">
                                            <label class="doc-name"><?=$data['real_filename_ciptaan'];?></label>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <label class="col-form-label ">Status :</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusOpt" id="statusOpt1" value="1" <?php if($data['status_id']==1) echo "checked";?>>
                                            <label class="form-check-label" for="statusOpt1">
                                             Data has been upload 
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusOpt" id="statusOpt2" value="2" <?php if($data['status_id']==2) echo "checked";?>>
                                            <label class="form-check-label" for="statusOpt2">
                                            Waiting for payment 
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusOpt" id="statusOpt3" value="3" <?php if($data['status_id']==3) echo "checked";?>>
                                            <label class="form-check-label" for="statusOpt3">
                                            Waiting for confirmation 
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusOpt" id="statusOpt4" value="4" <?php if($data['status_id']==4) echo "checked";?>>
                                            <label class="form-check-label" for="statusOpt4">
                                            Certificate Release 
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusOpt" id="statusOpt5" value="5" <?php if($data['status_id']==5) echo "checked";?>>
                                            <label class="form-check-label" for="statusOpt5">
                                            Published 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-form p-3 my-3">
                                <h5 class="txt-main ">Unggah Certificate:</h5>
                                <?php 
                                if($data['real_filename_sertifikat']!=''){
                                    ?>
                                 <a href="#" class="type-file" id="btndownload_sertifikat">
                                            <img src="resources/images/document.svg" class="doc-img">
                                            <label class="doc-name"><?=$data['real_filename_sertifikat'];?></label>
                                        </a>
                                <?php
                                }
                                ?>
                                <div class="custom-file ">
                                    <input type="file" class="custom-file-input " id="customFile">
                                    <label class="custom-file-label " for="customFile ">Pilih File Document </label>
                                </div>

                            </div>
                            <div class="row ">
                                <div class="col-12 pr-1 ">

                                    <a href="#" class="btn btn-main my-1 " id="btndownload_data">Download Data</a>
                                    <a href="#" class="btn btn-third my-1 " id="btnhapus" karya_id="<?=$data['karya_id'];?>">Delete Data</a>
                                </div>
                            </div>
                            <form id="formsave" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" name="status_id">
                                <input type="file" name="file" style="display: none;">
                            <a href="#" id="btnsave" class="btn btn-second w-100 my-1 mr-1">Save</a>
                        </div>
                    </form>
                        
                    </div>

                </div>
            </div>
        </div>
    </section>
  <form method="POST" id="formhapus">
        <input type="hidden" name="hapus_file">
    </form>
      <form method="POST" id="formdownload_file">
        <input type="hidden" name="download_file">
    </form>
  <form method="POST" id="formdownload_data">
        <input type="hidden" name="download_data">
    </form>
 <form method="POST" id="formdownload_sertifikat">
        <input type="hidden" name="download_sertifikat">
    </form>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <script type="text/javascript " src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js "></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("input[type='file']").change(function(){
                if($(this)[0].files.length==1){
                    $(".custom-file-label").text($(this)[0].files[0].name)
                }else{
                    $(".custom-file-label").text('Pilih File Document')
                }
            });
            $("#btnsave").click(function(){
                $("input[name='status_id']").val($("input[name='statusOpt']:checked").val())
                $("input[type='file']")[1].files=$("input[type='file']")[0].files
                $("#formsave").submit();
            })
            $("#btnhapus").click(function(e){
                e.preventDefault();
                if(confirm('Hapus karya dengan judul '+$("input[name='judul']").val()+'?')){
                    $("#formhapus").submit();
                }
            })
            $("#btndownload_file").click(function(e){
                e.preventDefault();
                $("#formdownload_file").submit();

            })
             $("#btndownload_data").click(function(e){
                e.preventDefault();
                
                $("#formdownload_data").submit();

            })
            $("#btndownload_sertifikat").click(function(e){
                e.preventDefault();
                
                $("#formdownload_sertifikat").submit();

            })
             
        })
    </script>
</body>

</html>