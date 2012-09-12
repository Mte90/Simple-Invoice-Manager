<?
	date_default_timezone_set('UTC');

	$config['language']	=	'en';
	$config['prefix']	=	'€ ';
	$config['date_format']	=	'd/m/Y';
	$config['number_ticket']=	true;
	$config['invoice_info']	=	'<p>Jonathan Neal</p>
					<p>101 E. Chapman Ave<br>Orange, CA 92866</p>
					<p>(800) 555-1234</p>';
	$config['invoice_logo'] =	true;
	$config['login']['enable']=	false;
	$config['login']['user']=	'admin';
	$config['login']['pass']=	'pass';

	include('./lib/function.php');
	include('./l10n/'.$config['language'].'.php');
?>
