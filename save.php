<?
	include('./config.php');

	if($_GET['mode']=='save_invoice') {
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
	}elseif($_GET['mode']=='new_client') {
		$number_clients = get_last_file('./clients');
		$number_clients++;
		$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$content .= '<client>'."\n\t";
		$content .= '<name>'.clean($_GET['name']).'</name>'."\n\t";
		$content .= '<vat>'.clean($_GET['vat']).'</vat>'."\n\t";
		$content .= '<address>'.clean($_GET['address']).'</address>'."\n\t";
		$content .= '<zipcode>'.clean($_GET['zipcode']).'</zipcode>'."\n\t";
		$content .= '<city>'.clean($_GET['city']).'</city>'."\n\t";
		$content .= '<region>'.clean($_GET['region']).'</region>'."\n\t";
		$content .= '<phone>'.clean($_GET['phone']).'</phone>'."\n\t";
		$content .= '<email>'.clean($_GET['email']).'</email>'."\n";
		$content .= '</client>';

		file_put_contents('./clients/'.$number_clients.'.xml',$content);
	}

?>
