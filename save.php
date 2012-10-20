<?
	include('./config.php');

	$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n\t";

	$data = array();
	if($_GET['mode']=='save_invoice') {

		$data['number'] = clean($_GET['invoice_number']);
		$data['ticket'] = clean($_GET['invoice_ticket']);
		$data['note'] = clean($_GET['note']);
		$data['date'] = clean($_GET['date']);
		$data['tax'] = clean($_GET['tax']);
		$data['client'] = clean($_GET['client_number']);
		$data['logo'] = clean($_GET['logo']);
		$data['last-mod'] = time();
		$temp_arr = json_to_array($_GET['content']);
		$data['products'] = $temp_arr['product'];

		$content = array_to_xml($data, 'invoice')->asXML();

		if (!file_exists('./invoice/'.date('Y'))) {
			mkdir('./invoice/'.date('Y'));
			file_put_contents('./invoice/'.date('Y').'/index.php','');
		}

		if($_GET['old_date']==clean($_GET['date']) && $_GET['old_number']!=clean($_GET['invoice_number'])){
			unlink('./invoice/'.date('Y').'/'.$_GET['old_number'].'.xml');
		}

		file_put_contents('./invoice/'.date('Y').'/'.clean($_GET['invoice_number']).'.xml',$content);
	} elseif($_GET['mode']=='save_draft_invoice') {
		$number_drafts = get_last_element('draft');
		$number_drafts++;

		$data['number'] = clean($_GET['invoice_number']);
		$data['ticket'] = clean($_GET['invoice_ticket']);
		$data['note'] = clean($_GET['note']);
		$data['date'] = clean($_GET['date']);
		$data['tax'] = clean($_GET['tax']);
		$data['client'] = clean($_GET['client_number']);
		$data['logo'] = clean($_GET['logo']);
		$data['last-mod'] = time();
		$temp_arr = json_to_array($_GET['content']);
		$data['products'] = $temp_arr['product'];

		$content = array_to_xml($data, 'invoice')->asXML();

		file_put_contents('./invoice/draft/'.$number_drafts.'.xml',$content);
	} elseif($_GET['mode']=='new_client') {
		$number_clients = get_last_element('client');
		$number_clients++;

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

		$content .= '<note>'."\n\t";
		$content .= '<name>'.clean($_GET['name']).'</name>'."\n\t";
		$content .= '<text>'.clean($_GET['text']).'</text>'."\n";
		$content .= '</note>';

		file_put_contents('./notes/'.$number_clients.'.xml',$content);
	}elseif($_GET['mode']=='mod_note') {

		$content .= '<note>'."\n\t";
		$content .= '<name>'.clean($_GET['name']).'</name>'."\n\t";
		$content .= '<text>'.clean($_GET['text']).'</text>'."\n";
		$content .= '</note>';

		file_put_contents('./notes/'.$_GET['note'].'.xml',$content);
	} elseif($_GET['mode']=='mod_client') {

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
