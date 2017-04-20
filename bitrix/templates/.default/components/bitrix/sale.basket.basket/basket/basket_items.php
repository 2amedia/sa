<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?echo ShowError($arResult["ERROR_MESSAGE"]);?>
<table class="gt">
	<tbody>
		<tr>
			<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
				<th class="name"><?= GetMessage("SALE_NAME")?></th>
			<?endif;?>
			<?if (in_array("PROPS", $arParams["COLUMNS_LIST"])):?>
				<th><?= GetMessage("SALE_PROPS")?></th>
			<?endif;?>
			<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
				<th><?= GetMessage("SALE_PRICE")?></th>
			<?endif;?>

			<?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
				<th><?= GetMessage("SALE_QUANTITY")?></th>
			<?endif;?>
				<th>Стоимость</th>
			<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
				<th><?= GetMessage("SALE_DELETE")?></th>
			<?endif;?>
		</tr>
		<?
		$i=0;
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
		{
			?>
			<tr class="odd cart_contents_table">
				<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
					<td><b><?=$arBasketItems["NAME"] ?></b></td>
				<?endif;?>
				<?if (in_array("PROPS", $arParams["COLUMNS_LIST"])):?>
					<td>
						<?
						foreach($arBasketItems["PROPS"] as $val)
						{
							echo $val["NAME"].": ".$val["VALUE"]."<br />";
						}
						?>
					</td>
				<?endif;?>
				<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
					<td align="center"><?=$arBasketItems["PRICE_FORMATED"]?></td>
				<?endif;?>

				<?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
					<td class="qty" align="center"><input maxlength="18" type="text" name="QUANTITY_<?=$arBasketItems["ID"] ?>" value="<?=$arBasketItems["QUANTITY"]?>" size="3" ></td>
				<?endif;?>
					<td align="center"><?=CurrencyFormat($arBasketItems["PRICE"]*$arBasketItems["QUANTITY"], "RUB")?></td>
				<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
					<td align="center"><input type="checkbox" name="DELETE_<?=$arBasketItems["ID"] ?>" id="DELETE_<?=$i?>" value="Y"></td>
				<?endif;?>
			</tr>
			<?
			$i++;
		}
		?>
		<script>
			function sale_check_all(val)
			{
				for(i=0;i<=<?=count($arResult["ITEMS"]["AnDelCanBuy"])-1?>;i++)
				{
					if(val)
						document.getElementById('DELETE_'+i).checked = true;
					else
						document.getElementById('DELETE_'+i).checked = false;
				}
			}
		</script>
		<tr class="odd cart_contents_table">
			<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
				<td align="right" nowrap>
					<?if ($arParams['PRICE_VAT_SHOW_VALUE'] == 'Y'):?>
						<b><?echo GetMessage('SALE_VAT_INCLUDED')?></b><br />
					<?endif;?>
					<?
					if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
					{
						?><b><?echo GetMessage("SALE_CONTENT_DISCOUNT")?><?
						if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0)
							echo " (".$arResult["DISCOUNT_PERCENT_FORMATED"].")";?>:</b><br /><?
					}
					?>
					<b><?= GetMessage("SALE_ITOGO")?>:</b>
				</td>
			<?endif;?>
			<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
				<td align="right" nowrap>
					<?if ($arParams['PRICE_VAT_SHOW_VALUE'] == 'Y'):?>
						<?=$arResult["allVATSum_FORMATED"]?><br />
					<?endif;?>
					<?
					if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
					{
						echo $arResult["DISCOUNT_PRICE_FORMATED"]."<br />";
					}
					?>
					<?=$arResult["allSum_FORMATED"]?><br />
				</td>
			<?endif;?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td colspan="5" style="padding-top:17px">
				<div style="float:right">

                <input type="checkbox" id="chk1"/>
    <label for="chk1" >*Я прочел, и согласен с условиями <a target="_blank" href="http://1090983.ru/agree/">Соглашения</a>.</label> 
    
    </div>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="padding-top:17px">
				<div class="cart_buttons">
					<table width="100%">
						<tbody>
							<tr>
								<td style="text-align:left;">
									<div class="but_l">&nbsp;</div>
									<div class="but"><a href="/" target="_top">&#8592; Продолжить покупки</a></div>
									<div class="but_r">&nbsp;</div>
								</td>
								<td style="text-align:center;">
									<div class="but_l">&nbsp;</div>
									<div class="but"><a href="javascript:void(0)" onclick="$('#SALE_REFRESH').click();">Пересчитать корзину &#8594;</a></div>
									<div class="but_r">&nbsp;</div>
								</td>
                                
								<td  style="text-align:right;">
									<?if ($arResult['allSum'] >= 5000):?>
										<div id="butcont" class="disabled" >
                                        <div class="but_l">&nbsp;</div>
                                        <div   class="but"><a  href="javascript:void(0)" onclick="$('#SALE_ORDER').click();">
                                        Продолжить	&#8594;</a></div>
                                        <div class="but_r">&nbsp;</div>
                                        </div>
									<?else:?>
										Минимальная сумма заказа - 5 000 руб.
									<?endif?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<input type="submit" id="SALE_REFRESH" value="<?echo GetMessage("SALE_REFRESH")?>" name="BasketRefresh" style="display: none;">
<input type="submit" id="SALE_ORDER" value="<?echo GetMessage("SALE_ORDER")?>" name="BasketOrder"	id="basketOrderButton2" style="display: none;">
<script type="text/javascript">
$('#chk1').change(function(){
  if($(this).prop("checked")) {
    $('#butcont').addClass('enabled');
  } else {
    $('#butcont').removeClass('enabled'); 
	$('#butcont').addClass('disabled');
  }
});


</script>
