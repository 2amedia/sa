<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="owl-main-wrap">
    <div id="owl-carousel-footer">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="item">
                <? if ($arItem["PROPERTIES"]["LINK"]["VALUE"]): ?><a id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                                                                     href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>"><? endif ?>
                    <img src="<?= $arItem["DETAIL_PICTURE"]["SRC"] ?>" class="adaptive-img">
                    <? if ($arItem["PROPERTIES"]["LINK"]["VALUE"]): ?></a><? endif ?>
            </div>
        <? endforeach; ?>
    </div>
</div>