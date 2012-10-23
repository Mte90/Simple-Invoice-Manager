<?
	date_default_timezone_set('UTC');

	$config['language']		=	'en';
	$config['prefix']		=	'€ ';
	$config['date_format']		=	'd/m/Y';
	$config['number_ticket']	=	true;
	$config['invoice_info']		=	'<p>Jonathan Neal</p>
						<p>101 E. Chapman Ave<br>Orange, CA 92866</p>
						<p>(800) 555-1234</p>';
	$config['invoice_logo'] 	=	true;
	$config['email']		=	'test@test.it';

	//default content of the new client field
	$config['client']['region']	=	'Italy';
	$config['client']['city']	=	'';
	$config['client']['vat']	=	'';
	$config['client']['address']	=	'';
	$config['client']['zipcode']	=	'';
	$config['client']['phone']	=	'';
	$config['client']['email']	=	'';

	$config['capture_payment']	= 	true;

	$config['debug']		=	true;

	$config['login']['enable']	=	false;
	$config['login']['user']	=	'admin';
	$config['login']['pass']	=	'pass';

	$config['pdf']['enable']	=	true;
	$config['pdf']['wp']		=	false;
	$config['pdf']['pdfcrowd']	=	false;
		$config['pdfcrowd']['user']=	'';
		$config['pdfcrowd']['key'] =	'';
	$config['pdf']['wkhtmltopdf']	=	true;

	$config['print']['client']	=	false;
	$config['print']['network']	=	true;

	/**** NOT EDIT THIS CODE!!!!! ****/
	include('./l10n/'.$config['language'].'.php');
	include('./lib/function.php');

	session_start();

	if ($config['login']['enable']) {
		if(!(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes')) {
	                echo $l10n['NEED_LOGIN'].':'."\n";
	                echo '<br><form action="login.php" method="post">'."\n";
	                echo '<input type="hidden" name="mode" value="login" />'."\n";
	                echo $l10n['USER'].': <input type="text" name="user" /><br>'."\n";
	                echo $l10n['PASSWORD'].': <input type="password" name="pass" /><br>'."\n";
	                echo '<input type="submit" value="'.$l10n['ENTER'].'">'."\n";
	                echo '</form>';
	                if ($login==false) {
		                exit();
		        }
		}
	}


?>
