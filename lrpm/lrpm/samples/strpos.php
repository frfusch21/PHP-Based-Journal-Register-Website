<?php
$a="Karya Ilmiah - OPTIMASI ADABOOST-C4.5 MENGGUNAKAN K-NEAREST NEIGHBOR IMPUTATION BERBASIS RELIEFF FEATURE SELECTION UNTUK DIAGNOSIS PENYAKIT GINJAL KRONIS";
$max_perline = 42;
$current_len=0;
$len=strlen($a);
while($current_len<$len){
  $next_len = $current_len+$max_perline;
  echo substr($target, $current_len, $max_perline)."\n";
  $current_len = $next_len;
}
?>