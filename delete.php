<?
	require_once('./config.php');

	if($_GET['mode']=='del_note') {
		unlink('./notes/'.$_GET['note'].'.xml');
	}elseif($_GET['mode']=='del_draft') {
		unlink('./invoice/draft/'.$_GET['draft'].'.xml');
	}
?>
