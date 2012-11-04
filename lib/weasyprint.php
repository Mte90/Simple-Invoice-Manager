<?
require_once('./config.php');

//WeasyPrint support

exec('weasyprint '.$path['tmp'].DIRECTORY_SEPARATOR.'pdf.htm '$path['tmp'].DIRECTORY_SEPARATOR.$pdf_name.' -s ./css/bootstrap.min.css -s ./css/style.css');

?>
