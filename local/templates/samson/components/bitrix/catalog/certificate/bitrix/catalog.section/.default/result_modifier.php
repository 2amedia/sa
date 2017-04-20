<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as &$arItem)
{
	$arItem['BIG_PICTURE'] = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']['ID'], array('width' => 800, 'height' => 600));
	$arItem['SMALL_PICTURE'] = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']['ID'], array('width' => 190, 'height' => 200), BX_RESIZE_IMAGE_EXACT);
}
?>