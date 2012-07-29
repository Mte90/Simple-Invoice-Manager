<?
	include('./config.php');

	if($_GET['mode']='save_invoice') {
		file_put_contents('./invoice',$_GET['content'])
	}

?>
