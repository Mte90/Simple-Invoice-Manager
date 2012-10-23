<?
	include('./config.php');

	$data = array();
	if($_GET['mode']=='save_invoice') {

		$data['number'] 	= clean($_GET['invoice_number']);
		$data['ticket'] 	= clean($_GET['invoice_ticket']);
		$data['note'] 		= clean($_GET['note']);
		$data['date'] 		= clean($_GET['date']);
		$data['tax'] 		= clean($_GET['tax']);
		$data['client'] 	= clean($_GET['client_number']);
		$data['logo'] 		= clean($_GET['logo']);
		$data['last-mod'] 	= time();
		$temp_arr = json_to_array($_GET['content']);
		$data['products'] 	= $temp_arr['product'];

		$content = array_to_xml($data, 'invoice')->asXML();
		$content = format_xml($content);

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

		$data['number'] 	= clean($_GET['invoice_number']);
		$data['ticket'] 	= clean($_GET['invoice_ticket']);
		$data['note'] 		= clean($_GET['note']);
		$data['date'] 		= clean($_GET['date']);
		$data['tax'] 		= clean($_GET['tax']);
		$data['client'] 	= clean($_GET['client_number']);
		$data['logo'] 		= clean($_GET['logo']);
		$data['last-mod'] 	= time();
		$temp_arr = json_to_array($_GET['content']);
		$data['products'] 	= $temp_arr['product'];

		$content = array_to_xml($data, 'invoice')->asXML();
		$content = format_xml($content);

		file_put_contents('./invoice/draft/'.$number_drafts.'.xml',$content);
	} elseif($_GET['mode']=='invoice_option') {

		$data['payment_date'] 		= clean($_GET['date']);
		$data['payment_capture'] 	= clean($_GET['capture']);

		$content = array_to_xml($data, 'invoice')->asXML();
		$content = format_xml($content);

		if(isset($_GET['is_invoice'])&&$_GET['is_invoice']==true){
			$path = './invoice/'.date('Y').'/'.clean($_GET['invoice_number']).'.xml';
		} else {
			$path = './invoice/draft/'.clean($_GET['invoice_number']).'.xml';
		}

		$file = new SimpleXMLElement(file_get_contents($path));
		$file->addChild("payment_capture",$data['payment_capture']);
		$file->addChild("payment_date",$data['payment_date']);

		$content = format_xml($file->asXML());

		file_put_contents($path,$content);

	}  elseif($_GET['mode']=='new_client') {
		$number_clients = get_last_element('client');
		$number_clients++;

		$data['name'] 		= clean($_GET['name']);
		$data['vat'] 		= clean($_GET['vat']);
		$data['address'] 	= clean($_GET['address']);
		$data['zipcode'] 	= clean($_GET['zipcode']);
		$data['city'] 		= clean($_GET['city']);
		$data['region'] 	= clean($_GET['region']);
		$data['phone'] 		= clean($_GET['phone']);
		$data['email'] 		= clean($_GET['email']);

		$content = array_to_xml($data, 'client')->asXML();
		$content = format_xml($content);

		file_put_contents('./clients/'.$number_clients.'.xml',$content);
	} elseif($_GET['mode']=='mod_client') {

		$data['name'] 		= clean($_GET['name']);
		$data['vat'] 		= clean($_GET['vat']);
		$data['address'] 	= clean($_GET['address']);
		$data['zipcode'] 	= clean($_GET['zipcode']);
		$data['city'] 		= clean($_GET['city']);
		$data['region'] 	= clean($_GET['region']);
		$data['phone'] 		= clean($_GET['phone']);
		$data['email'] 		= clean($_GET['email']);

		$content = array_to_xml($data, 'client')->asXML();
		$content = format_xml($content);

		file_put_contents('./clients/'.$_GET['client'].'.xml',$content);
	} elseif($_GET['mode']=='new_note') {
		$number_notes = get_last_element('note');
		$number_notes++;

		$data['name'] 		= clean($_GET['name']);
		$data['text'] 		= clean($_GET['text']);

		$content = array_to_xml($data, 'note')->asXML();

		file_put_contents('./notes/'.$number_notes.'.xml',$content);
	} elseif($_GET['mode']=='mod_note') {

		$data['name'] 		= clean($_GET['name']);
		$data['text'] 		= clean($_GET['text']);

		$content = array_to_xml($data, 'note')->asXML();
		$content = format_xml($content);

		file_put_contents('./notes/'.$_GET['note'].'.xml',$content);
	}

?>
