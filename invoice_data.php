<?
	require_once('./config.php');

	$invoice_data = extract_invoice($_GET['number'],$_GET['year']);
	echo json_encode($invoice_data);
?>
