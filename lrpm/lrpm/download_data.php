<?php
include("phpword/index.php");
require_once __DIR__ . '/bootstrap.php';
date_default_timezone_set("Asia/Jakarta");

use \PhpOffice\PhpWord\Settings;

// Settings::loadConfig();
Settings::setOutputEscapingEnabled(false);

include 'koneksi.php';
$id = $mysqli->real_escape_string($_GET['id']);
$res = $mysqli->query("SELECT * FROM karya WHERE id = '$id'") or die($mysqli->error());
// New Word document
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultFontName('times');
$phpWord->setDefaultFontSize(12);
$phpWord->setDefaultParagraphStyle(
    array(
        //'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
        'spacing' => 120,
        'lineHeight' => 1.15,
    )
);

while ($data = $res->fetch_array()) {
    $pencipta = [];
    $res = $mysqli->query("SELECT * FROM pencipta WHERE submission_id = ${data['id']} ORDER BY `order`");
    while ($t = $res->fetch_assoc()) {
        array_push($pencipta, $t);
    }

    // New section
    $section = $phpWord->addSection(array(
        'marginLeft' => 1500, 'marginRight' => 1500,
        'marginTop' => 1500, 'marginBottom' => 1500
    ));
    $section->addText('Peraturan Menteri Kehakiman', ['bold' => true], ['indent' => 7]);
    $section->addText('Nomor: M.01-HC.03.01 Tahun 1987', ['bold' => true], ['indent' => 7]);
    $section->addText("Kepada Yth.   :", null, ['indent' => 7]);
    $section->addText("Direktur Jenderal HIKI", null, ['indent' => 7]);
    $section->addText("melalui Direktur Hak Cipta", null, ['indent' => 7]);
    $section->addText("Desain Industri, Desain Tata Letak", null, ['indent' => 7]);
    $section->addText("Sirkuit Terpadu dan Rahasia Dagang ", null, ['indent' => 7]);
    $section->addText("di", null, ['indent' => 7]);
    $section->addText("    Jakarta", null, ['indent' => 7]);
    $section->addTextBreak(1);


    $section->addText('PERMOHONAN PENDAFTARAN CIPTAAN', ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
    $section->addTextBreak(1);


    $max_perline = 48;
    // Lists
    // $section->addText('Multilevel list.');
    $section->addText('I.  Pencipta:');
    foreach ($pencipta as $p_key => $p_val) {
        $section->addText("\tPencipta " . ($p_key + 1));
        //proses
        $data_ = [
            ['key' => $pencipta[$p_key]['nama'], 'value' => 'Nama', 'tabs' => 3],
            ['key' => $pencipta[$p_key]['kewarganegaraan'], 'value' => 'Kewarganegaraan', 'tabs' => 1],
            ['key' => $pencipta[$p_key]['alamat'], 'value' => 'Alamat', 'tabs' => 3],
            ['key' => $pencipta[$p_key]['telp'], 'value' => 'Telepon', 'tabs' => 3],
            ['key' => $pencipta[$p_key]['hp'], 'value' => 'HP', 'tabs' => 3],
            ['key' => $pencipta[$p_key]['email'], 'value' => 'Email', 'tabs' => 3]
        ];
        foreach ($data_ as $key => $value) {
            $target = $value['key'];
            $len = strlen($target);
            $max_index = cari_max_index($max_perline - 1, $target);
            $hasil = substr($target, 0, $max_index + 1);
            //$filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';

            $textrun = $section->addTextRun();
            $textrun->addText(htmlspecialchars("\t   " . ($key + 1) . ". " . $value['value'] . str_repeat("\t", $value["tabs"]) . ": "));
            $textrun->addText(substr($target, 0, $max_index + 1));
            $target = trim(substr($target, $max_index + 1));

            while (strlen($target) > 0) {
                $max_index = cari_max_index($max_perline - 1, $target);
                $textrun = $section->addTextRun(); //ganti baris
                $textrun->addText("\t\t\t\t\t  ");
                $hasil = substr($target, 0, $max_index + 1);
                //$filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';
                $textrun->addText($hasil);
                $target = trim(substr($target, $max_index + 1));
            }
        }
    }
    $section->addTextBreak(0);

    $data2_ = [['key' => 'nama_pemegang', 'value' => 'Nama', 'tabs' => 3], ['key' => 'kewarganegaraan_pemegang', 'value' => 'Kewarganegaraan', 'tabs' => 2], ['key' => 'alamat_pemegang', 'value' => 'Alamat', 'tabs' => 3], ['key' => 'telp_pemegang', 'value' => 'Telepon', 'tabs' => 3], ['key' => 'email_pemegang', 'value' => 'No. HP & Email', 'tabs' => 2]];

    $section->addText('II.  Pemegang Hak Cipta:');
    //proses
    foreach ($data2_ as $key => $value) {
        $target = $data[$value['key']];
        $len = strlen($target);
        $max_index = cari_max_index($max_perline - 1, $target);
        $hasil = substr($target, 0, $max_index + 1);
        //$filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';

        $textrun = $section->addTextRun();
        $textrun->addText(htmlspecialchars("\t" . ($key + 1) . ". " . $value['value'] . str_repeat("\t", $value["tabs"]) . ": "));
        $textrun->addText(substr($target, 0, $max_index + 1));
        $target = trim(substr($target, $max_index + 1));

        while (strlen($target) > 0) {
            $max_index = cari_max_index($max_perline - 1, $target);
            $textrun = $section->addTextRun(); //ganti baris
            $textrun->addText("\t\t\t\t\t  ");
            $hasil = substr($target, 0, $max_index + 1);
            //$filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';
            $textrun->addText($hasil);
            $target = trim(substr($target, $max_index + 1));
        }
    }
    $section->addTextBreak(0);

    $data3_ = [['key' => 'nama_kuasa', 'value' => 'Nama', 'tabs' => 3], ['key' => 'kewarganegaraan_kuasa', 'value' => 'Kewarganegaraan', 'tabs' => 2], ['key' => 'alamat_kuasa', 'value' => 'Alamat', 'tabs' => 3], ['key' => 'telp_kuasa', 'value' => 'Telepon', 'tabs' => 3], ['key' => 'email_kuasa', 'value' => 'No. HP & Email', 'tabs' => 2]];
    $section->addText('II.  Kuasa:');
    //proses
    foreach ($data3_ as $key => $value) {
        $target = $data[$value['key']];
        $len = strlen($target);
        $max_index = cari_max_index($max_perline - 1, $target);
        $hasil = substr($target, 0, $max_index + 1);
        //$filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';

        $textrun = $section->addTextRun();
        $textrun->addText(htmlspecialchars("\t" . ($key + 1) . ". " . $value['value'] . str_repeat("\t", $value["tabs"]) . ": "));
        //$textrun->addText(substr($target, 0, $max_index+1).$filled, ['underline'=>'single']);
        $textrun->addText(substr($target, 0, $max_index + 1));
        $target = trim(substr($target, $max_index + 1));

        while (strlen($target) > 0) {
            $max_index = cari_max_index($max_perline - 1, $target);
            $textrun = $section->addTextRun(); //ganti baris
            $textrun->addText("\t\t\t\t\t  ");
            $hasil = substr($target, 0, $max_index + 1);
            $filled = $max_perline - strlen($hasil) > 0 ? str_repeat('_', $max_perline - strlen($hasil)) : '';
            $textrun->addText($hasil . $filled);
            $target = trim(substr($target, $max_index + 1));
        }
    }
    $section->addTextBreak(0);

    ////////////////////////////////////////////////////
    $max_perline = 48;
    $textrun = $section->addTextRun(); //ganti baris
    $textrun->addText("IV.  Jenis dari judul yang dimohonkan\t: ");

    $target = $data['jenis_ciptaan'] . ' - ' . $data['judul_ciptaan'];
    $len = strlen($target);
    $max_index = cari_max_index($max_perline - 1, $target);
    $hasil = substr($target, 0, $max_index + 1);

    $textrun->addText(substr($target, 0, $max_index + 1), ['bold' => true]);
    $target = trim(substr($target, $max_index + 1));

    while (strlen($target) > 0) {
        $max_index = cari_max_index($max_perline - 1, $target);
        $textrun = $section->addTextRun(); //ganti baris
        $textrun->addText("\t\t\t\t\t  ");
        $hasil = substr($target, 0, $max_index + 1);
        $textrun->addText($hasil, ['bold' => true]);
        $target = trim(substr($target, $max_index + 1));
    }

    // Page break
    $section->addPageBreak();

    ////////////////////////////////////////////////////
    $max_perline = 48;
    $section->addText("V.  Tanggal dan tempat diumumkan"); //ganti baris
    $section->addText("     untuk pertama kali di wilayah ");
    $section->addText("     Indonesia atau di luar wilayah ");
    $textrun = $section->addTextRun();
    $textrun->addText("     Indonesia\t\t\t\t: ");
    $textrun->addText($data['tempat_ciptaan'] . ', ' . $data['tanggal_ciptaan']);
    $section->addTextBreak(1);


    /////////////ttd/////////////
    $namaBulan = array("January", "February", "March", "April", "Mey", "June", "July", "August", "September", "October", "November", "December");
    $textrun = $section->addTextRun(['indent' => 6]); //ganti baris
    $textrun->addText("Cikarang, " . date('d') . ' ' . $namaBulan[date('m') - 1] . ' ' . date("Y"));
    $textrun->addTextBreak(3);
    $textrun->addText("Tanda Tangan:", ['bold' => true, 'underline' => 'single']);
    $textrun->addText("\t\t\t\t", ['bold' => true, 'underline' => 'single']);
    $textrun->addTextBreak(1);
    $textrun->addText("Nama Lengkap: Prof. Dr. Jony Oktavian Haryanto", ['bold' => true]);

    $section->addPageBreak();

    $section->addText('SURAT PENGALIHAN HAK CIPTA', ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
    $section->addTextBreak(3);
    $section->addText('Yang bertanda tangan dibawah ini :');
    $section->addTextBreak(1);
    $section->addText("Nama \t\t\t\t: " . $pencipta[0]['nama']);
    $section->addText("Alamat \t\t\t: " . $pencipta[0]['alamat']);
    $section->addTextBreak(1);
    $section->addText('Adalah Pihak I selaku pencipta, dengan ini menyerahkan karya ciptaan saya kepada :');
    $section->addTextBreak(1);
    $section->addText("Nama \t\t\t\t: " . $data['nama_pemegang']);
    $section->addText("alamat \t\t\t\t: " . $data['alamat_pemegang']);
    $section->addTextBreak(1);
    $section->addText('Adalah Pihak II selaku Pemegang Hak Cipta berupa ' . $data['jenis_ciptaan'] . "-" . $data['judul_ciptaan'] . " untuk didaftarkan di Direktorat Hak Cipta, Desain Industri, Desain Tata Letak dan Sirkuit Terpadu dan Rahasia Dagang, Direktorat Jenderal Hak Kekayaan Intelektual, Kementerian Hukum dan Hak Asasi Manusia R.I.");
    $section->addTextBreak(3);
    $textrun = $section->addTextRun(['indent' => 7]); //ganti baris
    $textrun->addText("Cikarang, " . date('d') . ' ' . $namaBulan[date('m') - 1] . ' ' . date("Y"));

    $fancyTableStyleName = 'TTD';
    $fancyTableStyle = array('borderSize' => 0, 'borderColor' => 'ffffff', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50);
    $fancyTableFirstRowStyle = array('borderBottomSize' => 0, 'borderBottomColor' => 'ffffff', 'bgColor' => 'ffffff', 'width' => 100);
    $fancyTableCellStyle = array('valign' => 'center');
    $myFontStyle = array('bold' => false, 'align' => 'center');
    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
    $table = $section->addTable($fancyTableStyleName);
    $table->addRow(900);
    $table->addCell(5000, $fancyTableCellStyle)->addText('Pemegang Hak Cipta', $myFontStyle, array('alignment' => 'center'));
    $table->addCell(5000, $fancyTableCellStyle)->addText('Pencipta', $myFontStyle, array('alignment' => 'center'));
    $table->addRow();
    $table->addCell(5000)->addText("");
    $table->addCell(5000)->addText("");
    $table->addRow(100);
    $table->addCell(5000)->addText("");
    $table->addCell(5000)->addText("");
    $table->addRow(100);
    $table->addCell(5000)->addText(ucwords($data['nama_pemegang']), $myFontStyle, array('alignment' => 'center'));
    $table->addCell(5000)->addText(ucwords($pencipta[0]['nama']), $myFontStyle, array('alignment' => 'center'));

    $section->addPageBreak();

    $section->addText('SURAT PERNYATAAN', ['size' => 12, 'bold' => true, 'underline' => 'single'], ['align' => 'center']);
    $section->addTextBreak(1);
    $section->addText('Yang bertanda tangan dibawah ini :');
    $section->addText("Nama \t\t\t\t: " . $pencipta[0]['nama']);
    $section->addText("Kewarganegaraan \t\t: " . $pencipta[0]['kewarganegaraan']);
    $section->addText("Alamat \t\t\t: " . $pencipta[0]['alamat']);
    $section->addTextBreak(1);
    $section->addText('Dengan ini menyatakan bahwa :');
    $listStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER);
    $section->addListItem('Karya Cipta yang saya mohonkan :', 0, null, $listStyle);
    $section->addText("   \t Berupa \t\t: " . $data['jenis_ciptaan']);
    $section->addText("   \t Berjudul \t\t: " . $data['judul_ciptaan']);
    $section->addTextBreak(1);
    $section->addListItem('Tidak meniru dan tidak sama secara esensial dengan Karya Cipta milik pihak lain atau obyek kekayaan intelektual lainnya sebagaimana dimaksud dalam Pasal 68 ayat (2);', 1);
    $section->addListItem('Bukan merupakan Ekspresi Budaya Tradisional sebagaimana dimaksud dalam Pasal 38;', 1);
    $section->addListItem('Bukan merupakan Ciptaan yang tidak diketahui penciptanya sebagaimana dimaksud dalam Pasal 39;', 1);
    $section->addListItem('Bukan merupakan hasil karya yang tidak dilindungi Hak Cipta sebagaimana dimaksud dalam Pasal 41 dan 42;', 1);
    $section->addListItem('Bukan merupakan Ciptaan seni lukis yang berupa logo atau tanda pembeda yang digunakan sebagai merek dalam perdagangan barang/jasa atau digunakan sebagai lambang organisasi, badan usaha, atau badan hukum sebagaimana dimaksud dalam Pasal 65 dan;', 1);
    $section->addListItem('Bukan merupakan Ciptaan yang melanggar norma agama, norma susila, ketertiban umum, pertahanan dan keamanan negara atau melanggar peraturan perundang-undangan sebagaimana dimaksud dalam  Pasal 74 ayat (1) huruf d  Undang-Undang Nomor 28 Tahun 2014 tentang Hak Cipta.', 1);
    $section->addTextBreak(1);
    $section->addListItem('Sebagai pemohon mempunyai kewajiban untuk menyimpan asli contoh ciptaan yang dimohonkan  dan harus memberikan apabila dibutuhkan untuk kepentingan penyelesaian sengketa perdata maupun pidana sesuai dengan ketentuan perundang-undangan.', 0, null, $listStyle);
    $section->addTextBreak(1);
    $section->addListItem('Karya Cipta yang saya mohonkan pada Angka 1 tersebut di atas tidak pernah dan tidak sedang dalam sengketa  pidana dan/atau perdata di Pengadilan.', 0, null, $listStyle);
    $section->addTextBreak(1);
    $section->addListItem('Dalam hal ketentuan sebagaimana dimaksud dalam Angka 1 dan Angka 3 tersebut di atas saya / kami langgar, maka saya / kami bersedia secara sukarela bahwa :', 0, null, $listStyle);
    $listStyle2 = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_ALPHANUM);
    $listStyle3 = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_ALPHANUM);
    $section->addListItem('Permohonan karya cipta yang saya ajukan dianggap ditarik kembali; ', 1, null, $listStyle2);
    $section->addTextRun(['indent' => 2])->addText("Karya Cipta yang telah terdaftar dalam Daftar Umum Ciptaan Direktorat Hak Cipta, Direktorat Jenderal Hak Kekayaan Intelektual, Kementerian Hukum Dan Hak Asasi Manusia R.I dihapuskan sesuai dengan ketentuan perundang-undangan yang berlaku.");
    $section->addListItem('Dalam hal kepemilikan Hak Cipta yang dimohonkan secara elektronik sedang dalam berperkara dan/atau sedang dalam gugatan di Pengadilan maka status kepemilikan surat pencatatan elektronik tersebut ditangguhkan menunggu putusan Pengadilan yang berkekuatan hukum tetap.; ', 1, null, $listStyle2);
    $section->addTextBreak(1);

    $section->addText("Demikian Surat pernyataan ini saya / kami buat dengan sebenarnya dan untuk dipergunakan sebagimana mestinya.");

    $textrun = $section->addTextRun(['indent' => 7]); //ganti baris
    $textrun->addText("Cikarang, " . date('d') . ' ' . $namaBulan[date('m') - 1] . ' ' . date("Y"));

    $fancyTableStyleName = 'TTD';
    $fancyTableStyle = array('borderSize' => 0, 'borderColor' => 'ffffff', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50);
    $fancyTableFirstRowStyle = array('borderBottomSize' => 0, 'borderBottomColor' => 'ffffff', 'bgColor' => 'ffffff', 'width' => 100);
    $fancyTableCellStyle = array('valign' => 'center');
    $myFontStyle = array('bold' => false, 'align' => 'center');
    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
    $table = $section->addTable($fancyTableStyleName);
    $table->addRow(900);
    $table->addCell(5000, $fancyTableCellStyle)->addText('', $myFontStyle, array('alignment' => 'center'));
    $table->addCell(5000, $fancyTableCellStyle)->addText('Yang Menyatakan', $myFontStyle, array('alignment' => 'center'));
    $table->addRow();
    $table->addCell(5000)->addText("");
    $table->addCell(5000)->addText("");
    $table->addRow(100);
    $table->addCell(5000)->addText("", $myFontStyle, array('alignment' => 'center'));
    $table->addCell(5000)->addText("( \t\t\t )", $myFontStyle, array('alignment' => 'center'));
    $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
    $phpWord->save($temp_file, 'Word2007');

    header('Content-Disposition: attachment; filename="' . $pencipta[0]['nama'] . '""' . $data['judul_ciptaan'] . '.docx"');
    readfile($temp_file); // or echo file_get_contents($temp_file);
    unlink($temp_file);  // remove temp file
    exit();
}

function cari_max_index($index, $str)
{
    if (strlen($str) - 1 < $index) return $index;
    if ($str[$index] == ' ') return $index;
    else {
        $index2 = $index;
        while ($index2 > 0) {
            if ($str[--$index2] == ' ') return $index2;
        }
        return $index;
    }
}
