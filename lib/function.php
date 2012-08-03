<?
	function clean($string){
		$string = str_replace(array("\r\n", "\r", "\n", "\t", '  '), ' ',trim($string));
		return $string;
	}
?>
