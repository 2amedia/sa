<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["SECTIONS"] as &$arSection)
	$arSection['PICTURE'] = CFile::ResizeImageGet($arSection['PICTURE']['ID'], array('width' => 132, 'height' => 110), BX_RESIZE_IMAGE_EXACT);
?>