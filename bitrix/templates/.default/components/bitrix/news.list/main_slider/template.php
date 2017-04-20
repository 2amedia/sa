
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/owl.carousel/owl.carousel.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="/js/owl.carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="/js/owl.carousel/assets/owl.theme.default.min.css">

 <script type="text/javascript">
		$.noConflict();
        (function ($) {
            $(function() {

              $('#owl-carousel-unic').owlCarousel({
                    margin: 10,
					items : "1",
					loop: true,
					autoplay: 5000,
					itemsScaleUp : false,

                    //Basic Speeds
                    slideSpeed : 200,
                    paginationSpeed : 800,
                    rewindSpeed : 1000,

                    
                    stopOnHover : true,

                    // Navigation
                    nav : true,
                    navText : ["назад","вперед"],
                    rewindNav : true,
                    scrollPerPage : false,

                    //Pagination
                    pagination : true,
                    paginationNumbers: false,

                    // Responsive
                    responsive: true,
                    responsiveRefreshRate : 200,
                    responsiveBaseWidth: window,


                    //Lazy load
                    lazyLoad : true,
                    lazyFollow : true,
                    lazyEffect : "fade",

                    //Auto height
                    
                    //JSON
                    jsonPath : false,
                    jsonSuccess : false,

                    //Mouse Events
                    dragBeforeAnimFinish : true,
                    mouseDrag :  true,
                    touchDrag :  true,

                                        transitionStyle: false,
                    
                    // Other
                    addClassActive : false,

                    //Callbacks
                    beforeUpdate : false,
                    afterUpdate : false,
                    beforeInit: function(elem) {
                                                elem.children().sort(function(){
                            return Math.round(Math.random()) - 0.5;
                        }).each(function(){
                            $(this).appendTo(elem);
                        });
                                            },
                    afterInit: false,
                    beforeMove: false,
                    afterMove: function() {
                                            },
                    afterAction: false,
                    startDragging : false,
                    afterLazyLoad : false
					
                });
            })
        }(jQuery));
</script>
<div class="owl-main-wrap">
<div id="owl-carousel-unic">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="item">
			<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?><a id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?endif?>
			<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"  class="adaptive-img">
			<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?></a><?endif?>    			
		</div>	
		<?endforeach;?>
</div>
</div>