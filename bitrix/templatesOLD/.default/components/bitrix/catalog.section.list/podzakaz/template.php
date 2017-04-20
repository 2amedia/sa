<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script>
	$(function(){		
		var html = "";
		$('.contentbl .nc_list.nc_text .img_s').each(function(){
			html = html + "<br/><a class='linkswithoutmarker' href='" + $(this).find('a').attr('href') + "'>" + $(this).find('div').html() + "</a>";
		});
		$('.grayforwintergoods').replaceWith('<div class="grayforwintergoods"><div class="rumb"><a href="/Netshop/zima/"><b>Зимние игровые деревянные горки</b></a><div class="hr"></div></div><div class="items"><a href="/Netshop/zima/green/greenland.html">Горка "Гренландия"</a><br><a href="/Netshop/zima/island/island.html">Горка "Исландия"</a><br><a href="/Netshop/zima/yamal/yamal_el.html">Горка "Ямал"</a><br><a href="/Netshop/zima/Ural/Ural.html">Горка "Урал"</a><br><span>Под заказ</span>' + html + '</div></div>');	
	});
</script>

<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):
	
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
?>
	<div class="img_s">
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
		<a href="/Netshop/zima/podzakaz/<?=$arSection["CODE"]?><?=$url?>.html">
		<img style="width: auto; height: 110px;" alt="" src="<?=$arSection['PICTURE']['src']?>">
		<div><?=$arSection["NAME"]?></div>
		</a>
	</div>
<?endforeach?>
