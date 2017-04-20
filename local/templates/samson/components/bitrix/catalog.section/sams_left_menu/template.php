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
<? $page_url = $APPLICATION->GetCurPage () ?>
<div class="inner">
    <ul>
	    <? foreach ($arResult['ITEMS'] as $item)
	    { ?>
            <li <? echo ($page_url == $item['DETAIL_PAGE_URL']) ? 'class="active_m"' : '' ?>><a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a></li>
	    <? } ?>
    </ul>
</div>

