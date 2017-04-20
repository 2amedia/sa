<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="items">
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):

	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
?>
		<?
		$arSelect = Array("ID", "NAME", "CODE");
		$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arSection["ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		while($ob = $res->GetNextElement())
		{
		  $arFields = $ob->GetFields();
		  //var_dump($arFields);
		  $url=$arFields["CODE"];
		  break;
		}
		?>
		<? $put=$APPLICATION->sDirPath;?>
		<?$pieces = explode("/", $put);?>
		<? $url2='/'.$pieces[1].'/'.$pieces[2].'/'.$arSection["CODE"].'/'.$url.'.html';?>

		<?if($_SERVER['REQUEST_URI']==$url2){?>
			<span><?=$arSection["NAME"]?></span>
		<?}else{?>
			<a href="/<?=$pieces[1];?>/<?=$pieces[2];?>/<?=$arSection["CODE"]?>/<?=$url?>.html" style="display:block;">
				<?=$arSection["NAME"]?>
			</a>
		<?}?>

<?endforeach?>
</div>
