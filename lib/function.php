<?
	/* Set the header for load pdf file
	* @param string $filename the file to show
	*/
	function header_pdf($filename){
	global $path;
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($path['tmp'].DIRECTORY_SEPARATOR.$filename));
		header('Accept-Ranges: bytes');
		header("Cache-Control: no-cache");

		@readfile($path['tmp'].DIRECTORY_SEPARATOR.$filename);
	}

	/* Check exist last pdf version
	* @param string $id the id of the invoice
	* @param string $time the last-mod date of the invoice
	*/
	function need_new_pdf($id,$time) {
	global $path;
		$pdf_name='invoice-'.$id.'-'.$time.'.pdf';
		$pdf_path=$path['tmp'].DIRECTORY_SEPARATOR.$pdf_name;

		if (file_exists($pdf_path)) {
			return false;
		}else{
			foreach (glob($path['tmp'].DIRECTORY_SEPARATOR.'invoice-'.$id.'-*.pdf') as $filename) {
				unlink($filename);
			}
			return true;
		}
	}

	/* General Function */

	/* Remove break line and tab */
	function clean($string,$slash=false){
		if ($slash) {
			$string = str_replace('/','-',$string);
		}
		return str_replace(array("\r\n", "\r", "\n", "\t", '  '), ' ',trim($string));
	}

	/* JSON to xml */
	function json_to_array($json){
		return json_decode($json,true);
	}

	/* Get actual year */
	function get_last_year(){
		return date('Y');
	}

	/* Calculate the percentage */
	function percent($num_amount, $num_total) {
		$count = ($num_amount*$num_total) / 100;
		return $count;
	}
?>
