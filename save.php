<?
	include('./config.php');

	if($_GET['mode']='save_invoice') {
		$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n\t";
		$content .= '<invoice>'."\n\t\t";
		$content .= '<number>'.clean($_GET['invoice_number']).'</number>'."\n\t\t";
		$content .= '<ticket>'.clean($_GET['invoice_ticket']).'</ticket>'."\n\t\t";
		$content .= '<note>'.clean($_GET['note']).'</note>'."\n\t\t";
		$content .= '<date>'.clean($_GET['date']).'</date>'."\n\t\t";
		$content .= '<tax>'.clean($_GET['tax']).'</tax>'."\n\t\t";
		$content .= '<client>'.clean($_GET['client_number']).'</client>'."\n\t\t";
		$content .= '<logo>'.clean($_GET['logo']).'</logo>'."\n\t";
		$content .= '</invoice>';
		$content .= "\n\t".$_GET['content'];

		file_put_contents('./invoice/'.clean($_GET['invoice_number']).'.xml',$content);
	}

?>
