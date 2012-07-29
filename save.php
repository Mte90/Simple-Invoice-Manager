<?
	include('./config.php');

	if($_GET['mode']='save_invoice') {
		$content .= $_GET['content'];
		$content .= '<invoice>'."\n";
		$content .= '<number>'.$_GET['invoice_number'].'</number>'."\n";
		$content .= '<note>"'.$_GET['note'].'"</note>'."\n";
		$content .= '<date>"'.$_GET['date'].'"</date>'."\n";
		$content .= '<tax>'.$_GET['tax'].'</tax>'."\n";
		$content .= '<address>"'.$_GET['address'].'"</address>'."\n";
		$content .= '</invoice>';
		file_put_contents('./invoice/'.$_GET['invoice_number'].'.xml',$content);
	}

?>
