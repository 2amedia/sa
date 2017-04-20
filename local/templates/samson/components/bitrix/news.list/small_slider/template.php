<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
    <div id="owl-carousel-inner">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="item">
                <? if ($arItem["PROPERTIES"]["LINK"]["VALUE"]): ?><a id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                                                                     href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>"><? endif ?>
                    <img data-src="<?= $arItem["DETAIL_PICTURE"]["SRC"] ?>" class="lazyOwl">
                    <? if ($arItem["PROPERTIES"]["LINK"]["VALUE"]): ?></a><? endif ?>
            </div>
        <? endforeach; ?>
</div>