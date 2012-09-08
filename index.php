<? 	include('./config.php');	?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><? echo $l10n['TITLE']; ?></title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="license" href="http://www.opensource.org/licenses/mit-license/">
		<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<header>
			<address>
				<? echo $config['invoice_info']; ?>
			</address>
			<span>
			<? if($config['invoice_logo']){ ?>
			<div class="toolbar_logo">
				<img src="icons/folder_search.png" class="logos_search pointer" />
			</div>
			<? } ?>
			<img alt="" src="logos/logo_default.png" id="logo"></span>
		</header>
		<article>
			<h1><? echo $l10n['RECIPIENT'] ?></h1>
			<div class="toolbar_clients">
				<img src="icons/address_book_search.png" class="clients_search pointer" />
				<img src="icons/address_book_add.png" class="client_add pointer" />
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
						<td><a class="cut">-</a><span contenteditable>Front End Consultation</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span contenteditable>150.00</span></td>
						<td><span contenteditable>4</span></td>
						<td><span data-prefix><? echo $config['prefix']; ?></span><span>600.00</span></td>
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
					<td><span data-prefix><? echo $config['prefix']; ?></span><span>600.00</span></td>
				</tr>
				<tr>
					<th><span><? echo $l10n['TOTAL'] ?></span></th>
					<td><span data-prefix><? echo $config['prefix']; ?></span><span>600.00</span></td>
				</tr>
			</table>
		</article>
		<aside>
			<h1><span><? echo $l10n['NOTE'] ?></span></h1>
			<div contenteditable class="invoice_note">
				A finance charge of 1.5% will be made on unpaid balances after 30 days.
			</div>
		</aside>
		<div class="toolbar">
			<img src="icons/save.png" class="save pointer" alt="" /><br>
			<img src="icons/page_blank_add.png" class="new pointer" alt="" />
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
	</body>
</html>