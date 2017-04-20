var TCSJquery=jQuery.noConflict();

function TKSSendRequest(sClass)
{
	var arTR = TCSJquery("."+sClass+".data");
	var trMessage = TCSJquery("."+sClass+".message");
	var Data = [];
	arTR.find("input,textarea").each(function()
	{
		Data[Data.length] = {"name":TCSJquery(this).attr("name"), "value":TCSJquery(this).val()};
	});

	TCSJquery.ajax({
		url:"/bitrix/admin/tcsbank_send.php",
		type:"post",
		data: Data,
		dataType: "json",
		beforeSend:function()
		{
			arTR.find("input,textarea").attr("disabled","y");
		},
		success: function(data)
		{
			arTR.find("input,textarea").removeAttr("disabled");
			trMessage.removeClass("error success kvk-hidden").addClass(data.status).find("td div").html(data.message);
			if(data.status=="success")
			{
				arTR.addClass("kvk-hidden");
			}
		}
	});
}

TCSJquery.download = function(url, data, method)
{
    if( url && data )
    {
        data = typeof data == 'string' ? data : jQuery.param(data);
        var inputs = '';
        TCSJquery.each(data.split('&'), function(){
            var pair = this.split('=');
            inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
        });
        TCSJquery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>').appendTo('body').submit().remove();
    }
};

TCSJquery.fn.tcs_block = function(options)
{
    var def = {};
    def.background = "#FFF";
    def.message = "<span class = 'dTCSLoader'></span>";
    def.duration = 100;
    def.opacity = 0.65;

    if(options)
    {
        for(i in options) def[i] = options[i];
    }
    var Wrapper = TCSJquery(".dBlockWrapper");
    if(!Wrapper.length) Wrapper = TCSJquery("<div class = 'dBlockWrapper'><div class = 'dBlockBody'></div></div>");
    var dBody = Wrapper.find(".dBlockBody");
    dBody.empty();
    dBody.append(def.message);
    var ToWrap = TCSJquery(this);
    dBody.css({
        "width":ToWrap.outerWidth(),
        "height":ToWrap.outerHeight(),
        "text-align":"center",
        "vertical-align":"middle",
        "display":"table-cell"
    });
    Wrapper.css({
        "background":def.background,
        "z-index":"100",
        "opacity":0,
        "position":"absolute",
        "width":ToWrap.outerWidth(),
        "height":ToWrap.outerHeight()
    });
    ToWrap.prepend(Wrapper);
    Wrapper.animate({opacity:def.opacity}, def.duration);
    return Wrapper;
}

TCSJquery.fn.tcs_unblock = function(options)
{
    var Wrapper = TCSJquery(".dBlockWrapper");
    var duration = 100;
    if(options)
    {
        if(options.duration) duration = options.duration;
    }
    if(Wrapper.length)
    {
        Wrapper.animate({opacity:0},duration,function()
        {
            TCSJquery(this).remove();
        });
    }
}

function ReformOrder(iOrderID,iDownPayment, iPaymentCount, aLink)
{
	
	data = {"ID":iOrderID, "DOWN_PAYMENT":iDownPayment, "PAYMENT_COUNT":iPaymentCount, "TYPE":"reform"};
	if(window.confirm(TCSJquery(aLink).attr("confirm")))
	{
		MakeRequest(data);
	}
	return false;
}

function ReformRequest(obj)
{
	Form = TCSJquery(this).parents("form:first");
	MakeRequest(Form);

}

function UpdateOrder()
{
	TCSJquery.ajax({
		type:"post",
		url:"/bitrix/admin/tcsbank_iframe.php",
		data:TCSJquery(".fUpdateOrder").serialize(),
		beforeSend:function()
		{
			ShowWaitWindow();
		},
		success:function(data)
		{
			CloseWaitWindow();
			//dOrderFull = TCSJquery("<div/>").append(data).find(".dOrderFull");
			TCSJquery(".dOrderFull").html(data);
		}
	
	});
	

}

function MakeRequest(arData, addon)
{
	TCSJquery.ajax({
		type:"post",
		url:"/bitrix/admin/tcsbank_request.php",
		data:arData,
		dataType:"json",
		beforeSend:function()
		{
			ShowWaitWindow();
			TCSJquery(".dOrderDetail."+arData.ID).tcs_block();
		},
		success:function(data)
		{
			/* ASD=data;
			return; */
			CloseWaitWindow();
			TCSJquery(".dOrderDetail."+data.ID).tcs_unblock();
			if(data.status=="ok")
			{
				
				if(data.show_document)
				{
					TCSJquery.download("/bitrix/admin/tcsbank_get_file.php",data, "post");
					window.setTimeout(function(){ ShowOrder(data.ID); }, 2000);
				}
				else 
				{
					ShowOrder(data.ID, null, true);
					TCSJquery(".bx-core-dialog-overlay, .bx-core-dialog").remove();		
				}
			}
			else
			{
				iOrderID = (data.ID);
				if(!iOrderID)
				{
					iOrderID = addon;
				}
				TCSJquery(".fUpdateOrder .dError").html(data.message);
				var dOrderDetail = TCSJquery(".dOrderDetail."+iOrderID);
				dOrderDetail.find(".errortext").html(data.message);
			}
			
		}
	});

}

function ApplyContract(iOrderID)
{
	//var iOrderID = arData.ID;
    arData = {"ID":iOrderID,"TYPE":"approve"};

	var dOrderDetail = TCSJquery(".dOrderDetail."+iOrderID);

	var iInputCount = dOrderDetail.find("input[name=courier_mode]").length;
	var sCourierMode="";
	if(iInputCount==1)
	{
		sCourierMode = dOrderDetail.find("input[name=courier_mode]").val();
	}
	else
	{
		if(iInputCount==2)
		{
			sCourierMode = dOrderDetail.find("input[name=courier_mode]:checked").val();
		}
	}

	if(!sCourierMode.length)
	{
		alert(TCSAlerts.TCS_NO_COURIER);
		return false;
	}

	arData.COURIER_MODE=sCourierMode;
	MakeRequest(arData);
}

function ChooseCourier(obj, mode)
{
	dLabels = TCSJquery(obj).parents(".dLabels:first");

	dLabels.find(".dLinks a").removeClass("active");
	dLabels.find(".dLinks span[courier_mode="+mode+"] a").addClass("active");
	dLabels.parents(".dOrderDetail:first").find(".dApplyContract a.choose").addClass("show");
	dLabels.parents(".dOrderDetail:first").find(".dApplyContract span.choose").removeClass("show");
}

function ReturnOrder(iOrderID, aLink)
{
    var Div = TCSJquery(aLink).parents(".dReturnForm:first");
    iReturnedAmount = Div.find("input[name=RETURNED_AMOUNT]").val();
    iCashReturnedToCustomer = Div.find("input[name=CASH_RETURNED_TO_CUSTOMER]").val();
    sReason = Div.find("select[name=RETURN_TYPE] option:selected").attr("value");

    arData={
        "TYPE":"return",
        "ID":iOrderID,
        "RETURNED_AMOUNT":iReturnedAmount,
        "CASH_RETURNED_TO_CUSTOMER":iCashReturnedToCustomer,
        "RETURN_TYPE":sReason
    };
    MakeRequest(arData);
    Div.hide();
}

function CancelDocument(iOrderID, obj)
{
	var Div = TCSJquery(obj).parents(".dDeclineForm:first");
	var Input = Div.find("input:checked");
	sReason = Div.find("select option:selected").val();
	MakeRequest({"TYPE":"subscribe","ID":iOrderID,"SUBSCRIBE":0, "REASON":sReason});
	Div.hide();
}

function SubscribeDocument(iOrderID, obj, bGood)
{
	var Div = TCSJquery(obj).parents(".dContractResult:first");
    var dOrderDetail = TCSJquery(".dOrderDetail."+iOrderID);
	if(bGood)
	{
        var arData = {"TYPE":"subscribe","ID":iOrderID,"SUBSCRIBE":1};
        var dApplyFrom = dOrderDetail.find(".dApplyForm");
        var sCode = dApplyFrom.find(".sCode").val();
        var sPerson = dApplyFrom.find(".sPerson").val();
        if(!sCode.length)
        {
            alert(TCSAlerts.TCS_NO_APPLY_CODE);
            return false;
        }
        if(sCode.length!=4)
        {
            alert(TCSAlerts.TCS_NO_APPLY_CODE_NOT_4);
            return false;
        }
        if(!sPerson.length)
        {
            alert(TCSAlerts.TCS_NO_APPLY_PERSON);
            return false;
        }
        arData.CODE=sCode;
        arData.PERSON=sPerson;
	}
	else
	{
		var sReason = Div.find("select option:selected").val();
        var arData={"TYPE":"subscribe","ID":iOrderID,"SUBSCRIBE":0, "REASON":sReason};
	}
    MakeRequest(arData);
}

function ShowDecline(obj)
{
    TCSJquery(".dToggler").hide();
    dDecline = TCSJquery(obj).parents("td:first").find(".dDecline");
    dDecline.slideDown(150);
}

function ShowApply(obj)
{
    TCSJquery(".dToggler").hide();
	dApply = TCSJquery(obj).parents("td:first").find(".dApplyForm");
    dApply.slideDown(150);
}

function RefreshRow(iOrderID)
{
	TCSJquery.ajax({
		type:"post",
		url:"/bitrix/admin/tcsbank_get_order.php",
		data:{"ID":iOrderID},
		beforeSend:function()
		{
			TCSJquery(".dOrderDetail."+iOrderID).tcs_block();
			ShowWaitWindow();
		},
		success:function(data)
		{
			TCSJquery(".dOrderDetail."+iOrderID).tcs_unblock();
			Tr = TCSJquery("#iOrderID"+iOrderID).parents("tr:first");
			newTr = TCSJquery(data).find(".dAjaxTr #iOrderID"+iOrderID).parents("tr:first");
			Tr.find("td").each(function(a,b)
			{
				TCSJquery(b).html(newTr.find("td:eq("+a+")").html());
			});
			var dOrderDetail = TCSJquery(".dOrderDetail."+iOrderID);
			if(dOrderDetail.length)
			{
				dOrderDetail.html(TCSJquery(data).find(".dAjaxDiv").html());
			}
			CloseWaitWindow();
		}
	});	

}

function CloseDiv(iOrderID)
{
	var dOrderDetail = TCSJquery(".dOrderDetail."+iOrderID);
	if(dOrderDetail.length)
	{
		var Tr = dOrderDetail.parents("tr:first");
		Tr.remove();
		//dOrderDetail.slideUp(400,function(){Tr.remove});
	}
}

function ShowOrder(iOrderID)
{
	var Tr=TCSJquery("#iOrderID"+iOrderID).parents("tr:first");
	TCSJquery.ajax({
		type:"post",
		url:"/bitrix/admin/tcsbank_get_order.php",
		data:{"ID":iOrderID},
		beforeSend:function()
		{
			TCSJquery(".dOrderDetail."+iOrderID).tcs_block();
			ShowWaitWindow();
		},
		success:function(data)
		{
			var dOrderDetail = TCSJquery(".dOrderDetail."+iOrderID);
			dOrderDetail.tcs_unblock();
			if(!dOrderDetail.length)
			{
				var Table = Tr.parents("table:first");
				var Colspan = Tr.find(">td").length-2;
				Tr.after("<tr><td colspan='2'><a class = 'aClose' href = 'javascript:CloseDiv("+iOrderID+")'>"+sCloseText+"</a></td><td class = 'left right' colspan='"+Colspan+"' style = 'padding:0px!important'><div class = 'dOrderDetail "+iOrderID+"'></div></td></tr>");
				var dOrderDetail = Tr.next().find(".dOrderDetail");
			}			
			dOrderDetail.html(TCSJquery(data).find(".dAjaxDiv").html());
			newTr = TCSJquery(data).find(".dAjaxTr #iOrderID"+iOrderID).parents("tr:first");;
			Tr.find("td").each(function(a,b)
			{
				TCSJquery(b).html(newTr.find("td:eq("+a+")").html());
			});
			CloseWaitWindow();
		}
	});
}

function FillComment(button, iOrderID)
{
	var bSend = TCSJquery(button);
	var sText = bSend.parents(".dComment:first").find("textarea").val();
	var arData = {"TYPE":"comment","ID":iOrderID,"TEXT":sText};
	TCSJquery.ajax({
		type:"post",
		url:"/bitrix/admin/tcsbank_request.php",
		data:arData,
		dataType:"json",
		beforeSend:function()
		{
			ShowWaitWindow();
			bSend.attr("disabled","disabled");
		},
		success:function(data)
		{
			CloseWaitWindow();
            bSend.removeAttr("disabled");
			if(data.status=="ok")
			{

			}
			else
			{
				alert(data.message);
			}
		}
	});
	return false;
}
function CleanSelect(Select)
{
	count = Select.options.length;
	for(i=0; i<count; i++) Select.removeChild(Select.options[0]);
}

function PropertyTypeChange(Select,iPersonType)
{
	
	ID = Select.id;
	ChildSelect = document.getElementById(ID.replace("[TYPE]","[VALUE]"));
	InputAnother = document.getElementById(ID.replace("[TYPE]","[VALUE_ANOTHER]"));
	Options = Select.options;
	for(i = 0; i < Options.length; i++)
	{
		if(Options[i].selected)
		{
			SelectedOption = Options[i];
			break;
		}
	}
	CleanSelect(ChildSelect);
	InputAnother.value = "";
	Type = SelectedOption.value;
	switch(Type)
	{
		case "ANOTHER":
			ChildSelect.style.display="none";
			InputAnother.style.display="";	
		break;
		case "PROPERTY":
			for (sSiteID in arFields[Type][iPersonType] )
			{
				NewOption = new Option;
				NewOption.value = sSiteID;
				NewOption.text = arFields[Type][iPersonType][sSiteID];
				ChildSelect.appendChild(NewOption);
			}
			ChildSelect.style.display="";
			InputAnother.style.display="none";								
		break;
		case "USER":
		case "ORDER":
			for (sSiteID in arFields[Type] )
			{
				NewOption = new Option;
				NewOption.value = sSiteID;
				NewOption.text = arFields[Type][sSiteID];
				ChildSelect.appendChild(NewOption);
			}
			ChildSelect.style.display="";
			InputAnother.style.display="none";									
		break;
		
	}
}	

function GenerateButton(obj)
{
	var iWidth = TCSJquery(obj).prev().val();
	var Table = TCSJquery(obj).parents("table:first");
	TCSJquery.ajax({
		type:"post",
		url:"/bitrix/admin/tcsbank_buttons.php",
		data:{"BUTTON_WIDTH":iWidth},
		beforeSend:function()
		{
			ShowWaitWindow();
			TCSJquery(obj).attr("disabled","disabled");
		},
		success:function(data)
		{
			CloseWaitWindow();
			Table.replaceWith(data);
		}		
	});
}

function SelectHost(obj)
{
	Select = TCSJquery(obj);
	Input = Select.parents("td:first").find(".iHostAddress");
	Option = Select.find("option:selected");
	if(Option.val()=="another")
	{
		Input.removeAttr("disabled");
	}
	else
	{
		Input.attr("disabled","disabled");
	}
	Input.val(Option.attr("url"));
	Select.parents("td:first").find(".iHostAddress.iApi").val(Option.attr("api_url"));
}