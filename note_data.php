<?
	require_once('./config.php');

	$draft_data = read_note_info($_GET['number']);
	echo json_encode($draft_data);
?>
