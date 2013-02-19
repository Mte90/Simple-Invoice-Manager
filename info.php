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
		<h2 style="margin:0 auto;width:550px"><? echo $l10n['TITLE'].' - '.$config['version']; ?></h2><br>
		<table class="table table-striped table-bordered" style="width:40%;margin:0 auto">
			<tr>
				<th>Base Settings</th>
				<th>Value</th>
			</tr>
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
	</body>
</html>