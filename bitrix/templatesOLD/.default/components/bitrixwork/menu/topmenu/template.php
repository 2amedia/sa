<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table class="upmenu" id="nt" style="float:left;">
	<tbody>
	<tr>
	
<?if (!empty($arResult)):?>
<?$i=0;?>
<?foreach($arResult as $arItem):?>
		<?//var_dump($arItem);?>
		<td nowrap="" <?=($i == 1 || $i == 3 ? "class='akcii'" : "")?>>
			<a <?if(!$arItem["SELECTED"]):?>href="<?=$arItem["LINK"]?>"<?endif?>><span><?=$arItem["TEXT"]?></span></a>
		</td>
	<?$i++;?>
<?endforeach?>

	</tr>
	</tbody>
</table>

<?endif?>