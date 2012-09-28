<?
	require_once('./config.php');

	$invoice_data = extract_invoice($_GET['inv'],$_GET['year']);
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><? echo $l10n['TITLE']; ?></title>
		<style>
		<? echo file_get_contents('./css/bootstrap.min.css') ?>
		</style>
		<style>
		<? echo file_get_contents('./css/style.css') ?>
		</style>
	</head>
	<body class="modal-open">
		<header>
			<address>
				<? echo $config['invoice_info']; ?>
			</address>
			<span>
			<img alt="" src="<? echo $invoice_data['logo']; ?>" id="logo"></span>
		</header>
		<article>
			<h1><? echo $l10n['RECIPIENT'] ?></h1>
			<address class="client_info">
				<?
					$client_info = read_client_info($invoice_data['client']);
					echo '<table><tr>';
					echo '<th>'.$l10n['NAME'].'</th><td colspan="4">'.$client_info['name'].'</td></tr>';
					echo '<th>'.$l10n['VAT'].'</th><td colspan="2">'.$client_info['vat'].'</td>';
					echo '<th>'.$l10n['CITY'].'</th><td>'.$client_info['city'].'</td></tr>';
					echo '<tr><th>'.$l10n['ADDRESS'].'</th><td colspan="2">'.$client_info['address'].'</td>';
					echo '<th>'.$l10n['ZIP_CODE'].'</th><td>'.$client_info['zipcode'].'</td></tr>';
					echo '<th>'.$l10n['REGION'].'</th><td>'.$client_info['region'].'</td>';
					echo '<th>'.$l10n['PHONE_FAX'].'</th><td colspan="2">'.$client_info['phone'].'</td></tr>';
					echo '</tr></table>';
				?>
			</address>
			<table class="meta">
				<tr>
					<th><span><? echo $l10n['INVOICE'] ?></span></th>
					<td><span class="invoice_n">
					<?
					echo $invoice_data['number'];
					?></span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['DATE'] ?></span></th>
					<td><span class="invoice_date"><? echo $invoice_data['date']; ?></span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['AMOUNT_DUE'] ?></span></th>
					<td><span id="prefix"><? echo $config['prefix']; ?></span><span id="total">600.00</span></td>
				</tr>
				<? if($config['number_ticket']){ ?>
				<tr>
					<th><span><? echo $l10n['NUMBER_TICKET'] ?></span></th>
					<td><span class="invoice_ticket"><?
					echo $invoice_data['ticket'];
					?></span></td>
				</tr>
				<? } ?>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span><? echo $l10n['ITEM'] ?></span></th>
						<th><span><? echo $l10n['RATE'] ?></span></th>
						<th><span><? echo $l10n['QUANTITY'] ?></span></th>
						<th><span><? echo $l10n['PRICE'] ?></span></th>
					</tr>
				</thead>
				<tbody>

					<?
						$total = 0;
						foreach($invoice_data['product'] as $item){
							$price = $item['rate'] * $item['quantity'];
							echo '<tr>
							<td><span>'.$item['item'].'</span></td>
							<td><span>'.$config['prefix'].'</span><span>'.$item['rate'].'</span></td>
							<td><span>'.$item['quantity'].'</span></td>
							<td><span>'.$config['prefix'].'</span><span>'.$price.'</span></td>
							</tr>';
							$total += $price;
						}
					?>
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span><? echo $l10n['TAX'] ?></span></th>
					<td><span id="value_tax">21</span>%</td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TAXED_IMPORT'] ?></span></th>
					<td><span><? echo $config['prefix']; ?></span><span><? echo percent($invoice_data['tax'],$total); ?></span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['ORIGINAL_IMPORT'] ?></span></th>
					<td><span><? echo $config['prefix']; ?></span><span><? echo $total-percent($invoice_data['tax'],$total); ?></span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TOTAL'] ?></span></th>
					<td><span><? echo $config['prefix']; ?></span><span><? echo $total; ?></span></td>
				</tr>
			</table>
		</article>
		<aside>
			<h1><span><? echo $l10n['NOTE'] ?></span></h1>
			<div class="invoice_note">
			<?
			echo $invoice_data['note'];
			?>
			</div>
		</aside>
	</body>
</html>