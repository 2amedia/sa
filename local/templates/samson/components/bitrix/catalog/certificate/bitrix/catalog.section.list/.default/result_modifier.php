<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["SECTIONS"] as &$arItem)
	$arItem['PICTURE'] = CFile::ResizeImageGet($arItem['PICTURE']['ID'], array('width' => 190, 'height' => 240), BX_RESIZE_IMAGE_EXACT);
?>