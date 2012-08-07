<?
	function clean($string){
		$string = str_replace(array("\r\n", "\r", "\n", "\t", '  '), ' ',trim($string));
		return $string;
	}

	function get_last_file($folder,$ext=false){
		$files = scandir($folder, 1);
		$files = array_diff($files, array("index.php",'..','.'));
		$files = array_values($files);
		if(empty($last_file)){
			$last_file[0] = '1.xml';
		}
		if($ext==false){
			$last_file = pathinfo($files[0]);
			$last_file = $last_file['filename'];
		} else {
			$last_file = $files[0];
		}
		return $last_file;
	}
?>
