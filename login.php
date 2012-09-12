<?
	$login = true;
	require_once('./config.php');

	if($_GET['mode']=='logout') {
		session_destroy();
	}elseif($_POST['mode']=='login') {
		if ($_POST['user']==$config['login']['user'] && $_POST['pass']==$config['login']['pass']) {
		      $_SESSION['logged'] = "yes";
		      header('Location: ./index.php');
		}
	}
?>
