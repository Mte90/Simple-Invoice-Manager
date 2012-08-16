<?
	include('./config.php');
?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><? echo $l10n['LIST_CLIENTS']; ?></h3>
			</div>
			<div class="modal-body">
				<? echo "<table class=\"table table-bordered\">\n<tbody>\n";
					if ($handle = opendir('./clients/')) {
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != ".." && $entry != "index.php") {
									$client_info = read_client_info('./clients/'.$entry);
								echo "<tr><td>".$client_info['name']."</td></tr>\n";
								}
							}
						closedir($handle);
					}
					echo "</tbody>\n</table>";
				?>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
			</div>

