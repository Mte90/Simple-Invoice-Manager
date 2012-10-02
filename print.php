<?
require_once('./config.php');

if ($config['print']['client']==true) {

	$invoice_n = $_GET['inv'];
	$year = $_GET['year'];
	include('pdf.php');
?>

<object type="application/pdf" data="tmp/invoice.pdf" width="100%" height="100%" id="examplePDF" name="examplePDF" ><param name='src' value='tmp/invoice.pdf'/></object>

<script>
   examplePDF.printWithDialog();
</script>

<?
}
?>