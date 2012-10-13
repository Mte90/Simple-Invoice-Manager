<?
require_once('./config.php');

//WeasyPrint support

exec('weasyprint ./tmp/pdf.htm ./tmp/'.$pdf_name.' -s ./css/bootstrap.min.css -s ./css/style.css');

?>
