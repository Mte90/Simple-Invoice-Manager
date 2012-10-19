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
						echo '<tr data-id="'.$key[1].'"><td class="client_choosen">'.$key[0]['name'].'</td><td class="link-func client_mod">'.$l10n['MODIFY'].'</td><td class="link-func client_his">'.$l10n['HISTORY'].'</td></tr>'."\n";
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
	</div>
<?

}elseif($_GET['mode']=='clients_new'||$_GET['mode']=='client_mod') {

	if($_GET['mode']=='client_mod'){
		$client_info = read_client_info($_GET['client']);
	}else {
		$client_info['name']=$client_info['vat']=$client_info['address']=$client_info['zipcode']=$client_info['city']=$client_info['region']=$client_info['phone']=$client_info['email']='';
	}

?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>
			<?
			if($_GET['mode']=='client_mod'){
				echo $l10n['MODIFY_CLIENT'];
			}else {
				echo $l10n['ADD_CLIENTS'];
			}
			?>
		</h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" id="client_add_form">
			<input type="hidden" name="client_number" value="<? if(isset($_GET['client'])){echo $_GET['client'];} ?>"/>
			<div class="control-group">
				<label class="control-label" for="input-name"><? echo $l10n['NAME']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="client_add_name" value="<? echo $client_info['name']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-vat"><? echo $l10n['VAT']; ?></label>
				<div class="controls">
					<input type="number" class="input-xlarge" id="client_add_vat" value="<? echo $client_info['vat']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-address"><? echo $l10n['ADDRESS']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="client_add_address" value="<? echo $client_info['address']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-zipcode"><? echo $l10n['ZIP_CODE']; ?></label>
				<div class="controls">
					<input type="number" class="input-small" id="client_add_zipcode" value="<? echo $client_info['zipcode']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-city"><? echo $l10n['CITY']; ?></label>
				<div class="controls">
					<input type="text" class="input-small" id="client_add_city" value="<? echo $client_info['city']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-region"><? echo $l10n['REGION']; ?></label>
				<div class="controls">
					<input type="text" class="input-small" id="client_add_region" value="<? echo $client_info['region']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-phone"><? echo $l10n['PHONE_FAX']; ?></label>
				<div class="controls">
					<input type="number" class="input-large" id="client_add_phone" value="<? echo $client_info['phone']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input-email"><? echo $l10n['EMAIL']; ?></label>
				<div class="controls">
					<input type="email" class="input-large" id="client_add_email" value="<? echo $client_info['email']; ?>" data-validation-email-message="<? echo $l10n['validemail']; ?>">
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer" data-id-form="client_add_form">
		<button type="submit" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></button>
		<button type="submit" class="btn btn-primary" id="<? if($_GET['mode']=='client_mod'){echo 'mod_client_okay'; }else {echo 'save_client_okay'; }?>"><? echo $l10n['SAVE']; ?></button>
	</div>

<?

}elseif($_GET['mode']=='invoice_list'){

	?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['LIST_INVOICE']; ?></h3>
			</div>
			<div class="modal-body">
			<ul class="nav nav-tabs tabs-invoice">
				<li class="active" data-toggle="tab"><a href="#invoice"><? echo $l10n['LIST_INVOICE']; ?></a></li>
				<li><a href="#draft" data-toggle="tab"><? echo $l10n['LIST_DRAFT']; ?></a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="invoice">
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
								echo '<tr data-id="'.$key.'"><td class="draft_choosen">'.$key.' - '.$inv_info['date'].' - '.$client_info['name'].'</td><td class="link-func draft_del">'.$l10n['DELETE'].'</td></tr>'."\n";
							}
						?>
						</tbody>
					</table>
				</div>
			</div>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
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
					if($notes[0]!='error'){
						foreach ($notes as $key) {
							echo '<tr data-id="'.$key[1].'"><td class="note_choosen">'.$key[0]['name'].'</td><td class="link-func note_del">'.$l10n['DELETE'].'</td><td class="link-func note_mod">'.$l10n['MODIFY'].'</td></tr>'."\n";
						}
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
	</div>
<?

}elseif($_GET['mode']=='notes_new') {

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
					<input type="text" class="input-xlarge" id="note_add_name" required />
				</div>
				<br>
				<div class="note_preview well"></div>
			</div>
		</form>
	</div>
	<div class="modal-footer" data-id-form="note_add_form">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
		<a href="#" class="btn btn-primary" id="save_note_okay"><? echo $l10n['SAVE']; ?></a>
	</div>

<?

}elseif($_GET['mode']=='notes_mod') {

	$note_data = read_note_info($_GET['note']);

?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['MODIFY_NOTE']; ?></h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" id="note_mod_form">
			<input type="hidden" name="note_number" value="<? echo $_GET['note'];?>">
			<div class="control-group">
				<label class="control-label" for="input-name-note"><? echo $l10n['NAME']; ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="note_mod_name" required value="<? echo $note_data['name'];?>" />
				</div>
				<br>
				<textarea id="note_text" class="input-xxlarge" rows="10" required><? echo $note_data['text'];?></textarea>
			</div>
		</form>
	</div>
	<div class="modal-footer" data-id-form="note_mod_form">
		<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
		<a href="#" class="btn btn-primary" id="mod_note_okay"><? echo $l10n['SAVE']; ?></a>
	</div>

<?

}

?>