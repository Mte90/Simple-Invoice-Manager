 <?
	include('./config.php');

	if(!empty($_GET['file'])){
		$customer_info = read_customer_info($_GET['file']);

		echo '<input type="hidden" name="customer_email" value="'.$customer_info['email'].'"/>';
		echo '<table><tr>';
		echo '<th>'.$l10n['NAME'].'</th><td colspan="4">'.$customer_info['name'].'</td></tr>';
		echo '<tr><th>'.$l10n['VAT'].'</th><td colspan="2">'.$customer_info['vat'].'</td>';
		echo '<th>'.$l10n['CITY'].'</th><td>'.$customer_info['city'].'</td></tr>';
		echo '<tr><th>'.$l10n['ADDRESS'].'</th><td colspan="2">'.$customer_info['address'].'</td>';
		echo '<th>'.$l10n['ZIP_CODE'].'</th><td>'.$customer_info['zipcode'].'</td></tr>';
		echo '<th>'.$l10n['REGION'].'</th><td>'.$customer_info['region'].'</td>';
		echo '<th>'.$l10n['PHONE_FAX'].'</th><td colspan="2">'.$customer_info['phone'].'</td></tr>';
		echo '</tr></table>';
	}else{
		echo '0';
	}
?>
