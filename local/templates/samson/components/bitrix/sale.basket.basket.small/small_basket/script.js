function updateCart() {
	var	$cartCont = $('.cart-small').parent(),
		id, bxajaxid;
	id = $cartCont.attr('id');
	bxajaxid = id.replace('comp_', '');
	if (bxajaxid.length > 0) {
		BX.ajax.insertToNode('?show_cart=Y&bxajaxid=' + bxajaxid, id);
	}
}
function positionCart() {
	var $cont = $('.cart-small'),
		$cart = $('.cart-popup-wrapper');
	
	if ($(document).scrollTop() > $cont.offset().top + 21)
		$cart.css({position: 'fixed', right: parseInt($(document).width() - $cont.offset().left - $cont.outerWidth() - 12) + 'px', top: '20px'});
	else
		$cart.css({position: 'absolute', right: '-12px', top: '21px'});
}
function toggleCart() {
	$('.cart-popup-wrapper').toggleClass('js-active');
	return false;
}
function closeCart() {
	$('.cart-popup-wrapper').removeClass('js-active');
	return false;
}
function deleteCartItem(id) {
	$.getJSON(
		'/ajax/cart.php?action=delete&id='+ id,
		{},
		function(result){
			if (result.result == true) {console.log(result);
				updateCart();
			}
		}
	);
}
var cartUpdateTimer;
function cartChange(id, action) {
	var inp = document.getElementById('cart-q-' + id);
	
	if (action == 'inc')
		inp.value++;
	else if (inp.value > 1)
		inp.value--;

	clearTimeout(cartUpdateTimer);
	cartUpdateTimer = setTimeout(function(){
		$.getJSON(
			'/ajax/cart.php?action=change&id='+ id + '&q=' + inp.value,
			{},
			function(result){console.log(result);
				if (result.result == true) {console.log(result);
					updateCart();
				}
			}
		);
	}, 500);
}

$(function(){
	$(document).scroll(function(){
		positionCart();
	});
	BX.addCustomEvent("onAjaxSuccess", function(){positionCart()});
});