<?
	function clean($string){
		$string = str_replace(array("\r\n", "\r", "\n", "\t", '  '), ' ',trim($string));
		return $string;
	}

	function xml2array($file){
		return json_decode(json_encode((array) simplexml_load_file($file)), 1);
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
			$folder = './invoice/notes';
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
		$client = xml2array('./clients/'.$path .'.xml');
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
				if ($entry != "." && $entry != ".." && $entry != "index.php") {
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
		$xml['year']=$year;
		return $xml;
	}

	/* Get array of notes */
	function notes_list() {
		$client_list = Array();
		if ($handle = opendir('./notes/')) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php") {
					$entry = str_replace('.xml','',$entry);
					$notes_list[] = array(read_note_info($entry),$entry);
				}
			}
			closedir($handle);
		}
		return $notes_list;
	}

	function get_last_year(){
		return date('Y');
	}

	function percent($num_amount, $num_total) {
		$count = ($num_amount*$num_total) / 100;
		return $count;
	}

	function header_pdf($filename){
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize('./tmp/'.$filename));
		header('Accept-Ranges: bytes');
		header("Cache-Control: no-cache");

		@readfile('./tmp/'.$filename);
	}
?>
