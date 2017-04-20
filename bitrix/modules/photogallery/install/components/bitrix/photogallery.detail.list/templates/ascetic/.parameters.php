<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arTemplateParameters = array(
	"THUMBS_SIZE" => array(
		"NAME" => GetMessage("P_THUMBS_SIZE"),
		"TYPE" => "STRING",
		"DEFAULT" => "120"),
	"SHOW_PAGE_NAVIGATION" => array(
		"NAME" => GetMessage("P_SHOW_PAGE_NAVIGATION"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"none" => GetMessage("P_SHOW_PAGE_NAVIGATION_NONE"),
			"top" => GetMessage("P_SHOW_PAGE_NAVIGATION_TOP"),
			"bottom" => GetMessage("P_SHOW_PAGE_NAVIGATION_BOTTOM"),
			"both" => GetMessage("P_SHOW_PAGE_NAVIGATION_BOTH")),
		"DEFAULT" => "bottom"),
	"SQUARE" => array(
		"NAME" => GetMessage("P_SQUARE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N"),
	"PERCENT" => array(
		"NAME" => GetMessage("P_SQUARE_PERCENT"),
		"TYPE" => "STRING",
		"DEFAULT" => "70"),
);
?>