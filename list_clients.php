<?
	include('./config.php');
?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><? echo $l10n['LIST_CLIENTS']; ?></h3>
			</div>
			<div class="modal-body">
				<p>	<? echo '<table class="table-bordered"><tbody>';
						if ($handle = opendir('./clients/')) {
								while (false !== ($entry = readdir($handle))) {
									if ($entry != "." && $entry != ".." && $entry != "index.php") {
									echo "<tr><td>$entry</td></tr>\n";
									}
								}
							closedir($handle);
						}
						echo '</tbody></table>';

					?></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
			</div>

