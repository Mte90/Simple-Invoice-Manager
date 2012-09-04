<?
	include('./config.php');

	if($_GET['mode']=='logo_list') {
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['LIST_LOGOS']; ?></h3>
	</div>
	<div class="modal-body">
		<? echo "<table class=\"logos-list table table-bordered table-hover\">\n<tbody>\n";
			if ($handle = opendir('./logos/')) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && $entry != "index.php") {
						echo "<tr><td data-logo='$entry'><img src='logos/$entry' /></td></tr>\n";
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
<?

}elseif($_GET['mode']=='clients_list') {

?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['LIST_CLIENTS']; ?></h3>
	</div>
	<div class="modal-body">
		<? echo "<table class=\"clients-list table table-bordered table-hover\">\n<tbody>\n";
			if ($handle = opendir('./clients/')) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && $entry != "index.php") {
						$client_info = read_client_info('./clients/'.$entry);
						echo "<tr><td data-id='".$entry."'>".$client_info['name']."</td></tr>\n";
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
<?

}elseif($_GET['mode']=='clients_new') {

?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['ADD_CLIENTS']; ?></h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" id="client_add_form">
			<div class="control-group">
				<label class="control-label" for="input-name"><? echo $l10n['NAME']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="client_add_name" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-vat"><? echo $l10n['VAT']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="client_add_vat" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-address"><? echo $l10n['ADDRESS']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="client_add_address" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-zipcode"><? echo $l10n['ZIP_CODE']; ?></label>
				<div class="controls">
					<input type="text" class="input-small" id="client_add_zipcode" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-city"><? echo $l10n['CITY']; ?></label>
				<div class="controls">
					<input type="text" class="input-small" id="client_add_city" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-region"><? echo $l10n['REGION']; ?></label>
				<div class="controls">
					<input type="text" class="input-small" id="client_add_region" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-phone"><? echo $l10n['PHONE_FAX']; ?></label>
				<div class="controls">
					<input type="text" class="input-small" id="client_add_phone" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-email"><? echo $l10n['EMAIL']; ?></label>
				<div class="controls">
					<input type="email" class="input-small" id="client_add_email">
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
		<a href="#" class="btn btn-primary" id="save_client_okay"><? echo $l10n['SAVE']; ?></a>
	</div>

<?

}

?>