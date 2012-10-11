<?
	require_once('./config.php');

	if($_GET['mode']=='logo_list') {
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['LIST_LOGOS']; ?></h3>
	</div>
	<div class="modal-body">
		<table class="logos-list table table-bordered table-hover">
			<tbody>
				<?
					$logo = logo_list();
					foreach ($logo as $key) {
						echo '<tr><td data-logo="'.$key.'"><img src="logos/'.$key.'" /></td></tr>'."\n";
					}
				?>
			</tbody>
		</table>
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
		<table class="clients-list table table-bordered table-hover">
			<tbody>
				<?
					$client = client_list();
					foreach ($client as $key) {
						echo '<tr><td data-id="'.$key[1].'">'.$key[0]['name'].'</td></tr>'."\n";
					}
				?>
			</tbody>
		</table>
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

}elseif($_GET['mode']=='invoice_list'){

	?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['LIST_INVOICE']; ?></h3>
			</div>
			<div class="modal-body">
			<ul class="nav nav-tabs tabs-invoice" data-tabs="tabs">
				<li class="active"><a href="#invoice" data-toggle="tab"><? echo $l10n['LIST_INVOICE']; ?></a></li>
				<li><a href="#draft" data-toggle="tab"><? echo $l10n['LIST_DRAFT']; ?></a></li>
			</ul>

			<div class="tab-content">
				<div class="active tab-pane" id="invoice">
					<table class="invoice-list table table-bordered table-hover">
						<tbody>
						<?
							$invoice = get_invoice();
							foreach ($invoice as $key) {
								$inv_info = extract_invoice($key);
								$client_info = read_client_info($inv_info['client']);
								echo '<tr><td data-id="'.$key.'" data-year="'.$inv_info['year'].'">'.$key.' - '.$inv_info['date'].' - '.$client_info['name'].'</td></tr>'."\n";
							}
						?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="draft">
					<table class="draft-list table table-bordered table-hover">
						<tbody>
						<?
							$draft = get_invoice('draft');
							foreach ($draft as $key) {
								$inv_info = extract_invoice($key,'draft');
								$client_info = read_client_info($inv_info['client']);
								echo '<tr><td data-id="'.$key.'">'.$key.' - '.$inv_info['date'].' - '.$client_info['name'].'</td></tr>'."\n";
							}
						?>
						</tbody>
					</table>
				</div>
			</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
				<a href="#" class="btn btn-primary" id="open_invoice"><? echo $l10n['OPEN']; ?></a>
			</div>
	<?
}elseif($_GET['mode']=='notes_list') {

?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['LIST_NOTES']; ?></h3>
	</div>
	<div class="modal-body">
		<table class="notes-list table table-bordered table-hover">
			<tbody>
				<?
					$notes = notes_list();
					foreach ($notes as $key) {
						echo '<tr data-id="'.$key[1].'"><td class="note_choosen">'.$key[0]['name'].'</td><td class="link-func note_del">'.$l10n['DELETE'].'</td><td class="link-func note_mod">'.$l10n['MODIFY'].'</td></tr>'."\n";
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
	</div>
<?

}elseif($_GET['mode']=='notes_new'||$_GET['mode']=='notes_mod') {

?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['ADD_NOTES']; ?></h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" id="note_add_form">
			<div class="control-group">
				<label class="control-label" for="input-name-note"><? echo $l10n['NAME']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="note_add_name" required>
				</div>
				<br>
				<div class="note_preview well"></div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
		<a href="#" class="btn btn-primary" id="save_note_okay"><? echo $l10n['SAVE']; ?></a>
	</div>

<?

}

?>