<?
	require_once('./config.php');

	$note_data = read_note_info($_GET['number']);
	echo json_encode($note_data);
?>
