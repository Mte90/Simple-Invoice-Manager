<?
	include('./config.php');

	if($_GET['mode']='save_invoice') {
		$content .= $_GET['content'];
		$content .= '<invoice>';
		$content .= '<number>'.$_GET['invoice_number'].'</number>';
		$content .= '<note>'.$_GET['note'].'</note>';
		$content .= '<date>'.$_GET['date'].'</date>';
		$content .= '<tax>'.$_GET['tax'].'</tax>';
		$content .= '<address>'.$_GET['address'].'</address>';
		$content .= '</invoice>';
		file_put_contents('./invoice/test.xml',$content);
	}

?>
