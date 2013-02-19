<?
	date_default_timezone_set('UTC');
	$config['version']		=	'1.0 Beta Dev';

	//Config Invoice
	$config['language']		=	'en';
	$config['prefix']		=	'€ ';
	$config['date_format']		=	'd/m/Y';
	$config['invoice_info']		=	'<p>Jonathan Neal</p>
						<p>101 E. Chapman Ave<br>Orange, CA 92866</p>
						<p>(800) 555-1234</p>';
	$config['email']		=	'test@test.it';
	$config['tax']			=	21;
	$config['default_logo']		=	'logo_default.png';
	$config['info']			=	'General Condition of Sale';

	//Default content of the new customer field
	$config['customer']['region']	=	'Italy';
	$config['customer']['city']	=	'';
	$config['customer']['vat']	=	'';
	$config['customer']['address']	=	'';
	$config['customer']['zipcode']	=	'';
	$config['customer']['phone']	=	'';
	$config['customer']['email']	=	'';

	//General Option
	$config['ticket_number']	=	true;
	$config['capture_payment']	= 	true;
	$config['invoice_logo'] 	=	true;
	$config['debug']		=	true;
	$config['backend']		=	'xml';// only xml for the moment
	$config['dot_or_comma']		=	false;//true for dot or false for comma
	$config['invoice_date_number']	=	true;
	$config['show_all_info']	=	true;// in the info.php show the permission on folder and their path

	//Option Login
	$config['login']['enable']	=	false;
	$config['login']['user']	=	'admin';
	$config['login']['pass']	=	'pass';

	//Option PDF
	$config['pdf']['enable']	=	true;
	$config['pdf']['wp']		=	false;
	$config['pdf']['pdfcrowd']	=	false;
		$config['pdfcrowd']['user']=	'';
		$config['pdfcrowd']['key'] =	'';
	$config['pdf']['wkhtmltopdf']	=	true;
	$config['pdf']['wait']		= 	2; //seconds

	//Option Print
	$config['print']['customer']	=	false;
	$config['print']['network']	=	true;

	$path['root']			=	'.'.DIRECTORY_SEPARATOR;
	$path['invoice']		=	$path['root'].'invoice';
	$path['draft']			=	$path['invoice'].DIRECTORY_SEPARATOR.'draft';
	$path['customers']		=	$path['root'].'customers';
	$path['notes']			=	$path['root'].'notes';
	$path['logos']			=	$path['root'].'logos';
	$path['tmp']			=	$path['root'].'tmp';

	/**** NOT EDIT THIS CODE!!!!! ****/
	include('./l10n/'.$config['language'].'.php');
	include('./lib/function.php');
	include('./lib/'.$config['backend'].'/function.php');

	session_start();

	if ($config['login']['enable']) {
		if(!(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes')) {
	                echo $l10n['NEED_LOGIN'].':'."<br>\n";
	                echo '<form action="login.php" method="post">'."\n";
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
