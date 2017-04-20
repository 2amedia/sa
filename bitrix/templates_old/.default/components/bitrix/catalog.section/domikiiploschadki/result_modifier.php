<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as &$arItem)
	$arItem['PICTURE'] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width' => 136, 'height' => 114), BX_RESIZE_IMAGE_EXACT);
?>