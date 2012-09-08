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
		}
		$files = scandir($folder, 1);
		$files = array_diff($files, array("index.php",'..','.'));
		$files = array_values($files);
		if(empty($files)){
			$last_file = '1';
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
		/*$xml = simplexml_load_file('./clients/'.$path .'.xml');
		$client['name']		= $xml->name;
		$client['vat']		= $xml->vat;
		$client['address']	= $xml->address;
		$client['zipcode']	= $xml->zipcode;
		$client['city']		= $xml->city;
		$client['region']	= $xml->region;
		$client['phone']	= $xml->phone;
		$client['email']	= $xml->email;*/
		$client = xml2array('./clients/'.$path .'.xml');
		return $client;
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
			$folder = './invoice/'.date('Y');
		}else{
			$folder = './invoice/'.$year;
		}
		$xml = xml2array($folder.'/'.$file.'.xml');
		return $xml;
	}
?>
