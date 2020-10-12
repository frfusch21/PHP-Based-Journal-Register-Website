<?php 
require 'function.php';

$id_karyawan = $_GET["id_karyawan"];

if(hapus($id_karyawan) > 0){
	echo "
		<script>
			alert('data berhasil dihapus!');
			document.location.href = 'tabeldata.php';

		</script>
	";

}else {
	echo "
		<script>
			alert('data gagal dihapus!');
			document.location.href = 'tabeldata.php';

		</script>
	";
}

?>