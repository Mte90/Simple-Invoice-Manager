<?
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

	/* Get last element invoice or client */
	function get_last_element($folder,$ext=false){
		if($folder == "client") {
			$folder = './clients';
		} elseif($folder == "invoice") {
			$folder = './invoice/'.date('Y');
		} elseif($folder == "draft") {
			$folder = './invoice/draft';
		} elseif($folder == "note") {
			$folder = './notes';
		}
		$files = scandir($folder, 1);
		$files = array_diff($files, array("index.php",'..','.'));
		$files = array_values($files);
		if(empty($files)){
			$last_file = '0';
		}else {
			if($ext==false){
				$last_file = pathinfo($files[0]);
				$last_file = $last_file['filename'];
			} else {
				$last_file = $files[0];
			}
		}
		return $last_file;
	}

	/* Get client info */
	function read_client_info($path) {
	global $l10n;
		if(file_exists('./clients/'.$path .'.xml')) {
			$client = xml2array('./clients/'.$path .'.xml');
		} else {
			$client['name'] = $l10n['CLIENT_NOT_DEFINED'];
		}
		return $client;
	}

	/* Get note info */
	function read_note_info($path) {
		$note = xml2array('./notes/'.$path .'.xml');
		return $note;
	}

	/* Get array of client */
	function client_list() {
		$client_list = Array();
		if ($handle = opendir('./clients/')) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php" && strpos($entry,'_history.xml') === false) {
					$entry = str_replace('.xml','',$entry);
					$client_list[] = array(read_client_info($entry),$entry);
				}
			}
			closedir($handle);
		}
		return $client_list;
	}

	/* Get array of logo */
	function logo_list() {
		$logo_list = Array();
		if ($handle = opendir('./logos/')) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php") {
					$logo_list[] = $entry;
				}
			}
			closedir($handle);
		}
		return $logo_list;
	}

	/* Get Array of Invoice */
	function get_invoice($year='last'){
		if ($year=='last') {
			$folder = './invoice/'.date('Y');
		}elseif($year=='draft'){
			$folder = './invoice/draft';
		}else{
			$folder = './invoice/'.$year;
		}
		$files = scandir($folder, 1);
		$files = array_diff($files, array("index.php",'..','.'));
		$files = array_values($files);
		$files = str_replace('.xml','',$files);
		return $files;
	}

	/* Return Invoice data */
	function extract_invoice($file,$year='last') {
		if ($year=='last') {
			$year = get_last_year();
			$folder = './invoice/'.$year;
		}elseif($year=='draft'){
			$folder = './invoice/draft';
		}else{
			$folder = './invoice/'.$year;
		}
		$xml = xml2array($folder.'/'.$file.'.xml');
		if(!isset($xml['client'])){
			$xml['client'] = '';
		}
		$xml['year']=$year;
		$xml['product'] = $xml['products']['product'];
		return $xml;
	}

	/* Get array of notes */
	function notes_list() {
		$notes_list = Array();
		if ($handle = opendir('./notes/')) {
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

	/* Get history of invoice by client */
	function history_invoice($client){
		$file = './clients/'.$client.'_history.xml';
		$history_list = Array();
		if(file_exists($file)){
			$xml = xml2array($file);
			return $xml;
		} else {
			return '';
		}
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

	/* Set the header for load pdf file */
	function header_pdf($filename){
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize('./tmp/'.$filename));
		header('Accept-Ranges: bytes');
		header("Cache-Control: no-cache");

		@readfile('./tmp/'.$filename);
	}

	/* Check exist last pdf version */
	function need_new_pdf($invoice,$time) {
		$pdf_name='invoice-'.$invoice.'-'.$time.'.pdf';
		$pdf_path='./tmp/'.$pdf_name;

		if (file_exists($pdf_path)) {
			return false;
		}else{
			foreach (glob('./tmp/invoice-'.$invoice.'-*.pdf') as $filename) {
				unlink($filename);
			}
			return true;
		}
	}

	/* Format xml file for debug */
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
?>
