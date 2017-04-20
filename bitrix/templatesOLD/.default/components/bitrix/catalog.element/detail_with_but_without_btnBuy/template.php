<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="navigate"><span><?=$arResult["NAME"]?></span></div>
<table>
<tbody><tr><td valign="top" style="padding-bottom:200px">
<?if($arResult["MORE_PHOTO"][0]):?>
	<?$big=$arResult["MORE_PHOTO"][0]["SRC"];?>
<?else:?>
	<?$big=$arResult["DETAIL_PICTURE"]["SRC"];?>
<?endif?>
<a rel="lightbox[1]" href="<?=$big?>" title="<?=$arResult["NAME"]?>" class="lightbox-enabled">
<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>"></a>


<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
<div style="margin-top:28px;">Цена: <span style="color:#e13626;font-size:14px;"><?if($arPrice["VALUE"]):?><s></s> <b><font size="+1"><?=$arPrice["VALUE"]?> руб</font></b><?else:?>по запросу<?endif?></span></div>
<?endforeach;?>


<?
		$arSelect = Array("ID", "NAME", "CODE", "IBLOCK_SECTION_ID", "CATALOG_GROUP_1");
		$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "SECTION_ID"=>$arResult["IBLOCK_SECTION_ID"], "!ID"=>$arResult["ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
		
		if($res->SelectedRowsCount() > 0) {
		?>
			<div style="text-align:left">
			<br><br><b style="color:#ca4c9b">Варианты товара</b><br>
			<table width="100%" style="border-collapse:collapse; clear:both;">
			  <tbody>
				<?  
				while($ob = $res->GetNextElement())
				{
				  $arFields = $ob->GetFields();
				  $sres = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
				  $parent = $sres->GetNext();
				  $mres = CIBlockSection::GetByID($parent["IBLOCK_SECTION_ID"]);
				  $main = $mres->GetNext();
				  //var_dump($arFields);
				  ?>
				  <tr>
				  <td width="60%" height="15" style="padding:5px" nowrap="">
				   <a href="/Netshop/<?=$main["CODE"]?>/<?=$parent["CODE"]?>/<?=$arFields["CODE"]?>.html"><?=$arFields["NAME"]?></a>
				  </td>
				  <td class="cellforprice" width="15%" align="right" nowrap="" style="padding:5px;color:#e13626;font-weight:bold"> 
				    <?if(intval($arFields["CATALOG_PRICE_1"])):?><?=intval($arFields["CATALOG_PRICE_1"])?>&nbsp;руб.<?endif?>
				  </td>
				  <td>&nbsp;</td>
				  <td align="right" width="1%" nowrap="">    
				  </td>
				</tr>
				 <?
				}?>
			  </tbody>
			</table>
			</div>
		<?
		}
?>
  


  
</td>
<td style="padding-left:30px;padding-bottom:200px">
<?=$arResult["DETAIL_TEXT"]?>
</td>
</tr>


</tbody></table>
<div style="clear:both"></div>






