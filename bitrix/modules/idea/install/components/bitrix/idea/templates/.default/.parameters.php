<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("blog") || !CModule::IncludeModule("iblock"))
	return false;

//groups
$arGroups = array();
$oRes = CGroup::GetList ($by = "name", $order = "asc"); 
while($arRes = $oRes->Fetch())
        $arGroups[$arRes["ID"]] = $arRes["NAME"];

//Ib
$arIb = array();
$oRes = CIblock::GetList(
        array(), 
        array('ACTIVE'=>'Y')
);
while($arRes = $oRes->Fetch())
        $arIb[$arRes["ID"]] = '('.$arRes["IBLOCK_TYPE_ID"].') '.$arRes["NAME"];

//Def Status
$arUFStatus = array();
$arUF = CUserTypeEntity::GetList(array(),array("FIELD_NAME" => "UF_STATUS"))->Fetch();
if($arUF)
{   
       $arUF_ENUM = CUserFieldEnum::GetList(array("SORT"=>"ASC"), array("USER_FIELD_ID" => $arUF["ID"]));
       while($r = $arUF_ENUM->Fetch())
            $arUFStatus[$r["ID"]] = $r["VALUE"];
}

$arTemplateParameters = array(
	"BLOG_URL"=>array(
		"NAME" => GetMessage("ONE_BLOG_BLOG_URL"),
		"TYPE" => "STRING",
		"DEFAULT" => "",	
		"PARENT" => "BASE",
	),
	"NAME_TEMPLATE" => array(
		"TYPE" => "LIST",
		"NAME" => GetMessage("BC_NAME_TEMPLATE"),
		"VALUES" => CComponentUtil::GetDefaultNameTemplates(),
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => GetMessage("BC_NAME_TEMPLATE_DEFAULT"),
	),
	"SHOW_LOGIN" => Array(
		"NAME" => GetMessage("BC_SHOW_LOGIN"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"Y",
	),			
        //EXT
	"IBLOCK_CATOGORIES" => array(
		"TYPE" => "LIST",
		"NAME" => GetMessage("BC_POST_IBLOCK_CATOGORIES"),
		"VALUES" => $arIb,
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	),
	"POST_BIND_USER" => array(
		"TYPE" => "LIST",
		"NAME" => GetMessage("BC_POST_BIND_USER"),
		"VALUES" => $arGroups,
		"MULTIPLE" => "Y",
		"DEFAULT" => "",
	),
	"POST_BIND_STATUS_DEFAULT" => array(
		"TYPE" => "LIST",
		"NAME" => GetMessage("IDEA_PARAM_POST_BIND_STATUS_DEFAULT"),
		"VALUES" => $arUFStatus,
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	),
);
?>