<?
	function clean($string){
		$string = str_replace(array("\r\n", "\r", "\n", "\t", '  '), ' ',trim($string));
		return $string;
	}

	/* Get last element invoice or client */
	function get_last_element($folder,$ext=false){
		if($folder == "client") {
			$folder = './clients';
		} elseif($folder == "invoice") {
			$folder = './invoice';
		}
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

	/* Get client info */
	function read_client_info($path) {
		$xml = simplexml_load_file($path);
		$client['name']		= $xml->name;
		$client['vat']		= $xml->vat;
		$client['address']	= $xml->address;
		$client['zipcode']	= $xml->zipcode;
		$client['city']		= $xml->city;
		$client['region']	= $xml->region;
		$client['phone']	= $xml->phone;
		$client['email']	= $xml->email;
		return $client;
	}

	/* Get array of client */
	function client_list() {
		$client_list = Array();
		if ($handle = opendir('./clients/')) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "index.php") {
					$client_list[] = array(read_client_info('./clients/'.$entry),$entry);
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
?>
