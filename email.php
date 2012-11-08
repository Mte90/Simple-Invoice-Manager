 <?
	include('./config.php');

if($_GET['mode']=='form'){
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><? echo $l10n['SENT_INV_EMAIL']; ?></h3>
		</div>
	<div class="modal-body">
		<form class="form-horizontal" id="sent-email">

		<div class="control-group">
		<label class="control-label"><? echo $l10n['RECIPIENT']; ?></label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="user_email" value="<? echo $_GET['email']; ?>">
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
		<label class="control-label"><? echo $l10n['ATTACH_EMAIL']; ?></label>
		<div class="controls">
		<input type="checkbox" id="attach_email">
		</div>
		</div>

		<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
		<a class="btn btn-success" id="sent_email_ok" ><? echo $l10n['SENT_EMAIL']?></a>
		</div>
		</div>

		</form>
	</div>
<?
} elseif($_GET['mode']=='send'){
	require_once('./lib/sec.class.inc.php');

	$sec = new sec('', $_GET['user_email'], '', $config['email']);

	$sec->buildMessage($_GET['content_email'], $_GET['subject_email']);

	if($_GET['attach_email']=='on'){
		$invoice_n = $_GET['inv_'];
		$year = $_GET['year_'];
		include('pdf.php');

		$sec->attachment($pdf_path);
	}

	if($sec->sendmail()) {
	    echo 'ok';
	} else {
	    echo 'error';
	}

}
?>