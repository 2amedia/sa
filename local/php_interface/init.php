<?
AddEventHandler('sale', 'OnBeforeOrderAdd', 'OnBeforeOrderAddHandler');
function OnBeforeOrderAddHandler(&$arFields)
{
	$MIN_ORDER_PRICE = 5000;
	if ($arFields['PRICE'] < $MIN_ORDER_PRICE && $arFields['NO_CHECK_MIN_PRICE'] != true)
	{
		global $APPLICATION;
		$APPLICATION->ThrowException('Минимальная сумма заказа — ' . CurrencyFormat($MIN_ORDER_PRICE, 'RUB'));
		return false;
	}
	return true;
}


AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");
function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
	$arOrder = CSaleOrder::GetByID($orderID);

	//-- получаем телефоны и адрес
	$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	$phone="";
	$address="";
	$name="";
	$email="";
	$ur_address="";
	$ur_phone="";
	$ur_name="";
	$ur_email="";
	while ($arProps = $order_props->Fetch())
	{
		if ($arProps["CODE"] == "PHONE_OF_CUSTOMER")
		{
			$phone = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "UR_PHONE_OF_CUSTOMER")
		{
			$ur_phone = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "ADDRESS_FOR_DELIVERY")
		{
			$address = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "NAME_OF_CUSTOMER")
		{
			$name = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "UR_NAME_OF_CUSTOMER")
		{
			$ur_name = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "EMAIL_OF_CUSTOMER")
		{
			$email = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "UR_EMAIL_OF_CUSTOMER")
		{
			$ur_email = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "UR_ADDRESS_FOR_DELIVERY")
		{
			$ur_address = $arProps["VALUE"];
		}
	}

	//-- получаем название службы доставки
	$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
	$delivery_name = "";
	if ($arDeliv)
	{
		$delivery_name = $arDeliv["NAME"];
	}

	//-- получаем название платежной системы
	$arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
	$pay_system_name = "";
	if ($arPaySystem)
	{
		$pay_system_name = $arPaySystem["NAME"];
	}

	//-- добавляем новые поля в массив результатов
	$arFields["COMMENTS_EMAIL"] =	$arOrder["USER_DESCRIPTION"];
	$arFields["PHONE_OF_CUSTOMER"] =	$phone;
	$arFields["ADDRESS_FOR_DELIVERY"] =	$address;
	$arFields["NAME_OF_CUSTOMER"] =	$name;
	$arFields["EMAIL_OF_CUSTOMER"] =	$email;
	$arFields["DELIVERY_NAME"] =	$delivery_name;
	$arFields["PAY_SYSTEM_NAME"] =	$pay_system_name;
	$arFields["UR_ADDRESS_FOR_DELIVERY"] = $ur_address;
	$arFields["UR_PHONE_OF_CUSTOMER"] =	$ur_phone;
	$arFields["UR_NAME_OF_CUSTOMER"] =	$ur_name;
	$arFields["UR_EMAIL_OF_CUSTOMER"] =	$ur_email;
}

function endingsForm($n, $forms)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20)
		return $forms[2];
	if ($n1 > 1 && $n1 < 5)
		return $forms[1];
	if ($n1 == 1)
		return $forms[0];
	return $forms[2];
}

AddEventHandler("iblock", "OnAfterIBlockSectionAdd", "OnAfterIBlockSectionUpdateHandler");
AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", "OnAfterIBlockSectionUpdateHandler");

function OnAfterIBlockSectionUpdateHandler($arFields)
{
    if($arFields["IBLOCK_ID"] == 3 && $arFields["UF_LINKED"] && CModule::IncludeModule("iblock"))
    {
    	$arFilter = Array("IBLOCK_ID" => 3, "SECTION_ID" => $arFields["ID"],  "INCLUDE_SUBSECTIONS" => "Y");

		$arSelect = Array("ID");

		$dbItems = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);

		while($arItem = $dbItems->GetNext())
		{
			CIBlockElement::SetPropertyValuesEx($arItem["ID"], 3, array("BUY_WITH_THIS_PRODUC" => $arFields["UF_LINKED"]));
		}
    }
}

/**
 * @param $arResult
 * @param $notadmin , если true, то даже не админ увидит дамп
 */
function dump($arResult, $notadmin = false)
{
	global $USER;
	if (($USER->IsAdmin()) || $notadmin)
	{
		$bt = debug_backtrace();
		$bt = $bt[0];
		$dRoot = $_SERVER["DOCUMENT_ROOT"];
		$dRoot = str_replace("/", "\\", $dRoot);
		$bt["file"] = str_replace($dRoot, "", $bt["file"]);
		$dRoot = str_replace("\\", "/", $dRoot);
		$bt["file"] = str_replace($dRoot, "", $bt["file"]);
		?>
		<div style="font-size:12px;
                            color:#000;
                            background:#FFF;
                            border:1px dashed #000;">
			<div style="padding: 3px 5px;
                            background:#99CCFF;
                            font-weight:bold;">File: <?= $bt["file"] ?>
				[<?= $bt["line"] ?>]
			</div>
			<pre style="padding: 10px;"><? print_r($arResult) ?></pre>
		</div>
		<?
	}
}

/**
 * dumpLog - выводит логи в html-файл, сохраняет в папке /log/
 * @param $arResult
 */
function dumpLog($arResult)
{
	if (!empty($arResult))
	{
		$bt = debug_backtrace();
		$bt = $bt[0];
		$dRoot = $_SERVER["DOCUMENT_ROOT"];
		$dRoot = str_replace("/", "\\", $dRoot);
		$bt["file"] = str_replace($dRoot, "", $bt["file"]);
		$dRoot = str_replace("\\", "/", $dRoot);
		$bt["file"] = str_replace($dRoot, "", $bt["file"]);
		$time = date("H-i-s");
		$fp = fopen($_SERVER["DOCUMENT_ROOT"] . '/log/dumplog_' . $time . '.html', 'w');
		if (!$fp)
		{
			echo "Ошибка при открытии файла";
		}
		$mytext = '
<div style="font-size:12px;
            color:#000;
            background:#FFF;
            border:1px dashed #000;">' . '
	<div style="padding: 3px 5px;
            background:#99CCFF;
            font-weight:bold;">File: ' . $bt["file"] . ' [' . $bt["line"] . ']
	</div>
	' . '
	<pre style="padding: 10px;">' . var_export($arResult, true) . '</pre>
	';
		fwrite($fp, $mytext);
		fclose($fp);
		echo '<a href="https://' . SITE_SERVER_NAME . '/log/dumplog_' . $time . '.html" target="_blank">лог</a>';
	}
}

//подключение своей доставки ПЭК
$eventManager = \Bitrix\Main\EventManager::getInstance ();
$eventManager->addEventHandler ('sale', 'onSaleDeliveryHandlersClassNamesBuildList', 'addCustomDeliveryServices');

function addCustomDeliveryServices (\Bitrix\Main\Event $event)
{
	$result = new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, array(
		'\AAM\PEKDeliveryHandler' => '/local/classes/PEKDeliveryHandler.php'
		));
	
	return $result;
}
