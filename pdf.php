<?
	require_once('./config.php');

	if (isset($invoice_n)) {
		$invoice_data = extract_invoice($invoice_n,$year);
	}else {
		$invoice_data = extract_invoice($_GET['inv'],$_GET['year']);
	}

	$total = 0;

	foreach($invoice_data['product'] as $item){
		$total += $item['rate'] * $item['quantity'];
	}

	$pdf_name='invoice-'.$invoice_data['number'].'-'.$invoice_data['last-mod'].'.pdf';
	$pdf_path='./tmp/'.$pdf_name;

	if (need_new_pdf($invoice_data['number'],$invoice_data['last-mod'])) {

		if(!$config['pdf']['pdfcrowd']){
			$logo_path='../';
		}else {
			$logo_path='./';
		}

$content = '
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>'.$l10n['TITLE'].' - '.$invoice_data['number'].'</title>
		<style type="text/css">'
		.file_get_contents('./css/bootstrap.min.css').'
		</style>
		<style type="text/css">'
		.file_get_contents('./css/style.css').'
		</style>
	</head>
	<body>
		<header>';

if($invoice_data['payment_capture']==='checked'){
$content .= '			<h1 class="green">'.$l10n['PAID'].'</h1>';
} else {
$content .= '			<h1 class="red">'.$l10n['NOT_PAID'].'</h1>';
}

$content .= '		<address>'.$config['invoice_info'].'</address>
			<span><img alt="" src="'.$logo_path.$invoice_data['logo'].'" id="logo"></span>
		</header>
		<article>
			<address class="customer_info">';
			$customer_info = read_customer_info($invoice_data['customer']);
			$content .= '<table><tr>';
			$content .= '<th>'.$l10n['NAME'].'</th><td colspan="4">'.$customer_info['name'].'</td></tr>';
			$content .= '<tr><th>'.$l10n['VAT'].'</th><td colspan="2">'.$customer_info['vat'].'</td>';
			$content .= '<th>'.$l10n['CITY'].'</th><td>'.$customer_info['city'].'</td></tr>';
			$content .= '<tr><th>'.$l10n['ADDRESS'].'</th><td colspan="2">'.$customer_info['address'].'</td>';
			$content .= '<th>'.$l10n['ZIP_CODE'].'</th><td>'.$customer_info['zipcode'].'</td></tr>';
			$content .= '<th>'.$l10n['REGION'].'</th><td>'.$customer_info['region'].'</td>';
			$content .= '<th>'.$l10n['PHONE_FAX'].'</th><td colspan="2">'.$customer_info['phone'].'</td></tr>';
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

	file_put_contents('./tmp/pdf.htm',$content);

	if($config['pdf']['wp']) {
		include('./lib/weasyprint.php');

		if (!isset($invoice_n)) {
			header_pdf($pdf_name);
		}

	}elseif($config['pdf']['pdfcrowd']) {
		include('./lib/pdfcrowd.php');

		try
		{
			$customer = new Pdfcrowd($config['pdfcrowd']['user'], $config['pdfcrowd']['key']);
			$pdf = fopen($pdf_path, "wb");
			$customer->usePrintMedia(true);
			$customer->setNoModify(true);
			$customer->setNoCopy(true);
			$zip = new ZipArchive;
			$res = $zip->open('./tmp/pdf.zip', ZipArchive::CREATE);
			$zip->addFile('./tmp/pdf.htm', 'pdf.htm');
			$zip->addFile('./'.$invoice_data['logo'], $invoice_data['logo']);
			$zip->close();
			$customer->convertFile('./tmp/pdf.htm',$pdf);
			fclose($pdf);

			if (!isset($invoice_n)) {
				header_pdf($pdf_name);
			}

		}
		catch(PdfcrowdException $why)
		{
			echo "Pdfcrowd Error: " . $why;
		}

	}elseif($config['pdf']['wkhtmltopdf']) {
		include('./lib/WkHtmlToPdf.php');

		$pdf = new WkHtmlToPdf;
		$pdf->addPage('./tmp/pdf.htm');
		$pdf->saveAs($pdf_path);

		if (!isset($invoice_n)) {
			header_pdf($pdf_name);
		}

	}

	}else {
		if (!isset($invoice_n)) {
			header_pdf($pdf_name);
		}

	}
?>