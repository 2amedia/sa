(function() {

if (BX.Notifier)
	return;

BX.Notifier = function(domNode, params)
{
	this.settings = {};
	this.params = params || {};
	this.windowInnerSize = {};
	this.windowScrollPos = {};
	this.updateStateDisabled = false;
		
	this.panel = domNode;
	
	this.settings.messengerStatus = params.messengerStatus;
	
	this.settings.panelPosition = {};
	this.settings.panelPosition.horizontal = this.params.panelPosition.horizontal || 'right';
	this.settings.panelPosition.vertical = this.params.panelPosition.vertical || 'bottom';
	
	if (BX.browser.SupportLocalStorage())
	{
		var panelPosition = BX.localStorage.get('npp');
		this.settings.panelPosition.horizontal = !!panelPosition? panelPosition.h: this.settings.panelPosition.horizontal;
		this.settings.panelPosition.vertical = !!panelPosition? panelPosition.v: this.settings.panelPosition.vertical;
	}
	
	this.lfCount = params.lfCount;
	this.mailCount = params.mailCount;
	
	this.notify = params.notify;
	this.unreadNotify = params.unreadNotify;
	this.flashNotify = params.flashNotify;
	
	if (BX.browser.IsDoctype())
		BX.addClass(this.panel, 'bx-notifier-panel-doc');
	
	this.adjustPosition({resize: true});
	
	this.panelButtonNotify = BX.findChild(this.panel, {className : "bx-notifier-notify"}, true);
	this.panelButtonNotifyCount = BX.findChild(this.panelButtonNotify, {className : "bx-notifier-indicator-count"}, true);
	
	this.panelButtonMail = BX.findChild(this.panel, {className : "bx-notifier-mail"}, true);
	this.panelButtonMailCount = BX.findChild(this.panelButtonMail, {className : "bx-notifier-indicator-count"}, true);
	
	this.panelButtonLF = BX.findChild(this.panel, {className : "bx-notifier-lf"}, true);
	this.panelButtonLFCount = BX.findChild(this.panelButtonLF, {className : "bx-notifier-indicator-count"}, true);
	
	this.panelDragLabel = BX.findChild(this.panel, {className : "bx-notifier-drag"}, true);
	this.panelMenuIcon = BX.findChild(this.panel, {className : "bx-notifier-menu-icon"}, true);
	this.panelMenu = this.panelMenuIcon.parentNode;
	
	
	this.popupMenuItem = null;
	/* full window notify */
	this.popupNotifyItem = null;
	this.popupNotifyItemDomItems = null;
	this.popupNotifyItemDomWrap = null;
	this.popupNotifyItemScroll= null;
	this.popupNotifyTimeout = null;
	/* flash window notify */
	this.popupNewNotifyItem = null;
	this.popupNewNotifyItemDomItems = null;
	this.popupNewNotifyItemDomWrap = null;
	this.popupNewNotifyItemScroll= null;
	this.popupNewNotifyTimeout = null;
	/* flash window notify */
	this.popupNewMessageItem = null;
	this.popupNewMessageItemDomItems = null;
	this.popupNewMessageItemDomWrap = null;
	this.popupNewMessageItemScroll= null;
	this.popupNewMessageTimeout = null;	
	
	this.dragged = false;
    this.dragPageX = 0;
    this.dragPageY = 0;
	
	BX.bind(this.panelButtonNotify, "click", BX.proxy(this.openNotify, this));
	
	BX.bind(this.panelMenu, "contextmenu", BX.proxy(this.openMenu, this));
	
	BX.bind(this.panelDragLabel, "mousedown", BX.proxy(this._startDrag, this));
	
	BX.addCustomEvent(window, "onLocalStorageSet", BX.proxy(this.storageSet, this));
			
	BX.bind(window, "resize", BX.proxy(function(){this.adjustPosition({resize: true}); this.closePopup()}, this));	
	
	if (!BX.browser.IsDoctype())
		BX.bind(window, "scroll", BX.proxy(function(){this.adjustPosition({scroll: true}); this.adjustPopup()}, this));
	else
		BX.bind(window, "scroll", BX.proxy(function(){ this.adjustPopup() }, this));
	
	//this.updateState();
	this.updateNotifyCount();
	this.updateNotifyLFCount();
	this.updateNotifyMailCount();
	this.adjustPosition({resize: true});
	
	this.setStatus(params.messengerStatus, false);
	//this.openNotify();
	//this.newNotify();
	//this.newMessage();
};

BX.Notifier.prototype.updateState = function()
{
	setTimeout(
		BX.proxy(function(){
			if (!this.updateStateDisabled)
			{
				BX.ajax({url:'https://cp.bitrix.ru/bitrix/components/bitrix/rating.vote/vote.ajax.php',method:'POST',dataType:'json',data:{}});
				BX.localStorage.set('nud', true, 5);
				
				var data = {};
				data.unreadNotify = [1017, 1016, 1012];
				data.countLF = 2;
				data.countMail = 1;
					
				this.updateNotifyLFCount(data.countLF);
				this.updateNotifyMailCount(data.countMail);			
				this.changeUnreadMessage(data.unreadNotify);
			}
			this.updateStateDisabled = false;
			
			this.updateState();
		}, this)
	, 5000);
};

BX.Notifier.prototype.updateNotifyLFCount = function(count)
{	
	if (count != undefined)
		this.lfCount = parseInt(count);
		
	if (this.lfCount > 0)
		BX.removeClass(this.panelButtonLF, 'bx-notifier-hide');
	else
		BX.addClass(this.panelButtonLF, 'bx-notifier-hide');
		
	this.panelButtonLFCount.innerHTML = this.lfCount;
}

BX.Notifier.prototype.updateNotifyMailCount = function(count)
{	
	if (count != undefined)
		this.mailCount = parseInt(count);

	if (this.mailCount > 0)
		BX.removeClass(this.panelButtonMail, 'bx-notifier-hide');
	else
		BX.addClass(this.panelButtonMail, 'bx-notifier-hide');
		
	this.panelButtonMailCount.innerHTML = this.mailCount;
}

BX.Notifier.prototype.updateNotifyCount = function()
{	
	var count = 0;
	for (var i in this.notify)
		count++;
		
	if (count > 0)
		BX.removeClass(this.panelButtonNotify, 'bx-notifier-hide');
	else
		BX.addClass(this.panelButtonNotify, 'bx-notifier-hide');
		
	this.panelButtonNotifyCount.innerHTML = count;
}

BX.Notifier.prototype.changeUnreadMessage = function(unreadNotify)
{

	if (this.settings.messengerStatus != 'dnd')
	{
		for (var i = 0; i < unreadNotify.length; i++) 
			if (this.unreadNotify[i] == undefined)
				this.flashNotify[i] = unreadNotify[i];
		
		this.newNotify();
	}
	this.unreadNotify = unreadNotify;
	this.updateNotifyCount();
}


BX.Notifier.prototype.newNotify = function(send)
{
	send = send == false? false: true;
	this.closePopup();
	
	if (this.settings.messengerStatus == 'dnd')
		return false;
	
	var arNotify = [];
	for (var i in this.flashNotify)
	{
		var notify = BX.Notifier.createNotify(this.notify[this.flashNotify[i]]);
		if (notify !== false)
			arNotify.push(notify);
	}
	if (arNotify.length == 0)
		return false;
		
	this.popupNewNotifyItem = new BX.PopupWindow('bx-notifier-popup-new-notify', this.panelButtonNotify, {
		lightShadow : true,
		offsetTop: -3,
		offsetLeft: 16,
		autoHide: false,
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.proxy(function() { this.popupNewNotifyItem = null; }, this)
		},
		titleBar: {content: BX.create('span', {props : { className : "bx-notifier-notify-title" }, html: 'Novoe sobitie'})},
		closeIcon : {'marginTop': '5px', 'marginRight': '0px'},
		content : this.popupNewNotifyItemDomItems = BX.create("div", { props : { className : "bx-notifier-items" }, children : [BX.create("div", { props : { className : "bx-notifier-items-wrap" }, children: arNotify})]})
	});
	this.popupNewNotifyItem.setAngle({});
	this.popupNewNotifyItem.show();
	
	this.popupNewNotifyItemScroll = new BXScrollbar(this.popupNewNotifyItemDomItems);
	
	this.popupNewNotifyItemDomWrap = BX.findChild(this.popupNewNotifyItemDomItems, {className : "bx-notifier-items-wrap"}, true);
	
	// click to button from notify item
	BX.bindDelegate(this.popupNewNotifyItemDomItems, 'click', {className: 'bx-notifier-item-button'}, BX.proxy(function(e) {
		button = {};
		button.id = BX.proxy_context.getAttribute('data-id');
		button.value = BX.proxy_context.getAttribute('data-value');
		
		delete this.notify[button.id];
		this.updateNotifyCount();
		/* AJAX */
		BX.fx.hide(BX.proxy_context.parentNode.parentNode.parentNode, 'scroll', {time: 0.5, step: 0.01, direction: 'vertical', callback_complete: BX.proxy(function(){
			/* remove notification */
			BX.remove(this.parentNode.parentNode.parentNode);
		}, BX.proxy_context)});
		
		setTimeout(BX.proxy(function(){this.newNotifyResize()}, this), 600);
	}, this));
	
	
	BX.bindDelegate(this.popupNotifyItemDomItems, 'click', {className: 'bx-notifier-item-action'}, function(e) {
		/* remove notification */
	});
		
	this.newNotifyResize();
	
	clearTimeout(this.popupNotifyTimeout);
	BX.fx.show(this.popupNewNotifyItem.popupContainer, 'fade', {time: 0.6, step: 0.01});
	this.popupNotifyTimeout = setTimeout(BX.proxy(function(){
		if (this.popupNewNotifyItem != null)
			BX.fx.hide(this.popupNewNotifyItem.popupContainer, 'fade', {time: 0.6, step: 0.01, callback_complete: BX.proxy(function(){this.popupNewNotifyItem.close()}, this)})
	}, this), 3000);
	BX.bind(this.popupNewNotifyItemDomItems, "mouseover", BX.proxy(function() { clearTimeout(this.popupNotifyTimeout) }, this));
	
	if (send)
		BX.localStorage.set('nnn', true, 5);
		
	this.flashNotify = {};	
};

BX.Notifier.prototype.newNotifyResize = function(event)
{
	if (this.popupNewNotifyItem == null)
		return false;

	if (parseInt(BX.style(this.popupNewNotifyItemDomItems, 'height')) < this.popupNewNotifyItemDomWrap.offsetHeight)
	{
		this.popupNewNotifyItemScroll.reDraw();
		return false;
	}
		
	if (this.popupNewNotifyItemDomWrap.offsetHeight < 10)
		this.popupNewNotifyItem.close();
	else
	{
		BX.style(this.popupNewNotifyItemDomItems, 'height', this.popupNewNotifyItemDomWrap.offsetHeight+'px');
		
		this.popupNewNotifyItem.bindOptions.forceBindPosition = true;
		this.popupNewNotifyItem.adjustPosition();	
		this.popupNewNotifyItem.bindOptions.forceBindPosition = false;
		this.popupNewNotifyItemScroll.reDraw();
	}
}


BX.Notifier.prototype.openNotify = function(event)
{
	if (this.popupNotifyItem !== null)
	{
		this.closePopup();
		return false;
	}
	this.closePopup();
	

	var arNotify = [];
	for (var i in this.notify)
	{
		var notify = BX.Notifier.createNotify(this.notify[i]);
		if (notify !== false)
			arNotify.push(notify);
	}
		
	if (arNotify.length == 0)
		return false;
	
	this.popupNotifyItem = new BX.PopupWindow('bx-notifier-popup-notify', this.panelButtonNotify, {
		lightShadow : true,
		offsetTop: -3,
		offsetLeft: 16,
		autoHide: true,
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.proxy(function() { this.popupNotifyItem = null; }, this)
		},
		titleBar: {content: BX.create('span', {props : { className : "bx-notifier-notify-title" }, html: 'Sobitiya'})},
		closeIcon : {'marginTop': '5px', 'marginRight': '0px'},
		content : this.popupNotifyItemDomItems = BX.create("div", { props : { className : "bx-notifier-items" }, children : [BX.create("div", { props : { className : "bx-notifier-items-wrap" }, children: arNotify})]})
	});
	this.popupNotifyItem.setAngle({});
	this.popupNotifyItem.show();

	this.popupNotifyItemScroll = new BXScrollbar(this.popupNotifyItemDomItems);
	
	this.popupNotifyItemDomWrap = BX.findChild(this.popupNotifyItemDomItems, {className : "bx-notifier-items-wrap"}, true);
	
	// click to button from notify item
	BX.bindDelegate(this.popupNotifyItemDomItems, 'click', {className: 'bx-notifier-item-button'}, BX.proxy(function(e) {
		button = {};
		button.id = BX.proxy_context.getAttribute('data-id');
		button.value = BX.proxy_context.getAttribute('data-value');
		
		delete this.notify[button.id];
		this.updateNotifyCount();
		
		/* AJAX */
		BX.fx.hide(BX.proxy_context.parentNode.parentNode.parentNode, 'scroll', {time: 0.5, step: 0.01, direction: 'vertical', callback_complete: BX.proxy(function(){
			/* remove notification */
			
			BX.remove(this.parentNode.parentNode.parentNode);
		}, BX.proxy_context)});
		
		setTimeout(BX.proxy(function(){this.notifyResize()}, this), 600);
	}, this));
	
	BX.bindDelegate(this.popupNotifyItemDomItems, 'click', {className: 'bx-notifier-item-action'}, function(e) {
		/* remove notification */
	});
	
	// click to delete circle
	BX.bindDelegate(this.popupNotifyItemDomItems, 'click', {className: 'bx-notifier-item-delete'}, BX.proxy(function(e) {	
		/* AJAX */
		delete this.notify[BX.proxy_context.getAttribute('data-id')];
		this.updateNotifyCount();
		BX.fx.hide(BX.proxy_context.parentNode, 'scroll', {time: 0.5, step: 0.01, direction: 'vertical', callback_complete: BX.proxy(function(){
			/* remove notification */
			
			BX.remove(this.parentNode);
		}, BX.proxy_context)});
		
		setTimeout(BX.proxy(function(){this.notifyResize()}, this), 600);
	}, this));
	
	BX.bindDelegate(this.popupNotifyItemDomItems, 'mouseover', {className: 'bx-notifier-item'}, function(e) {
		BX.addClass(this, 'bx-notifier-item-hover');
		return BX.PreventDefault(e);
	});	
	BX.bindDelegate(this.popupNotifyItemDomItems, 'mouseout', {className: 'bx-notifier-item'}, function(e) {
		BX.removeClass(this, 'bx-notifier-item-hover');
		return BX.PreventDefault(e);
	});
	
	this.notifyResize();
};

BX.Notifier.prototype.notifyResize = function(event)
{
	if (this.popupNotifyItem == null)
		return false;

	if (parseInt(BX.style(this.popupNotifyItemDomItems, 'height')) < this.popupNotifyItemDomWrap.offsetHeight)
	{
		this.popupNotifyItemScroll.reDraw();
		return false;
	}
		
	if (this.popupNotifyItemDomWrap.offsetHeight < 10)
		this.popupNotifyItem.close();
	else
	{
		BX.style(this.popupNotifyItemDomItems, 'height', this.popupNotifyItemDomWrap.offsetHeight+'px');
		
		this.popupNotifyItem.bindOptions.forceBindPosition = true;
		this.popupNotifyItem.adjustPosition();	
		this.popupNotifyItem.bindOptions.forceBindPosition = false;
		this.popupNotifyItemScroll.reDraw();
	}
}

BX.Notifier.prototype.openMenu = function(event)
{
	this.closePopup();
	
	menuItems = [
		{icon: 'bx-notifier-status-online', text: BX.message("IM_STATUS_ONLINE"), onclick: BX.proxy(function(){ this.setStatus('online'); this.popupMenuItem.destroy(); }, this)},
		{icon: 'bx-notifier-status-dnd', text: BX.message("IM_STATUS_DND"), onclick: BX.proxy(function(){ this.setStatus('dnd'); this.popupMenuItem.destroy(); }, this)}
	];
		
	this.popupMenuItem = new BX.PopupWindow('bx-notifier-popup-menu', this.panelMenu, {
		lightShadow : true,
		offsetTop: -3,
		offsetLeft: 14,
		autoHide: true,
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() {},
			onPopupDestroy : BX.proxy(function() { this.popupMenuItem = null; }, this)
		},
		content : BX.create("div", { props : { className : "bx-notifier-popup-menu" }, children: [
			BX.create("div", { props : { className : "bx-notifier-popup-menu-items" }, children: BX.Notifier.MenuPreprareList(this.panelMenu, menuItems)})
		]})
	});
	this.popupMenuItem.setAngle({});
	this.popupMenuItem.show();

	return BX.PreventDefault(event);
};

BX.Notifier.MenuPreprareList = function(element, menuItems)
{
	var items = [];
	for (var i = 0; i < menuItems.length; i++) 
	{

		var item = menuItems[i];
		if (!item.text || !BX.type.isNotEmptyString(item.text))
			continue;

		if (i > 0)
			items.push(BX.create("div", { props : { className : "popup-window-hr" }, children : [ BX.create("i", {}) ]}));

		var a = BX.create("a", {
			props : { className: "bx-notifier-popup-menu-item" +  (BX.type.isNotEmptyString(item.className) ? " " + item.className : "")},
			attrs : { title : item.title ? item.title : ""},
			events : item.onclick && BX.type.isFunction(item.onclick) ? { click : BX.proxy(item.onclick, element) } : null,
			html :  '<span class="bx-notifier-popup-menu-item-left"></span>'+(item.icon? '<span class="bx-notifier-popup-menu-item-icon '+item.icon+'"></span>':'')+'<span class="bx-notifier-popup-menu-item-text">' + item.text + '</span><span class="bx-notifier-popup-menu-right"></span>'
		});

		if (item.href)
			a.href = item.href; 
		items.push(a);
	}
	return items;
};
BX.Notifier.prototype.setStatus = function(status, send)
{	
	send = send == false? false: true;
	if (!BX.hasClass(this.panelMenuIcon, 'bx-notifier-status-'+status))
	{
		this.panelMenuIcon.className = 'bx-notifier-menu-icon bx-notifier-status-'+status;
		
		this.settings.messengerStatus = status;
		
		if (send)
		{
			BX.onCustomEvent(this, 'onNotifierStatusChange', [status]);
			BX.localStorage.set('nms', status, 5);
		}
	}
};

BX.Notifier.prototype.adjustPosition = function(params)
{	
	params = params || {};
	params.scroll = params.scroll || !BX.browser.IsDoctype();
	params.resize = params.resize || false;

	if (!this.windowScrollPos.scrollLeft)
		this.windowScrollPos = {scrollLeft : 0, scrollTop : 0};
	if (params.scroll)
		this.windowScrollPos = BX.GetWindowScrollPos();

	if (params.resize || !this.windowInnerSize.innerWidth)
		this.windowInnerSize = BX.GetWindowInnerSize();
		
	if (params.scroll || params.resize)
	{
		if (this.settings.panelPosition.horizontal == 'left')
			this.panel.style.left = (this.windowScrollPos.scrollLeft+25)+'px';
		else if (this.settings.panelPosition.horizontal == 'center')
			this.panel.style.left = (this.windowScrollPos.scrollLeft+this.windowInnerSize.innerWidth-this.panel.offsetWidth)/2+'px';
		else if (this.settings.panelPosition.horizontal == 'right')
			this.panel.style.left = (this.windowScrollPos.scrollLeft+this.windowInnerSize.innerWidth-this.panel.offsetWidth-35)+'px';
			
		if (this.settings.panelPosition.vertical == 'top')	
		{
			this.panel.style.top = (this.windowScrollPos.scrollTop)+'px';
			if (BX.hasClass(this.panel, 'bx-notifier-panel-doc'))
				this.panel.className = 'bx-notifier-panel bx-notifier-panel-top bx-notifier-panel-doc';
			else
				this.panel.className = 'bx-notifier-panel bx-notifier-panel-top';
		}
		else if (this.settings.panelPosition.vertical == 'bottom')	
		{
			if (BX.hasClass(this.panel, 'bx-notifier-panel-doc'))
				this.panel.className = 'bx-notifier-panel bx-notifier-panel-bottom bx-notifier-panel-doc';
			else
				this.panel.className = 'bx-notifier-panel bx-notifier-panel-bottom';
			
			this.panel.style.top = (this.windowScrollPos.scrollTop+this.windowInnerSize.innerHeight-this.panel.offsetHeight)+'px';
		}
	}
};

BX.Notifier.prototype.move = function(offsetX, offsetY)
{
	var left = parseInt(this.panel.style.left) + offsetX;
	var top = parseInt(this.panel.style.top) + offsetY;

	if (left < 0)
		left = 0;

	var scrollSize = BX.GetWindowScrollSize();
	var floatWidth = this.panel.offsetWidth;
	var floatHeight = this.panel.offsetHeight;

	if (left > (scrollSize.scrollWidth - floatWidth))
		left = scrollSize.scrollWidth - floatWidth;

	if (top > (scrollSize.scrollHeight - floatHeight))
		top = scrollSize.scrollHeight - floatHeight;

	if (top < 0)
		top = 0;

	this.panel.style.left = left + "px";
	this.panel.style.top = top + "px";
};
BX.Notifier.prototype._startDrag = function(event)
{
	event = event || window.event;
    BX.fixEventPageXY(event);

	this.dragPageX = event.pageX;
	this.dragPageY = event.pageY;
	this.dragged = false;

	this.closePopup();
	
	BX.bind(document, "mousemove", BX.proxy(this._moveDrag, this));
	BX.bind(document, "mouseup", BX.proxy(this._stopDrag, this));
	
	if (document.body.setCapture)
		document.body.setCapture();

	//document.onmousedown = BX.False;
	document.body.ondrag = BX.False;
	document.body.onselectstart = BX.False;
    document.body.style.cursor = "move";
    document.body.style.MozUserSelect = "none";
    this.panel.style.MozUserSelect = "none";
	BX.addClass(this.panel, "bx-notifier-panel-drag-"+(this.settings.panelPosition.vertical == 'top'? 'top': 'bottom'));

	/* TODO: drag spirit  */
	
	return BX.PreventDefault(event);
};

BX.Notifier.prototype._moveDrag = function(event)
{
	event = event || window.event;
	BX.fixEventPageXY(event);
		
	if(this.dragPageX == event.pageX && this.dragPageY == event.pageY)
		return;
		
	this.move((event.pageX - this.dragPageX), (event.pageY - this.dragPageY));
	this.dragPageX = event.pageX;
	this.dragPageY = event.pageY;

	if (!this.dragged)
	{
		BX.onCustomEvent(this, "onPopupDragStart");
		this.dragged = true;
	}

	BX.onCustomEvent(this, "onPopupDrag");
};

BX.Notifier.prototype._stopDrag = function(event)
{
	if(document.body.releaseCapture)
		document.body.releaseCapture();	
		
	BX.unbind(document, "mousemove", BX.proxy(this._moveDrag, this));
	BX.unbind(document, "mouseup", BX.proxy(this._stopDrag, this));

	//document.onmousedown = null;
    document.body.ondrag = null;
    document.body.onselectstart = null;
    document.body.style.cursor = "";
    document.body.style.MozUserSelect = "";
    this.panel.style.MozUserSelect = "";
	BX.removeClass(this.panel, "bx-notifier-panel-drag-"+(this.settings.panelPosition.vertical == 'top'? 'top': 'bottom'));	
	BX.onCustomEvent(this, "onPopupDragEnd");

	var windowScrollPos = BX.GetWindowScrollPos();
	this.settings.panelPosition.vertical = (this.windowInnerSize.innerHeight/2 > (event.pageY - windowScrollPos.scrollTop||event.y))? 'top' : 'bottom';
	if (this.windowInnerSize.innerWidth/3 > (event.pageX- windowScrollPos.scrollLeft||event.x))
		this.settings.panelPosition.horizontal = 'left';
	else if (this.windowInnerSize.innerWidth/3*2 < (event.pageX - windowScrollPos.scrollLeft||event.x))
		this.settings.panelPosition.horizontal = 'right';	
	else 
		this.settings.panelPosition.horizontal = 'center';

	BX.userOptions.save('IM', 'settings', 'panelPositionVertical', this.settings.panelPosition.vertical);	
	BX.userOptions.save('IM', 'settings', 'panelPositionHorizontal', this.settings.panelPosition.horizontal);	
		
	BX.localStorage.set('npp', {v: this.settings.panelPosition.vertical, h: this.settings.panelPosition.horizontal});
	
	this.adjustPosition({resize: true});

	this.dragged = false;
	
	return BX.PreventDefault(event);
};

BX.Notifier.prototype.closePopup = function(event)
{
	if (this.popupMenuItem !== null)
		this.popupMenuItem.destroy();
	if (this.popupNewMessageItem !== null)
		this.popupNewMessageItem.destroy();	
	if (this.popupNotifyItem !== null)
		this.popupNotifyItem.destroy();	
	if (this.popupNewNotifyItem !== null)
		this.popupNewNotifyItem.destroy();
};

BX.Notifier.prototype.adjustPopup = function(event)
{
	if (this.popupMenuItem !== null)
		this.popupMenuItem.adjustPosition();	
	if (this.popupNewMessageItem !== null)
		this.popupNewMessageItem.adjustPosition();
	if (this.popupNotifyItem !== null)
		this.popupNotifyItem.adjustPosition();		
	if (this.popupNewNotifyItem !== null)
		this.popupNewNotifyItem.adjustPosition();	
};
BX.Notifier.createNotify = function(notify)
{
	var element = false;
	if (notify.type == 1)
	{
		var arButtons = [];
		for (var i = 0; i < notify.buttons.length; i++) 
			arButtons.push(BX.create('span', {props : { className : "bx-notifier-item-button bx-notifier-item-button-"+notify.buttons[i].type }, attrs : { 'data-id' : notify.id, 'data-value' : notify.buttons[i].value}, html: '<i></i><span>'+notify.buttons[i].title+'</span><i></i>'}));
		
		element = BX.create("div", {props : { className: "bx-notifier-item"}, children : [
			BX.create("div", {props : { className: "bx-notifier-item-wrap"}, children : [
				BX.create('span', {props : { className : "bx-notifier-item-confirm-text" }, html: notify.text}),
				BX.create('span', {props : { className : "bx-notifier-item-confirm-date" }, children : [
					BX.create('span', {props : { className : "bx-notifier-item-confirm-date-text" }, html: notify.dateText}),
					BX.create('span', {props : { className : "bx-notifier-item-confirm-date-number" }, html: BX.Notifier.FormatDate(notify.date)})
				]}),
				BX.create('span', {props : { className : "bx-notifier-item-confirm-button" }, children : arButtons}),
				BX.create('span', {props : { className : "bx-notifier-item-confirm-clear" }})
			]})
		]});
	}
	else if (notify.type == 2)
	{
		element = BX.create("div", {props : { className: "bx-notifier-item"}, children : [
			BX.create("a", {attrs : {href : '#', 'data-id' : notify.id}, props : { className: "bx-notifier-item-delete"}}),
			BX.create("div", {props : { className: "bx-notifier-item-wrap"}, children : [
				BX.create('span', {props : { className : "bx-notifier-item-avatar" }, children : [
					BX.create('img', {attrs : {src : notify.userAvatar}})
				]}),
				BX.create('span', {props : { className : "bx-notifier-item-content" }, children : [
					BX.create('span', {props : { className : "bx-notifier-item-date" }, html: BX.Notifier.FormatDate(notify.date)}),
					BX.create('span', {props : { className : "bx-notifier-item-name" }, html: '<a href="'+notify.userLink+'">'+notify.userName+'</a>'}),
					BX.create('span', {props : { className : "bx-notifier-item-text" }, html: notify.text})
				]})
			]})
		]});
		
	}
	else if (notify.type == 3)
	{
		element = BX.create("div", {props : { className: "bx-notifier-item"}, children : [
			BX.create("a", {attrs : {href : '#', 'data-id' : notify.id}, props : { className: "bx-notifier-item-delete"}}),
			BX.create("div", {props : { className: "bx-notifier-item-wrap"}, children : [
				BX.create('span', {props : { className : "bx-notifier-item-avatar bx-notifier-item-avatar-group" }, children : [
					BX.create('img', {attrs : {src : notify.userAvatar}})
				]}),
				BX.create('span', {props : { className : "bx-notifier-item-content" }, children : [
					BX.create('span', {props : { className : "bx-notifier-item-date" }, html: BX.Notifier.FormatDate(notify.date)}),
					BX.create('span', {props : { className : "bx-notifier-item-name" }, html: '<a href="'+notify.userLink+'">'+notify.userName+'</a> i eshe '+notify.otherCount+' chelovek(a)'}),
					BX.create('span', {props : { className : "bx-notifier-item-text" }, html: notify.text})
				]})
			]})
		]});
	}
	return element;
}
BX.Notifier.FormatDate = function(timestamp)
{
	var format = [
		["tommorow", "tommorow, H:i"],
		["today", "today, H:i"],
		["yesterday", "yesterday, H:i"],
		["", BX.date.convertBitrixFormat(BX.message("FORMAT_DATETIME"))]
	];

	return BX.date.format(format, timestamp);
}
BX.Notifier.prototype.storageSet = function(params)
{		
    if (params.key == 'npp') 
	{
		panelPosition = BX.localStorage.get(params.key);
		this.settings.panelPosition.horizontal = !!panelPosition? panelPosition.h: this.settings.panelPosition.horizontal;
		this.settings.panelPosition.vertical = !!panelPosition? panelPosition.v: this.settings.panelPosition.vertical;
		this.adjustPosition({resize: true});
    } 
	else if (params.key == 'nms')
	{
		this.setStatus(params.value, false);
	}
	else if (params.key == 'nud')
	{
		this.updateStateDisabled = true;
	}
	else if (params.key == 'nnn')
	{
		this.newNotify(false);
	}
};

})();