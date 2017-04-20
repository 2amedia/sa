if (window.ShowWaitWindow == null)
{
	function ShowWaitWindow()
	{
		PShowWaitMessage();
		return false;
	}
}

if (window.CloseWaitWindow == null)
{
	function CloseWaitWindow()
	{
		PCloseWaitMessage();
		return false;
	}
}	

var pjsFloatDiv = new JCFloatDiv();
pjsFloatDiv.Show = function(div, left, top, dxShadow, bSubstrate, bIframe)
{
	var zIndex = parseInt(div.style.zIndex);
	if(zIndex <= 0 || isNaN(zIndex))
		zIndex = 100;
	div.style.zIndex = zIndex;
	div.style.left = left + "px";
	div.style.top = top + "px";

	if(jsUtils.IsIE() && bIframe != "N")
	{
		var frame = document.getElementById(div.id+"_frame");
		if(!frame)
		{
			frame = document.createElement("IFRAME");
			frame.src = "javascript:''";
			frame.id = div.id+"_frame";
			frame.style.position = 'absolute';
			frame.style.zIndex = zIndex-1;
			document.body.appendChild(frame);
		}
		frame.style.width = div.offsetWidth + "px";
		frame.style.height = div.offsetHeight + "px";
		frame.style.left = div.style.left;
		frame.style.top = div.style.top;
		frame.style.visibility = 'visible';
	}

	/*shadow*/
	if(isNaN(dxShadow))
		dxShadow = 5;
	if(dxShadow > 0)
	{
		var img = document.getElementById(div.id+'_shadow');
		if(!img)
		{
			if(jsUtils.IsIE())
			{
	 			img = document.createElement("DIV");
	 			img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+photoVars.templatePath+"images/shadow.png',sizingMethod='scale')";
			}
			else
			{
	 			img = document.createElement("IMG");
				img.src = photoVars.templatePath + 'images/shadow.png';
			}
			img.id = div.id+'_shadow';
			img.style.position = 'absolute';
			img.style.zIndex = zIndex-2;
			document.body.appendChild(img);
		}
		img.style.width = div.offsetWidth+'px';
		img.style.height = div.offsetHeight+'px';
		img.style.left = parseInt(div.style.left)+dxShadow+'px';
		img.style.top = parseInt(div.style.top)+dxShadow+'px';
		img.style.visibility = 'visible';
	}
	
	if (bSubstrate != "N")
	{
		var substrate = document.getElementById("photo_substrate");
		if(!substrate)
		{
			substrate = document.createElement("DIV");
			substrate.id = 	"photo_substrate";
			substrate.style.zIndex = zIndex-3;
			substrate.style.position = 	'absolute';
			substrate.style.display = 'none';
			substrate.style.visibility = 'hidden';
			substrate.style.background = 'white';
			substrate.style.opacity = '0.5';
			if (substrate.style.MozOpacity)
				substrate.style.MozOpacity = '0.5';
			else if (substrate.style.KhtmlOpacity)
				substrate.style.KhtmlOpacity = '0.5';
			if (jsUtils.IsIE())
			{
		 		substrate.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity=50)";
			}
			document.body.appendChild(substrate);
		}
		substrate.style.display = 'block';
		substrate.style.left = 0;
		substrate.style.top = 0;
		var WindowSize = jsUtils.GetWindowSize();
		substrate.style.width = WindowSize["scrollWidth"] + "px";
		substrate.style.height = WindowSize["scrollHeight"] + "px";
		substrate.style.visibility = 'visible';
	}
	return false;
}
		
pjsFloatDiv.Close = function(div)
{
	if(!div)
		return false;
	var sh = document.getElementById(div.id+"_shadow");
	if(sh)
		sh.style.visibility = 'hidden';

	var frame = document.getElementById(div.id+"_frame");
	if(frame)
		frame.style.visibility = 'hidden';
		
	var substrate = document.getElementById("photo_substrate");
	if(substrate)
	{
		substrate.style.display = 'none';
		substrate.style.visibility = 'hidden';
	}
	return false;
}
/************************************************/

function PhotoPopupMenu()
{
	var _this = this;
	this.active = null;
	
	this.PopupShow = function(div, pos)
	{
		this.PopupHide();
		if(!div)
			return false;
		if (typeof(pos) != "object")
			pos = {};
			
		this.active = div.id;
	    div.ondrag = jsUtils.False;
		
		jsUtils.addEvent(document, "keypress", _this.OnKeyPress);
		
		div.style.width = div.offsetWidth + 'px';
		div.style.visibility = 'visible';
		
		var res = jsUtils.GetWindowSize();
		pos['top'] = parseInt(res["scrollTop"] + res["innerHeight"]/2 - div.offsetHeight/2);
		pos['left'] = parseInt(res["scrollLeft"] + res["innerWidth"]/2 - div.offsetWidth/2);
		pjsFloatDiv.Show(div, pos["left"], pos["top"]);

/*	    div.onselectstart = jsUtils.False;
	    div.style.MozUserSelect = 'none';
	    
*/	
		return false;
	}

	this.PopupHide = function()
	{
		if (!_this.active || _this.active.length <= 0)
			return false;
		var div = document.getElementById(_this.active);
		if(div)
		{
			pjsFloatDiv.Close(div);
			div.parentNode.removeChild(div);
		}

		this.active = null;
//		jsUtils.removeEvent(document, "click", _this.CheckClick);
		jsUtils.removeEvent(document, "keypress", _this.OnKeyPress);
		return false;
	}

	this.CheckClick = function(e)
	{
		var div = document.getElementById(_this.active);
		
		if(!div)
		{
			return false;
		}

		if (div.style.visibility != 'visible')
			return false;
			
		if (!jsUtils.IsIE() && e.target.tagName == 'OPTION')
			return false;
			
		var x = e.clientX + document.body.scrollLeft;
		var y = e.clientY + document.body.scrollTop;

		/*menu region*/
		var posLeft = parseInt(div.style.left);
		var posTop = parseInt(div.style.top);
		var posRight = posLeft + div.offsetWidth;
		var posBottom = posTop + div.offsetHeight;
		if(x >= posLeft && x <= posRight && y >= posTop && y <= posBottom)
			return false;

		if(_this.controlDiv)
		{
			var pos = jsUtils.GetRealPos(_this.controlDiv);
			if(x >= pos['left'] && x <= pos['right'] && y >= pos['top'] && y <= pos['bottom'])
				return true;
		}
		_this.PopupHide();
		
		return false;
	}

	this.OnKeyPress = function(e)
	{
		if(!e) e = window.event
		if(!e) return false;
		if(e.keyCode == 27)
			_this.PopupHide();
		return;
	},

	this.IsVisible = function()
	{
		return (document.getElementById(this.active).style.visibility != 'hidden');
	}
}
var PhotoMenu = new PhotoPopupMenu();