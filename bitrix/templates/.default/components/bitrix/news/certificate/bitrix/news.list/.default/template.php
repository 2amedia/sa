<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="navigate">
<p class="line_for_breadcrumbs">
			<span><a href="/">Главная</a></span>
			<span> -> </span>
			<span>Сертификаты</span>
		</p>

<span>Сертификаты</span></div>

<table width="100%" class="table_for_certificaties">
<tbody>
<? $count = 0; ?>
<?foreach($arResult["ITEMS"] as $arItem):?>
		<? $count++; ?>
		<? if ($count == 0) { ?>
		<tr><td>
		<? } else { ?>
		<td>
		<? } ?>
		
		<div class="certificate-preview">
			<?echo $arItem["NAME"]?><br>
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PICTURE"]["src"]?>"></a><br> 
		</div>

		<? if ($count == 3) { $count = 0; ?>
		</td></tr>
		<? } else { ?>
		</td>
		<? } ?>	

<?endforeach;?>
</tbody>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
