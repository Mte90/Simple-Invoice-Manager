<?
	require_once('./config.php');

	//http://www.php.net/manual/en/ziparchive.addfile.php#108491
	class zip extends ZipArchive {
		public function addDirectory($dir) {
			foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				$this->addDirectory($file);
			else
				$this->addFile($file);
			}
		}
	}


	$zip = new zip;
	$date = str_replace('/','-',date($config['date_format']));
	$res = $zip->open($path['tmp'].DIRECTORY_SEPARATOR.'backup-'.$date.'.zip', ZipArchive::CREATE);
	$zip->addDirectory($path['invoice']);
	$zip->addDirectory($path['notes']);
	$zip->addDirectory($path['logos']);
	$zip->addDirectory($path['customers']);
	$zip->addFile($path['root'].DIRECTORY_SEPARATOR.'config.php','config.php');
	$zip->close();

	//If you use a cron for execute this script comment the after line
	echo '<a href="tmp/backup-'.$date.'.zip">Download Backup '.$date.'</a>'
?>
