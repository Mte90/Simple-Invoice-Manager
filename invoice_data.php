<?
	require_once('./config.php');

	$invoice_data = read_invoice_info($_GET['number'],$_GET['year']);
	echo json_encode($invoice_data);
?>
