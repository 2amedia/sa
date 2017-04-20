<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID"))
	return;

if (!defined("WIZARD_SITE_DIR"))
	return;

$path = str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"); 
$siteFolder = str_replace(array("\\", "///", "//"), "/", WIZARD_SITE_DIR.$wizard->GetVar("siteFolder")."/");

$handle = @opendir($path);
if ($handle)
{
	while ($file = readdir($handle))
	{
		if (in_array($file, array(".", "..")))
			continue; 
		CopyDirFiles(
			$path.$file,
			$_SERVER["DOCUMENT_ROOT"].$siteFolder.$file,
			$rewrite = true, 
			$recursive = true,
			$delete_after_copy = false
		);
	}
}

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);
$siteName = htmlspecialchars($wizard->GetVar("siteName"));
WizardServices::ReplaceMacrosRecursive($_SERVER["DOCUMENT_ROOT"].$siteFolder, Array("SITE_DIR" => $siteFolder));
WizardServices::ReplaceMacrosRecursive($_SERVER["DOCUMENT_ROOT"].$siteFolder."about/", Array("SALE_EMAIL" => $wizard->GetVar("shopEmail")));
WizardServices::ReplaceMacrosRecursive($_SERVER["DOCUMENT_ROOT"].$siteFolder."delivery/", Array("SALE_EMAIL" => $wizard->GetVar("shopEmail")));
WizardServices::ReplaceMacrosRecursive($_SERVER["DOCUMENT_ROOT"].$siteFolder, Array("SALE_PHONE" => $wizard->GetVar("siteTelephone")));
WizardServices::ReplaceMacrosRecursive($_SERVER["DOCUMENT_ROOT"].$siteFolder, Array("SITE_NAME" => htmlspecialchars($wizard->GetVar("siteName"))));


$arUrlRewrite = array(); 
if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
{
	include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
}

$arNewUrlRewrite = array(
	array(
		"CONDITION"	=>	"#^".$siteFolder."news/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	 $siteFolder."news/index.php",
		), 

	); 	
	
$arNewUrlRewrite[] =
	array(
		"CONDITION"	=>	"#^".$siteFolder."personal/order/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:sale.personal.order",
		"PATH"	=>	 $siteFolder."personal/order/index.php",
		);

CModule::IncludeModule("iblock");
$iblockCode = "furniture_news_".WIZARD_SITE_ID; 
$iblockType = "news"; 

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
if ($arIBlock = $rsIBlock->Fetch())
{
	WizardServices::ReplaceMacrosRecursive($_SERVER["DOCUMENT_ROOT"].$siteFolder."news/", Array("IBLOCK_ID" => $arIBlock["ID"]));
}

//$iblockCode = "furniture_".WIZARD_SITE_ID; 
$iblockType = "catalog"; 

$rsIBlock = CIBlock::GetList(array(), array("TYPE" => $iblockType, 'LID' => WIZARD_SITE_ID));
while ($arIBlock = $rsIBlock->Fetch())
{

	$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arIBlock["ID"]));
	$p = 0;
	$strProps = "";
	while ($prop_fields = $properties->Fetch())
	{
		if( $prop_fields["CODE"] != 'MINIMUM_PRICE' && $prop_fields["CODE"] != 'MAXIMUM_PRICE')
		{
			$strProps .= $p." => \"".$prop_fields["CODE"]."\", \r\n";
			$p++; 
		}
	}
	
	CModule::IncludeModule("catalog");
	$arCatalog = CCatalog::GetByIDExt($arIBlock["ID"]); 
	if (is_array($arCatalog) && (in_array($arCatalog['CATALOG_TYPE'],array('P','X'))) == true) 
	{
		$rsoffers = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCatalog['OFFERS_IBLOCK_ID']));
		$p = 0;
		$stroOffers = "";
		while ($offers_fields = $rsoffers->Fetch())
		{
			if( $offers_fields["CODE"] != 'CML2_LINK' )
			{
				$strOffers .= $p." => \"".$offers_fields["CODE"]."\", \r\n";
				$p++; 
			}
		}
	}
	
	if(!empty($arIBlock["CODE"])){
		$path_from = $_SERVER['DOCUMENT_ROOT'].$wizard->GetPath().'/site/public/'.LANGUAGE_ID.'/catalog/furniture';
		$path_to = $_SERVER['DOCUMENT_ROOT'].$siteFolder.'catalog/'.$arIBlock["CODE"];
		
		CheckDirPath($path_to.'/');
		
		$arFiles = array('index.php', '.section.php');
		echo $path_to;
		foreach ($arFiles as $file)
		{
			copy($path_from.'/'.$file, $path_to.'/'.$file);
	
			CWizardUtil::ReplaceMacros(
				$path_to.'/'.$file, 
				array(
					"IBLOCK_ID" => $arIBlock["ID"],
					"IBLOCK_NAME" => addslashes($arIBlock['NAME']),
					"IBLOCK_CODE" => $arIBlock["CODE"], 
					"SITE_DIR" => $siteFolder,
					"PROPS_DETAIL" => $strProps,
					"OFFERS" => $strOffers,
				)
			);
		}
	}
	
	$arNewUrlRewrite[] =
	array(
		"CONDITION"	=>	"#^".$siteFolder."catalog/".$arIBlock["CODE"]."/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	 $siteFolder."catalog/".$arIBlock["CODE"]."/index.php",
		);
}


foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite))
	{
		CUrlRewriter::Add($arUrl);
	}
}


$ff = CFile::GetByID($wizard->GetVar("siteLogo"));	
if($zr = $ff->Fetch())
{
	$strOldFile = str_replace("//", "/", WIZARD_SITE_ROOT_PATH."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$zr["SUBDIR"]."/".$zr["FILE_NAME"]);
	@copy($strOldFile, $_SERVER["DOCUMENT_ROOT"].$siteFolder."images/logo.jpg");
	CFile::Delete($siteLogo);
}


COption::SetOptionString("store", "siteMobileFolder", $wizard->GetVar("siteFolder"), false, $siteID);
COption::SetOptionString("store.mobile", "wizard_installed", "Y", false, WIZARD_SITE_ID);

?>