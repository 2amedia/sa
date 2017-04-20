<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as &$arItem)
{
	if (is_array($arItem['PREVIEW_PICTURE']))
		$arItem['PICTURE'] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 238));
}
?>