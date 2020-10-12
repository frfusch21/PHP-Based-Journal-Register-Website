<?php
$target="Karya Ilmiah - Perancangan Sistem Monitoring Jam Kerja Mesin Terintegrasi Perawatan Preventif";
$max_perline = 48;
$len=strlen($target);
while(strlen($target)>0){
	$max_index = cari_max_index($max_perline-1, $target);
	$hasil = substr($target, 0, $max_index+1).$filled;
	$filled = $max_perline-strlen($hasil)>0?str_repeat('_', $max_perline-strlen($hasil)):'';
	echo $hasil.$filled."\n";
	$target = trim(substr($target, $max_index+1));
}
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
?>