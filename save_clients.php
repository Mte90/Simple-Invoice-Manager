<?
	include('./config.php');

	if($_GET['mode']='new_client') {

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
		$content .= '<phone>'.clean($_GET['phone']).'</phone>'."\n";
		$content .= '<email>'.clean($_GET['email']).'</email>'."\n";
		$content .= '</client>';

		file_put_contents('./clients/'.$number_clients.'.xml',$content);
	}

?>
