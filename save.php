<?
	include('./config.php');

	if($_GET['mode']='save_invoice') {
		$content = '<invoice>'."\n\t";
		$content .= '<number>'.clean($_GET['invoice_number']).'</number>'."\n\t";
		$content .= '<ticket>'.clean($_GET['invoice_ticket']).'</ticket>'."\n\t";
		$content .= '<note>"'.clean($_GET['note']).'"</note>'."\n\t";
		$content .= '<date>"'.clean($_GET['date']).'"</date>'."\n\t";
		$content .= '<tax>'.clean($_GET['tax']).'</tax>'."\n\t";
		$content .= '<address>"'.clean($_GET['address']).'"</address>'."\n";
		$content .= '</invoice>';
		$content .= $_GET['content'];

		file_put_contents('./invoice/'.clean($_GET['invoice_number']).'.xml',$content);
	}

?>
