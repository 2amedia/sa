<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="navigate">
	
	<p class="line_for_breadcrumbs">
			<span><a href="/">Главная</a></span>
			<span> -> </span>
			<span>Галерея Ждем Ваши фотографии</span>
		</p>
	
	<span>Приглашаем Вас стать участником нашей галереи! Присылайте фотографии на почту:  info@samson.bz</span></div>


<div class="nc_list nc_photogallery">
	<table class="nc_table"><colgroup><col width="33%"><col width="33%"><col width="33%">
		</colgroup>
		<tbody>

<?$cell=0;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
		<?if($cell%3 == 0):?>
		<tr>
		<?endif;?>

		<td class="nc_row">
			<h3><?=$arItem["NAME"]?></h3>
			<a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" rel="lightbox[2]"><img class="nc_row_img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>"></a>
			
		</td>
		
		<?$cell++;
		if($cell%3 == 0):?>
			</tr>
		<?endif?>
<?endforeach;?>

		<?if($cell%3 != 0):?>
			<?while(($cell++)%3 != 0):?>
				<td>&nbsp;</td>
			<?endwhile;?>
			</tr>
		<?endif?>
		</tbody>
		</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>		
</div>

