<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include(dirname(__FILE__)."/../include.php");
include(dirname(__FILE__)."/../constants.php");
IncludeModuleLangFile(dirname(__FILE__)."/status.php");
IncludeModuleLangFile(__FILE__);
$arRights = $obModule->GetGroupRight();

$arReturn = Array();
if ($arRights > "D") 
{
	$iOrderID = IntVal($_REQUEST["ID"]);
	if($obModule->CheckSiteRights(Array("ORDER_ID"=>$iOrderID)))
	{


		if(!$arTCSOrder = $obModule->RefreshOrder($iOrderID))
		{

			$sBlockMessage = $obModule->LAST_ERROR;
			$bBlockAll = true;
		}

		if(($arTCSOrder["PROCESSING"]>0) && !$bBlockAll)
		{
			$sBlockMessage = GetMessage("TCS_ORDER_PROCESSING")." <a href='javascript:RefreshRow({$iOrderID})'>".GetMessage("TCS_REFRESH")."</a>";
			$bBlockAll = true;	
		}
		if($arRights<"S")
		{
			if($bBlockAll) $sBlockMessage .= GetMessage("TCS_NO_RIGHTS1");
			else $sBlockMessage = GetMessage("TCS_NO_RIGHTS2");
			$bBlockAll = true;	
		}

		
		$bApplyContract = false;
		$bPrintContract = false;
		$bContractResult = false;
		$bUploadDocuments = false;
		$bCancelOrder = false;
		$bReturnOrder = false;
		$bReformOrder = false;
		$bApplyChanges = false;
		
		if(in_array($arTCSOrder["STATUS"], Array("new","rej","hol","ver")) && !$bBlockAll)
		{
			$sBlockMessage = GetMessage("TCS_ORDER_STATUS",Array("STATUS"=>GetMessage("TCS_bank_status_{$arTCSOrder["STATUS"]}")));
			$bBlockAll = true;
		}
		elseif(($arTCSOrder["CANCEL_STATUS"]!="" || $arTCSOrder["CANCELED"]=="Y") && !$bBlockAll)
		{
			$sBlockMessage = GetMessage("TCS_CANCEL_REASON",Array("REASON"=>$arCancelReason[$arTCSOrder["CANCEL_STATUS"]]));
			$bBlockAll = true;	
		}

		$iTCSOrderPrice = $arTCSOrder["LOAN_AMOUNT"]+$arTCSOrder["DOWN_PAYMENT"]-FloatVal($arTCSOrder["COMISSION"]);
		$sReformURL = "javascript:".$APPLICATION->GetPopupLink( array(
		   'URL' => '/bitrix/admin/tcsbank_iframe.php?ID='.$iOrderID, 
		   'PARAMS' => array( 
			  'width' => 780, 
			  'height' => 500, 
			  'resizable' => true, 
			  'min_width' => 780, 
			  'min_height' => 500
		   )) 
		);	
		$arOrderData = $obTCSOrder->GetItemsArray($iOrderID);
		$iBXOrderPrice = $arOrderData["TOTAL_TCS_SUMM_RUB"];
		if(($iBXOrderPrice!=$iTCSOrderPrice) && !$bBlockAll)
		{
			$sBlockMessage = GetMessage("TCS_DIFF_SUMM",Array("BX_SUMM"=>$iBXOrderPrice, "TCS_SUMM"=>$iTCSOrderPrice,"SITE_ID"=>$arOrderData["LID"]));
			if($arTCSOrder["APPROVED"]=="Y")
			{
				$sBlockMessage .= GetMessage("TCS_NO_REFORM");
			}
			else 
			{
				$sBlockMessage .= GetMessage("TCS_NEED_MAKE")." <a href='#trOrder{$iOrderID}' confirm = '".GetMessage("TCS_REFORM_CONFIRM")."' onclick = 'return ReformOrder({$iOrderID},{$arTCSOrder["DOWN_PAYMENT"]}, {$arTCSOrder["PAYMENT_COUNT"]}, this)'>".GetMessage("TCS_ORDER_REFORM_")."</a>";
			}
			$bBlockAll = true;
		}

		if(!$bBlockAll)
		{
			$bCancelOrder = true;
			$bReturnOrder = false;
			$bReformOrder = true;		
			if($arTCSOrder["APPROVED"]=="N") 
			{
				$obOrder = CSaleOrder::GetList(Array(),Array("ID"=>$iOrderID),false,false,Array("LID"));
				$arOrder = $obOrder->Fetch();
				$sSiteID = $arOrder["LID"];
				
				$arSiteData = $obModule->GetSitesData($sSiteID);
				$sCourierMode = $arSiteData["courier_mode"];
				$arSiteCourierModes = $arCourierModes[$sCourierMode]["MODE"];
				$arTCSCourierModes = explode(" ",$arTCSOrder["POSSIBLE_SIGNING_TYPES"]);
		
				$arAvailableCourierModes = array_values(array_intersect($arSiteCourierModes,$arTCSCourierModes));
				$iBankCourierID = array_search("bank",$arAvailableCourierModes);
				if($iBankCourierID!==false)
				{
					if(!($sCourierURL = $arTCSOrder["SCHEDULER_URL"]))
					{
						unset($arAvailableCourierModes[$iBankCourierID]);
					}
				}
				$arCourierModes = Array();
				foreach($arAvailableCourierModes as $sMode)
				{
					switch($sMode)
					{
						case "bank":
							$arCourierModes[] = Array(
								"NAME"=>GetMessage("TCS_courier_mode_{$sMode}"),
								"CODE"=>$sMode,
								"LINK"=>"<a class = 'aBankCourier' target='_blank' href='{$sCourierURL}'>".GetMessage("TCS_SET_VISIT")."</a>"
							);							
						break;
						case "partner":
							$arCourierModes[] = Array(
								"NAME"=>GetMessage("TCS_courier_mode_{$sMode}"),
								"CODE"=>$sMode,
								"LINK"=>""
							);
						break;
					}
				}
				$bApplyContract = (!empty($arCourierModes))?true:false;
				if($bApplyContract)
				{
					$bApplyShow = (count($arCourierModes)==1)?true:false;
				}
				$bCourierMode = true;
				$bReformOrder = true;
			}
			if($arTCSOrder["APPROVED"]=="Y") 
			{
				if($arTCSOrder["SIGNING_TYPE"]=="bank")
				{
					if($sCourierURL = $arTCSOrder["SCHEDULER_URL"])
					{
						$bShowBankURL = true;
					}
				}			
				$bPrintContract = true;
				$bReformOrder = false;
			}
			if($arTCSOrder["PRINTED"]=="Y") 
			{
				if($arTCSOrder["SUBSCRIBED"]!="Y")
				{
					$bContractResult = true;
				}
				else
				{
					$bCancelOrder = false;			
					$bReformOrder = false;					
					$bUploadDocuments = true;
					$bReturnOrder=true;
				}
			}
		}

		//$bReturnOrder = false;
		$bUploadDocuments = false;
		$arLimits = Array(
			"ALLOWED_LIMIT"=>0
		);
	}
	else
	{	
		$APPLICATION->ThrowException((GetMessage("TCS_INVALID_SITE",Array("ORDER_ID"=>$iOrderID))));
	}
}
else 
{
	$APPLICATION->ThrowException(GetMessage("TCS_NO_RIGHTS"));
}

?>
<div class = "dAjaxResult">
	<div class = "dAjaxDiv">
		<?if($ex = $APPLICATION->GetException()):?>
			<?=ShowError($ex->GetString());?>
		<?else:?>
			<table class = "tOrder">
				<tr class = "head">
					<td class = "left"><?=GetMessage("TCS_OFFER")?></td>
					<td><?=GetMessage("TCS_MEET_RESULT")?></td>
					<?/*<td><?=GetMessage("TCS_LOAD_SCANS")?></td>
					<td class = "right"><?=GetMessage("TCS_BILL_STATUS")?></td>*/?>
				</tr>
				<tr>
					<td class = "left">
						<?if($bCourierMode):?>
							<div class="dCourierMode">
								<p class = "pDeliveryMode"><?=GetMessage("TCS_DELIVERY_MSG")?></p>
								<?if($bCourierMode&&!empty($arCourierModes)):?>
									<div class="dLabels">
										<?if(count($arCourierModes)>1):?>
											<?foreach($arCourierModes as $arCourierMode):?>
												<label>
													<input type = "radio" name="courier_mode" onclick = "ChooseCourier(this, '<?=$arCourierMode["CODE"]?>')" value = "<?=$arCourierMode["CODE"]?>" class = "iCourierMode"/>
													<?=$arCourierMode["NAME"]?>
												</label>
											<?endforeach;?>		
											<div class="dLinks">
												<?foreach($arCourierModes as $arCourierMode):?>
													<span courier_mode="<?=$arCourierMode["CODE"]?>"><?=$arCourierMode["LINK"]?></span>
												<?endforeach;?>										
											</div>	
										<?else:?>
											<label><?=$arCourierModes[0]["NAME"]?></label>
											<input type = "hidden" name="courier_mode"  value = "<?=$arCourierModes[0]["CODE"]?>"/>
											<?if(strlen($arCourierModes[0]["LINK"])):?>
												<div class="dLinks all_active">
													<?=$arCourierModes[0]["LINK"]?>
												</div>
											<?endif;?>
										<?endif;?>
									</div>	
								<?else:?>
									<font color="#FF0000"><b><?=GetMessage("TCS_NO_COURIER_MODES")?></b></font>
									<span class = "sNoActive"><?=GetMessage("TCS_APPROVE")?></span>
								<?endif;?>								
							</div>
						<?else:?>
							<div class="dShowCourier">
								<?=GetMessage("TCS_COURIER_VARIANT")?>: <b><?=GetMessage("TCS_courier_mode_{$arTCSOrder["SIGNING_TYPE"]}")?></b>
							</div>
							
						<?endif;?>
						<?if($bShowBankURL):?>
							<div class="dCourierMode no_margin">
								<a class = 'aBankCourier' target='_blank' href='<?=$sCourierURL?>'><?=GetMessage("TCS_SET_VISIT")?></a>
							</div>
						<?endif;?>
						<div class = "dApplyContract">
							<?if($bApplyContract&&$bCourierMode):?>
								<a href = 'javascript:void(0)' class='aPartnerCourier <?=$bApplyShow?"show":""?> choose' onclick = "ApplyContract(<?=$iOrderID?>);"><?=GetMessage("TCS_APPROVE")?></a>
								<span class = "sNoActive <?=(!$bApplyShow)?"show":""?> choose"><?=GetMessage("TCS_APPROVE")?></span>
                            <?else:?>
								<span class = "sNoActive"><?=GetMessage("TCS_APPROVE")?></span>
							<?endif;?>
						</div>
						<div class = "dPrintContract">
							<?if($bPrintContract):?>
								<a href = "javascript:void(0)" onclick = "MakeRequest({'TYPE':'print', 'ID':<?=$iOrderID?>})"><?=GetMessage("TCS_PRINT_OFFER")?></a>
							<?else:?>
								<span class = "sNoActive"><?=GetMessage("TCS_PRINT_OFFER")?></span>
							<?endif;?>				
						</div>
					</td>
					<td>
						<div class = "dContractResult">
                            <div class="dSubChoose">

                                <?if($arRights<="S" && $bContractResult):?>
                                    <?$bContractResult=false;?>
                                    <span class="sError"><?=GetMessage("TCS_NO_MEET_RIGHTS")?></span>
                                <?endif;?>
                                <label>
                                    <?if($bContractResult):?>
                                        <a class='aContactResult' href="javascript:void(0)" onclick="ShowApply(this)"><?=GetMessage("TCS_OFFER_SUBSCRIBED")?></a>
                                    <?else:?>
                                        <span class = "sNoActive"><?=GetMessage("TCS_OFFER_SUBSCRIBED")?></span>
                                    <?endif;?>
                                    <div class = "clear"></div>
                                </label>
                                <label>
                                    <?if($bContractResult):?>
                                        <a class='aContactResult' href="javascript:void(0)" onclick="ShowDecline(this)"><?=GetMessage("TCS_NO_OFFER_SUBSCRIBED")?></a>
                                    <?else:?>
                                        <span class = "sNoActive"><?=GetMessage("TCS_NO_OFFER_SUBSCRIBED")?></span>
                                    <?endif;?>
                                    <div class = "clear"></div>
                                </label>
                            </div>
                            <?if($bContractResult):?>
                                <div class="dSubForm">
                                    <div class = "dDecline dToggler">
                                        <p class="pTitle"><?=GetMessage("TCS_SET_DECLINE_DATA")?></p>
                                        <select class = "sDecline" autocomplete="off">
                                            <?foreach($arCancelReason as $sKey=>$sReason):?>
                                                <option value = "<?=$sKey?>"><?=$sReason?></option>
                                            <?endforeach;?>
                                        </select>
                                        <div class="dButtons">
                                            <input type="button" class = "sCancel adm-btn" onclick = "TCSJquery(this).parents('.dDecline:first').hide(); return false;" value="<?=GetMessage("TCS_DECLINE")?>">
                                            <input type="button" class="sApply adm-btn-save" onclick = "SubscribeDocument(<?=$iOrderID?>, this, false); return false;" value="<?=GetMessage("TCS_SEND_QUERY")?>">
                                        </div>
                                    </div>
                                    <div class = "dApplyForm dToggler">
                                        <p class="pTitle"><?=GetMessage("TCS_SET_APPROVE_DATA")?></p>
                                        <p><?=GetMessage("TCS_SET_APPROVE_CODE")?></p>
                                        <input type="text" class="sCode sText" autocomplete="off" value=""/>
                                        <p><?=GetMessage("TCS_SET_APPROVE_PERSON")?></p>
                                        <input  type="text" class="sPerson sText" autocomplete="off" value=""/>
                                        <div class = "dButtons">
                                            <input type="button" class = "sCancel adm-btn" onclick = "TCSJquery(this).parents('.dApplyForm:first').hide(); return false;" value="<?=GetMessage("TCS_DECLINE")?>">
                                            <input type="button" class = "sApply adm-btn-save" onclick = "SubscribeDocument(<?=$iOrderID?>, this, true); return false;" value="<?=GetMessage("TCS_SEND_QUERY")?>">
                                        </div>
                                    </div>
                                </div>
                            <?endif;?>
						</div>
					</td>
					<?/*
					<td>
						<div class = "dUploadDocuments">
							<?if($bUploadDocuments):?>
								<ol>
									<li><a href = "javascript:void(0)"><?=GetMessage("TCS_ANKET")?></a></li>
									<li><a href = "javascript:void(0)"><?=GetMessage("TCS_PASSPORT")?></a></li>
									<li><a href = "javascript:void(0)"><?=GetMessage("TCS_REG_PAGE")?></a></li>
								</ol>
							<?else:?>
								<ol class = "sNoActive">
									<li><span><?=GetMessage("TCS_ANKET")?></span></li>
									<li><span><?=GetMessage("TCS_PASSPORT")?></span></li>
									<li><span><?=GetMessage("TCS_REG_PAGE")?></span></li>
								</ol>				
							<?endif;?>					
						</div>
					</td>
					<td class = "right"></td>*/?>
				</tr>
				<tr>
					<td colspan = "2" class = "left right" align = "center" style = "padding:8px 0px!important">
						<div class = "dError"></div>
						<font class = "errortext">
							<?=($sBlockMessage);?>
						</font>
					</td>
				</tr>
				<tr>
					<td colspan = "2" class = "left right" style = "padding:8px 0px!important">
						<table class = "tBasketItems">
							<tr class = "head">
								<td><?=GetMessage("TCS_NUM")?></td>
								<td><?=GetMessage("TCS_NAME")?></td>
								<td><?=GetMessage("TCS_QUANTITY")?></td>
								<td><?=GetMessage("TCS_PRICE")?></td>
								<td><?=GetMessage("TCS_PRICE_SUMM")?></td>
							</tr>
							<?foreach($arOrderData["ITEMS"] as $iKey=>$arItem):?>
								<tr>
									<td><?=($iKey+1)?></td>
									<td><?=$arItem["NAME"]?></td>
									<td><?=$arItem["TCS_QUANTITY"]?></td>
									<td><?=number_format($arItem["PRICE_RUB"],2,"."," ");?></td>
									<td><?=number_format($arItem["PRICE_TOTAL_RUB"],2,"."," ");?></td>
								</tr>
							<?endforeach;?>
							<?if(FloatVal($arTCSOrder["COMISSION"])):?>
								<tr>
									<td><?=($iKey+2)?></td>
									<td><?=GetMessage("TCS_COMISSION")?></td>
									<td>1</td>
									<td><?=number_format($arTCSOrder["COMISSION"],2,"."," ");?></td>
									<td><?=number_format($arTCSOrder["COMISSION"],2,"."," ");?></td>
								</tr>	
								<?$arOrderData["TOTAL_SUMM_RUB"]+=$arTCSOrder["COMISSION"];?>
								<?$arOrderData["TOTAL_TCS_SUMM_RUB"]+=$arTCSOrder["COMISSION"];?>
							<?endif;?>
							<tr class = "result">
								<td class = "no-border"></td>
								<td class = "no-border"></td>
								<td class = "no-border"></td>
								<td><?=GetMessage("TCS_TOTAL")?>:</td>
								<td><?=number_format($arOrderData["TOTAL_SUMM_RUB"],2,"."," ");?></td>
							</tr>	
							<tr class = "result">
								<td class = "no-border"></td>
								<td class = "no-border"></td>
								<td class = "no-border"></td>
								<td><?=GetMessage("TCS_PRECISION_TOTAL")?>:</td>
								<td><?=number_format($arOrderData["TOTAL_TCS_SUMM_RUB"],0,"."," ");?></td>
							</tr>				
						</table>
						<div class = "dBottomButtons">

			
							<input type="button" <?=(!$bCancelOrder)?"disabled='y'":""?> class = "bCancel adm-btn" onclick = "TCSJquery(this).parent().find('.dDeclineForm').show(); return false;" value="<?=GetMessage("TCS_CANCEL")?>">
							<input type="button" <?=(!$bReturnOrder)?"disabled='y'":""?> onclick = "TCSJquery(this).parent().find('.dReturnForm').show(); return false;" class = "bReturn adm-btn" value="<?=GetMessage("TCS_RETURN")?>">
							<input type="button" <?=(!$bReformOrder)?"disabled='y'":""?> onclick = "<?=$sReformURL?>; return false;" class = "bReform adm-btn" value="<?=GetMessage("TCS_REFORM")?>">
							<?if($bCancelOrder):?>
								<div class = "dDeclineForm">
									<p><?=GetMessage("TCS_SET_CANCEL_REASON")?></p>
									<select class = "sDecline" autocomplete="off">
										<?foreach($arCancelReason as $sKey=>$sReason):?>
											<option value = "<?=$sKey?>"><?=$sReason?></option>
										<?endforeach;?>
									</select>
									<div class = "dButtons">
										<input type="button" class = "sCancel adm-btn" onclick = "TCSJquery(this).parents('.dDeclineForm:first').hide(); return false;" type="button" value="<?=GetMessage("TCS_DECLINE")?>">
										<input type="button" class = "sApply adm-btn-save" onclick = "CancelDocument(<?=$iOrderID?>,this); return false;" type="button" value="<?=GetMessage("TCS_SEND_QUERY")?>">
									</div>
								</div>	
							<?endif;?>
							<?if($bReturnOrder):?>
								<div class = "dReturnForm">
									<p><?=GetMessage("TCS_RETURNED_AMOUNT")?></p>
									<input class="sText" type = "text" name = "RETURNED_AMOUNT" value = "<?=$arTCSOrder["RETURNED_AMOUNT"]?>"/>
									<p><?=GetMessage("TCS_CASH_RETURNED_TO_CUSTOMER")?></p>
									<input class="sText" type = "text" name = "CASH_RETURNED_TO_CUSTOMER" value = "0"/>
									<p><?=GetMessage("TCS_RETURNED_TYPE")?></p>
                                    <select name = "RETURN_TYPE">
                                        <?foreach($arReturnType as $sKey=>$sName):?>
                                            <option value = "<?=$sKey?>"><?=$sName?></option>
                                        <?endforeach;?>
                                    </select>
									<div class = "dButtons">
										<input type="button" class = "sCancel adm-btn" onclick = "TCSJquery(this).parents('.dReturnForm:first').hide(); return false;" value="<?=GetMessage("TCS_DECLINE")?>">
										<input type="button" class = "sApply adm-btn-save" onclick = "ReturnOrder(<?=$iOrderID?>,this); return false;" value="<?=GetMessage("TCS_SEND_QUERY")?>">
									</div>
								</div>	
							<?endif;?>							
						</div>
						<div class = "clear"></div>
						<div class = "dCommentWrapper">
							<div class = "dLimits">
								<div class = "dLeft">
									<p><?=GetMessage("TCS_MAX_LOAN_AMOUNT")?></p>
									<div class = "dAllowed">
										<?=FormatCurrency($arTCSOrder["MAX_LOAN_AMOUNT"],"RUB")?>
									</div>
								</div>
								<div class = "dRight">
									<p><?=GetMessage("TCS_MONTHLY_PAYMENT")?></p>
									<div class = "dEveryMonth">
										<?=FormatCurrency($arTCSOrder["MONTHLY_PAYMENT"],"RUB")?>
									</div>
									<p><?=GetMessage("TCS_DOWN_PAYMENT")?></p>
									<div class = "dFirstPayment">
										<?=FormatCurrency($arTCSOrder["DOWN_PAYMENT"],"RUB")?>
									</div>
									<p><?=GetMessage("TCS_LOAN_AMOUNT")?></p>
									<div class = "dCreditSumm">
										<?=FormatCurrency($arTCSOrder["LOAN_AMOUNT"],"RUB")?>
									</div>							
								</div>
							</div>	
							<div class = "dComment">
								<p><?=GetMessage("TCS_ORDER_COMMENT")?></p>
								<textarea name = "ORDER_COMMENT"><?=$arTCSOrder["COMMENT"]?></textarea><br/>
								<input onclick = "return FillComment(this, <?=$iOrderID?>)" class = "bLeaveComment adm-btn" value="<?=GetMessage("TCS_LEAVE_COMMENT")?>" type="button">
							</div>	

						</div>
					</td>
				</tr>
			</table>
			<div class = "clear"></div>
		<?endif;?>
	</div>
	<div class = "dAjaxTr">
		<?
			$lAdmin = $obModule->GetOrderTable(Array("ID"=>$iOrderID));
			$lAdmin->DisplayList();	
		?>
	</div>	
</div>
