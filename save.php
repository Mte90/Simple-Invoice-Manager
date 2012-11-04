<?
	include('./config.php');

	$data = array();
	if($_GET['mode']=='save_invoice') {

		$data['number'] 	= clean($_GET['invoice_number']);
		$data['ticket'] 	= clean($_GET['invoice_ticket']);
		$data['note'] 		= clean($_GET['note']);
		$data['date'] 		= clean($_GET['date']);
		$data['tax'] 		= clean($_GET['tax']);
		$data['customer'] 	= clean($_GET['customer_number']);
		$data['logo'] 		= clean($_GET['logo']);
		$data['last-mod'] 	= time();
		$temp_arr = json_to_array($_GET['content']);
		$data['products'] 	= $temp_arr['product'];

		$content = array_to_xml($data, 'invoice')->asXML();
		$content = format_xml($content);

		if (!file_exists('./invoice/'.get_last_year())) {
			mkdir('./invoice/'.get_last_year());
			file_put_contents('./invoice/'.get_last_year().'/index.php','');
		}

		if(!sset($_GET['year'])){
			$year_invoice = $_GET['year'];
		} else {
			$year_invoice = get_last_year();
		}

		$inv_info = extract_invoice(clean($_GET['invoice_number']),$year_invoice);

		if($_GET['old_date']==clean($_GET['date']) && $_GET['old_number']!=clean($_GET['invoice_number'])){
			$inv_info = extract_invoice($_GET['old_number']);
			unlink('./invoice/'.$year_invoice.'/'.$_GET['old_number'].'.xml');
		}

		if ($inv_info['customer']!=$data['customer']) {
			//remove info of old customer
			$file_history = './customers/'.$data['customer'].'_history.xml';
			$add_history = true;
			if(!file_exists($file_history)){
				$add_history=true;
			} else {
				$check = xml2array($file_history);
				foreach($check as $key => $value){
					if($check[$key]['number']==$data['number'] && $check[$key]['year']== $year_invoice ) {
						$add_history = false;
						break;
					}
				}
			}

			if($add_history){
				$data_h['invoice']['number'] = $data['number'];
				$data_h['invoice']['year'] = $year_invoice;
				$history['history'] = $data_h['invoice'];

				$content_h = array_to_xml($history, 'customer-history')->asXML();
				$content_h = format_xml($content_h);
				file_put_contents($file_history,$content_h);
			}
		}

		file_put_contents('./invoice/'.$year_invoice.'/'.clean($_GET['invoice_number']).'.xml',$content);
	} elseif($_GET['mode']=='save_draft_invoice') {
		$number_drafts = get_last_element('draft');
		$number_drafts++;

		$data['number'] 	= clean($_GET['invoice_number']);
		$data['ticket'] 	= clean($_GET['invoice_ticket']);
		$data['note'] 		= clean($_GET['note']);
		$data['date'] 		= clean($_GET['date']);
		$data['tax'] 		= clean($_GET['tax']);
		$data['customer'] 	= clean($_GET['customer_number']);
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
			$path = './invoice/'.get_last_year().'/'.clean($_GET['invoice_number']).'.xml';
		} else {
			$path = './invoice/draft/'.clean($_GET['invoice_number']).'.xml';
		}

		$file = new SimpleXMLElement(file_get_contents($path));
		$file->addChild("payment_capture",$data['payment_capture']);
		$file->addChild("payment_date",$data['payment_date']);

		$content = format_xml($file->asXML());

		file_put_contents($path,$content);

	}  elseif($_GET['mode']=='new_customer') {
		$number_customers = get_last_element('customer');
		$number_customers++;

		$data['name'] 		= clean($_GET['name']);
		$data['vat'] 		= clean($_GET['vat']);
		$data['address'] 	= clean($_GET['address']);
		$data['zipcode'] 	= clean($_GET['zipcode']);
		$data['city'] 		= clean($_GET['city']);
		$data['region'] 	= clean($_GET['region']);
		$data['phone'] 		= clean($_GET['phone']);
		$data['email'] 		= clean($_GET['email']);

		$content = array_to_xml($data, 'customer')->asXML();
		$content = format_xml($content);

		file_put_contents('./customers/'.$number_customers.'.xml',$content);
	} elseif($_GET['mode']=='mod_customer') {

		$data['name'] 		= clean($_GET['name']);
		$data['vat'] 		= clean($_GET['vat']);
		$data['address'] 	= clean($_GET['address']);
		$data['zipcode'] 	= clean($_GET['zipcode']);
		$data['city'] 		= clean($_GET['city']);
		$data['region'] 	= clean($_GET['region']);
		$data['phone'] 		= clean($_GET['phone']);
		$data['email'] 		= clean($_GET['email']);

		$content = array_to_xml($data, 'customer')->asXML();
		$content = format_xml($content);

		file_put_contents('./customers/'.$_GET['customer'].'.xml',$content);
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
