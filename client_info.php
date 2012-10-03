 <?
	include('./config.php');

	$client_info = read_client_info($_GET['file']);

	echo '<input type="hidden" name="client_email" value="'.$client_info['email'].'"/>';
	echo '<table><tr>';
	echo '<th>'.$l10n['NAME'].'</th><td colspan="4">'.$client_info['name'].'</td></tr>';
	echo '<tr><th>'.$l10n['VAT'].'</th><td colspan="2">'.$client_info['vat'].'</td>';
	echo '<th>'.$l10n['CITY'].'</th><td>'.$client_info['city'].'</td></tr>';
	echo '<tr><th>'.$l10n['ADDRESS'].'</th><td colspan="2">'.$client_info['address'].'</td>';
	echo '<th>'.$l10n['ZIP_CODE'].'</th><td>'.$client_info['zipcode'].'</td></tr>';
	echo '<th>'.$l10n['REGION'].'</th><td>'.$client_info['region'].'</td>';
	echo '<th>'.$l10n['PHONE_FAX'].'</th><td colspan="2">'.$client_info['phone'].'</td></tr>';
	echo '</tr></table>';
?>
