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
 */

$this->setFrameMode(true);?>

<!-- /.row -->
<div class="row">
    <div class="col-xs-12">
        <h1 class="name_sec"><?= $arResult['NAME'] ?></h1>
    </div>
    <!-- /.col-xs-12 -->
</div>
<?if(!empty($arResult['SUBSECTIONS'])){?>
<div class="row">
    <div class="col-xs-12">
        <div class="sorting">
            <?foreach ($arResult['SUBSECTIONS'] as $sorting){?>
               <div class="sort_item" data-id="<?= $sorting['ID'] ?>"><?= $sorting['NAME'] ?> <span class="close_im"></span>
               <!-- /.close --></div>
            <?}?>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- /.col-xs-12 -->
</div>
<!-- /.row -->
<?}?>
<div class="row" id="section_list" data-id="<?= $arResult['ID']?>">
<?foreach($arResult['ITEMS'] as $item) {?>
    <div class="col-xs-4">
        <div class="section_item">
        <a href="<?= $item['URL'] ?>">
            <div class="section_image" data-id="<?= $item['ID'] ?>"
                 <?if (!$item['SLIDER']):?>
                 style="background: url('<?= $item['PHOTO']['0'] ?>')"
            <?endif;?>
            ><? if ($item['SLIDER']) {?>
                <ul class="slider-container"
                     data-slider-interval="3000" id="slider_<?= $item['ID'] ?>">
	                <? $active = true ?>
                    <?foreach ($item['PHOTO'] as $value){?>
                        <li class="item">
                            <div style="background:url('<?= $value ?>')"></div>
                        </li>
                    <?}?>

                    <!-- /.proress -->
                </ul>
                    <div class="progress_bar"></div>
	            <?}?>
                <!-- /.slider -->
                <div class="labels">
	                <? if ($item['NEW']) echo '<span class="new"></span>' ?>
	                <? if ($item['ACTION']) echo '<span class="action"></span>' ?>
	                <? if ($item['DOST']) echo '<span class="dost"></span>' ?>
                </div>
                <!-- /.labels -->
            </div>
            <div class="section_name">
                <?= $item['NAME'] ?>
            </div>
            <?if($item['CAN_BY']){?>
                    <div class="price"><?= $item['PRICE']['DISCOUNT_VALUE'] ?></div>
                <?}else {?>
                <div class="price">по запросу</div>
            <? } ?>
	            <? if ($item['DISCOUNT'])
	            { ?>
                    <div class="old-price"><?= $item['PRICE']['VALUE'] ?></div>
                    <div class="skidka"><?= $item['PRICE']['DISCOUNT_DIFF_PERCENT'] ?> %</div>
	            <?
	            } ?>

        </a>
    </div>
    </div>
<?}?>
</div>
<?CJSCore::Init("fx");?>

