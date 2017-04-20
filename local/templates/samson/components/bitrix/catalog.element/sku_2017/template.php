<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $price['MIN_QUANTITY'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>

<div class="bx-detail-element" id="<?= $itemIds['ID'] ?>" data-parent ='<?=$arResult['ID']?>'>
    <div class="row">
        <div class="col-sm-4">
            <div class="product-item-detail-slider-container" id="<?= $itemIds['BIG_SLIDER_ID'] ?>">
                <span class="product-item-detail-slider-close" data-entity="close-popup"></span>
                <div class="product-item-detail-slider-block
						<?= ($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '') ?>"
                     data-entity="images-slider-block">
                    <span class="product-item-detail-slider-left" data-entity="slider-control-left"
                          style="display: none;"></span>
                    <span class="product-item-detail-slider-right" data-entity="slider-control-right"
                          style="display: none;"></span>

                    <div class="product-item-detail-slider-images-container" data-entity="images-container">
					    <?
					    if (!empty($actualItem['MORE_PHOTO']))
					    {
						    foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
						    {
						        $koef = $photo['WIDTH']/ $photo['HEIGHT'];
							    if ($koef > 2) {
								    $koef = $koef - 1;
                                }

						        if ($koef >0) {
							        $newWidth = $koef * 1000;
							        $newHeight = 1000;
                                }
                                else {
	                                $newHeight = $koef * 1000;
	                                $newWidth = 1000;
                                }
							    $arWaterMark = Array(
								    array(
									    "name" => "watermark",
									    "position" => "topleft",
									    "type" => "image",
									    "size" => "real",
									    "file" => $_SERVER['DOCUMENT_ROOT'] . "/upload/watermark/800_600.png",
									    "fill" => "exact"
								    )
							    );
						    //dump($water);
							    $image_resize = CFile::ResizeImageGet ($photo['ID'], array(
									    "width" => $newWidth,
									    "height" => $newHeight
								    ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arWaterMark);

							    //dump($image_resize);
							    ?>
                                <div class="product-item-detail-slider-image<?= ($key == 0 ? ' active' : '') ?>"
                                     data-entity="image" data-id="<?= $photo['ID'] ?>">

                                    <img src="<?= $image_resize['src'] ?>" alt="<?= $alt ?>"
                                         title="<?= $title ?>"<?= ($key == 0 ? ' itemprop="image"' : '') ?>>
                                </div>
							    <?
						    }
					    }

					    if ($arParams['SLIDER_PROGRESS'] === 'Y')
					    {
						    ?>
                            <div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar"
                                 style="width: 0;"></div>
						    <?
					    }
					    ?>
                    </div>
                </div>
			    <?
			    if ($showSliderControls)
			    {
				    if ($haveOffers)
				    {
					    foreach ($arResult['OFFERS'] as $keyOffer => $offer)
					    {
						    if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
						    {
							    continue;
						    }

						    $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
						    ?>
                            <div class="product-item-detail-slider-controls-block"
                                 id="<?= $itemIds['SLIDER_CONT_OF_ID'] . $offer['ID'] ?>"
                                 style="display: <?= $strVisible ?>;">
							    <?
							    foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
							    {
								    if ($photo['WIDTH'] > 60 || $photo['HEIGHT'] > 60)
								    {
									    $koef = $photo['WIDTH'] / $photo['HEIGHT'];

									    if ($koef > 2)
									    {
										    $koef = $koef - 1;
									    }

									    if ($koef > 0)
									    {
										    $newWidth = $koef * 60;
										    $newHeight = 60;
									    }
									    else
									    {
										    $newHeight = $koef * 60;
										    $newWidth = 60;
									    }
								    }

								    $image_resize = CFile::ResizeImageGet ($photo['ID'], array(
										    "width" => $newWidth,
										    "height" => $newHeight
									    ), BX_RESIZE_IMAGE_PROPORTIONAL, true);
								    ?>
                                    <div class="product-item-detail-slider-controls-image<?= ($keyPhoto == 0 ? ' active' : '') ?>"
                                         data-entity="slider-control"
                                         data-value="<?= $offer['ID'] . '_' . $photo['ID'] ?>">
                                        <img src="<?= $image_resize['src'] ?>">
                                    </div>
								    <?
							    }
							    ?>
                            </div>
						    <?
					    }
				    }
				    else
				    {
					    ?>
                        <div class="product-item-detail-slider-controls-block" id="<?= $itemIds['SLIDER_CONT_ID'] ?>">
						    <?
						    if (!empty($actualItem['MORE_PHOTO']))
						    {
							    foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
							    {
								    if ($photo['WIDTH'] > 60 || $photo['HEIGHT'] > 60)
								    {
									    $koef = $photo['WIDTH'] / $photo['HEIGHT'];

									    if ($koef > 2)
									    {
										    $koef = $koef - 1;
									    }

									    if ($koef > 0)
									    {
										    $newWidth = $koef * 60;
										    $newHeight = 60;
									    }
									    else
									    {
										    $newHeight = $koef * 60;
										    $newWidth = 60;
									    }
								    }

								    $image_resize = CFile::ResizeImageGet (
								            $photo['ID'],
                                        array(
									    "width" => $newWidth,
									    "height" => $newHeight),
									    BX_RESIZE_IMAGE_PROPORTIONAL,
									    true
								    );
								    ?>
                                    <div class="product-item-detail-slider-controls-image<?= ($key == 0 ? ' active' : '') ?>"
                                         data-entity="slider-control" data-value="<?= $photo['ID'] ?>">
                                        <img src="<?= $image_resize['src'] ?>">
                                    </div>
								    <?
							    }
						    }
						    ?>
                        </div>
					    <?
				    }
			    }
			    ?>
            </div>
            <?if (!empty($arResult['SOPUTKA'])){?>
            <div class="by_with_caption">
                с этим товаром покупают
            </div>
            <ul class="soputka_list">
                <?foreach($arResult['SOPUTKA'] as $soputka){?>
                    <li class="soputka_item">
                        <a href="<?=$soputka['URL']?>">
                            <div class="soput_img" style="background: url(<?= $soputka['PIC'] ?>)">
                            </div>
                            <!-- /.soput_img -->
                        <div class="soput_name">
	                        <?= $soputka['NAME'] ?>
                        </div>
                        <!-- /.soput_name -->
                        <div class="soput_des">
	                        <?= $soputka['DESCR'] ?>
                        </div>
                        <!-- /.soput_des -->
                        <div class="soput_pr">
	                        <?= $soputka['PRICE'] ?> руб.
                        </div>
                        <!-- /.soput_pr -->
                        </a>
                        <span class="btn_add" id="dop_<?= $soputka['ID'] ?>"></span>
                        <div class="clearfix"></div>
                        <!-- /.clearfix -->
                    </li>
                <?}?>
            </ul>
            <?}?>
        </div>

        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12 ">
					<div class="tovar_name">
	                    <h1><?= $name ?></h1>
	                    <span><?=$arResult['PREVIEW_TEXT'] ?></span>
					</div>
                </div>
                <div class="col-sm-12">
                    <div class="product-item-detail-price-block" >
			            <? foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
			            {
				            switch ($blockName)
				            {

					            case 'price':
						            ?>
                                    <div class="product-item-detail-info-container " id="price_block">
                                        <span>Цена:</span>
                                        <div class="clearfix"></div>
                                        <!-- /.clearfix -->

                                        

                                       
                                       
	                                    <?
	                                    if ($arParams['SHOW_OLD_PRICE'] === 'Y')
	                                    {
		                                    ?>
                                            <div class="price-old"
                                                 id="<?= $itemIds['OLD_PRICE_ID'] ?>"
                                                 style="display: <?= ($showDiscount ? '' : 'none') ?>;">
			                                    <?= ($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '') ?>
                                            </div>
                                            
                                            <div class="price-current" id="<?= $itemIds['PRICE_ID'] ?>">
						            <? if (!$haveOffers && ($price['PRICE'] > 0)){ ?>
								            <?= $price['PRINT_RATIO_PRICE'] ?>
                                        <?} else {?>
                                        по запросу
                                    <?}?>
                                        </div>
	                                    <?
	                                    if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
	                                    {
		                                    if ($haveOffers)
		                                    {
			                                    ?>
                                                <div class="discount"
                                                     id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"
                                                     style="display: none;">
                                                    скидка <?= $price['PERCENT'] ?>%
                                                </div>
			                                    <?
		                                    }
		                                    else
		                                    {
			                                    if ($price['DISCOUNT'] > 0)
			                                    {
				                                    ?>
                                                    <div class="discount"
                                                         id="<?= $itemIds['DISCOUNT_PERCENT_ID'] ?>"
                                                         title="скидка <?=$price['PERCENT'] ?>%">
                                                        скидка <?= $price['PERCENT'] ?>%
                                                    </div>
				                                    <?
			                                    }
		                                    }
	                                    }
	                                    ?>
                                         <!-- /.clearfix -->
                                         <div class="clearfix"></div>
                                         
											<? if (!$haveOffers && ($price['PRICE'] > 3000))
                                        {;
										$pricecredit=$price['PRICE'] * 1.2 / 12;
										$pricecredit2=number_format($pricecredit, 0, ',', ' ');;?>
                                        
                                            <div id="credit">
                                                <div id="credit_price"><? echo $pricecredit2; ?> руб.<br><span>платёж в месяц</span></div>
                                                <div id="credit_text"> <a href="" class="credit_text">кредит на год</a></div>
                                                
                                                
                                                
                                                <!-- /.credit_text -->
                                            </div><div class="clearfix"></div>
											<?
										} ?>
											<? if ($haveOffers)
										{ ?>
                                            <div id="credit" class="hidden">
                                                <div id="credit_price"></div>
                                                <div id="credit_text">кредит на год</div>
                                                <!-- /.credit_text -->
                                            </div><div class="clearfix"></div>
											<?
										} ?>
                                            
                                            <div class="qty">Наличие:
                                                <?if (!$haveOffers){?>
                                                <?echo ($arResult['PRODUCT']['QUANTITY']>0)? '<b>Много</b>' : '<b>под заказ</b>'?>
                                                <?}?>
                                            </div>
                                            <!-- /.qty -->
                                            <span id="<?= $itemIds['DISCOUNT_PRICE_ID'] ?>" class="hidden"></span>
		                                    <?
	                                    }
	                                    ?>

                                    </div>

						            <?
						            break;
				            }
			            }?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="product-item-detail-info-section">
					    <?
					    foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
					    {
						    switch ($blockName)
						    {
							    case 'sku':
								    if ($haveOffers && !empty($arResult['OFFERS_PROP']))
								    {
									    ?>
                                        <div id="<?= $itemIds['TREE_ID'] ?>">

										    <?
										    foreach ($arResult['SKU_PROPS'] as $skuProperty)
										    { //($skuProperty);
											    if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
											    {
												    continue;
											    }

											    $propertyId = $skuProperty['ID'];
											    $skuProps[] = array(
												    'ID' => $propertyId,
												    'SHOW_MODE' => $skuProperty['SHOW_MODE'],
												    'VALUES' => $skuProperty['VALUES'],
												    'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
											    );
											    ?>
                                                <div class="product-item-detail-info-container"
                                                     data-entity="sku-line-block">
                                                    <div class="product-item-detail-info-container-title"><?= htmlspecialcharsEx($skuProperty['NAME']) ?></div>
                                                    <div class="product-item-scu-container">
                                                        <div class="product-item-scu-block">
                                                            <div class="product-item-scu-list">
                                                                <ul class="product-item-scu-item-list">
																    <?
																    foreach ($skuProperty['VALUES'] as &$value)
																    {
																	    $value['NAME'] = htmlspecialcharsbx($value['NAME']);

																	    if ($skuProperty['SHOW_MODE'] === 'PICT')
																	    {
																		    ?>
                                                                            <li class="product-item-scu-item-color-container  <?= $value['CSS'] ?>"
                                                                                data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                                data-onevalue="<?= $value['ID'] ?>">
                                                                                <div class="product-item-scu-item-color-block">
                                                                                    <div class="product-item-scu-item-color"
                                                                                         style="background-image: url(<?= $value['PICT']['SRC'] ?>);">
                                                                                    </div>
                                                                                    <?if(strlen
                                                                                    ($value['DESCRIPTION'])>0):?>
                                                                                    <div class="tooltip_samson">
		                                                                                <?= $value['DESCRIPTION'] ?>
                                                                                    </div>
                                                                                    <?endif;?>
                                                                                </div>
                                                                            </li>
																		    <?
																	    }
																	    else
																	    {
																		    ?>
                                                                            <li class="product-item-scu-item-text-container"

                                                                                data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>"
                                                                                data-onevalue="<?= $value['ID'] ?>">
                                                                                <div class="product-item-scu-item-text-block">
                                                                                    <div class="product-item-scu-item-text <?=$value['CSS']?>"><?= $value['NAME'] ?></div>
	                                                                                <? if (strlen($value['DESCRIPTION']) > 0):?>
                                                                                        <div class="tooltip_samson">
			                                                                                <?= $value['DESCRIPTION'] ?>
                                                                                        </div>
	                                                                                <?endif; ?>
                                                                                </div>
                                                                            </li>
																		    <?
																	    }
																    }
																    ?>
                                                                </ul>
                                                                <div style="clear: both;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
											    <?
										    }
										    ?>
                                        </div>
									    <?
								    }

								    break;
						    }
					    }
					    ?>
                    </div>
                    <?if (count($arResult['USLUGI'])>0) {?>
                    <div class="product-item-detail-info-section" id="uslugi_block">
                        <div class="dop_uslugi_caption">
                            дополнительные услуги:
                        </div>
                        <ul class="uslugi">
	                        <? foreach ($arResult['USLUGI'] as $usluga)
	                        { ?>
                                <?if($usluga['PER_PRICE']>0){?>
                                <li data-id="<?= $usluga['ID'] ?>"
                                    data-per='<?=$usluga['PER_PRICE']?>'
                                    data-price="<? if (!$haveOffers) echo $price['BASE_PRICE'] * $usluga['PER_PRICE'] / 100 ?>"
                                    <? if (strpos ($usluga['NAME'], 'Сборка') > 0){?>data-sborka ='y'<?}?>
                                class="usluga_item_percent">
                                    <?= $usluga['NAME'] ?>:
                                    <span id="usl_<?=$usluga['ID']?>">
                                        <?if(!$haveOffers){?><?=$price['BASE_PRICE']*$usluga['PER_PRICE']/100
                                            ?> руб.<?}?>
                                    </span>
                                </li>
                                <?}
                                ?>
                                <?if ($usluga['PER_PRICE'] == 0){?>
		                       <li data-id="<?= $usluga['ID'] ?>"
								   <? if (strpos ($usluga['NAME'], 'Сборка') >= 0)
								   { ?>data-sborka='y'<? } ?>
                                   class="usluga_item">
                                   <?=
                               $usluga['NAME']
                                   ?>:
                                   <span><?= $usluga['PRICE'] ?> руб.</span></li>
                                <?}?>
		                        <?
	                        } ?>
                        </ul>

                        <!-- /.dop_uslugi -->
                    </div>
                    <!-- /.product-item-detail-info-section -->
                    <?}?>
                </div>
                <div class="col-sm-12 button_block">
	            <? if ((!$haveOffers)): ?>
                    <?if (($price['PRICE'] > 0)&& ($arResult['PRODUCT']['QUANTITY']>0)):?>
                    <div id="buy_block">
                    <!-- /#buy_block -->
                    <a href="/" class="cart_button">
                        <img src="<?=$templateFolder?>/images/sh_cart_w.png"> В корзину
                    </a>
                    <a href="/" class="one_click">
                    Купить в 1 клик
                    </a>
                   
                    <a href="" class="credit">
                    Купить в кредит
                    </a>
                    
                    </div>
                    <div class="clearfix"></div>
                    <?else:?>
                    <div id="pre_block">
                    <a href="/" class="pre_order">
                    Оставить запрос
                    </a>
                    </div>
                    <?endif;?>
                    <?endif;?>

        <?if($haveOffers):?>
            <div id="buy_block">
                <!-- /#buy_block -->
                <a href="/" class="cart_button">
                    <img src="<?= $templateFolder ?>/images/sh_cart_w.png"> В корзину
                </a>
                <a href="/" class="one_click">
                    Купить в 1 клик
                </a>
                <div class="clearfix"></div>
                <a href="" class="credit">
                    Купить в кредит
                </a>
            </div>
                <div id="pre_block">
                    <a href="/" class="pre_order">
                        Оставить запрос
                    </a>
                </div>
        <?endif;?>
                </div>
                <!-- /.col-sm-12 -->
                <div class="col-sm-12">
                    <div class="desc_caption">ОПИСАНИЕ ТОВАРА</div>
                    <?if(count($arResult['SERT'])>0){?>
                        <div>
	                        <? $i=0;
                            foreach ($arResult['SERT'] as $img)
	                        { ?>
                                <a class="sert" href="<?= $img ?>" <?if($i==0) echo 'id="sert"'?>">
                                    Сертификаты товара
                                </a>
	                        <?
	                        $i++;} ?>
                        </div>
                        <!-- /.sert -->
                        <?}?>
                    <div id="chertej">
	                    <? if (count ($arResult['CHERT']) > 0)
	                    { ?>

			                    <?
			                    foreach ($arResult['CHERT'] as $img)
			                    { ?>
                                    <a class="chert" href="<?= $img ?>">
                                    Габаритный чертеж
                                    </a>
				                    <?
			                    } ?>
	                    <? } ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- /.clearflost -->
                    <div id="desc"
                         <?if ($haveOffers) {?>
                         data-offerid="<?=$arResult['OFFERS_SELECTED']?>"
                         data-offername="<?=$arResult['JS_OFFERS'][$arResult['OFFERS_SELECTED']]['NAME']?>"
                         <?}?>
                            <? if (!$haveOffers) {?>
                                data-offerid="<?= $arResult['ID'] ?>"
                                data-offername="<?= $arResult['NAME'] ?>"
                           <? }?>
                    >
                    <? if ($haveOffers && !empty($arResult['JS_OFFERS'][$arResult['OFFERS_SELECTED']]['TEXT'])){
                    echo $arResult['JS_OFFERS'][$arResult['OFFERS_SELECTED']]['TEXT'];
                    }
                    else {
                        echo $arResult['DETAIL_TEXT'];
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.bx-detail-element -->
	<?
	if ($haveOffers)
	{
		foreach ($arResult['JS_OFFERS'] as $offer)
		{
			$currentOffersList = array();

			foreach ($offer['TREE'] as $propName => $skuId)
			{
				$propId = (int)substr($propName, 5);

				foreach ($skuProps as $prop)
				{
					if ($prop['ID'] == $propId)
					{
						foreach ($prop['VALUES'] as $propId => $propValue)
						{
							if ($propId == $skuId)
							{
								$currentOffersList[] = $propValue['NAME'];
								break;
							}
						}
					}
				}
			}

			$offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
			?>
			<?
		}

		unset($offerPrice, $currentOffersList);
	}
	else
	{
		?>
		<?
	}
	?>

<?
if ($haveOffers)
{
	$offerIds = array();
	$offerCodes = array();

	foreach ($arResult['JS_OFFERS'] as &$jsOffer)
	{
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($jsOffer['DISPLAY_PROPERTIES']))
			{
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
				{
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
					{
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
		{
			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
			{
				if ($range['HASH'] !== 'ZERO-INF')
				{
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
					{
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
						{
							break;
						}
					}

					if ($itemPrice)
					{
						$strPriceRanges .= '<dt>'.Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_FROM',
								array('#FROM#' => $range['SORT_FROM'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
							).' ';

						if (is_infinite($range['SORT_TO']))
						{
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						}
						else
						{
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
							);
						}

						$strPriceRanges .= '</dt><dd>'.$itemPrice['PRINT_PRICE'].'</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH'],
            'DETAIL_TEXT'=>$arResult['DETAIL_TEXT']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
	{
		?>
		<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
			<?
			if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
				{
					?>
					<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
					<?
					unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
				?>
				<table>
					<?
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
					{
						?>
						<tr>
							<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
							<td>
								<?
								if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
								)
								{
									foreach ($propInfo['VALUES'] as $valueId => $value)
									{
										?>
										<label>
											<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
												value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
											<?=$value?>
										</label>
										<br>
										<?
									}
								}
								else
								{
									?>
									<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
										<?
										foreach ($propInfo['VALUES'] as $valueId => $value)
										{
											?>
											<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
												<?=$value?>
											</option>
											<?
										}
										?>
									</select>
									<?
								}
								?>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				<?
			}
			?>
		</div>
		<?
	}

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
            'DETAIL_TEXT'=> $arResult['DETAIL_TEXT'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
}

?>
<noindex>
    <div id="credit_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3>Покупка товара в кредит</h3>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
                    <p>Уважаемые клиенты, Вы можете оформить online-кредит на заказы общей стоимостью <b>от 3000
                            руб.</b></p>

                    <p>Теперь Вам не нужно приезжать в офис, достаточно оформить заказ на сайте и заполнить online-анкету. После получения положительного решения от банка о выдаче кредита, заполнить остальные подготовленные для Вас документы и забрать свой заказ.</p>

                    <p><b>Заявку на online-кредит можно заполнить при оформлении заказа в корзине</b></p>
                    <p>
                     <iframe width="550" height="305" src="https://www.youtube.com/embed/-ZRSMYqM3I8?showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </p>
                </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">закрыть</button>
                </div>
            </div>
        </div>
    </div>
</noindex>
    <noindex>
        <div id="one_click_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3>Купить в 1 клик</h3>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body" id="one_button_form_result_mess">
                        <form  id="one_button_form">
                            <div class="zakaz">
                            </div>
                            <!-- /.zakaz -->
                            <input type="text" name="user_name" value="" id="user_name" placeholder="Ваше имя" required>
                            <input type="phone" name="user_phone" value="" id="user_phone" class='user_phone' placeholder="Телефон" required>
                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button class="btn btn-default" type="submit" id="one_form_send">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </noindex>
    <noindex>
        <div id="pre_order_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3>Запрос цены</h3>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body" id="pre_order_form_result_mess">
                        <form id="pre_order_form">
                            <div class="zakaz">
                            </div>
                            <!-- /.zakaz -->
                            <input type="text" name="user_name" value="" id="user_name" placeholder="Ваше имя" required>
                            <input type="phone" name="user_phone" value="" id="user_phone" class='user_phone' placeholder="Телефон" required>
                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button class="btn btn-default" type="submit" id="pre_order_modal_send">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </noindex>

<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=SITE_ID?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?
unset($actualItem, $itemIds, $jsParams);
//dump($arResult ['JS_OFFERS']);
