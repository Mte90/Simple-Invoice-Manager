<?
	require_once('./config.php');

	$invoice_data = extract_invoice($_GET['number']);
	echo json_encode($invoice_data);
?>
