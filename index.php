<? 	require_once('./config.php');	?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><? echo $l10n['TITLE']; ?></title>
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="css/style.css">
		<link rel="license" href="http://www.opensource.org/licenses/mit-license/">
		<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</head>
	<body class="modal-open">
		<header>
			<address>
				<? echo $config['invoice_info']; ?>
			</address>
			<span>
			<? if($config['invoice_logo']){ ?>
			<div class="toolbar_logo">
				<img src="icons/folder_search.png" class="logos_search pointer" title="<? echo $l10n['CHOOSE_LOGO']; ?>" />
			</div>
			<? } ?>
			<img alt="" src="logos/logo_default.png" id="logo"></span>
		</header>
		<article>
			<h1><? echo $l10n['RECIPIENT'] ?></h1>
			<div class="toolbar_clients">
				<img src="icons/address_book_search.png" class="clients_search pointer" title="<? echo $l10n['CHOOSE_CLIENT']; ?>" />
				<img src="icons/address_book_add.png" class="client_add pointer" title="<? echo $l10n['NEW_CLIENT']; ?>" />
			</div>
			<address class="client_info">
				<b><? echo $l10n['CHOOSE_CLIENT'] ?></b>
			</address>
			<table class="meta">
				<tr>
					<th><span><? echo $l10n['INVOICE'] ?></span></th>
					<td><span contenteditable class="invoice_n">
					<?
					$number_invoice = get_last_element('invoice');
					$number_invoice++;
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
				<? if($config['number_ticket']){ ?>
				<tr>
					<th><span><? echo $l10n['NUMBER_TICKET'] ?></span></th>
					<td><span contenteditable class="invoice_ticket"></span></td>
				</tr>
				<? } ?>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span><? echo $l10n['ITEM'] ?></span></th>
						<th><span><? echo $l10n['RATE'] ?></span></th>
						<th><span><? echo $l10n['QUANTITY'] ?></span></th>
						<th><span><? echo $l10n['PRICE'] ?></span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a class="cut">-</a><span contenteditable></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable></span></td>
						<td><span contenteditable>0</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span></span></td>
					</tr>
					<tr>
						<td><a class="cut">-</a><span contenteditable></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable></span></td>
						<td><span contenteditable>0</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span></span></td>
					</tr>
					<tr>
						<td><a class="cut">-</a><span contenteditable></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable></span></td>
						<td><span contenteditable>0</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span></span></td>
					</tr>
					<tr>
						<td><a class="cut">-</a><span contenteditable></span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable></span></td>
						<td><span contenteditable>0</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span></span></td>
					</tr>
				</tbody>
			</table>
			<a class="add">+</a>
			<table class="balance">
				<tr>
					<th><span><? echo $l10n['TAX'] ?></span></th>
					<td><span contenteditable id="value_tax">21</span>%</td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TAXED_IMPORT'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span>0.00</span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['ORIGINAL_IMPORT'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span>0.00</span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TOTAL'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span>0.00</span></td>
				</tr>
			</table>
		</article>
		<aside>
			<div class="toolbar_notes">
				<img src="icons/web_layout_search.png" class="notes_search pointer" title="<? echo $l10n['CHOOSE_NOTES']; ?>" />
				<img src="icons/web_layout_error_add.png" class="notes_add pointer" title="<? echo $l10n['NEW_NOTE']; ?>" />
			</div>
			<h1><span><? echo $l10n['NOTE'] ?></span></h1>
			<div contenteditable class="invoice_note">

			</div>
		</aside>
		<div class="toolbar">
			<img src="icons/save.png" class="save pointer" alt="" title="<? echo $l10n['SAVE_INVOICE']; ?>" /><br>
			<img src="icons/comment.png" class="draft pointer" alt="" title="<? echo $l10n['SAVE_DRAFT']; ?>" /><br>
			<img src="icons/page_blank_add.png" class="new pointer" alt="" title="<? echo $l10n['SAVE_DRAFT']; ?>" /><br>
			<img src="icons/search.png" class="search pointer" alt="" title="<? echo $l10n['NEW_INVOICE']; ?>" /><br>
			<? if($config['pdf']){ ?>
			<img src="icons/pdf.png" class="pdf pointer" alt="" title="<? echo $l10n['EXPORT_PDF']; ?>" /><br>
			<? } ?>
			<img src="icons/newspaper.png" class="print pointer" alt="" title="<? echo $l10n['PRINT']; ?>" /><br><br>
			<? if($config['login']['enable']){ ?>
			<img src="icons/user_close.png" class="logout pointer" alt="" title="<? echo $l10n['LOGOUT']; ?>" />
			<? } ?>
		</div>
		<div class="modal hide" id="save_inv_modal" role="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><? echo $l10n['SAVE_INVOICE']; ?></h3>
			</div>
			<div class="modal-body">
				<p><? echo $l10n['SURE_SAVE_INVOICE']; ?></p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><? echo $l10n['REJECT']; ?></a>
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

	</body>
</html>