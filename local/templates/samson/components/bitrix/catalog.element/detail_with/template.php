<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="row element">
	<div class="col-xs-5">
<!--		картинки-->
		<div class="tovar-images">
		<? $i=0;
		$push = true;
		foreach ($arResult['IMAGES'] as $img) {
			?>
			<? if ($i == 0) {
				?>
				<div class="col-xs-12 ">
					<a  href="<?= $img['big'] ?>" title="<?= $arResult["NAME"] ?>">
						<img src="<?= $img['small'] ?>" alt="<?= $arResult["NAME"] ?>" class="img-responsive img-center"></a>
				</div>
				<?
			} else {
				$push = false;
				?>
				<div class="col-xs-6"><div class="small">
					<a  title="<?= $arResult["NAME"] ?>" href="<?= $img['big'] ?>">
						<img src="<?= $img['small'] ?>">
					</a>
					</div>
				</div>
				<?
			}
			$i++;
		}?>
		</div>
<!--		варианты товаров-->
		<div class="col-xs-12">
		<?if ($arResult['VARIANTS']){?>
		<h4><span>Варианты товара</span></h4>
			<?foreach ($arResult['VARIANTS'] as $variant) {?>
				<div class="col-xs-8"><a href=" <?=$variant['url']?>">
						<?=$variant['name']?>
					</a></div>
				<div class="col-xs-4">
				 <span class="catalog-price"><?=$variant['price']?></span>
				</div>
				<?}?>
		<?}?>
		</div>
	</div>
	<div class="col-xs-7">
<!--		заголовок-->
		<div class="col-xs-8 contentnames">
			<span class="name_span" ><?=$arResult["SECTION"]['PATH'][0]['NAME'];?></span><br>
			<h1><?=$arResult["NAME"]?></h1>
					<span style="margin-bottom:0; color: #000;font-size: 12px;">Цена:</span>
			<?if ($arResult['PRICES']['roznica']['VALUE'] == 0):?>
				<span class="price">по запросу</span>
			<? else: {?>
				<? if ($arResult['PRICES']['roznica']['VALUE'] > $arResult['PRICES']['roznica']['DISCOUNT_VALUE']): ?>
                	<span class="price"><?= number_format($arResult['PRICES']['roznica']['DISCOUNT_VALUE'], 0, ',', ' ') . ' руб.' ?>
                    <a href="<?= $APPLICATION->GetCurPage() ?>?action=ADD2BASKET&id=<?= $arResult["ID"] ?>" class="add2cart" data-id="<?= $arResult['ID'] ?>">Купить</a></span>
					<span class="old-price"><?= number_format($arResult['PRICES']['roznica']['VALUE'], 0, ',', ' ') . ' руб.' ?></span>
					<span class="sale">СКИДКА <?= intval($arResult['SALE']) ?>%</span>
					
						
				<? else: ?>
					<span class="price"><?= number_format($arResult['PRICES']['roznica']['VALUE'], 0, ',', ' ') . ' руб.' ?>
						<a href="<?= $APPLICATION->GetCurPage() ?>?action=ADD2BASKET&id=<?= $arResult["ID"] ?>" class="add2cart" data-id="<?= $arResult['ID'] ?>">Купить</a></span>
				<? endif; ?>
			<?}?>
			<? endif; ?>
</div>

<!--		конец заголовка-->
<!--		история и модалки-->
		<div class="col-xs-4">
			<div  class="history">
				<span data-mfp-src="#test-popup" id="popup-btn" data-effect="mfp-zoom-in">
					<?if (CSite::InDir('/Netshop/derevostreet/')){?>Географическое название<?}?>
					<?if (CSite::InDir('/Netshop/sad/')){?>Это интересно!<?}?>
					<?if (CSite::InDir('/Netshop/choice/matlal/')){?>Спорт-это настроение!<?}?>
					<?if (CSite::InDir('/Netshop/choice/metalstreet/')){?> Спорт-это настроение!<?}?>
					<?if (CSite::InDir('/Netshop/zima/')){?>Географическое название<?}?>
					<?if (CSite::InDir('/Netshop/cube/')){?>Как используют КУБ?<?}?>
				</span>

				<div id="popup" class="white-popup mfp-hide">
					<div class="top-history-bg"></div>
					<div class="history-bg">
						<div class="history-content">
					<?if (CSite::InDir('/Netshop/derevostreet/')){?>
						<i>Много интересного на земном шаре! Путешествуйте с нами! Мы дали нашим детским деревянным игровым площадкам географические названия.</i>
					<?}?>
					<?if (CSite::InDir('/Netshop/choice/matlal/')){?>
						<i>Шведская стенка &mdash; гимнастический снаряд из вертикальных стоек с поперечными округлыми перекладинами (лестница). Изобретателем шведской стенки в её нынешнем виде стал в начале 19 века П. Линг. Подобные снаряды и упражнения с их использованием описывались ещё в 1793 году немецким педагогом И. Гутс-Мутс в его труде &laquo;Гимнастика для юношества&raquo;. В России этот товар выпускался под названием &ldquo;Детский спортивный комплекс (ДСК) “Юниор&rdquo; («Юниор», «Чемпион» и др.). НП предприятием «Калужский приборостроительный завод «Тайфун» с 1992 года.</i>
					<?}?>
					<?if (CSite::InDir('/Netshop/cube/')){?>
						<i>КУБ - открывает широкие возможности по созданию уникального индивидуального интерьера для Вас. </i>
					<?}?>
					<p><?=htmlspecialcharsBack($arResult["PROPERTIES"]["TEXT_HISTORYIMP"]["VALUE"]["TEXT"])?></p>
						</div>
					</div>
					</div>
				</div>
			</div>

<!--конец история и модалки-->

<div class="description ">
<div class="clearfix"></div>
	<?foreach ($arResult['BANNER'] as $banner) echo $banner?>
	<?=$arResult['DETAIL_TEXT']?>
</div>
</div>
	</div>
<div class="row"><div class="col-xs-12">
		<? if (count($arResult['BY_WHITH']) > 0) { ?>
			<h2 class="caption blue">С этим товаром покупают</h2>
			<div id="owl-carousel-whith">
				<? foreach ($arResult['BY_WHITH'] as $arItem) {?>
					<div class="item">
						<a href="<?= $arItem['url'] ?>">
							<img src="<?= $arItem['img'] ?>" alt="<?= $arItem['name'] ?>" class="adaptive-img">
							<span><?= $arItem['name'] ?></span>
						</a>
						<span>Цена: <span class="catalog-price"><?= $arItem['price'] ?></span></span>
					</div>
					</a>
				<? } ?>
			</div>
		<? } ?>
	</div>
</div>
