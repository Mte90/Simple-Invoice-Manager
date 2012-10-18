/* Shivving (IE8 is not supported, but at least it won't look as awful)
/* ========================================================================== */

(function (document) {
	var
	head = document.head = document.getElementsByTagName('head')[0] || document.documentElement,
	elements = 'article aside bdi data datalist details figcaption figure footer header hgroup nav output picture progress section summary time x'.split(' '),
	elementsLength = elements.length,
	elementsIndex = 0,
	element;

	while (elementsIndex < elementsLength) {
		element = document.createElement(elements[++elementsIndex]);
	}

	element.innerHTML = 'x<style>' +
		'article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}' +
	'</style>';

	return head.insertBefore(element.lastChild, head.firstChild);
})(document);

/* Prototyping
/* ========================================================================== */

(function (window, ElementPrototype, ArrayPrototype, polyfill) {
	function NodeList() { [polyfill] }
	NodeList.prototype.length = ArrayPrototype.length;

	ElementPrototype.matchesSelector = ElementPrototype.matchesSelector ||
	ElementPrototype.mozMatchesSelector ||
	ElementPrototype.msMatchesSelector ||
	ElementPrototype.oMatchesSelector ||
	ElementPrototype.webkitMatchesSelector ||
	function matchesSelector(selector) {
		return ArrayPrototype.indexOf.call(this.parentNode.querySelectorAll(selector), this) > -1;
	};

	ElementPrototype.ancestorQuerySelectorAll = ElementPrototype.ancestorQuerySelectorAll ||
	ElementPrototype.mozAncestorQuerySelectorAll ||
	ElementPrototype.msAncestorQuerySelectorAll ||
	ElementPrototype.oAncestorQuerySelectorAll ||
	ElementPrototype.webkitAncestorQuerySelectorAll ||
	function ancestorQuerySelectorAll(selector) {
		for (var cite = this, newNodeList = new NodeList; cite = cite.parentElement;) {
			if (cite.matchesSelector(selector)) ArrayPrototype.push.call(newNodeList, cite);
		}
		return newNodeList;
	};

	ElementPrototype.ancestorQuerySelector = ElementPrototype.ancestorQuerySelector ||
	ElementPrototype.mozAncestorQuerySelector ||
	ElementPrototype.msAncestorQuerySelector ||
	ElementPrototype.oAncestorQuerySelector ||
	ElementPrototype.webkitAncestorQuerySelector ||
	function ancestorQuerySelector(selector) {
		return this.ancestorQuerySelectorAll(selector)[0] || null;
	};
})(this, Element.prototype, Array.prototype);

/* Helper Functions
/* ========================================================================== */

function generateTableRow() {
	var emptyColumn = document.createElement('tr');

	emptyColumn.innerHTML = '<td><a class="cut">-</a><span contenteditable></span></td>' +
		'<td><span data-prefix>$</span><span contenteditable></span></td>' +
		'<td><span contenteditable>0</span></td>' +
		'<td><span data-prefix>$</span><span>0.00</span></td>';

	return emptyColumn;
}

function parseFloatHTML(element) {
	return parseFloat(element.innerHTML.replace(/[^\d\.\-]+/g, '')) || 0;
}

function parsePrice(number) {
	return number.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1,');
}

/* Update Number
/* ========================================================================== */

function updateNumber(e) {
	var
	activeElement = document.activeElement,
	value = parseFloat(activeElement.innerHTML),
	wasPrice = activeElement.innerHTML == parsePrice(parseFloatHTML(activeElement));

	if (!isNaN(value) && (e.keyCode == 38 || e.keyCode == 40 || e.wheelDeltaY)) {
		e.preventDefault();
		value += e.keyCode == 38 ? 1 : e.keyCode == 40 ? -1 : Math.round(e.wheelDelta * 0.025);
		value = Math.max(value, 0);
		activeElement.innerHTML = wasPrice ? parsePrice(value) : value;
	}

	updateInvoice();
}

/* Update Invoice
/* ========================================================================== */

function updateInvoice() {
	var total = 0;
	var cells, price, total, a, i;

	// update inventory cells
	// ======================

	for (var a = document.querySelectorAll('table.inventory tbody tr'), i = 0; a[i]; ++i) {
		// get inventory row cells
		cells = a[i].querySelectorAll('span:last-child');

		// set price as cell[2] * cell[3]
		price = parseFloatHTML(cells[1]) * parseFloatHTML(cells[2]);

		// add price to total
		total += price;

		// set row total
		cells[3].innerHTML = price;
	}

	// update balance cells
	// ====================

	// get balance cells
	cells = document.querySelectorAll('table.balance td:last-child span:last-child');

	// only import tax
	cells[3].innerHTML = total;
	jQuery('#total').html(total);

	// set total
	cells[1].innerHTML = (total*jQuery('#value_tax').html())/100;
	cells[2].innerHTML = total-cells[1].innerHTML;

	// update prefix formatting

	var prefix = document.querySelector('#prefix').innerHTML;
	for (a = document.querySelectorAll('[data-prefix]'), i = 0; a[i]; ++i) a[i].innerHTML = prefix;

	// update price formatting

}

/* On Content Load
/* ========================================================================== */

function onContentLoad() {
	updateInvoice();
	var image = document.querySelector('img');

	function onClick(e) {
		var element = e.target.querySelector('[contenteditable]'), row;
		element && e.target != document.documentElement && e.target != document.body && element.focus();
		if (e.target.matchesSelector('.add')) {
			document.querySelector('table.inventory tbody').appendChild(generateTableRow());
		}
		else if (e.target.className == 'cut') {
			row = e.target.ancestorQuerySelector('tr');
			row.parentNode.removeChild(row);
		}

		updateInvoice();
	}

	function onEnterCancel(e) {
		e.preventDefault();
		image.classList.add('hover');
	}

	function onLeaveCancel(e) {
		e.preventDefault();
		image.classList.remove('hover');
	}

	if (window.addEventListener) {
		document.addEventListener('click', onClick);
		document.addEventListener('mousewheel', updateNumber);
		document.addEventListener('keydown', updateNumber);
		document.addEventListener('keydown', updateInvoice);
		document.addEventListener('keyup', updateInvoice);
	}
}

window.addEventListener && document.addEventListener('DOMContentLoaded', onContentLoad);

//Invoice Code

$(function() {
	jQuery(document).on('change','input,select,textarea :not([type=submit])',function() {
		jQuery(this).jqBootstrapValidation();
	});

	jQuery('.number-check [contenteditable=true]').keydown(function (e) {
		e.preventDefault();
	});


	jQuery(document).on('click','.btn-primary',function(e) {
		jQuery('input,select,textarea').jqBootstrapValidation();
		jQuery(this).jqBootstrapValidation('init',{event:e});
	});

	/* Invoice */
	//New Invoice
	jQuery('.new').click(function() {
			location.reload();
		});
	//On save Invoice
	jQuery(document).on('click','.save',function() {
		var txt=mode_inv=old_text = '';

		jQuery('table.inventory tbody tr').each(function(key, value) {
			cells = jQuery(this).find('td span');
			if(jQuery(cells[0]).html()!=""){
				txt += "<product>\n\t\t<item>"+jQuery(cells[0]).html()+"</item>\n\t\t<rate>"+jQuery(cells[2]).html();
				txt += "</rate>\n\t\t<quantity>"+jQuery(cells[3]).html()+"</quantity>\n\t</product>\n\t";
			}
		});

		if (jQuery('body').data('client')=='' || jQuery('body').data('client')==null) {
			old_text = jQuery('#save_inv_modal .modal-body').html();
			jQuery('#save_inv_modal .modal-body').html(jQuery('#save_inv_modal .modal-body').data('message-option'));
			mode_inv = 'save_draft_invoice';
		} else {
			mode_inv = 'save_invoice';
		}

		console.log(jQuery('body').data('client'))
		console.log(mode_inv)
		jQuery('#save_inv_modal').modal('show');

		jQuery('#save_inv_okay').off('click');
		jQuery('#save_inv_okay').click(function() {
			jQuery.get('save.php', {
				'mode'		:mode_inv,
				'invoice_number':jQuery('.invoice_n').html(),
				'invoice_ticket':jQuery('.invoice_ticket').html(),
				'content'	:txt,
				'note'		:jQuery('.invoice_note').html(),
				'date'		:jQuery('.invoice_date').html(),
				'tax'		:jQuery('#value_tax').html(),
				'client_number'	:jQuery('body').data('client'),
				'logo'		:jQuery('#logo').attr('src')
			}).success(function() {
				jQuery('#save_inv_modal').modal('hide');
				if(mode_inv == 'save_draft_invoice'){
					jQuery('#save_inv_modal .modal-body').html(old_text);
				}
			});

		});

	});
	//Select Invoice
	jQuery(document).on('click','.invoice-list td',function(e){
		choosen = this;
		jQuery.getJSON('invoice_data.php', {
			'number':	jQuery(choosen).data('id'),
			'year'  :	jQuery(choosen).data('year')
		}).success(function(data) {
			init_invoice(data);
			jQuery('#invoice_modal_list').modal('hide');
		});
		e.stopPropagation();
	});

	/* Draft */
	//On save Draft Invoice
	jQuery(document).on('click','.draft',function() {
		var txt = '';
		jQuery('table.inventory tbody tr').each(function(key, value) {
			cells = jQuery(this).find('td span');
			if(jQuery(cells[0]).html()!=""){
				txt += "<product>\n\t\t<item>"+jQuery(cells[0]).html()+"</item>\n\t\t<rate>"+jQuery(cells[2]).html();
				txt += "</rate>\n\t\t<quantity>"+jQuery(cells[3]).html()+"</quantity>\n\t</product>\n\t";
			}
		});
		jQuery('#save_draft_modal').modal('show');
		jQuery('#save_draft_okay').click(function() {
			jQuery.get('save.php', {
				'mode'		:'save_draft_invoice',
				'invoice_number':jQuery('.invoice_n').html(),
				'invoice_ticket':jQuery('.invoice_ticket').html(),
				'content'	:txt,
				'note'		:jQuery('.invoice_note').html(),
				'date'		:jQuery('.invoice_date').html(),
				'tax'		:jQuery('#value_tax').html(),
				'client_number'	:jQuery('body').data('client'),
				'logo'		:jQuery('#logo').attr('src')
			}).success(function() {jQuery('#save_draft_modal').modal('hide');});
		});
	});
	//Select Draft
	jQuery(document).on('click','.draft-list .draft_choosen',function(e){
		jQuery.getJSON('invoice_data.php', {
			'number':		jQuery(this).parent().data('id'),
			'year'	:		'draft'
		}).success(function(data) {
			init_invoice(data);
			jQuery('#invoice_modal_list').modal('hide');
		});
		e.stopPropagation();
	});
	//Sure Delete Draft
	jQuery(document).on('click','.draft-list .draft_del',function() {
		jQuery('#invoice_modal_list').modal('hide');
		jQuery('#del_draft_modal').data('id',jQuery(this).parent().data('id')).modal('show');
	});
	//Delete Draft
	jQuery('#del_draft_okay').click(function() {
		jQuery.get('delete.php', {
			'mode'		:'del_draft',
			'draft'		:jQuery('#del_note_modal').data('id')
		}).success(function() {jQuery('#del_draft_modal').modal('hide');});
	});

	/* Client */
	//Add Client
	jQuery('.client_add').click(function() {
		jQuery('body').append('<div id="client_modal_add" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'clients_new'
		}).success(function(data) {
			jQuery('#client_modal_add').html(data);
		});
		jQuery('#client_modal_add').modal('show');
		jQuery('#client_add_name').focus();
	});
	//On save Clients
	jQuery(document).on('click','#save_client_okay',function() {
		jQuery.get('save.php', {
			'mode'		:'new_client',
			'name'		:jQuery('#client_add_name').val(),
			'vat'		:jQuery('#client_add_vat').val(),
			'address'	:jQuery('#client_add_address').val(),
			'zipcode'	:jQuery('#client_add_zipcode').val(),
			'city'		:jQuery('#client_add_city').val(),
			'region'	:jQuery('#client_add_region').val(),
			'phone'		:jQuery('#client_add_phone').val(),
			'email'		:jQuery('#client_add_email').val()
		}).success(function() {
			jQuery('#client_add_form').each(function(){this.reset();});
			jQuery('#client_modal_add').modal('hide');
		});
	});
	//Search Client
	jQuery('.clients_search').click(function() {
		jQuery('body').append('<div id="clients_modal_list" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'clients_list'
		}).success(function(data) {
			jQuery('#clients_modal_list').html(data);
		});
		jQuery('#clients_modal_list').modal('show');
	});
	//Select Client
	jQuery(document).on('click','.clients-list .client_choosen',function(e){
		var choose_client = jQuery(this);
		jQuery.get('client_info.php', {
			'file':		jQuery(this).parent().data('id')
		}).success(function(data) {
			jQuery('.client_info').html(data);
			jQuery('#clients_modal_list').modal('hide');
		});
		jQuery('body').data('client',jQuery('.clients-list .client_choosen').parent().data('id'));
		e.stopPropagation();
	});
	//Modify Client
	jQuery(document).on('click','.clients-list .client_mod',function() {
		jQuery('body').append('<div id="client_modal_mod" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'client_mod',
			'client'	:jQuery(this).parent().data('id')
		}).success(function(data) {
			jQuery('#clients_modal_list').modal('hide');
			jQuery('#client_modal_mod').html(data);
			jQuery('#client_modal_mod').modal('show');
		});
	});
	//On save Modified Notes
	jQuery(document).on('click','#mod_client_okay',function() {
		jQuery.get('save.php', {
			'mode'		:'mod_client',
			'name'		:jQuery('#client_add_name').val(),
			'vat'		:jQuery('#client_add_vat').val(),
			'address'	:jQuery('#client_add_address').val(),
			'zipcode'	:jQuery('#client_add_zipcode').val(),
			'city'		:jQuery('#client_add_city').val(),
			'region'	:jQuery('#client_add_region').val(),
			'phone'		:jQuery('#client_add_phone').val(),
			'email'		:jQuery('#client_add_email').val(),
			'client'	:jQuery('input[name=client_number]').val()
		}).success(function() {
			jQuery('#client_add_form').each(function(){this.reset();});
			jQuery('#client_modal_mod').modal('hide');
		});
	});

	/* Note */
	//Add Note
	jQuery('.notes_add').click(function() {
		jQuery('body').append('<div id="note_modal_add" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'notes_new'
		}).success(function(data) {
			jQuery('#note_modal_add').html(data);
			jQuery('.note_preview').html(jQuery('.invoice_note').html());
			jQuery('#note_modal_add').modal('show');
		});
	});
	//On save Notes
	jQuery(document).on('click','#save_note_okay',function() {
		jQuery.get('save.php', {
			'mode'		:'new_note',
			'name'		:jQuery('#note_add_name').val(),
			'text'		:jQuery('.invoice_note').html()
		}).success(function() {
			jQuery('#note_modal_add').modal('hide');
		});
	});
	//Search Notes
	jQuery('.notes_search').click(function() {
		jQuery('body').append('<div id="notes_modal_list" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'notes_list'
		}).success(function(data) {
			jQuery('#notes_modal_list').html(data);
		});
		jQuery('#notes_modal_list').modal('show');
	});
	//Select Note
	jQuery(document).on('click','.notes-list .note_choosen',function(e){
		jQuery.getJSON('note_data.php', {
			'number':		jQuery(this).parent().data('id')
		}).success(function(data) {
			jQuery('.invoice_note').html(data.text);
			jQuery('#notes_modal_list').modal('hide');
		});
		e.stopPropagation();
	});
	//Modify Note
	jQuery(document).on('click','.notes-list .note_mod',function() {
		jQuery('body').append('<div id="note_modal_mod" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'notes_mod',
			'note'		:jQuery(this).parent().data('id')
		}).success(function(data) {
			jQuery('#notes_modal_list').modal('hide');
			jQuery('#note_modal_mod').html(data);
			jQuery('#note_modal_mod').modal('show');
		});
	});
	//On save Modified Notes
	jQuery(document).on('click','#mod_note_okay',function() {
		jQuery.get('save.php', {
			'mode'		:'mod_note',
			'name'		:jQuery('#note_mod_name').val(),
			'text'		:jQuery('#note_text').val(),
			'note'		:jQuery('input[name=note_number]').val()
		}).success(function() {
			jQuery('#note_modal_mod').modal('hide');
		});
	});
	//Sure Delete Note
	jQuery(document).on('click','.notes-list .note_del',function() {
		jQuery('#notes_modal_list').modal('hide');
		jQuery('#del_note_modal').data('id',jQuery(this).parent().data('id')).modal('show');
	});
	//Delete Note
	jQuery('#del_note_okay').click(function() {
		jQuery.get('delete.php', {
			'mode'		:'del_note',
			'note'		:jQuery('#del_note_modal').data('id')
		}).success(function() {jQuery('#del_note_modal').modal('hide');});
	});

	/* Logo */
	//Search Logo
	jQuery('.logos_search').click(function() {
		jQuery('body').append('<div id="logos_modal_list" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'logo_list'
		}).success(function(data) {
			jQuery('#logos_modal_list').html(data);
		});
		jQuery('#logos_modal_list').modal('show');
	});
	//Select Logo
	jQuery(document).on('click','.logos-list td',function(e){
		jQuery('#logo').attr('src','logos/'+jQuery(this).data('logo'));
		jQuery('#logos_modal_list').modal('hide');
		e.stopPropagation();
	});

	//Search Draft/Invoice Modal
	jQuery('.search').click(function() {
		jQuery('body').append('<div id="invoice_modal_list" class="modal hide" role="dialog"/>');
		jQuery.get('list.php', {
			'mode'		:'invoice_list'
		}).success(function(data) {
			jQuery('#invoice_modal_list').html(data);
			jQuery('.tabs-invoice #invoice').tab('show');
		});
		jQuery('#invoice_modal_list').modal('show');
	});

	//PDF
	jQuery('.pdf').click(function() {
		window.open('./pdf.php?inv='+jQuery('.invoice_n').html()+'&year='+jQuery('body').data('year'), '_blank');
	});
	//Print
	jQuery('.print').click(function() {
		window.open('./print.php?inv_='+jQuery('.invoice_n').html()+'&year_='+jQuery('body').data('year'), '_blank');
	});
	//EMail
	jQuery('.email').click(function() {
		jQuery('body').append('<div id="email_modal" class="modal hide" role="dialog"/>');
		jQuery.get('email.php', {
			'mode'		:'form',
			'email'		:jQuery('input[name=client_email]').val()
		}).success(function(data) {
			jQuery('#email_modal').html(data);
		});
		jQuery('#email_modal').modal('show');
	});

	jQuery(document).on('click','#sent_email_ok',function() {
		spin_show();
		jQuery.get('email.php', {
			'mode'		:'send',
			'user_email'	:jQuery('#user_email').val(),
			'subject_email'	:jQuery('#subject_email').val(),
			'content_email'	:jQuery('#content_email').val(),
			'attach_email'	:jQuery('#attach_email').val(),
			'inv_'		:jQuery('.invoice_n').html(),
			'year_'		:jQuery('body').data('year')
		}).success(function(data) {
			spin_hide();
			if(data!='error') {
				jQuery('#email_modal').modal('hide');
			} else {
				alert('Error with email!');
			}
		});
	});

	function spin_show() {
		jQuery('<div class="modal-backdrop spin"/>').activity({color:'#08c'});
	}

	function spin_hide() {
		jQuery('.modal-backdrop.spin').activity(false).remove();
	}

	//Load Invoice/Draft
	function init_invoice(json) {
		jQuery('.invoice_n').html(json.number);
		jQuery('.invoice_ticket').html(json.ticket);
		jQuery('.invoice_note').html(json.note);
		jQuery('.invoice_date').html(json.date);
		jQuery('#value_tax').html(json.tax);
		jQuery('#logo').attr('src',json.logo);
		jQuery('body').data('year',json.year);
		jQuery('body').data('client',json.client);

		jQuery('table.inventory tbody tr').remove();

		for (i=0; i<json.product.length; i++) {
			document.querySelector('table.inventory tbody').appendChild(generateTableRow());
		}
		list_product = jQuery('table.inventory tbody tr');

		$.each(json.product, function(i){
			cells = jQuery(list_product[i]).find('td span');
			jQuery(cells[0]).html(json.product[i].item);
			jQuery(cells[2]).html(json.product[i].rate);
			jQuery(cells[3]).html(json.product[i].quantity);
		});

		jQuery.get('client_info.php', {
			'file':		json.client
		}).success(function(data) {
			if(data!=0){
				jQuery('.client_info').html(data);

				if(jQuery('input[name=client_email]').val()!=''){
					jQuery('.email').show();
				}else {
					jQuery('.email').hide();
				}
			}else {
				jQuery('.client_info').html('<b>'+jQuery('body').data('choose-client')+'</b>');
			}
		});

		updateNumber();
		updateInvoice();
	}


});
