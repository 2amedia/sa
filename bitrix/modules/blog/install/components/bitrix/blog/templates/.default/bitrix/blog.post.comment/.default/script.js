var B_open = 0;
var I_open = 0;
var U_open = 0;
var S_open = 0;
var QUOTE_open = 0;
var CODE_open = 0;
var CUT_open = 0;
var URL_open = 0;

var bbtags = new Array();

var clientPC = navigator.userAgent.toLowerCase(); 
var clientVer = parseInt(navigator.appVersion); 

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));

function quoteMessageEx(theAuthor)
{
	var selection;
	if (document.getSelection)
	{
		selection = document.getSelection();
		selection = selection.replace(/\r\n\r\n/gi, "_newstringhere_");
		selection = selection.replace(/\r\n/gi, " ");
		selection = selection.replace(/ /gi, "");
		selection = selection.replace(/_newstringhere_/gi, "\r\n\r\n");
	}
	else
	{
		selection = document.selection.createRange().text;
	}
	if (selection!="")
	{
		document.getElementById("comment").value += "[quote]"+theAuthor+":\n"+selection+"[/quote]\n";
	}
}

// Insert simple tags: B, I, U, CODE, QUOTE
function simpletag(thetag)
{
	var tagOpen = eval(thetag + "_open");

	if (tagOpen == 0)
	{
		if (doInsert("[" + thetag + "]", "[/" + thetag + "]", true))
		{
			eval(thetag + "_open = 1");
			// Change the button status

			pushstack(bbtags, thetag);
			cstat();
		}
	}
	else
	{
		// Find the last occurance of the opened tag
		lastindex = 0;

		for (i = 0 ; i < bbtags.length; i++ )
		{
			if ( bbtags[i] == thetag )
			{
				lastindex = i;
			}
		}

		// Close all tags opened up to that tag was opened
		while (bbtags[lastindex])
		{
			tagRemove = popstack(bbtags);
			doInsert("[/" + tagRemove + "]", "", false);

			// Change the button status
			eval(tagRemove + "_open = 0");
		}

		cstat();
	}
}

// Insert font tag
function alterfont(theval, thetag)
{
	if (theval == 0)
		return;

	if (doInsert("[" + thetag + "=" + theval + "]", "[/" + thetag + "]", true))
		pushstack(bbtags, thetag);

	document.getElementById("select_font").selectedIndex = 0;
	cstat();
	document.getElementById("comment").focus();
}

// Insert url tag
function tag_url()
{
	var textarea = document.form_comment.comment;
	var currentScroll = textarea.scrollTop;

	bTitleYes = false;
	if (is_ie)
	{
		textarea.focus();
		var sel = document.selection;
		var rng = sel.createRange();
		rng.colapse;
		if ((sel.type == "Text" || sel.type == "None") && rng != null)
		{
			bTitleYes = true;
		}
	}
	else 
	{
		if(textarea.selectionEnd > textarea.selectionStart)
			bTitleYes = true;
	}

	var enterURL = prompt(text_enter_url, "http://");

	if(bTitleYes)
	{
		if(enterURL)
		{
			if(is_ie)
				rng.text = '[URL='+enterURL+']'+rng.text+'[/URL]';
			else
				mozillaWr(textarea, '[URL='+enterURL+']', '[/URL]');
		}
		else
		{
			if(is_ie)
				rng.text = '[URL]'+rng.text+'[/URL]';
			else
				mozillaWr(textarea, '[URL]', '[/URL]');
		}
	}
	else
	{
		if (enterURL)
		{
			var enterTITLE = prompt(text_enter_url_name, "");
			if (!enterTITLE)
				enterTITLE=enterURL;	
			doInsert("[URL="+enterURL+"]"+enterTITLE+"[/URL]", "", false);
		}
	}
	
	textarea.scrollTop = currentScroll;
	textarea.focus();
}

// Insert image tag
function tag_image()
{
	var textarea = document.form_comment.comment;
	var currentScroll = textarea.scrollTop;

	var enterURL = prompt(text_enter_image, "http://");

	if (enterURL)
		doInsert("[IMG]"+enterURL+"[/IMG]", "", false);
	textarea.scrollTop = currentScroll;
	textarea.focus();
}

// Insert list tag
function tag_list()
{
	var textarea = document.form_comment.comment;
	var currentScroll = textarea.scrollTop;

	var listvalue = "init";
	var thelist = "[LIST]\n";

	while ( (listvalue != "") && (listvalue != null) && (listvalue != " ")) 
	{
		listvalue = prompt(list_prompt, "");
		if ( (listvalue != "") && (listvalue != null) && (listvalue != " ")) 
		{
			thelist = thelist+"[*]"+listvalue+"\n";
		}
	}

	doInsert(thelist + "[/LIST]\n", "", false);
	textarea.scrollTop = currentScroll;
	textarea.focus();
}

// Close all tags
function closeall()
{
	if (bbtags[0]) 
	{
		while (bbtags[0]) 
		{
			tagRemove = popstack(bbtags);
			document.form_comment.comment.value += "[/" + tagRemove + "]";

			if ( (tagRemove != 'FONT') && (tagRemove != 'SIZE') && (tagRemove != 'COLOR') )
			{
				eval(tagRemove + "_open = 0");
			}
		}
	}

	bbtags = new Array();
	cstat();
}

// Stack functions
function pushstack(thearray, newval)
{
	arraysize = stacksize(thearray);
	thearray[arraysize] = newval;
}

function popstack(thearray)
{
	arraysize = stacksize(thearray);
	theval = thearray[arraysize - 1];
	delete thearray[arraysize - 1];
	return theval;
}

function stacksize(thearray)
{
	for (i = 0 ; i < thearray.length; i++ )
	{
		if ( (thearray[i] == "") || (thearray[i] == null) || (thearray == 'undefined') ) 
		{
			return i;
		}
	}

	return thearray.length;
}

// Show statistic
function cstat()
{
	var c = stacksize(bbtags);

	if ( (c < 1) || (c == null) )
	{
		c = 0;
	}

	if ( ! bbtags[0] )
	{
		c = 0;
	}

	if (c > 0)
		document.getElementById("close_all").style.visibility="visible";
	else
		document.getElementById("close_all").style.visibility="hidden";
	document.form_comment.comment.focus();
}

addEvent(document, "mousedown", function(e){hidePicker();});
addEvent(document, "keypress", function(e){hidePicker();});
addEvent(document, "mousedown", function(e){hideSmiles();});
addEvent(document, "keypress", function(e){hideSmiles();});

var elem_id=0;

function addEvent(el, evname, func)
{
	if(el.attachEvent) // IE
		el.attachEvent("on" + evname, func);
	else if(el.addEventListener) // Gecko / W3C
		el.addEventListener(evname, func, false);
	else
		el["on" + evname] = func;
}
	
function GetStyleValue(el, styleProp)
{
	if(el.currentStyle)
		var res = el.currentStyle[styleProp];
	else if(window.getComputedStyle)
		var res = document.defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
	return res;
}
	
function GetRealPos(el)
{
	if(!el || !el.offsetParent)
		return false;
	var res=Array();
	res["left"] = el.offsetLeft;
	res["top"] = el.offsetTop;
	var objParent = el.offsetParent;
	while(objParent.tagName != "BODY")
	{
		if(GetStyleValue(objParent, 'position') == 'static')
		{
			res["left"] += objParent.offsetLeft;
			res["top"] += objParent.offsetTop;
		}
		objParent = objParent.offsetParent;
	}
	res["right"]=res["left"] + el.offsetWidth;
	res["bottom"]=res["top"] + el.offsetHeight;

	return res;
}

function hidePicker() 
{
	document.getElementById('ColorPick').style.visibility = "hidden";
}

function ColorPicker()
{
	try
	{
		var obj = document.getElementById("FontColor");

		res=GetRealPos(obj);
	
		document.getElementById('ColorPick').style.left=res["left"] + "px";
		document.getElementById('ColorPick').style.top=res["top"] + 20 + "px";
		document.getElementById('ColorPick').style.visibility = "visible";
	} catch(e){}
}

function hideSmiles() 
{
	document.getElementById('smilesPanel').style.visibility = "hidden";
}

function Smiles()
{
	try
	{
		var obj = document.getElementById("FontColor");

		res=GetRealPos(obj);
	
		var el = document.getElementById('smilesPanel');
		el.style.left=res["left"] + 110+ "px";
		el.style.top=res["top"] + "px";
		el.style.visibility = "visible";
	} catch(e){}
}

function emoticon(theSmilie)
{
	doInsert(" " + theSmilie + " ", "", false);
	/*
	sm = document.getElementById('smile'+id);
	smB = document.getElementById('smilebutton');
	smB.src = sm.src;
	smB.width = sm.width;
	smB.height = sm.height;
	*/
}


function mozillaWr(textarea, open, close)
{
	var selLength = textarea.textLength;
	var selStart = textarea.selectionStart;
	var selEnd = textarea.selectionEnd;
	
	if (selEnd == 1 || selEnd == 2)
	selEnd = selLength;

	var s1 = (textarea.value).substring(0,selStart);
	var s2 = (textarea.value).substring(selStart, selEnd)
	var s3 = (textarea.value).substring(selEnd, selLength);
	textarea.value = s1 + open + s2 + close + s3;

	textarea.selectionEnd = 0;
	textarea.selectionStart = selEnd + open.length + close.length;
	return;
}

function doInsert(ibTag, ibClsTag, isSingle)
{
	var isClose = false;
	var textarea = document.form_comment.comment;
	
	if (isSingle)
		isClose = true;

	var currentScroll = textarea.scrollTop;
	if (is_ie)
	{
		textarea.focus();
		var sel = document.selection;
		var rng = sel.createRange();
		rng.colapse;
		if ((sel.type == "Text" || sel.type == "None") && rng != null)
		{
			if (ibClsTag != "" && rng.text.length > 0)
			{
				ibTag += rng.text + ibClsTag;
				isClose = false;
			}

			rng.text = ibTag;
		}
	}
	else 
	{
		if (document.getElementById)
		{
			if (ibClsTag != "" && textarea.selectionEnd > textarea.selectionStart)
			{
				mozillaWr(textarea, ibTag, ibClsTag);
				isClose = false;
			}
			else 
				mozillaWr(textarea, ibTag, '');
		}
		else
			textarea.value += ibTag;
	}

	textarea.scrollTop = currentScroll;
	textarea.focus();
	return isClose;
}

function quoteMessage()
{
	var selection;
	
    if (window.getSelection && !window.opera)     
		selection = window.getSelection(); // ff
    else if (document.getSelection)             
		selection = document.getSelection(); // opera
    else if (document.selection)                 
		selection = document.selection.createRange().text; // ie

	if (selection=="")
	{
		simpletag("QUOTE");
	}
	else
	{	
		if (is_ie)
		{
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			
			postText = "[QUOTE]" + selection + "[/QUOTE]";

			var sel = document.selection.createRange();
			var selection_copy = sel.duplicate();
			postText = postText.replace(/\r?\n/g, '\r\n'); 
			if(sel.parentElement().name && sel.parentElement().name == "comment")
			{
				sel.text = postText;
				sel.setEndPoint('StartToStart', selection_copy); 
				sel.setEndPoint('EndToEnd', selection_copy); 
				sel.collapse(true);
				postText = postText.replace(/\r\n/g, '1');
				sel.moveEnd('character', postText.length);
				sel.select();
			}
			else
			{
				document.form_comment.comment.value += postText;
			}
		}
		else 
		{
			if (document.getElementById)
			{
				textarea = document.form_comment.comment;
				if (textarea.selectionEnd > textarea.selectionStart)
					mozillaWr(textarea, "[QUOTE]", "[/QUOTE]");
				else 
					mozillaWr(textarea, "[QUOTE]"+selection, '[/QUOTE]');
			}
		}

	}
		
	document.form_comment.comment.focus();
}

check_ctrl_enter = function(e)
{
	if(!e)
		e = window.event;

	if((e.keyCode == 13 || e.keyCode == 10) && e.ctrlKey)
	{
		document.form_comment.submit();
	}
}


if(document.attachEvent && !(navigator.userAgent.toLowerCase().indexOf('opera') != -1))
	var imgLoaded = false;
else
	var imgLoaded = true;
function imageLoaded()
{
	imgLoaded = true;
}
