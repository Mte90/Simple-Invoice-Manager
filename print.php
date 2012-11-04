<?
require_once('./config.php');

	$invoice_n = $_GET['inv_'];
	$year = $_GET['year_'];
	include('pdf.php');

if ($config['print']['customer']==true) {

?>

<object type="application/pdf" data="tmp/invoice.pdf" width="100%" height="100%" id="examplePDF" name="examplePDF" ><param name='src' value='tmp/invoice.pdf'/></object>

<script>
   examplePDF.printWithDialog();
</script>

<?
}elseif($config['print']['network']==true) {
	exec('lpr -o fit-to-page ./tmp/invoice.pdf');
}
?>