<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["SECTIONS"] as &$arItem)
	$arItem['PICTURE'] = CFile::ResizeImageGet($arItem['PICTURE']['ID'], array('width' => 132, 'height' => 110), BX_RESIZE_IMAGE_EXACT);
?>