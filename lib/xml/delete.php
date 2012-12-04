<?
	if($_GET['mode']=='del_note') {
		unlink($path['notes'].DIRECTORY_SEPARATOR.$_GET['note'].'.xml');
	}elseif($_GET['mode']=='del_draft') {
		unlink($path['draft'].DIRECTORY_SEPARATOR.$_GET['draft'].'.xml');
	}
?>
