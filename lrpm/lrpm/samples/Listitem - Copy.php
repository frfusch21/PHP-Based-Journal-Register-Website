<?php
date_default_timezone_set("Asia/Jakarta");
include_once 'Sample_Header.php';
include 'tes.php';
// New Word document
echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultParagraphStyle(
array(
//'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
'spacing' => 120,
'lineHeight' => 1.15,
)
);
// Define styles
$fontStyleName = 'myOwnStyle';
$phpWord->addFontStyle($fontStyleName, array('color' => 'FF00FF'));

$paragraphStyleName = 'P-Style';
$phpWord->addParagraphStyle($paragraphStyleName, array('spaceAfter' => 95));




// New section
$section = $phpWord->addSection();
$section->addText('Peraturan Menteri Kehakiman',['bold'=>true],['indent'=>7]);
$section->addText('Nomor: M.01-HC.03.01 Tahun 1987',['bold'=>true],['indent'=>7]);
$section->addText("Kepada Yth.   :",null,['indent'=>7]);
$section->addText("Direktur Jenderal HIKI",null,['indent'=>7]);
$section->addText("melalui Direktur Hak Cipta",null,['indent'=>7]);
$section->addText("Desain Industri, Desain Tata Letak",null,['indent'=>7]);
$section->addText("Sirkuit Terpadu dan Rahasia Dagang di",null,['indent'=>7]);
$section->addText("    Jakarta",null,['indent'=>7]);
$section->addTextBreak(1);


$section->addText('PERMOHONAN PENDAFTARAN CIPTAAN',['size'=>12,'bold'=>true,'underline'=>'single'],['align'=>'center']);
$section->addTextBreak(1);


$max_perline=48;
// Lists
// $section->addText('Multilevel list.');
$section->addText('I.  Pencipta:');
//proses 
$data_ = [['key'=>'nama','value'=>'Nama','tabs'=>3],['key'=>'kewarganegaraan','value'=>'Kewarganegaraan','tabs'=>2], ['key'=>'alamat','value'=>'Alamat', 'tabs'=>3], ['key'=>'telepon','value'=>'Telepon', 'tabs'=>3], ['key'=>'hp_or_email','value'=>'No. HP & Email', 'tabs'=>2]];
foreach ($data_ as $key => $value) {
  $target = $data[$value['key']];
  $len = strlen($target);
  $max_index = cari_max_index($max_perline-1, $target);
  $hasil = substr($target, 0, $max_index+1);
  $filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';

  $textrun = $section->addTextRun();
  $textrun->addText("\t".($key+1).". ".$value['value'].str_repeat("\t", $value["tabs"]).": ");
  $textrun->addText(substr($target, 0, $max_index+1).$filled, ['underline'=>'single']);
  $target = trim(substr($target, $max_index+1));

  while(strlen($target)>0){
    $max_index = cari_max_index($max_perline-1, $target);
    $textrun = $section->addTextRun(); //ganti baris
    $textrun->addText("\t\t\t\t\t  ");
    $hasil = substr($target, 0, $max_index+1);
    $filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';
    $textrun->addText($hasil.$filled, ['underline'=>'single']);
    $target = trim(substr($target, $max_index+1));
  }

}
$section->addTextBreak(0);

$section->addText('II.  Pemegang Hak Cipta:');
//proses 
foreach ($data_ as $key => $value) {
  $target = $data2[$value['key']];
  $len = strlen($target);
  $max_index = cari_max_index($max_perline-1, $target);
  $hasil = substr($target, 0, $max_index+1);
  $filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';

  $textrun = $section->addTextRun();
  $textrun->addText("\t".($key+1).". ".$value['value'].str_repeat("\t", $value["tabs"]).": ");
  $textrun->addText(substr($target, 0, $max_index+1).$filled, ['underline'=>'single']);
  $target = trim(substr($target, $max_index+1));

  while(strlen($target)>0){
    $max_index = cari_max_index($max_perline-1, $target);
    $textrun = $section->addTextRun(); //ganti baris
    $textrun->addText("\t\t\t\t\t  ");
    $hasil = substr($target, 0, $max_index+1);
    $filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';
    $textrun->addText($hasil.$filled, ['underline'=>'single']);
    $target = trim(substr($target, $max_index+1));
  }
}
$section->addTextBreak(0);


$section->addText('II.  Kuasa:');
//proses 
foreach ($data_ as $key => $value) {
  $target = $data3[$value['key']];
  $len = strlen($target);
  $max_index = cari_max_index($max_perline-1, $target);
  $hasil = substr($target, 0, $max_index+1);
  $filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';

  $textrun = $section->addTextRun();
  $textrun->addText("\t".($key+1).". ".$value['value'].str_repeat("\t", $value["tabs"]).": ");
  $textrun->addText(substr($target, 0, $max_index+1).$filled, ['underline'=>'single']);
  $target = trim(substr($target, $max_index+1));

  while(strlen($target)>0){
    $max_index = cari_max_index($max_perline-1, $target);
    $textrun = $section->addTextRun(); //ganti baris
    $textrun->addText("\t\t\t\t\t  ");
    $hasil = substr($target, 0, $max_index+1);
    $filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';
    $textrun->addText($hasil.$filled, ['underline'=>'single']);
    $target = trim(substr($target, $max_index+1));
  }
}
$section->addTextBreak(0);

////////////////////////////////////////////////////
$max_perline=48;
$textrun = $section->addTextRun(); //ganti baris
$textrun->addText("IV.  Jenis dari judul yang dimohonkan\t: ");

$target = $data['jenis'].' - '.$data['judul'];
$len = strlen($target);
$max_index = cari_max_index($max_perline-1, $target);
$hasil = substr($target, 0, $max_index+1);

$textrun->addText(substr($target, 0, $max_index+1), ['bold'=>true]);
$target = trim(substr($target, $max_index+1));

while(strlen($target)>0){
   $max_index = cari_max_index($max_perline-1, $target);
   $textrun = $section->addTextRun(); //ganti baris
   $textrun->addText("\t\t\t\t\t  ");
   $hasil = substr($target, 0, $max_index+1);
   $textrun->addText($hasil, ['bold'=>true]);
   $target = trim(substr($target, $max_index+1));
 }

////////////////////////////////////////////////////
$max_perline=48;
$section->addText("V.  Tanggal dan tempat diumumkan"); //ganti baris
$section->addText("     untuk pertama kali di wilayah ");
$section->addText("     Indonesia atau di luar wilayah ");
$textrun = $section->addTextRun();
$textrun->addText("     Indonesia\t\t\t\t: ");
$textrun->addText($data['tempat'].', '.$data['tanggal']);
$section->addTextBreak(3);


/////////////ttd/////////////
$namaBulan = array("Januari","Februaru","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$textrun = $section->addTextRun(['indent'=>6]); //ganti baris
$textrun->addText("Cikarang, ".date('d').' '.$namaBulan[date('m')-1].' '.date("Y"));
$textrun->addTextBreak(5);
$textrun->addText("Tanda Tangan:", ['bold'=>true,'underline'=>'single']);
$textrun->addText("\t\t\t\t", ['bold'=>true,'underline'=>'single']);
$textrun->addTextBreak(1);
$textrun->addText("Nama Lengkap: Prof. Dr. Jony Oktavian Haryanto", ['bold'=>true]);


// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);

function cari_max_index($index,$str){
  if(strlen($str)-1<$index)return $index;
  if($str[$index]==' ')return $index;
  else{
    $index2=$index;
    while($index2>0){
      if($str[--$index2]==' ')return $index2;
    }
    return $index;
  }
}