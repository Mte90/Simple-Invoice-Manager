<? 	require_once('./config.php');	?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><? echo $l10n['TITLE'].' - '.$config['version']; ?></title>
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="css/style.css">
		<link rel="license" href="http://opensource.org/licenses/GPL-3.0">
		<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.blockUI.min.js"></script>
		<script type="text/javascript" src="js/jqbootstrapvalidation.min.js"></script>
		<script type="text/javascript" src="js/jquery.livequery.min.js"></script>
		<script type="text/javascript" src="js/jquery.livefilter.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</head>
	<body class="modal-open" data-choose-customer="<? echo $l10n['CHOOSE_CUSTOMER'] ?>" data-dotcomma="<? echo $config['dot_or_comma']; ?>">
		<div class="invoice_option">
		<? /* Show Capture payment Option */
		if($config['capture_payment']){ ?>
			<div class="form-inline">
				<label class="checkbox"><input type="checkbox" id="capture_payment" /><? echo $l10n['CAPTURE_PAYMENT'] ?></label>
				<input type="text" id="capture_date" class="input-small" value="<? echo date($config['date_format']); ?>" placeholder="<? echo $l10n['DATE'] ?>" />
				<button type="submit" class="btn" id="invoice_option_okay"><? echo $l10n['SAVE']; ?></button>
			</div>
		<? } ?>
		</div>
		<header>
			<h1 class="green paid"><? echo $l10n['PAID'] ?></h1>
			<h1 class="red not-paid"><? echo $l10n['NOT_PAID'] ?></h1>
			<address>
				<? echo $config['invoice_info']; ?>
			</address>
			<? /* Show Logo Chooser */
			if($config['invoice_logo']){ ?>
			<div class="toolbar_logo">
				<img src="icons/folder_search.png" class="logos_search pointer" alt="<? echo $l10n['CHOOSE_LOGO']; ?>" title="<? echo $l10n['CHOOSE_LOGO']; ?>" />
			</div>
			<? } ?>
			<img alt="" src="<? echo $path['logos'].'/'.$config['default_logo']; ?>" <? if($config['invoice_logo']){ ?> id="logo" <? } ?>>
		</header>
		<article>
			<div class="toolbar_customers">
				<img src="icons/address_book_search.png" class="customers_search pointer" alt="<? echo $l10n['CHOOSE_CUSTOMER']; ?>" title="<? echo $l10n['CHOOSE_CUSTOMER']; ?>" /><br>
				<img src="icons/address_book_add.png" class="customer_add pointer" alt="<? echo $l10n['NEW_CUSTOMER']; ?>" title="<? echo $l10n['NEW_CUSTOMER']; ?>" />
			</div>
			<address class="customer_info">
				<b><? echo $l10n['CHOOSE_CUSTOMER'] ?></b>
			</address>
			<table class="meta">
				<tr>
					<th><span><? echo $l10n['INVOICE'] ?></span></th>
					<td><span contenteditable class="invoice_n">
					<?
					$number_invoice = get_last_element('invoice');
					$number_invoice++;
					if ($config['invoice_date_number']){
						$number_invoice .= '/'.get_last_year();
					}
					echo $number_invoice;
					?></span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['DATE'] ?></span></th>
					<td><span contenteditable class="invoice_date"><? echo date($config['date_format']); ?></span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['AMOUNT_DUE'] ?></span></th>
					<td><span id="prefix"><? echo $config['prefix']; ?></span><span id="total">600.00</span></td>
				</tr>
				<? /* Ticket Number Option */
				if($config['ticket_number']){ ?>
				<tr>
					<th><span><? echo $l10n['NUMBER_TICKET'] ?></span></th>
					<td><span contenteditable class="number-check invoice_ticket"></span></td>
				</tr>
				<? } ?>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span><? echo $l10n['QUANTITY'] ?></span></th>
						<th><span><? echo $l10n['ITEM'] ?></span></th>
						<th><span><? echo $l10n['RATE'];
						if($config['tax_included']){
							echo '<br><small>'.$l10n['TAX_INCLUDED'].'</small>';
						}
						?></span></th>
						<th><span><? echo $l10n['SALE'] ?></span></th>
						<th><span><? echo $l10n['TOTAL'] ?></span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a class="cut">-</a>
						<span contenteditable class="number-check quantity">0</span></td>
						<td><span contenteditable class="desc"></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable class="number-check decimal price"></span></td>
						<td><span contenteditable class="sale"></span><span>%</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span class="total"></span></td>
					</tr>
					<tr>
						<td><a class="cut">-</a>
						<span contenteditable class="number-check quantity">0</span></td>
						<td><span contenteditable class="desc"></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable class="number-check decimal price"></span></td>
						<td><span contenteditable class="sale"></span><span>%</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span class="total"></span></td>
					</tr>
					<tr>
						<td><a class="cut">-</a>
						<span contenteditable class="number-check quantity">0</span></td>
						<td><span contenteditable class="desc"></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable class="number-check decimal price"></span></td>
						<td><span contenteditable class="sale"></span><span>%</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span class="total"></span></td>
					</tr>
					<tr>
						<td><a class="cut">-</a>
						<span contenteditable class="number-check quantity">0</span></td>
						<td><span contenteditable class="desc"></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable class="number-check decimal price"></span></td>
						<td><span contenteditable class="sale"></span><span>%</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span class="total"></span></td>
					</tr>
				</tbody>
			</table>
			<a class="add">+</a>
			<div class="box-info">
				<? echo $config['info'] ?>
			</div>
			<table class="balance">
				<tr>
					<th><span><? echo $l10n['TAX'] ?></span></th>
					<td><span contenteditable id="value_tax"><? echo $config['tax'] ?></span>%</td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TAXABLE_AMOUNT'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span id="taxable_amount">0.00</span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TAX_AMOUNT'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span id="tax_amount">0.00</span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TOTAL'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span id="total_invoice">0.00</span></td>
				</tr>
			</table>
		</article>
		<aside>
			<div class="toolbar_notes">
				<img src="icons/web_layout_search.png" class="notes_search pointer" alt="<? echo $l10n['CHOOSE_NOTES']; ?>" title="<? echo $l10n['CHOOSE_NOTES']; ?>" />
				<img src="icons/web_layout_error_add.png" class="notes_add pointer" alt="<? echo $l10n['ADD_NOTES']; ?>" title="<? echo $l10n['ADD_NOTES']; ?>" />
			</div>
			<h1><span><? echo $l10n['NOTE'] ?></span></h1>
			<div contenteditable class="invoice_note">
			</div>
		</aside>
		<div class="toolbar">
			<img src="icons/save.png" class="save pointer" alt="<? echo $l10n['SAVE_INVOICE']; ?>" title="<? echo $l10n['SAVE_INVOICE']; ?>" /><br>
			<img src="icons/comment.png" class="draft pointer" alt="<? echo $l10n['SAVE_DRAFT']; ?>" title="<? echo $l10n['SAVE_DRAFT']; ?>" /><br>
			<img src="icons/page_blank_add.png" class="new pointer" alt="<? echo $l10n['NEW_INVOICE']; ?>" title="<? echo $l10n['NEW_INVOICE']; ?>" /><br>
			<img src="icons/search.png" class="search pointer" alt="<? echo $l10n['LIST_INVOICE']; ?>" title="<? echo $l10n['LIST_INVOICE']; ?>" /><br>
			<? /* PDF Option */
			if($config['pdf']['enable']){ ?>
			<img src="icons/pdf.png" class="pdf pointer hide" alt="<? echo $l10n['EXPORT_PDF']; ?>" title="<? echo $l10n['EXPORT_PDF']; ?>" /><br>
			<? } ?>
			<img src="icons/newspaper.png" class="print pointer" alt="<? echo $l10n['PRINT']; ?>" title="<? echo $l10n['PRINT']; ?>" /><br>
			<img src="icons/email_forward.png" class="email pointer hide" alt="<? echo $l10n['SENT_EMAIL']; ?>" title="<? echo $l10n['SENT_EMAIL']; ?>" /><br><br>
			<? /* Show Logout Link */
			if($config['login']['enable']){ ?>
			<img src="icons/user_close.png" class="logout pointer" alt="<? echo $l10n['LOGOUT']; ?>" title="<? echo $l10n['LOGOUT']; ?>" />
			<? } ?>
		</div>
		<div class="modal hide" id="save_inv_modal" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['SAVE_INVOICE']; ?></h3>
			</div>
			<div class="modal-body" data-message-option='["<? echo $l10n['CHECK_INVOICE_CUSTOMER']; ?>","<? echo $l10n['CHECK_INVOICE_NUMBER']; ?>"]'>
				<p><? echo $l10n['SURE_SAVE_INVOICE']; ?></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" id="reject_invoice"><? echo $l10n['REJECT']; ?></a>
				<a href="#" class="btn btn-primary" id="save_inv_okay"><? echo $l10n['SAVE']; ?></a>
			</div>
		</div>
		<div class="modal hide" id="save_draft_modal" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['SAVE_DRAFT']; ?></h3>
			</div>
			<div class="modal-body">
				<p><? echo $l10n['SURE_SAVE_INVOICE']; ?></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
				<a href="#" class="btn btn-primary" id="save_draft_okay"><? echo $l10n['SAVE']; ?></a>
			</div>
		</div>
		<div class="modal hide" id="del_note_modal" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['DELETE']; ?></h3>
			</div>
			<div class="modal-body">
				<p><? echo $l10n['SURE_DEL_NOTE']; ?>?</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
				<a href="#" class="btn btn-primary" id="del_note_okay"><? echo $l10n['SAVE']; ?></a>
			</div>
		</div>
		<div class="modal hide" id="del_draft_modal" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['DELETE']; ?></h3>
			</div>
			<div class="modal-body">
				<p><? echo $l10n['SURE_DEL_DRAFT']; ?>?</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
				<a href="#" class="btn btn-primary" id="del_draft_okay"><? echo $l10n['SAVE']; ?></a>
			</div>
		</div>
		<div class="modal hide" id="check_note_modal" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['ADD_NOTE']; ?></h3>
			</div>
			<div class="modal-body">
				<p><? echo $l10n['CHECK_EMPTY_NOTE']; ?></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
			</div>
		</div>
	</body>
</html>