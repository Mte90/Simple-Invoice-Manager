<?
	include('./config.php');
?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><? echo $l10n['LIST_LOGOS']; ?></h3>
			</div>
			<div class="modal-body">
				<? echo '<table class="table table-bordered logos-list"><tbody>';
					if ($handle = opendir('./logos/')) {
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != ".." && $entry != "index.php") {
								echo "<tr><td data-logo='$entry'><img src='logos/$entry' /></td></tr>\n";
								}
							}
						closedir($handle);
					}
					echo '</tbody></table>';
				?>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
			</div>

