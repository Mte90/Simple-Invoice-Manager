<?
	include('./config.php');
?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
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
						</div>
						</div>
					</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
				<a href="#" class="btn btn-primary" id="save_client_okay"><? echo $l10n['SAVE']; ?></a>
			</div>

