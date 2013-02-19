<? 	require_once('./config.php');

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Info - <? echo $l10n['TITLE'].' - '.$config['version']; ?></title>
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
	</head>
	<body>
		<div style="margin:0 auto;width:550px"><h2><? echo $l10n['TITLE'].' - '.$config['version']; ?></h2>
		<h4>Base Settings</h4></div>
		<table class="table table-striped table-bordered" style="width:40%;margin:0 auto">
			<tr>
				<td>Language</td>
				<td><? echo $config['language']; ?></td>
			</tr>
			<tr>
				<td>Money Value</td>
				<td><? echo $config['prefix']; ?></td>
			</tr>
			<tr>
				<td>Date Format</td>
				<td><? echo date($config['date_format']); ?></td>
			</tr>
			<tr>
				<td>Default Logo</td>
				<td><img src="<? echo $path['logos'].DIRECTORY_SEPARATOR.$config['default_logo']; ?>" /></td>
			</tr>
		</table>
		<div style="margin:0 auto;width:550px"><h4>Settings</h4></div>
		<table class="table table-striped table-bordered" style="width:40%;margin:0 auto">
			<tr>
				<th>Settings</th>
				<th>Value</th>
			</tr>
			<tr>
				<td>Insert the Ticket Number</td>
				<td><? echo $config['ticket_number']? 'true' : 'false'; ?></td>
			</tr>
			<tr>
				<td>Capture Payment</td>
				<td><? echo $config['capture_payment']? 'true' : 'false'; ?></td>
			</tr>
			<tr>
				<td>Insert the Logo in the Invoice</td>
				<td><? echo $config['invoice_logo']? 'true' : 'false'; ?></td>
			</tr>
			<tr>
				<td>Dot or Comma</td>
				<td><? echo $config['dot_or_comma']? 'true' : 'false'; ?></td>
			</tr>
			<tr>
				<td>Insert the year in the Invoice Number</td>
				<td><? echo $config['capture_payment']? 'true' : 'false'; ?></td>
			</tr>
			<tr>
				<td>Login</td>
				<td><? echo $config['pdf']['enable']? 'true' : 'false'; ?></td>
			</tr>
			<tr>
				<td>Backend</td>
				<td><? echo $config['backend']; ?></td>
			</tr>
			<tr>
				<td><b>Enable Debug</b></td>
				<td><? echo $config['debug']? 'true' : 'false'; ?></td>
			</tr>
		</table>
	</body>
</html>