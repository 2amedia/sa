<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//    $sChainProlog - HTML код выводимый перед навигационной цепочкой?//
//    $sChainBody - HTML код определяющий внешний вид одного пункта навигационной цепочки?
////    $sChainEpilog - HTML код выводимый после навигационной цепочки?
////    $strChain - HTML код всей навигационной цепочки собранный к моменту подключения шаблона??
////    $TITLE - заголовок очередного пункта навигационной цепочки?
////    $LINK - ссылка на очередном пункте навигационной цепочки?
////    $arCHAIN - копия массива элементов навигационной цепочки?
////    $arCHAIN_LINK - ссылка на массив элементов навигационной цепочки
//?//    $ITEM_COUNT - количество элементов массива навигационной цепочки?
////    $ITEM_INDEX - порядковый номер очередного пункта навигационной цепочки??
if ($ITEM_COUNT > 1) {
    $sChainProlog = '<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
    $sChainEpilog = '</ol>';
    if ($ITEM_INDEX < $ITEM_COUNT -1 )
        $sChainBody = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemprop="item" href="https://' . SITE_SERVER_NAME . $LINK . '">
            <span itemprop="name">' . htmlspecialcharsex($TITLE) . '</span>
        </a>
        <meta itemprop="position" content="' . $ITEM_INDEX . '" /></li>';
    elseif
    ($ITEM_INDEX == 0) $sChainBody = '<li><a href="https://' . SITE_SERVER_NAME . $LINK . '">Главная</a></li>';
else $sChainBody = '<li>' . htmlspecialcharsex($TITLE) . '</li>';
}
return $strChain;
