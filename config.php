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

	/**** NOT EDIT THIS CODE!!!!! ****/
	include('./lib/function.php');
	include('./l10n/'.$config['language'].'.php');

	if ($config['login']['enable']) {
		session_start();
		if(!(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes')) {
	                echo $l10n['NEED_LOGIN'];
	                echo '<form action="login.php" method="post">';
	                echo '<input type="hidden" name="mode" value="login" />';
	                echo $l10n['USER'].': <input type="text" name="user" /><br>';
	                echo $l10n['PASSWORD'].': <input type="password" name="pass" />';
	                echo '<input type="submit" value="Send it!">';
	                echo '<form>';
			exit;
		}
	}
?>
