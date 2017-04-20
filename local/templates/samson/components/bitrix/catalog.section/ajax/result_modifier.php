<? if (!defined ('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
foreach ($arResult['ITEMS'] as $key=>$item)
{
	$photo = array();
	$haveOffers = !empty($item['OFFERS']);//есть ли торговые предложения
	$name = $item['NAME'];//имя
	$url = $item['DETAIL_PAGE_URL'];//урл
	if ($item['PROPERTIES']['NEW']['VALUE'] == 'Y') $new = true;//новинка
	if ($item['PROPERTIES']['ACTION']['VALUE'] == 'Y') $action = true;//акция
	if ($item['PROPERTIES']['DOST']['VALUE'] == 'Y') $dost = true;//доставка

	//простой товар
	if (!$haveOffers)
	{
		//собираем картинки
		$pic[0] = $item['PREVIEW_PICTURE'];
		$pic[1] = $item['DETAIL_PICTURE'];
		if (count($item['DISPLAY_PROPERTIES']['ADD_PHOTO_IN_DETAIL']['VALUE']) > 1) {
			$more_pic_detail = $item['DISPLAY_PROPERTIES']['ADD_PHOTO_IN_DETAIL']['FILE_VALUE'];
		}
		else $more_pic_detail[0] = $item['DISPLAY_PROPERTIES']['ADD_PHOTO_IN_DETAIL']['FILE_VALUE'];

		if (count ($item['DISPLAY_PROPERTIES']['MORE_PHOTO']['VALUE']) > 1)
		{
			$more = $item['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'];
		}
		else $more[0] = $item['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'];

		$photo = array_merge ($pic, $more_pic_detail,$more);
		$price = array(
			"VALUE" => number_format ($item['MIN_PRICE']['VALUE'], 0, ' ', ' ') . ' руб.',
			"DISCOUNT_VALUE" => number_format ($item['MIN_PRICE']['DISCOUNT_VALUE'], 0, ' ', ' ') . ' руб.',
			"DISCOUNT_DIFF_PERCENT" => $item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']
		);
		//определяем что есть скидка
		if ($item['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0) $discount = true;
		//определяем что есть цена больше 0
		if ($item['MIN_PRICE']['DISCOUNT_VALUE'] > 0) $can_by = true;
	}
//сложный товар
	if ($haveOffers)
	{
		foreach ($item['OFFERS'] as $offer)
		{
			//собираем картинки
			$pic[0] = $offer['PREVIEW_PICTURE'];
			$pic[1] = $offer['DETAIL_PICTURE'];


			if (count ($offer['DISPLAY_PROPERTIES']['SKU_DOP_PHOTO']['VALUE']) > 1)
			{
				$more_pic_detail = $offer['DISPLAY_PROPERTIES']['SKU_DOP_PHOTO']['FILE_VALUE'];
			}
			else $more_pic_detail[0] = $more_pic_detail = $offer['DISPLAY_PROPERTIES']['SKU_DOP_PHOTO']['FILE_VALUE'];


			$photo = array_merge_recursive ($more_pic_detail, $pic, $photo);
			//получаем цены
			$VALUES[] = intVal($offer['MIN_PRICE']['VALUE']);
			$DISCOUNT_VALUES[] = intVal($offer['MIN_PRICE']['DISCOUNT_VALUE']);
			$DISCOUNT_DIFF_PERCENTS[] = intVal($offer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']);
			//определяем что есть скидка
			if ($offer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] > 0) $discount = true;
			//определяем что есть цена больше 0
			if ($offer['MIN_PRICE']['DISCOUNT_VALUE'] > 0) $can_by = true;
		}

		//dump($VALUES);

		//оставлем только уникальные цены
		$VALUES = array_unique($VALUES);
		//dump ($VALUES);
		$DISCOUNT_VALUES = array_unique($DISCOUNT_VALUES);
		//убираем нахрен 0 из цены
		$VALUES = array_diff($VALUES, array('0'));
		//dump ($VALUES);
		$DISCOUNT_VALUES= array_diff ($DISCOUNT_VALUES, array('0'));
		// определяем сколько уникальных цен, если больше 1 то несколько цен и пишем 'от'
			if (count($VALUES)>1) {
				$value = 'от '.number_format (min ($VALUES), 0, ' ', ' ') . ' руб.';
				$dis_value = 'от ' . number_format (min ($DISCOUNT_VALUES), 0, ' ', ' ') . ' руб.';
			}
			else {
				$value = number_format (min ($VALUES), 0, ' ', ' ') . ' руб.';
				$dis_value = number_format (min ($VALUES), 0, ' ', ' ') . ' руб.';
			}
		$price = array(
			//минимальная полная цена
			"VALUE" => $value,
			//минимальная цена со скидкой
			"DISCOUNT_VALUE" => $dis_value ,
			//минимальный % скидки
			"DISCOUNT_DIFF_PERCENT" => min ($DISCOUNT_DIFF_PERCENTS)
		);

	}

	//убираем дубли фоток
	foreach ($photo as $value)
	{
		$key = $value['ORIGINAL_NAME'];
		$arPhoto[$key] = $value['ID'];
	}
	//нормализуем массив с фото
	foreach ($arPhoto as $photo)
	{
		$file_photo = CFile::GetFileArray($photo);
			if ($file_photo['WIDTH'] >300  || $file_photo['HEIGHT'] > 300)
			{
				$koef = $file_photo['WIDTH']/ $file_photo['HEIGHT'];

				if ($koef > 2)
				{
					$koef = $koef - 1;
				}

				if ($koef > 0)
				{
					$newWidth = $koef * 300;
					$newHeight = 300;
				}
				else
				{
					$newHeight = $koef * 300;
					$newWidth = 300;
				}
			}

		$image_resize = CFile::ResizeImageGet ($photo, array(
			"width" => $newWidth,
			"height" => $newHeight,
			BX_RESIZE_IMAGE_PROPORTIONAL,
			true
		));
		if (!empty($photo)) $photos[] = $image_resize['src'];
	}
	//если фото несколько то вклчаем слайдер при ховере
	if(count($photos)>1) $slider = true;
	$newItem = array(
		'ID'=>$item['ID'],
		'NAME' => $name,
		'URL' => $url,
		'PHOTO' => $photos,
		'PRICE' => $price,
		'NEW' => $new,
		'ACTION' => $action,
		'DOST' => $dost,
		"CAN_BY"=> $can_by,
		'HAVE_OFFERS' => $haveOffers,
		'DISCOUNT' => $discount,
		'SLIDER'=>$slider
	);

	$newItems[] = $newItem;
	unset($more_pic_detail, $value, $dis_value, $arPhoto, $photo, $photos, $discount, $can_by,$new, $action, $dost,
	$VALUES, $DISCOUNT_VALUES, $DISCOUNT_DIFF_PERCENTS, $haveOffers,$slider, $more);
}
//dump($newItems);
$arResult['ITEMS'] = $newItems;


