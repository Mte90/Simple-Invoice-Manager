<?
//WeasyPrint support

$filename = 'invoice.pdf';
exec('weasyprint ./tmp/pdf.htm ./tmp/'.$filename.' -s ./css/bootstrap.min.css -s ./css/style.css');

?>
