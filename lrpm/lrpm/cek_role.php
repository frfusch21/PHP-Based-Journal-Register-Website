<?php 
function cek_role($current_role, $target_role){
	if($current_role!=$target_role){
		header("HTTP/1.0 403 Forbidden");
		exit();
	}
}
