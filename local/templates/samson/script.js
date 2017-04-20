$(document).ready(function () {

    //левое меню
    $('.toggle_element').click(function () {
		// $('.lev_one').removeClass('uncollapsed');
        $(this).parent().parent().toggleClass('uncollapsed');
		var thisIndex = $('.toggle_element').index(this);
		$('.toggle_element').each(function (index) {
			if (index > thisIndex) {
				$(this).parent().parent().removeClass('uncollapsed');
			}
		});
    });


    //Sort random function
    function random(owlSelector) {
        owlSelector.children().sort(function () {
            return Math.round(Math.random()) - 0.5;
        }).each(function () {
            $(this).appendTo(owlSelector);
        });
    }

    $("#owl-carousel-unic").owlCarousel({
        margin:0,
        items: "1",
        loop: true,
        autoPlay: true,
        singleItem:true,
        itemsScaleUp: true,
        lazyLoad:true,
        lazyEffect:false,
        responsiveClass:true,
        autoWidth: true,

        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1000,

        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }

    });

    $("#owl-carousel-footer").owlCarousel({
        margin:0,
        items: "1",
        loop: true,
        autoPlay: true,
        singleItem:true,
        itemsScaleUp: true,
        lazyLoad:true,
        lazyEffect:false,
        responsiveClass:true,
        autoWidth: true,

        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1000,

        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });

    $("#owl-carousel-inner").owlCarousel({
        margin: 0,
        items: "1",
        loop: true,
        singleItem:true,
        itemsScaleUp: true,
        lazyLoad:true,
        lazyEffect:false,
        responsiveClass:true,
        autoWidth: true,
        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1000,

        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });


    $("#owl-carousel-small").owlCarousel({
        margin:0,
        items: "1",
        loop: true,
        autoPlay: true,
        itemsScaleUp: false,
        singleItem:true,
        //Basic Speeds
        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1000,
        pagination: false,
        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });
    $("#owl-carousel-whith").owlCarousel({
        margin: 10,
        items: "4",
        loop: true,
        autoPlay: false,
        itemsScaleUp: true,
        pagination:true,

        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1000,

        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });


    $('.gallery-items').each(function () { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true
            }
        });
    });

    $('.doc').each(function () { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true
            }
        });
    });

    $('.tovar-images').each(function () { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true
            }
        });
    });

    $('.add2cart').click(function(e){
        e.preventDefault();
        var id = parseInt($(this).attr('data-id')),
            q = 1;
        console.log(bxSession.sessid);
        if (id > 0) {
            $.getJSON(
                '/ajax/cart.php?action=add&id='+ id +'&q='+ q +'&sessid='+ bxSession.sessid,
                {},
                function(result){
                    if (result.result == true) {
                        updateCart();
                    }
                }
            );
        }
    });

    $('#popup-btn').magnificPopup({
        items: {
            src: '#popup',
            type: 'inline'},
            callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeBtnInside:false,
            showCloseBtn:false,
            closeOnContentClick:true

    });
    $('.auto-ru').brazzersCarousel();

/*страница лендос*/
 $('.design_download').click(function () {
        $('.item_order_modal_bg').fadeIn("slow");
        $('.item_order_modal_content').fadeIn("slow");
    });
    $('.item_order_btn').click(function () {
        $('.item_order_modal_bg').fadeIn("slow");
        $('.item_order_modal_content').fadeIn("slow");
    });
    $('.item_order_modal_close').click(function () {
        $('.item_order_modal_bg').fadeOut("slow");
        $('.item_order_modal_content').fadeOut("slow");
    });
    $('.item_order_modal_bg').click(function () {
        $('.item_order_modal_bg').fadeOut("slow");
        $('.item_order_modal_content').fadeOut("slow");
    });
    $('.question_name').click(function () {
        $(this).parent().children('.question_content').slideToggle('slow');
        $(this).toggleClass('opened');
    });
    $('.question:first-child').children('.question_content').show();

    $lItm = $('div.item-el').length;
    $hItm = 2;
    if ($lItm > 2) {
        $('.item-el').slice(2).hide();
    } else {
        $('.design_more>span').hide();
    }
    $('.design_more').click(function () {
        console.log($hItm);
        console.log($lItm);
        $hItm = $hItm + 1;
        if ($hItm <= $lItm) {
            $('.item-el:nth-child(' + $hItm + ')').slideDown('slow');
            if ($hItm == $lItm){
                $('.design_more>span').fadeOut('slow');
            }
        }
    });
    $("#phone").mask("+7(999) 999-9999");
    $(".user_phone").mask("+7(999) 999-9999");
    $("#phone2").mask("+7(999) 999-9999");
      $('#order_kons').submit(function (e) {
        $.ajax({
            method:'POST',
            url: '/include/ajax/order.php',
            data: $(this).serialize(),
            success: function(response){
                $('#order_kons').html(response);
            }
        });
        e.preventDefault();
    });
    $('#order').submit(function (e) {
        $.ajax({
            method:'POST',
            url: '/include/ajax/order.php',
            data: $(this).serialize(),
            success: function(response){
                $('.item_order_modal_content').html(response);
            }
        });
        e.preventDefault();
    });

    //$.fn.snowit({ flakeColor: '#CCC', total: 55 });

    //клик на доп услге
    $('.usluga_item').click(function () {

        if (!$(this).hasClass('req')) {
            $(this).toggleClass('selected_usluga');
        }
    });
    $('.usluga_item_percent').click(function () {
        if (!$(this).hasClass('req')) {
            $(this).toggleClass('selected_usluga_persent');
        }
    });


    //клик по доп товару
    $('.btn_add').click(function () {
        var elem = $(this);
        var id = $(this).attr('id').replace('dop_','');
        //добавляем
        if(!elem.hasClass('btn_added')){
            q = 1;
            console.log(bxSession.sessid);
            if (id > 0) {
                $.getJSON(
                    '/ajax/cart.php?action=add&id=' + id + '&q=' + q + '&sessid=' + bxSession.sessid,
                    {},
                    function (result) {
                        if (result.result == true) {
                            updateCart();
                            elem.removeClass('btn_add');
                            elem.addClass('btn_added');
                        }
                    }
                );
            }
        }
    });

    //клик по кредиту
    $('.credit').click(function (e) {
        e.preventDefault();
        $('#credit_modal').modal('show');
    });
	 //клик по кредиту
    $('.credit_text').click(function (e) {
        e.preventDefault();
        $('#credit_modal').modal('show');
    });

//один клик собираем форму
    $('.one_click').click(function (e) {
        e.preventDefault();
        $('.zakaz').html('');
        $('#one_button_form')[0].reset();
        var tovar_sel = $('#desc').attr("data-offername");
        var price = $('.price-current').text();
        $('.zakaz').append('<input type="hidden" name ="tovar" value="' + tovar_sel +':  '+ price + '" class="super_form">');
        $('.selected_usluga').each(function (index, value) {
            var text_item = $(this).text();
            $('.zakaz').append('<input type="hidden" name ="dop_'+ index +'"'+' value="'+ text_item +'" class="super_form" >');
        });
        $('#one_click_modal').modal('show');
    });

    //один клик отправлем форму
    $('#one_button_form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: '/include/ajax/one_click.php',
            data: $(this).serialize(),
            success: function (response) {
                $('#one_button_form_result_mess').html(response);
                $('#one_form_send').hide();
            }
        });

    });

    //предзаказ
    $('.pre_order').click(function (e) {
        e.preventDefault();
        $('.zakaz').html('');
        $('#one_button_form')[0].reset();
        var tovar_sel = $('#desc').attr("data-offername");
        var price = $('.price-current').text();
        $('.zakaz').append('<input type="hidden" name ="tovar" value="' + tovar_sel + ':  ' + price + '" class="super_form">');
        $('.selected_usluga').each(function (index, value) {
            var text_item = $(this).text();
            $('.zakaz').append('<input type="hidden" name ="dop_' + index + '"' + ' value="' + text_item + '" class="super_form" >');
        });
        $('#pre_order_modal').modal('show');
    });

    //предзаказ отправлем форму
    $('#pre_order_form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: '/include/ajax/one_pre_order.php',
            data: $(this).serialize(),
            success: function (response) {
                $('#pre_order_form_result_mess').html(response);
                $('#pre_order_modal_send').hide();
            }
        });

    });

    //в корзину

    $('.cart_button').click(function (e) {
        e.preventDefault();
        var id_item = new Array();
        var id_item_persent = new Array();
        var i = 0;
        var j = 0;
        var id = parseInt($('#desc').attr("data-offerid"));
        var parent_id = parseInt($('.bx-detail-element').attr("data-parent"));

        //console.log(usl_item);

        $('.selected_usluga').each(function (index, value) {
             id_item[i] = parseInt($(this).attr("data-id"));
             i++
        });

        //id_item[i] = id;


        $('.selected_usluga_persent').each(function (index, value) {
            id_item_persent[j] = $(this).attr("data-id")+':'+$(this).attr("data-price");
            j++
        });

        //id_item_persent = id_item_persent.toString();

        console.log(bxSession.sessid);

            $.getJSON(
                '/ajax/cart.php?action=addmore&parent_id='+parent_id+'&id='+id+'&set_ids=' + id_item + '&set_ids_percent=' + id_item_persent + '&sessid=' + bxSession.sessid,
                {},
                function (result) {
                    if (result.result == true) {
                        updateCart();
                    }
                }
            );
    });


    $('.sert').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    $('#chertej').delegate('a', 'click',function (event) {
        event.preventDefault();
        console.log(this);
        $(this).magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
        $(this).click();
    });

});


function collapsElement(id) {
    if (document.getElementById(id).style.display != "none") {
        document.getElementById(id).style.display = 'none';
    }
    else {
        document.getElementById(id).style.display = '';
    }
};
