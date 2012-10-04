 <?
	include('./config.php');

?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['SENT_INV_EMAIL']; ?></h3>
		</div>
	<div class="modal-body">
		<form class="form-horizontal" id="sent-email" method='post' action=''>

		<div class="control-group">
		<label class="control-label">Email</label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="user_email">
		</div>
		</div>

		<div class="control-group">
		<label class="control-label"><? echo $l10n['SUBJECT_EMAIL']; ?></label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="subject_email">
		</div>
		</div>

		<div class="control-group">
		<label class="control-label"><? echo $l10n['CONTENT_EMAIL']; ?></label>
		<div class="controls">
		<textarea class="input-xlarge" id="content_email" rows="3"></textarea>
		</div>
		</div>

		<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
		<button type="submit" class="btn btn-success" id="sent_email_ok" ><? echo $l10n['SENT_EMAIL']?></button>
		</div>
		</div>

		</form>
	</div>