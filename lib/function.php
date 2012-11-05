<?
	/* Specific function */


	/* Get Array of Invoice by the folder choosen
	* @param string $folder_choosen the folder choosen
	*/
	function invoice_list($folder_choosen='last'){
	global $path;
		if ($folder_choosen=='last') {
			$folder = $path['invoice'].DIRECTORY_SEPARATOR.get_last_year();
		}elseif($folder_choosen=='draft'){
			$folder = $path['draft'];
		}else{
			$folder = $path['invoice'].DIRECTORY_SEPARATOR.$folder_choosen;
		}
		$files = scandir($folder, 1);
		$files = array_diff($files, array("index.php",'..','.'));
		$files = array_values($files);
		$files = str_replace('.xml','',$files);
		return $files;
	}

	/* Get Array of Customer */
	function customer_list() {
	global $path;
		$customer_list = Array();
		if ($handle = opendir($path['customers'].DIRECTORY_SEPARATOR)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php" && strpos($entry,'_history.xml') === false) {
					$entry = str_replace('.xml','',$entry);
					$customer_list[] = array(read_customer_info($entry),$entry);
				}
			}
			closedir($handle);
		}
		return $customer_list;
	}

	/* Get Array of Logo */
	function logo_list() {
	global $path;
		$logo_list = Array();
		if ($handle = opendir($path['logos'].DIRECTORY_SEPARATOR)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php") {
					$logo_list[] = $entry;
				}
			}
			closedir($handle);
		}
		return $logo_list;
	}

	/* Get Array of Notes */
	function notes_list() {
	global $path;
		$notes_list = Array();
		if ($handle = opendir($path['notes'])) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php") {
					$entry = str_replace('.xml','',$entry);
					$notes_list[] = array(read_note_info($entry),$entry);
				}
			}
			closedir($handle);
		}

		if(!count($notes_list)>0){
			$notes_list[0]='error';
		}

		return $notes_list;
	}

	/* Get customer info by the id
	* @param string $id the id of the customer
	*/
	function read_customer_info($id) {
	global $l10n,$path;
		if(file_exists($path['customers'].DIRECTORY_SEPARATOR.$id.'.xml')) {
			$customer = xml2array($path['customers'].DIRECTORY_SEPARATOR.$id.'.xml');
		} else {
			$customer['name'] = $l10n['CUSTOMER_NOT_DEFINED'];
		}
		return $customer;
	}

	/* Get note info by the id
	* @param string $id the id of the note
	*/
	function read_note_info($id) {
	global $path;
		$note = xml2array($path['notes'].DIRECTORY_SEPARATOR.$id.'.xml');
		return $note;
	}

	/* Get Invoice info by id and folder
	* @param string $id the id of the invoice
	* @param string $folder_choosen the folder choosen
	*/
	function read_invoice_info($id,$folder_choosen='last') {
	global $path;
		if ($folder_choosen=='last') {
			$folder_choosen = get_last_year();
			$folder = $path['invoice'].DIRECTORY_SEPARATOR.$folder_choosen;
		}elseif($folder_choosen=='draft'){
			$folder = $path['draft'];
		}else{
			$folder = $path['invoice'].DIRECTORY_SEPARATOR.$folder_choosen;
		}
		$xml = xml2array($folder.DIRECTORY_SEPARATOR.$id.'.xml');
		if(!isset($xml['customer'])){
			$xml['customer'] = '';
		}
		$xml['year']=$folder_choosen;
		$xml['product'] = $xml['products']['product'];
		if(!isset($xml['payment_capture'])){
			$xml['payment_capture'] = "";
		}
		return $xml;
	}

	/* Get Array of annual invoice  */
	function get_annual_invoice() {
	global $path;
		$contents = array();
		$dir = $path['invoice'];
		foreach (scandir($dir) as $node) {
			if ($node == '.')  continue;
			if ($node == '..') continue;
			if ($node == 'draft') continue;
			if (is_dir($dir . DIRECTORY_SEPARATOR . $node)) {
				$contents[] = $node;
			}
		}
		return $contents;
	}

	/* Get history of invoice by customer
	* @param string $id the id of the customer
	*/
	function history_invoice($id){
	global $path;
		$file = $path['customers'].DIRECTORY_SEPARATOR.$id.'_history.xml';
		$history_list = Array();
		if(file_exists($file)){
			$xml = xml2array($file);
			return $xml;
		} else {
			return '';
		}
	}

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

	/* Format xml file for debug
	* @param string $xml the xml that be formatted
	*/
	function format_xml($xml){
	global $config;
		if($config['debug']){
			$dom = new DOMDocument('1.0');
			$dom->loadXML($xml);
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$xml = $dom->saveXML($dom);
		}
		return $xml;
	}

	/* General Function */

	/* Get last element invoice or customer of you want the last element
	* @param string $folder the folder
	*/
	function get_last_element($folder){
	global $path;
		if($folder == "customer") {
			$folder = $path['customers'];
		} elseif($folder == "invoice") {
			$folder = $path['invoice'].DIRECTORY_SEPARATOR.get_last_year();
		} elseif($folder == "draft") {
			$folder = $path['draft'];
		} elseif($folder == "note") {
			$folder = $path['notes'];
		}
		$files = scandir($folder, 1);
		$files = array_diff($files, array("index.php",'..','.'));
		$files = array_values($files);
		if(empty($files)){
			$last_file = '0';
		}else {
			$last_file = pathinfo($files[0]);
			$last_file = $last_file['filename'];
		}
		return $last_file;
	}

	/* Remove break line and tab */
	function clean($string){
		return str_replace(array("\r\n", "\r", "\n", "\t", '  '), ' ',trim($string));
	}

	/* Xml to array */
	function xml2array($file){
		$array = json_decode(json_encode((array) simplexml_load_file($file)), 1);

		foreach($array as $key => $value){
			if(empty($array[$key])) $array[$key] = '';
		}
		if(!empty($array['products'])){
			foreach($array['products']['product'] as $key => $value){
				foreach($array['products']['product'][$key] as $keyz => $value){
					if(empty($array['products']['product'][$key][$keyz])) $array['products']['product'][$key][$keyz] = '';
				}
			}
		}
		return $array;
	}

	/* JSON to xml */
	function json_to_array($json){
		return json_decode($json,true);
	}

	/* Array to xml */
	function array_to_xml($array,$root=null,SimpleXMLElement $xml = null){

		if ($xml == null){
			$xml = new SimpleXMLElement('<'.$root.'/>');
		}

		//When the array have subarray the key are a number with this code change it
		if ($root=='invoice') {
			$ar_replace = 'product';
		}else {
			$ar_replace = 'history';
		}

		foreach ($array as $key => $value) {

			$key = (is_numeric($key)) ? 'product' : $key;
			if(is_array($value)){
				array_to_xml($value,$root, $xml->addChild($key));
			} else {
				$xml->addChild($key, $value);
			}

		}
		return $xml;
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
