<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arActivityDescription = array(
	"NAME" => GetMessage("BPTA2_DESCR_NAME"),
	"DESCRIPTION" => GetMessage("BPTA2_DESCR_DESCR"),
	"TYPE" => "activity",
	"CLASS" => "Task2Activity",
	"JSCLASS" => "BizProcActivity",
	"CATEGORY" => array(
		"ID" => "interaction",
	),
);
?>