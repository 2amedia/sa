<?
	class CTCSExchange
	{
		var $sHost;
        var $sPort;
        var $sScheme;

        public function FillHostData($sURL)
        {
            $arURL = parse_url($sURL);
            $this->sPort = 443;
            $this->sHost=$arURL["host"];
            if(array_key_exists("port",$arURL))
            {
                $this->sPort=$arURL["port"];
            }
            $this->sScheme="tls://";
        }

		public function CheckValid($sSiteID)
		{
			$arParams = $this->GetSiteSecret($sSiteID);


            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));


			$arParams["params"] = array(
				'Param' => '12345'
			);
			$arReturn = $this->Request("ping", $arParams);

			if($arReturn["array"]["status"]=="FAILED")
			{
				return false;
			}
			else return true;
		}

		public function ReformOrder($iOrderID, $iDownPayment=false, $iMonths=false, $sSiteID = false)
		{
			IncludeModuleLangFile(__FILE__);
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}
            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));
			$arParams = $this->GetSiteSecret($sSiteID);
			$obTCSOrder = new CTCSOrder;
			$arData = $obTCSOrder->GetItemsArray($iOrderID);
			$iOrderPrice = $arData["TOTAL_SUMM_RUB"];
			$iMax = $iOrderPrice-3000;
			$iMax = floor($iMax);
			$iCreditSumm = $iOrderPrice-$iDownPayment;
			$iMonthPayment = $this->MonthPayment($iMonths,$iCreditSumm);


			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID,
				"DesiredMonthlyPayment"=>$iMonthPayment,
				"DesiredCreditPeriod"=>$iMonths,
				"DesiredAmount"=>$iCreditSumm
			);
			foreach($arData["ITEMS"] as $arItem)
			{
				if(IntVal($arItem["PRODUCT_ID"]))
				{
					$obElement = CIBLockElement::GetList(Array(),Array("ID"=>$arItem["PRODUCT_ID"]),false,false,Array("ID","IBLOCK_SECTION_ID"));
					if($arElement = $obElement->Fetch())
					{
						$obSection = CIBlockSection::GetList(Array(),Array("ID"=>$arElement["IBLOCK_SECTION_ID"]),false,Array("NAME"));
						$sSectionName = "";
						if($arSection = $obSection->Fetch())
						{
							$sSectionName = $arSection["NAME"];
						}
						$arProduct = Array(
							"ProductName"=>$arItem["NAME"],
							"Category"=>$sSectionName,
							"ProductQuantity"=>IntVal($arItem["QUANTITY"]),
							"ProductPrice"=>$arItem["PRICE_RUB"]
						);
					}
				}
				else
				{
					$arProduct = Array(
						"ProductName"=>$arItem["NAME"],
						"Category"=>"",
						"ProductQuantity"=>IntVal($arItem["QUANTITY"]),
						"ProductPrice"=>$arItem["PRICE_RUB"]
					);
				}
				$arParams["params"]["Products"][] = $arProduct;

			}
			global $APPLICATION;

			$arReturn = $this->Request("change_order", $arParams);
			$arReturn = $arReturn["array"];
			if($arReturn["status"]=="FAILED")
			{
				$this->LAST_ERROR = $arReturn["result"];
				return false;
			}
			elseif($ex = $APPLICATION->GetException())
			{
				$this->LAST_ERROR = $ex->GetString();
				return false;
			}
			return $arReturn["array"];
		}

		public function GetCourierURL($iOrderID, $sSiteID = false)
		{
			IncludeModuleLangFile(__FILE__);
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}
            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));
			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID
			);
			$arReturn = $this->Request("bank_signing_check", $arParams);
			if(IntVal($arReturn["array"]["CanDeliver"]))
			{
				return $arReturn["array"]["SchedulerUrl"];
			}
			return false;
			//return "www.ya.ru";
		}

		public function ConfirmOrder($iOrderID, $sSiteID = false, $sCourierMode)
		{
			IncludeModuleLangFile(__FILE__);
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}
			if(!$sCourierMode)
			{
				$this->LAST_ERROR = GetMessage("TCS_ERROR_NO_COURIER");
				return false;
			}

            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));

			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID,
				'SigningType' => $sCourierMode
			);
			$arReturn = $this->Request("confirm_order", $arParams);

			return $arReturn["array"];
		}
		public function GetContract($iOrderID, $sSiteID = false)
		{
			IncludeModuleLangFile(__FILE__);
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}

            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));

			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID
			);
			$arReturn = $this->Request("get_contract", $arParams);

			return $arReturn["array"];
		}

		public function CancelOrder($iOrderID, $sSiteID = false, $sStatus)
		{
			include(dirname(__FILE__)."/../constants.php");
			IncludeModuleLangFile(__FILE__);
			global $APPLICATION;
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}

            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));

			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID,
				"Reason" => $arCancelReason[$sStatus]
			);
			$arReturn = $this->Request("cancel_order", $arParams);
            $arReturn = $arReturn["array"];
			if($arReturn["status"]=="FAILED")
			{
				$this->LAST_ERROR = $arReturn["result"];
				return false;
			}
			elseif($ex = $APPLICATION->GetException())
			{
				$this->LAST_ERROR = $ex->GetString();
				return false;
			}
			else
			{
				$obTCSOrder = new CTCSOrder;
				$obTCSOrder->Update($iOrderID,Array("CANCELED"=>"Y", "CANCEL_STATUS"=>$sStatus));

				if(1)
				{
					CSaleOrder::CancelOrder($iOrderID,"Y","Canceled by TCSBank module");
				}

			}
			return true;
		}
		public function OrderCompleted($iOrderID, $sSiteID = false, $sCode="",$sPerson="")
		{
			IncludeModuleLangFile(__FILE__);
			global $APPLICATION;
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}

            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));

			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID,
                'Code'=>$sCode,
                'Person'=>$sPerson
			);
			$arReturn = $this->Request("order_completed", $arParams);
            $arReturn = $arReturn["array"];
			if($arReturn["status"]=="FAILED")
			{
				$this->LAST_ERROR = $arReturn["result"];
				return false;
			}
			elseif($ex = $APPLICATION->GetException())
			{
				$this->LAST_ERROR = $ex->GetString();
				return false;
			}
			else
			{
				$obTCSOrder = new CTCSOrder;
				$obTCSOrder->Update($iOrderID,Array("SUBSCRIBED"=>"Y"));
			}
			return true;
		}

		public function ReturnOrder($iOrderID, $iReturnedAmount = false , $iCashReturnedToCustomer=false, $sSiteID = false, $sReturnType="")
		{
			IncludeModuleLangFile(__FILE__);
			global $APPLICATION;
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}

            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));

			$obTCSOrder = new CTCSOrder;
			if(!($arOrderData = $obTCSOrder->GetItemsArray($iOrderID)))
			{
				$this->LAST_ERROR = GetMessage("TCS_ERROR_ORDER_PROCESS",Array("ORDER_ID"=>$iOrderID));
				return false;
			}
			$iReturnedAmount=IntVal($iReturnedAmount);

			if(!$iReturnedAmount)
			{
				$this->LAST_ERROR = GetMessage("TCS_ERROR_RETURNED_AMOUNT");
				return false;
			}
			if(!is_numeric($iCashReturnedToCustomer))
			{
				$this->LAST_ERROR = GetMessage("TCS_CASH_RETURNED_TO_CUSTOMER");
				return false;
			}
			else $iCashReturnedToCustomer=IntVal($iCashReturnedToCustomer);
			/* if($iCashReturnedToCustomer>$iReturnedAmount)
			{
				$this->LAST_ERROR = GetMessage("TCS_CUSTOMER_GT");
				return false;
			} */
			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID,
				'ReturnedAmount' => $iReturnedAmount,
				'CashReturnedToCustomer'=>$iCashReturnedToCustomer,
                "Type"=>$sReturnType
			);
			$arReturn = $this->Request("get_return_goods_form", $arParams);
			return $arReturn["array"];
		}


		public function GetDecision($iOrderID, $sSiteID = false)
		{
			IncludeModuleLangFile(__FILE__);
			if(!$sSiteID)
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				if(!($arOrder = $obOrder->Fetch()))
				{
					$this->LAST_ERROR = GetMessage("TCS_ORDER_NOT_FOUND");
					return false;
				}
				$sSiteID = $arOrder["LID"];
			}

            $this->FillHostData($this->GetApiHostBySiteID($sSiteID));

			$arParams = $this->GetSiteSecret($sSiteID);
			$arParams["params"] = array(
				'PartnerOrderId' => $iOrderID
			);
			$arReturn = $this->Request("get_decision", $arParams);

			return $arReturn["array"];
		}

		public function SendSiteRequest($arParams)
		{
			IncludeModuleLangFile(__FILE__);
			$arError = Array();
			if(!strlen(trim($arParams["SITE"])))
			{
				$arError[] = GetMessage("TCS_FILL_FIELD",Array("NAME"=>GetMessage("TCS_SITE"), "ADDITIONAL_INFO"=>GetMessage("TCS_SITE_NAME_SETTING_LINK")));
			}
			if(!strlen(trim($arParams["FIO"])))
			{
				$arError[] = GetMessage("TCS_FILL_FIELD",Array("NAME"=>GetMessage("TCS_FIO"), "ADDITIONAL_INFO"=>""));
			}
			if(!strlen(trim($arParams["PHONE"])))
			{
				$arError[] = GetMessage("TCS_FILL_FIELD",Array("NAME"=>GetMessage("TCS_PHONE"), "ADDITIONAL_INFO"=>""));
			}
			if(!strlen(trim($arParams["EMAIL"])))
			{
				$arError[] = GetMessage("TCS_FILL_FIELD",Array("NAME"=>GetMessage("TCS_EMAIL"), "ADDITIONAL_INFO"=>""));
			}
			elseif(!check_email($arParams["EMAIL"]))
			{
				$arError[] = GetMessage("TCS_WRONG_EMAIL");
			}
			if(!empty($arError))
			{
				$arReturn = Array(
					"status"=>"error",
					"message"=>implode("<br/>",$arError)
				);
			}
			else
			{
				$obCurl = curl_init();
				$sFeedbackURL = $this->GetHost("main","SRC")."/main/feedback";

				curl_setopt($obCurl, CURLOPT_URL, $sFeedbackURL);
				curl_setopt($obCurl, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($obCurl, CURLOPT_HTTPHEADER, Array());
				curl_setopt($obCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($obCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
				$sName = $arParams["SITE"].", ".$arParams["FIO"].", ".$arParams["PHONE"];
				$sPost = "name={$sName}&email={$arParams["EMAIL"]}&message={$arParams["COMMENT"]}";
				curl_setopt($obCurl, CURLOPT_POSTFIELDS, $sPost);
				curl_setopt($obCurl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($obCurl, CURLOPT_HEADER, true);
				$arResult = array();
				$arTempResult = curl_exec($obCurl);
				$sResult = substr($arTempResult, curl_getinfo($obCurl, CURLINFO_HEADER_SIZE));
				$arResult = json_decode($this->Decode($sResult));
				if($arResult->status=="errors")
				{
					$sErrorMsg = "";
					foreach($arResult->fields as $sKey=>$arField)
					{
						if(!empty($arField)) $sErrorMsg.="{$sKey} - ".implode(", ",$arField)."<br/>";
					}
					$arReturn=Array(
						"status"=>"error",
						"message"=>"Server error: ".$sErrorMsg
					);
				}
				else $arReturn = Array(
					"status"=>"success",
					"message"=>GetMessage("SUCCESS_SEND")
				);
			}

			return $arReturn;
		}


		public function SignMessage($sMessage, $salt, $iterationCount = 1102) {
			$sMessage = $sMessage.$salt;
			$result = md5($sMessage).sha1($sMessage);
			for($i = 0; $i < $iterationCount; $i++) {
				$result = md5($result);
			}
			return $result;
		}

		public function EnvelopeMessage($message, $secretPhrase) {
			$Base64EncodedMessage = base64_encode($message);
			$arParams["RequestSignature"] = $sign = $this->signMessage($Base64EncodedMessage, $secretPhrase);
			$arParams["Base64EncodedMessage"] = $Base64EncodedMessage;
			return $this->ArrayToXML(Array("envelope"=>$arParams));
		}

		public function NodeBranch($arValues, $sKey=false, $arExceptions = Array())
		{
            $sReturn="";
			foreach($arValues as $sKey=>$sValue)
			{
				if(!in_array($sKey,$arExceptions))
				{
					if(is_array($sValue))
					{
						if(is_numeric($sKey)) $sKey="Product";
						if(!strlen($sKey)) $sKey="__";
						//$obArray = $obBranch->appendChild(new DOMElement($sKey));
                        $sReturn .= "<{$sKey}>";
                        $sReturn .= $this->NodeBranch($sValue);
                        $sReturn .= "</{$sKey}>";
					}
					else
					{
						if(is_numeric($sKey)) $sKey="Product";
						//$obElement = $obBranch->appendChild(new DOMElement($sKey));
						//$obElement->nodeValue = $sValue;
                        //$sReturn=$sValue;
                        $sReturn .= "<{$sKey}>";
                        $sReturn .= $sValue;
                        $sReturn .= "</{$sKey}>";
					}
				}
			}
            return $sReturn;
		}

		public function ArrayToXML($arParams)
		{
			$sXML = $this->NodeBranch($arParams);
            //'<?xml encoding="UTF-8">'.
            //printr(htmlspecialchars($sXML)); die();
			return $sXML;
		}



		public function Request($sMethod, $arParams = null)
		{
			global $APPLICATION;
			IncludeModuleLangFile(__FILE__);
			if(isset($arParams["salt"]))
			{
				$sSalt = $arParams["salt"];
				unset($arParams["salt"]);
			}


			$sXML = $this->Encode($this->ArrayToXML(Array("request"=>$arParams)));

            $sXMLRequest = $this->EnvelopeMessage($sXML, $sSalt);

            /*$obCurl = curl_init();
            curl_setopt($obCurl, CURLOPT_URL, $this->sHost."/api/".$sMethod);
            curl_setopt($obCurl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($obCurl, CURLOPT_HTTPHEADER, Array());
            curl_setopt($obCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($obCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if($arParams !== null)
                curl_setopt($obCurl, CURLOPT_POSTFIELDS, $sXMLRequest);
            curl_setopt($obCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($obCurl, CURLOPT_HEADER, true);*/

			$arResult = array();
			//$arTempResult = curl_exec($obCurl);

            $sResult = QueryGetData(
                $this->sHost,
                $this->sPort,
                "/api/".$sMethod,
                $sXMLRequest,
                $error_number,
                $error_text,
                "POST",
                $this->sScheme
            );


			//printr($arTempResult,curl_getinfo($obCurl));
			//$arResult['body'] = substr($arTempResult, curl_getinfo($obCurl, CURLINFO_HEADER_SIZE));
			//$arResult['headers'] = substr($arTempResult, 0, curl_getinfo($obCurl, CURLINFO_HEADER_SIZE));

			//$arResult['code'] = curl_getinfo($obCurl, CURLINFO_HTTP_CODE);
			//$arResult['code_level'] = intval($arResult['code']/100);

			//$arResult['xml'] = $arResult['body'];
            //printr(htmlspecialchars($sResult));
			$arResponse = $this->XMLToArray($this->Decode($sResult));

			$arResult["array"] = $arResponse["response"];

			if($ex = $APPLICATION->GetException())
			{

				$APPLICATION->ThrowException(GetMessage("TCS_CONNECTION_ERROR"));
			}
			//curl_close($obCurl);
			if($arResult["array"]["status"]=="FAILED")
			{
				$arResult["array"]["result"] = $this->GetRusError($arResult["array"]["result"]);
			}
			return $arResult;

		}


		public function XMLToArray($xml)
		{



			if (is_string($xml))
			{
                require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/xml.php');
                $obXML = new CDataXML();
                $obXML->LoadString($xml);
                $arNew = $obXML->GetArray();
                $arReturn = Array();
                reset($arNew);
                $sKey=key($arNew);
                $arReturn = ARray($sKey=>$this->ProcessXMLArray($arNew[$sKey]));
                reset($arNew);
                reset($arReturn);
                return $arReturn;
			}

			return false;
		}

        public function ProcessXMLArray($arNode)
        {
            if(is_array($arNode['#'])){
                $arChilds = $arNode['#'];

                foreach($arChilds as $sNodeName=>$arValues)
                {
                    if(count($arValues)==1)
                    {
                        $arValues = $arValues[0];
                    }
                    $result[$sNodeName]=$this->ProcessXMLArray($arValues);
                }
            }
            else
            {
                $result=trim($arNode['#']);
            }
            return $result;
        }

		/*public function _process($node) {
			$occurance = array();

			foreach($node->childNodes as $child) {
				$occurance[$child->nodeName]++;
			}

			if($node->nodeType == XML_TEXT_NODE) {
				$result = html_entity_decode(htmlentities($node->nodeValue, ENT_COMPAT, 'UTF-8'),
										 ENT_COMPAT,'ISO-8859-15');
			}
			else {
				if($node->hasChildNodes()){
					$children = $node->childNodes;

					for($i=0; $i<$children->length; $i++) {
						$child = $children->item($i);

						if($child->nodeName != '#text') {
							if($occurance[$child->nodeName] > 1) {
								$result[$child->nodeName][] = $this->_process($child);
							}
							else {
								$result[$child->nodeName] = $this->_process($child);
							}
						}
						else if ($child->nodeName == '#text') {
							$text = $this->_process($child);

							if (trim($text) != '') {
								$result = $this->_process($child);
							}
						}
					}
				}

				if($node->hasAttributes()) {
					$attributes = $node->attributes;

					if(!is_null($attributes)) {
						foreach ($attributes as $key => $attr) {
							$result["@".$attr->name] = $attr->value;
						}
					}
				}
			}

			return $result;
		}
		*/

		public function Encode(&$sData)
		{
			if(CTCSExchange::NeedCoding())
			{
				$sReturn = $sData = iconv("windows-1251","utf-8",$sData);
			}
			else $sReturn = $sData;
			return $sReturn;
		}

		public function NeedCoding()
		{
			return (!defined("BX_UTF") || (BX_UTF!=true));
		}

		public function GetRusError($sEnglError)
		{
			include(dirname(__FILE__)."/../constants.php");
			IncludeModuleLangFile(__FILE__);
			$sEnglError=trim($sEnglError);
			$sReturn = $sEnglError;
			foreach($arTCSMessage as $iErrorCode=>$arMessage)
			{
				if(preg_match("#{$arMessage["ENG"]}#",$sEnglError,$arMatches))
				{
					$sReturn = $arMessage["RUS"];
					foreach($arMatches as $iKey=>$sValue)
					{
						if(IntVal($iKey)) $sReturn = str_replace("#{$iKey}#",$sValue,$sReturn);
					}
				}
			}
			return $sReturn;
		}

		public function Decode(&$sData)
		{
			if(CTCSExchange::NeedCoding())
			{
				$sReturn = $sData = iconv("utf-8","windows-1251",$sData);
			}	
			else $sReturn = $sData;
			return $sReturn;
		}		
	
	
	}
?>