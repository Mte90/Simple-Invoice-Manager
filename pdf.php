<?
	require_once('./config.php');

	$invoice_data = extract_invoice($_GET['inv'],$_GET['year']);

	$total = 0;
	foreach($invoice_data['product'] as $item){
		$total += $item['rate'] * $item['quantity'];
	}

$content = '
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>'.$l10n['TITLE'].'</title>
		<style>'.file_get_contents('./css/bootstrap.min.css').'
		</style>
		<style>'.file_get_contents('./css/style.css').'
		</style>
	</head>
	<body>
		<header>
			<address>'.$config['invoice_info'].'</address>
			<span><img alt="" src="'.$invoice_data['logo'].'" id="logo"></span>
		</header>
		<article>
			<h1>'.$l10n['RECIPIENT'].'</h1>
			<address class="client_info">';
			$client_info = read_client_info($invoice_data['client']);
			$content .= '<table><tr>';
			$content .= '<th>'.$l10n['NAME'].'</th><td colspan="4">'.$client_info['name'].'</td></tr>';
			$content .= '<tr><th>'.$l10n['VAT'].'</th><td colspan="2">'.$client_info['vat'].'</td>';
			$content .= '<th>'.$l10n['CITY'].'</th><td>'.$client_info['city'].'</td></tr>';
			$content .= '<tr><th>'.$l10n['ADDRESS'].'</th><td colspan="2">'.$client_info['address'].'</td>';
			$content .= '<th>'.$l10n['ZIP_CODE'].'</th><td>'.$client_info['zipcode'].'</td></tr>';
			$content .= '<th>'.$l10n['REGION'].'</th><td>'.$client_info['region'].'</td>';
			$content .= '<th>'.$l10n['PHONE_FAX'].'</th><td colspan="2">'.$client_info['phone'].'</td></tr>';
			$content .= '</tr></table>
			</address>
			<table class="meta">
				<tr>
					<th><span>'.$l10n['INVOICE'].'</span></th>
					<td><span class="invoice_n">'.$invoice_data['number'].'</span></td>
				</tr>
				<tr>
					<th><span>'.$l10n['DATE'].'</span></th>
					<td><span class="invoice_date">'.$invoice_data['date'].'</span></td>
				</tr>
				<tr>
					<th><span>'.$l10n['AMOUNT_DUE'].'</span></th>
					<td><span id="prefix">'.$config['prefix'].'</span><span id="total">'.$total.'</span></td>
				</tr>';
				if($config['number_ticket']){
				$content .= '<tr>
					<th><span>'.$l10n['NUMBER_TICKET'].'</span></th>
					<td><span class="invoice_ticket">'.$invoice_data['ticket'].'</span></td>
					</tr>';
				}
			$content .= '</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span>'.$l10n['ITEM'].'</span></th>
						<th><span>'.$l10n['RATE'].'</span></th>
						<th><span>'.$l10n['QUANTITY'].'</span></th>
						<th><span>'.$l10n['PRICE'].'</span></th>
					</tr>
				</thead>
				<tbody>';
					foreach($invoice_data['product'] as $item) {
						$price = $item['rate'] * $item['quantity'];
						$content .= '<tr>
						<td><span>'.$item['item'].'</span></td>
						<td><span>'.$config['prefix'].'</span><span>'.$item['rate'].'</span></td>
						<td><span>'.$item['quantity'].'</span></td>
						<td><span>'.$config['prefix'].'</span><span>'.$price.'</span></td>
						</tr>';
					}
			$percent = percent($invoice_data['tax'],$total);
			$content .= '</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span>'.$l10n['TAX'].'</span></th>
					<td><span id="value_tax">'.$invoice_data['tax'].'</span>%</td>
				</tr>
				<tr>
					<th><span>'.$l10n['TAXED_IMPORT'].'</span></th>
					<td><span>'.$config['prefix'].'</span><span>'.$percent.'</span></td>
				</tr>
				<tr>
					<th><span>'.$l10n['ORIGINAL_IMPORT'].'</span></th>
					<td><span>'.$config['prefix'].'</span><span>'.($total-$percent).'</span></td>
				</tr>
				<tr>
					<th><span>'.$l10n['TOTAL'].'</span></th>
					<td><span>'.$config['prefix'].'</span><span>'.$total.'</span></td>
				</tr>
			</table>
		</article>
		<aside>
			<h1><span>'.$l10n['NOTE'].'</span></h1>
			<div class="invoice_note">'.$invoice_data['note'].'</div>
		</aside>
	</body>
</html>';

echo $content;
?>