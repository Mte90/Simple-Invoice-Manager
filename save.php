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
		$content .= '<logo>'.clean($_GET['logo']).'</logo>'."\n";
		$content .= '<last-mod>'.time().'</last-mod>';
		$content .= "\n\t".$_GET['content'];
		$content .= '</invoice>';
		if (!file_exists('./invoice/'.date('Y'))) {
			mkdir('./invoice/'.date('Y'));
			file_put_contents('./invoice.index.php','');
		}
		file_put_contents('./invoice/'.date('Y').'/'.clean($_GET['invoice_number']).'.xml',$content);
	}if($_GET['mode']=='save_draft_invoice') {
		$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n\t";
		$content .= '<invoice>'."\n\t\t";
		$content .= '<number>'.clean($_GET['invoice_number']).'</number>'."\n\t\t";
		$content .= '<ticket>'.clean($_GET['invoice_ticket']).'</ticket>'."\n\t\t";
		$content .= '<note>'.clean($_GET['note']).'</note>'."\n\t\t";
		$content .= '<date>'.clean($_GET['date']).'</date>'."\n\t\t";
		$content .= '<tax>'.clean($_GET['tax']).'</tax>'."\n\t\t";
		$content .= '<client>'.clean($_GET['client_number']).'</client>'."\n\t\t";
		$content .= '<logo>'.clean($_GET['logo']).'</logo>'."\n";
		$content .= '<last-mod>'.time().'</last-mod>';
		$content .= "\n\t".$_GET['content'];
		$content .= '</invoice>';
		file_put_contents('./invoice/draft/'.get_last_element('draft').'.xml',$content);
	} elseif($_GET['mode']=='new_client') {
		$number_clients = get_last_element('client');
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
	} elseif($_GET['mode']=='new_note') {
		$number_notes = get_last_element('note');
		$number_notes++;
		$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$content .= '<note>'."\n\t";
		$content .= '<name>'.clean($_GET['name']).'</name>'."\n\t";
		$content .= '<text>'.clean($_GET['text']).'</text>'."\n";
		$content .= '</note>';

		file_put_contents('./notes/'.$number_clients.'.xml',$content);
	}elseif($_GET['mode']=='mod_note') {
		$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$content .= '<note>'."\n\t";
		$content .= '<name>'.clean($_GET['name']).'</name>'."\n\t";
		$content .= '<text>'.clean($_GET['text']).'</text>'."\n";
		$content .= '</note>';

		file_put_contents('./notes/'.$_GET['note'].'.xml',$content);
	} elseif($_GET['mode']=='mod_client') {
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

		file_put_contents('./clients/'.$_GET['client'].'.xml',$content);
	}

?>
