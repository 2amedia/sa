<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="cart-small">
	<?if ($arResult["READY"] == "Y"):?>
		<a href="/personal/basket/" target="_self"><img src="/images/korz-orig.jpg">Ваша корзина [<?=$arResult['QUANTITY']?>]</a>
		<div class="cart-popup-wrapper<?if ($arParams['SHOW_CART'] == 'Y'):?> js-active<?endif?>">
			<div class="cart-popup">
				<a href="" onclick="closeCart();return false;" class="cart-popup-close" title="Скрыть">x</a>
				<table>
					<thead>
						<tr>
							<th width="180"><a target="_self" href="/personal/basket/">В вашей корзине</a></th>
							<th width="20">Кол-во</th>
							<th width="30">Цена</th>
						</tr>
					</thead>
				</table>
				<div class="cart-popup-items">
					<table>
						<tbody>
							<?foreach ($arResult['ITEMS'] as $arItem):?>
								<tr>
									<td width="65">
										<div class="cart-picture">
											<a href="javascript:void(0)" class="cart-delete" onclick="deleteCartItem(<?=$arItem['ID']?>)">
											<?if (isset($arResult['PICTURES'][$arItem['PRODUCT_ID']])):?>
												<a target="_blank" href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arResult['PICTURES'][$arItem['PRODUCT_ID']]['src']?>"></a>
											<?else:?>
												&nbsp;
											<?endif?>
										</div>
									</td>
									<td><a target="_blank" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></td>
									<td width="50" align="center"><div class="spinner"><a href="javascript:void(0)" class="dec" onclick="cartChange(<?=$arItem['ID']?>, 'dec')">-</a><input type="text" value="<?=intval($arItem['QUANTITY'])?>" onchange="updateCart()" id="cart-q-<?=$arItem['ID']?>"><a href="javascript:void(0)" class="inc" onclick="cartChange(<?=$arItem['ID']?>, 'inc')">+</a></div></td>
									<td width="70"><?=$arItem['PRICE_FORMATED']?></td>
								</tr>
							<?endforeach?>
						</tbody>
					</table>
				</div>
				<div class="cart-popup-footer">
					<b>Итого: <?=$arResult['PRICE_FORMATED']?></b>
					
						<a class="cart-small-order" target="_self" href="<?=$arParams['PATH_TO_ORDER']?>">Оформить заказ</a>
					
						
				</div>
			</div>
		</div>
	<?else:?>
		<img style="margin-right: 5px;
    vertical-align: middle;" src="/images/korz-orig.jpg"> Ваша корзина пуста
	<?endif;?>
</div>