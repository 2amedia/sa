(function() {

if (BX.Messenger)
	return;

BX.Messenger = function(obNotifier, params)
{
	this.settings = {};
	this.params = params || {};
	
	this.updateStateVeryFastCount = 0; 
	this.updateStateFastCount = 0; 
	this.updateStateStep = 60; 
	this.updateStateTimeout = null;
		
	this.notifier = obNotifier;
	
	this.settings.userId = params.userId;
	this.settings.status = params.status;
	this.settings.viewOffline = params.viewOffline;
	this.settings.viewGroup = params.viewGroup;
	
	this.users = params.users;
	this.groups = params.groups;
	this.userInGroup = params.userInGroup;
	this.woGroups = params.woGroups;
	this.woUserInGroup = params.woUserInGroup;
	this.currentTab = params.currentTab;
	this.openTab = params.openTab;
	this.redrawTab = {};
	this.showMessage = params.showMessage;
	this.unreadMessage = params.unreadMessage;
	this.flashMessage = params.flashMessage;
	this.message = params.message;
	this.messageTmpIndex = 0;
	this.history = params.history;
	this.textareaHistory = {};
	this.textareaHistoryTimeout = null;
	this.messageCount = 0;
	this.forceLoadMessage = true;
	
	this.windowHead = document.getElementsByTagName("head")[0];
	this.windowTitle = document.title;
	this.windowFavicon = null;
	this.windowFaviconTimeout = null;

	this.popupNewMessageItem = null;
	this.popupNewMessageItemDomItems = null;
	this.popupNewMessageItemScroll = null;
	this.popupNewMessageItemDomWrap = null;
	this.popupNewMessageTimeout = null;
	
	this.popupHistory = null;
	this.popupHistoryElements = null;
	this.popupHistoryItems = null;
	this.popupHistoryScroll = null;
	this.popupHistoryBodyWrap = null;
	this.popupHistoryPage = null;
	this.popupHistorySearchInput = null;
	this.historySearch = '';
	this.historySearchTimeout = null;
	
	this.popupMessenger = null;
	this.popupMessengerElements = null;
	this.popupMessengerBody = null;
	this.popupMessengerScroll = null;
	this.popupMessengerBodyWrap = null;
	this.popupMessengerContentCurrent = null;
	this.popupMessengerTextareaPlace = null;
	this.popupMessengerTextarea = null;
		
	this.popupMessengerTabs = null;
	this.popupMessengerTabsByUser = {};
	this.popupMessengerTabsContent = null;
	this.popupMessengerTabsContentByUser = {};

	this.contactListPanel = null;
	this.contactListPanelStatus = null;
	this.contactListSearch = '';
	
	this.popupStatusMenu = null;
	
	this.openMessengerFlag = false;
	this.openContactListFlag = false;
	
	this.updateStateDisabled = null;
	
	this.popupContactList = null;
	this.popupContactListSearchInput = null;
	this.popupContactListFocus = false;
	this.popupContactListWrap = null;
	this.popupContactListElements = null;
	this.popupContactListElementsWrap = null;
	this.popupContactListScroll = null;
	this.popupContactListSearch = null;
	this.popupContactListSearchKey = null;
	
	this.popupContactListMenu = null;
	
	this.panelButtonMessage = BX.findChild(this.notifier.panel, {className : "bx-notifier-message"}, true);
	this.panelButtonMessageCount = BX.findChild(this.panelButtonMessage, {className : "bx-notifier-indicator-count"}, true);
		
	BX.bind(this.panelButtonMessage, "click", BX.delegate(function(e){
		if (this.messageCount <= 0 && this.popupMessenger != null)
			this.popupMessenger.close();
		else
			this.openMessenger(null);
		return BX.PreventDefault(e);
	}, this));
	
	BX.bind(this.notifier.panelMenu, "click", BX.delegate(function(e){
		this.openContactList();
		return BX.PreventDefault(e);
	}, this));
	
	if (BX.browser.SupportLocalStorage())
	{
		BX.addCustomEvent(window, "onLocalStorageSet", BX.delegate(this.storageSet, this));
		BX.addCustomEvent(this.notifier, "onNotifierStatusChange", BX.delegate(this.setStatus, this));
		this.textareaHistory = BX.localStorage.get('mtah') || {};
		this.openContactListFlag = BX.localStorage.get('mclo') || false;
		this.openMessengerFlag = BX.localStorage.get('mmo') || false;
		this.currentTab = BX.localStorage.get('mct') || this.currentTab;
		this.openTab = BX.localStorage.get('mot') || this.openTab;
		this.contactListSearch = BX.localStorage.get('mcls') || '';
		
		var mcth = BX.localStorage.get('mcth');
		if (mcth)
		{
			if (this.history[this.currentTab] == undefined)
				this.history[this.currentTab] = [];
				
			for (var i = 0; i < mcth.length; i++) 
				this.history[this.currentTab].push(mcth[i]);
				
			this.history[this.currentTab] = BX.util.array_unique(this.history[this.currentTab]);
		}
		
		var mctsm = BX.localStorage.get('mctsm');
		if (mctsm)
		{
			if (this.showMessage[this.currentTab] == undefined)
				this.showMessage[this.currentTab] = [];
				
			for (var i = 0; i < mctsm.length; i++) 
				this.showMessage[this.currentTab].push(mctsm[i]);
				
			this.showMessage[this.currentTab] = BX.util.array_unique(this.showMessage[this.currentTab]);
			this.showMessage[this.currentTab].sort();
		}
		
		var mctm = BX.localStorage.get('mctm');
		if (mctm)
		{
			for (var i in mctm)
			{
				this.message[i] = mctm[i];
			}
		}
	}

	BX.bind(window, "scroll", BX.delegate(function(){ this.adjustPopup() }, this));
	
	//BX.bind(document, "click", BX.delegate(function(){
	//	this.contactListFocusOut();
	//}, this));
	
	BX.garbage(function(){
		BX.localStorage.set('mtah', this.textareaHistory, 15);
		BX.localStorage.set('mclo', (this.popupContactList? true: false), 15);
		BX.localStorage.set('mmo', (this.popupMessenger? true: false), 15);
		BX.localStorage.set('mct', this.currentTab, 15);
		BX.localStorage.set('mot', this.openTab, 15);
		BX.localStorage.set('mcth', this.history[this.currentTab], 15);
		BX.localStorage.set('mctsm', this.showMessage[this.currentTab], 15);
		BX.localStorage.set('mcls', this.contactListSearch, 15);
		var sendMessage = {};
		if (this.showMessage[this.currentTab])
		{
			for (var i = 0; i < this.showMessage[this.currentTab].length; i++) 
			{
				sendMessage[this.showMessage[this.currentTab][i]] = this.message[this.showMessage[this.currentTab][i]];
				BX.localStorage.set('mctm', sendMessage, 15);
			}
		}
	}, this);
	
	this.updateState();
	this.updateMessageCount();
	setTimeout(BX.delegate(function(){
		this.newMessage();
	}, this), 1000);
	

	if (this.openContactListFlag)
		this.openContactList();
		
	if (this.openMessengerFlag)
		this.openMessenger(this.currentTab);
	
	//this.openHistory(1);
	//this.notifier.newMessage();
};

BX.Messenger.prototype.setStatus = function(status, send)
{	
	send = send == false? false: true;
	if (!BX.hasClass(this.contactListPanelStatus, 'bx-messenger-cl-panel-status-'+status))
	{
		this.contactListPanelStatus.className = 'bx-messenger-cl-panel-status-wrap bx-messenger-cl-panel-status-'+status;
		
		this.settings.status = status;
		
		var statusText = BX.findChild(this.contactListPanelStatus, {className : "bx-messenger-cl-panel-status-text"}, true);
		
		statusText.innerHTML = BX.message("IM_STATUS_"+status.toUpperCase());
		
		if (send)
		{
			BX.userOptions.save('IM', 'settings', 'status', status);
			this.notifier.setStatus(status);
			BX.onCustomEvent(this, 'onMessengerStatusChange', [status]);
			BX.localStorage.set('mms', status, 5);
		}
	}
};

BX.Messenger.prototype.setUpdateStateStep = function()
{
	var force = false;
	var step = 60;
	if (this.popupContactList != null)
		step = 30;
	if (this.popupMessenger != null)
	{
		step = 20; //todo
		if (this.updateStateVeryFastCount > 0)
		{
			step = 5;
			this.updateStateVeryFastCount--;
		}
		else if (this.updateStateFastCount > 0)
		{
			step = 10;
			this.updateStateFastCount--;
		}
	}
	this.updateStateStep = parseInt(step);
	BX.localStorage.set('uss', this.updateStateStep, 5);
	this.updateState();
}
BX.Messenger.prototype.updateState = function(force)
{
	force = force == true? true: false;
	clearTimeout(this.updateStateTimeout);
	this.updateStateTimeout = setTimeout(
		BX.delegate(function(){
			BX.ajax({
				url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
				method: 'POST',
				dataType: 'json',
				lsId: 'IM_UPDATE_STATE_'+this.updateStateStep,
				lsTimeout: parseInt(this.updateStateStep/2),
				data: {'IM_UPDATE_STATE' : 'Y', 'OPEN_MESSENGER' : this.popupMessenger != null? 1: 0, 'OPEN_CONTACT_LIST' : this.popupContactList != null? 1: 0, 'TAB' : this.currentTab, 'TABS' : this.openTab, 'sessid': BX.bitrix_sessid()},
				onsuccess: BX.delegate(function(data)	{
					if (data.ERROR == 'NO_NEED_LOAD')
						return false;
					
					for (var i in data.USERS)
					{	
						this.users[i] = data.USERS[i];
					}	
					for (var i in data.USER_IN_GROUP)
					{	
						if (this.userInGroup[i] == undefined)
							this.userInGroup[i] = data.USER_IN_GROUP[i];
						else
						{
							for (var j = 0; j < data.USER_IN_GROUP[i].users; j++) 
								this.userInGroup[i].users.push(data.USER_IN_GROUP[i][j]);
							
							this.userInGroup[i].users = BX.util.array_unique(this.userInGroup[i].users)
						}
						
					}
					for (var i in data.WO_USER_IN_GROUP)
					{	
						if (this.woUserInGroup[i] == undefined)
							this.woUserInGroup[i] = data.WO_USER_IN_GROUP[i];
						else
						{
							for (var j = 0; j < data.WO_USER_IN_GROUP[i].users; j++) 
								this.woUserInGroup[i].users.push(data.WO_USER_IN_GROUP[i][j]);
							
							this.woUserInGroup[i].users = BX.util.array_unique(this.woUserInGroup[i].users)
						}
					}	
					var userChangeStatus = {};
					for (var i in this.users)
					{	
						 
						if (data.ONLINE[i] == undefined)
						{
							if (this.users[i].status != 'offline')
							{
								userChangeStatus[i] = this.users[i].status;
								this.users[i].status = 'offline';
							}
						}
						else
						{
							if (this.users[i].status != data.ONLINE[i].status)
							{
								userChangeStatus[i] = this.users[i].status;
								this.users[i].status = data.ONLINE[i].status;
							}
						}
					}
					for (var i in userChangeStatus)
					{
						if (this.popupMessengerTabsByUser[i])
						{
							BX.removeClass(this.popupMessengerTabsByUser[i], 'bx-messenger-tab-'+userChangeStatus[i]);
							BX.addClass(this.popupMessengerTabsByUser[i], 'bx-messenger-tab-'+this.users[i].status);
						}
					}
					
					for (var i in data.MESSAGE)
					{	
						this.message[i] = data.MESSAGE[i];
					}
					for (var i in data.USERS_MESSAGE)
					{	
						data.USERS_MESSAGE[i].sort(function(s1, s2) {s2 = parseInt(s2);s1 = parseInt(s1);if (s1 > s2) {return 1; }	else if (s1 < s2) {return -1;}else{	return 0; }});
						if (this.showMessage[i])
						{
							for (var j = 0; j < data.USERS_MESSAGE[i].length; j++) 
							{
								if (!BX.util.in_array(data.USERS_MESSAGE[i][j], this.showMessage[i]))
								{
									this.showMessage[i].push(data.USERS_MESSAGE[i][j]);
									this.drawMessage(this.popupMessengerTabsContentByUser[i], i, this.message[data.USERS_MESSAGE[i][j]], this.currentTab == i? true: false);
								}
							}
						}
						else
						{
							this.showMessage[i] = data.USERS_MESSAGE[i];
						}
					}

					this.changeUnreadMessage(data.UNREAD_MESSAGE);	
					this.contactListRedraw();	
					this.updateStateDisabled = false;	
					BX.localStorage.set('mus', true, 5);
				}, this),
				onfailure: function(data)	{} 
			});
			
			this.setUpdateStateStep();
		}, this)
	, force? 0: this.updateStateStep*1000);
};

BX.Messenger.prototype.changeUnreadMessage = function(unreadMessage)
{
	for (var i in unreadMessage)
	{
		if (this.popupContactList != null && this.currentTab != i)
		{
			var elements = BX.findChildren(this.popupContactListElementsWrap, {attribute: {'data-userId': ''+i+''}}, true);
			if (elements != null)
			{
				for (var j = 0; j < elements.length; j++) 
					BX.addClass(elements[j], 'bx-messenger-cl-status-new-message');
			}
		}	
		
		if (this.popupMessenger != null && this.currentTab != i)
		{
			if (this.popupMessengerTabsByUser[i])
				BX.addClass(this.popupMessengerTabsByUser[i], 'bx-messenger-tab-new-message');
		}
		
		if (this.settings.status != 'dnd')
		{
			if (this.unreadMessage[i] == undefined || !BX.util.in_array(unreadMessage[i][unreadMessage[i].length-1], this.unreadMessage[i]))
				this.flashMessage[i] = unreadMessage[i][unreadMessage[i].length-1];
		}
		
		if (this.popupMessenger != null && this.currentTab == i)
			delete unreadMessage[i];
		else
		{
			if (this.unreadMessage[i])
				this.unreadMessage[i] = BX.util.array_unique(BX.util.array_merge(this.unreadMessage[i], unreadMessage[i])); 
			else
				this.unreadMessage[i] = unreadMessage[i];
		}
	}
	if (this.settings.status != 'dnd')
		this.newMessage();

	this.updateMessageCount();
}

BX.Messenger.prototype.updateMessageCount = function(send)
{
	send = send == false? false: true;
	var count = 0;
	for (var i in this.unreadMessage)
		count = count+this.unreadMessage[i].length;
	
	if (this.messageCount == count)
		return count;
	
	this.messageCount = count;

	if (count > 0)
	{
		BX.addClass(this.panelButtonMessage, 'bx-notifier-message-new');
		
		if (!BX.browser.IsIE())
		{
			var iconPath = ''
			if (count > 10)
				iconPath = '/bitrix/js/im/images/icon/im-new-mesasge-10-plus.ico';
			else
				iconPath = '/bitrix/js/im/images/icon/im-new-mesasge-'+count+'.ico';
				
			this.changeFavicon(iconPath, true);
		}
		document.title = '('+count+') '+this.windowTitle;
	}
	else
	{
		if (!BX.browser.IsIE())
			this.changeFavicon(this.windowFavicon);
		BX.removeClass(this.panelButtonMessage, 'bx-notifier-message-new');
		document.title = this.windowTitle;
	}

	this.panelButtonMessageCount.innerHTML = count;
	
	if (send)
		BX.localStorage.set('mumc', this.unreadMessage, 5);
	
	return count;
}

BX.Messenger.prototype.newMessage = function(send)
{
	send = send == false? false: true;
	if (this.popupNewMessageItem !== null)
		this.popupNewMessageItem.destroy();

	if (this.settings.status == 'dnd')
		return false;
		
	var arNewMessage = [];
	for (var i in this.flashMessage)
	{
		if (this.popupMessenger != null)
		{
			var skip = false;
			for (var j in this.openTab)
				if (i == j)
					skip = true;
			
			if (skip)
				continue;
		}	
		var messageText = this.message[this.flashMessage[i]].text;
		if (messageText.length > 80)
		{
			messageText = this.message[this.flashMessage[i]].text.substr(0, 80);
			var lastSpace = messageText.lastIndexOf(' ');
			if (lastSpace>50)
				messageText = messageText.substr(0, lastSpace)+'...';
			else
				messageText = messageText.substr(0, 80)+'...';
		}
		
		var element = BX.create("div", {props : { className: "bx-messenger-new-message-item"}, attrs : { 'data-userId' : i, 'data-messageId' : this.flashMessage[i]}, children : [
			BX.create("div", {props : { className: "bx-messenger-new-message-item-wrap"}, children : [
				BX.create('span', {props : { className : "bx-messenger-new-message-item-avatar" }, children : [
					BX.create('img', {props : { className : "bx-messenger-new-message-item-avatar-img" }, attrs : {src : this.users[i].avatar, width: '26', height: '26'}})
				]}),
				BX.create('span', {props : { className : "bx-messenger-new-message-item-name" }, html: this.users[i].name}),
				BX.create('span', {props : { className : "bx-messenger-new-message-item-text" }, html: this.prepareText(messageText)})
			]})
		]});
		arNewMessage.push(element);
	}
		
	if (arNewMessage.length == 0)
		return false;
	
	this.popupNewMessageItem = new BX.PopupWindow('bx-messenger-popup-new-message', this.panelButtonMessage, {
		lightShadow : true,
		offsetTop: -3,
		offsetLeft: 13,
		autoHide: false,
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.proxy(function() { this.popupNewMessageItem = null; }, this)
		},
		titleBar: {content: BX.create('span', {props : { className : "bx-messenger-title" }, html: BX.message('IM_MESSENGER_NEW_MESSAGE')})},
		closeIcon : {'marginTop': '5px', 'marginRight': '0px'},
		content : this.popupNewMessageItemDomItems = BX.create("div", { props : { className : "bx-messenger-new-message-items" }, children : [BX.create("div", { props : { className : "bx-messenger-new-message-items-wrap" }, children : arNewMessage})]})
	});
	this.popupNewMessageItem.setAngle({});
	this.popupNewMessageItem.show();

	this.popupNewMessageItemScroll = new BXScrollbar(this.popupNewMessageItemDomItems);
	
	this.popupNewMessageItemDomWrap = BX.findChild(this.popupNewMessageItemDomItems, {className : "bx-messenger-new-message-items-wrap"}, true);
		
	BX.bindDelegate(this.popupNewMessageItemDomItems, 'click', {className: 'bx-messenger-new-message-item'}, BX.delegate(function(e) {
		this.openMessenger(BX.proxy_context.getAttribute('data-userId'));
		this.popupNewMessageItem.destroy();
	}, this));
	
	this.newMessageResize();
	
	var animation = true;
	if (BX.browser.IsIE() && !BX.browser.IsIE9())
		animation = false;
	
	if (animation)
		BX.fx.show(this.popupNewMessageItem.popupContainer, 'fade', {time: 0.6, step: 0.01});
		
	clearTimeout(this.popupNewMessageTimeout);
	this.popupNewMessageTimeout = setTimeout(BX.proxy(function(){
		if (this.popupNewMessageItem != null)
		{
			if (animation)
				BX.fx.hide(this.popupNewMessageItem.popupContainer, 'fade', {time: 0.6, step: 0.01, callback_complete: BX.proxy(function(){this.popupNewMessageItem.close()}, this)});
			else
				this.popupNewMessageItem.close();
		}
	}, this), animation? 6000: 8000);
	BX.bind(this.popupNewMessageItemDomItems, "mouseover", BX.proxy(function() { clearTimeout(this.popupNewMessageTimeout) }, this));
	
	//if (send)
	//	BX.localStorage.set('mnm', this.flashMessage, 5);
		
	this.flashMessage = {};	
};

BX.Messenger.prototype.newMessageResize = function(event)
{
	if (this.popupNewMessageItem == null)
		return false;

	if (parseInt(BX.style(this.popupNewMessageItemDomItems, 'height')) < this.popupNewMessageItemDomWrap.offsetHeight)
	{
		this.popupNewMessageItemScroll.reDraw();
		return false;
	}
		
	if (this.popupNewMessageItemDomWrap.offsetHeight < 10)
		this.popupNewMessageItem.close();
	else
	{
		BX.style(this.popupNewMessageItemDomItems, 'height', this.popupNewMessageItemDomWrap.offsetHeight+'px');
		
		this.popupNewMessageItem.bindOptions.forceBindPosition = true;
		this.popupNewMessageItem.adjustPosition();	
		this.popupNewMessageItem.bindOptions.forceBindPosition = false;
		
		this.popupNewMessageItemScroll.reDraw();
	}
}


BX.Messenger.prototype.readMessage = function(userId, send)
{
	send = send == false? false: true;
	if (this.unreadMessage[userId])
	{
		delete this.unreadMessage[userId];
		this.updateMessageCount();
		
		if (this.popupContactList != null)
		{
			var elements = BX.findChildren(this.popupContactListElementsWrap, {attribute: {'data-userId': ''+userId+''}}, true);
			if (elements)
				for (var i = 0; i < elements.length; i++) 
					BX.removeClass(elements[i], 'bx-messenger-cl-status-new-message');
		}
		
		if (this.popupMessenger != null)
		{
			if (this.popupMessengerTabsByUser[userId] != undefined)	
				BX.removeClass(this.popupMessengerTabsByUser[userId], 'bx-messenger-tab-new-message');
		}
		
		if (send)
		{
			BX.ajax({
				url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
				method: 'POST',
				dataType: 'json',
				data: {'IM_READ_MESSAGE' : 'Y', 'USER_ID' : userId, 'sessid': BX.bitrix_sessid()}
			});
			BX.localStorage.set('mrm', userId, 5);
		}
	}
}

BX.Messenger.prototype.drawHistory = function(userId)
{
	if (this.popupHistory == null)
		return false;
		
	var activeSearch = this.historySearch.length == 0? false: true;
	if (this.history[userId])
	{
		arHistory = [];
		arHistorySort = BX.util.array_unique(this.history[userId]);
		arHistorySort.sort(function(i, ii) {ii = parseInt(ii);i = parseInt(i);if (i > ii) {	return -1; } else if (i < ii) {return 1;}else{	return 0; }});

		for (var i = 0; i < arHistorySort.length; i++) 
		{
			var history = this.message[this.history[userId][i]];
			if (history)
			{
				if (activeSearch && history.text.toLowerCase().indexOf(this.historySearch.toLowerCase()) < 0)
					continue;
					
				arHistory.push(
					BX.create("div", { attrs : { 'data-messageId' : history.id}, props : { className : "bx-messenger-history-item"+(history.senderId == this.settings.userId?"": " bx-messenger-history-item-2") }, children : [
						BX.create("div", { props : { className : "bx-messenger-history-item-name" }, html : this.users[history.senderId].name+' <span class="bx-messenger-history-hide">[</span><span class="bx-messenger-history-item-date">'+BX.Messenger.FormatDate(history.date)+'</span><span class="bx-messenger-history-hide">]</span><span class="bx-messenger-history-item-delete-icon" title="'+BX.message('IM_MESSENGER_HISTORY_DELETE')+'" data-messageId="'+history.id+'"></span>'}),
						BX.create("div", { props : { className : "bx-messenger-history-item-text" }, html : this.prepareText(history.text)}),
						BX.create("div", { props : { className : "bx-messenger-history-hide" }, html : '&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;'})
					]})
				);
			}
		};
	}
	else if (this.showMessage[userId] && this.showMessage[userId].length <= 0)
	{
		arHistory = [
			BX.create("div", { props : { className : "bx-messenger-content-history-empty" }, children : [
				BX.create("span", { props : { className : "bx-messenger-content-load-text" }, html : BX.message('IM_MESSENGER_NO_MESSAGE')})
			]})
		];
	}
	else
	{
		arHistory = [
			BX.create("div", { props : { className : "bx-messenger-content-load-history" }, children : [
				BX.create('span', { props : { className : "bx-messenger-content-load-img" }}),
				BX.create("span", { props : { className : "bx-messenger-content-load-text" }, html : BX.message('IM_MESSENGER_LOAD_MESSAGE')})
			]})
		];
		BX.ajax({
			url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
			method: 'POST',
			dataType: 'json',
			data: {'IM_HISTORY_LOAD' : 'Y', 'USER_ID' : userId, 'sessid': BX.bitrix_sessid()},
			onsuccess: BX.delegate(function(data){
				for (var i in data.MESSAGE)
				{	
					this.message[i] = data.MESSAGE[i];
				}
				for (var i in data.USERS_MESSAGE)
				{	
					if (this.history[i])
						this.history[i] = BX.util.array_merge(this.history[i], data.USERS_MESSAGE[i]); 
					else
						this.history[i] = data.USERS_MESSAGE[i];
				}
				
				BX.cleanNode(this.popupHistoryBodyWrap);
				if (data.USERS_MESSAGE[userId].length <= 0)
				{
					this.popupHistoryBodyWrap.appendChild(BX.create("div", { props : { className : "bx-messenger-content-load-history" }, children : [
						BX.create('span', { props : { className : "bx-messenger-content-load-img" }}),
						BX.create("span", { props : { className : "bx-messenger-content-load-text" }, html : BX.message('IM_MESSENGER_LOAD_MESSAGE')})
					]}));
				}
				else
				{
					for (var i = 0; i < data.USERS_MESSAGE[userId].length; i++) 
					{
						var history = this.message[data.USERS_MESSAGE[userId][i]];
						if (history)
						{
							this.popupHistoryBodyWrap.appendChild(
								BX.create("div", { attrs : { 'data-messageId' : history.id}, props : { className : "bx-messenger-history-item"+(history.senderId == this.settings.userId?"": " bx-messenger-history-item-2") }, children : [
									BX.create("div", { props : { className : "bx-messenger-history-item-name" }, html : this.users[history.senderId].name+' <span class="bx-messenger-history-hide">[</span><span class="bx-messenger-history-item-date">'+BX.Messenger.FormatDate(history.date)+'</span><span class="bx-messenger-history-hide">]</span><span class="bx-messenger-history-item-delete-icon" title="'+BX.message('IM_MESSENGER_HISTORY_DELETE')+'" data-id="'+history.id+'"></span>'}),
									BX.create("div", { props : { className : "bx-messenger-history-item-text" }, html : this.prepareText(history.text)}),
									BX.create("div", { props : { className : "bx-messenger-history-hide" }, html : '&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;'})
								]})
							);
						}
					};
				}
				
				this.popupHistoryScroll.reDraw();
			}, this),
			onfailure: function(data)	{} 
		});
	}
	
	BX.cleanNode(this.popupHistoryBodyWrap);
	BX.adjust(this.popupHistoryBodyWrap, {children: arHistory});
	this.popupHistoryScroll.reDraw();	
}
BX.Messenger.prototype.openHistory = function(userId)
{	
	if (this.popupHistory !== null)
		this.popupHistory.close();
	
	userId = userId === null? 0: parseInt(userId);
	if (userId == 0)
		return false;	
		
	this.popupHistory = new BX.PopupWindow('bx-messenger-popup-history', null, {
		lightShadow : true,
		offsetTop: 0,
		offsetLeft: -46,
		autoHide: false,
		draggable: {restrict: true},
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.delegate(function() { this.popupHistory = null; this.historySearch = ''; }, this)
		},
		titleBar: {content: BX.create('span', {props : { className : "bx-messenger-title" }, html: BX.message('IM_MESSENGER_HISTORY')})},
		closeIcon : {'marginTop': '5px', 'marginRight': '0px'},
		content : this.popupHistoryElements = BX.create("div", { props : { className : "bx-messenger-history" }, children: [
			BX.create("div", { props : { className : "bx-messenger-history-left" }}),
			BX.create("div", { props : { className : "bx-messenger-history-right" }, children : [ 
				BX.create("div", { props : { className : "bx-messenger-history-panel" }, children : [
					BX.create("div", { props : { className : "bx-messenger-history-panel-left" }, children : [
						BX.create("span", { props : { className : "bx-messenger-history-avatar" }, children : [
							BX.create('img', { props : { className : "bx-messenger-history-avatar-img" }, attrs : {src : this.users[userId].avatar, width: '26', height: '26'}})
						]}),
						BX.create("span", { props : { className : "bx-messenger-history-name" }, html : this.users[userId].name})
					]}),
					BX.create("div", { props : { className : "bx-messenger-history-panel-right" }, children : [
						BX.create("span", { props : { className : "bx-messenger-history-search" }, children : [
							this.popupHistorySearchInput = BX.create('input', { props : { className : "bx-messenger-history-search-input" }, attrs : {type : 'text'}})
						]}),
						BX.create("span", { props : { className : "bx-messenger-history-delete" }, children : [
							BX.create('span', { props : { className : "bx-messenger-history-delete-icon" }, attrs : {title : BX.message('IM_MESSENGER_HISTORY_DELETE_ALL')}})
						]})
					]})
				]}),
				this.popupHistoryItems = BX.create("div", { props : { className : "bx-messenger-history-items" }, children : [
					BX.create("div", { props : { className : "bx-messenger-history-items-wrap" }})
				]})
			]})
		]})
	});
	this.popupHistory.show();
	
	this.popupHistoryScroll = new BXScrollbar(this.popupHistoryItems);
	this.popupHistoryBodyWrap = BX.findChild(this.popupHistoryElements, {className : "bx-messenger-history-items-wrap"}, true);
	
	this.drawHistory(userId);
	
	BX.focus(this.popupHistorySearchInput);
	
	this.popupHistoryButtonDeleteAll = BX.findChild(this.popupHistoryElements, {className : "bx-messenger-history-delete-icon"}, true);
	BX.bind(this.popupHistoryButtonDeleteAll, "click",  BX.delegate(function(){
		if (!confirm(BX.message('IM_MESSENGER_HISTORY_DELETE_ALL_CONFIRM')))
			return false;
		BX.ajax({
			url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
			method: 'POST',
			dataType: 'json',
			data: {'IM_HISTORY_REMOVE_ALL' : 'Y', 'USER_ID' : userId, 'sessid': BX.bitrix_sessid()}
		});
		BX.localStorage.set('mhra', userId, 5);
		/* TODO redraw tab */
		this.history[userId] = [];
		this.showMessage[userId] = [];
		this.popupHistoryBodyWrap.innerHTML = '';
		this.popupHistoryBodyWrap.appendChild(BX.create("div", { props : { className : "bx-messenger-history-item bx-messenger-history-item-2" }, children : [
			BX.create("div", { props : { className : "bx-messenger-history-item-text" }, html : BX.message('IM_MESSENGER_NO_MESSAGE')})
		]}));
		this.popupHistoryScroll.reDraw();
	}, this));
	
	BX.bindDelegate(this.popupHistoryBodyWrap, 'click', {className: 'bx-messenger-history-item-delete-icon'}, BX.delegate(function(e) {
		if (!confirm(BX.message('IM_MESSENGER_HISTORY_DELETE_CONFIRM')))
			return false;
		BX.ajax({
			url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
			method: 'POST',
			dataType: 'json',
			data: {'IM_HISTORY_REMOVE_MESSAGE' : 'Y', 'MESSAGE_ID' : BX.proxy_context.getAttribute('data-messageId'), 'sessid': BX.bitrix_sessid()}
		});
		BX.localStorage.set('mhrm', BX.proxy_context.getAttribute('data-messageId'), 5);
		/* TODO remove in tab message */
		elementDelete = BX.util.array_search(BX.proxy_context.getAttribute('data-messageId'), this.history[userId]);
		newArray = [];
		for (var i = 0; i < this.history[userId].length; i++)
		{
			if (i == elementDelete)
				continue;
			newArray.push(this.history[userId][i])
		}
		this.history[userId] = newArray;

		elementDelete = BX.util.array_search(BX.proxy_context.getAttribute('data-messageId'), this.showMessage[userId]);
		newArray = [];
		for (var i = 0; i < this.showMessage[userId].length; i++)
		{
			if (i == elementDelete)
				continue;
			newArray.push(this.showMessage[userId][i])
		}
		this.showMessage[userId] = newArray;
		
		BX.remove(BX.proxy_context.parentNode.parentNode);
		if (this.popupHistoryBodyWrap.lastChild == undefined)
		{
			this.popupHistoryBodyWrap.appendChild(BX.create("div", { props : { className : "bx-messenger-history-item bx-messenger-history-item-2" }, children : [
				BX.create("div", { props : { className : "bx-messenger-history-item-text" }, html : BX.message('IM_MESSENGER_NO_MESSAGE')})
			]}));
		}
	}, this));
		

	var endOfList = false;
	BX.addCustomEvent(this.popupHistoryScroll, "onScrollEnd", BX.delegate(function(){
		if (!endOfList)
		{
			var lastMessage = 0;
			if (this.popupHistoryBodyWrap.lastChild)
				lastMessage = this.popupHistoryBodyWrap.lastChild.getAttribute('data-messageId');
			BX.ajax({
				url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
				method: 'POST',
				dataType: 'json',
				data: {'IM_HISTORY_LOAD_MORE' : 'Y', 'USER_ID' : userId, 'MESSAGE_ID' : lastMessage, 'sessid': BX.bitrix_sessid()},
				onsuccess: BX.delegate(function(data){
					if (data.MESSAGE.length == 0)
					{
						endOfList = true;
						return;
					}
					for (var i in data.MESSAGE)
					{	
						this.message[i] = data.MESSAGE[i];
					}
					for (var i in data.USERS_MESSAGE)
					{	
						if (this.history[i])
							this.history[i] = BX.util.array_merge(this.history[i], data.USERS_MESSAGE[i]); 
						else
							this.history[i] = data.USERS_MESSAGE[i];
					}
					for (var i = 0; i < data.USERS_MESSAGE[userId].length; i++) 
					{
						var history = this.message[data.USERS_MESSAGE[userId][i]];
						if (history)
						{
							this.popupHistoryBodyWrap.appendChild(
								BX.create("div", { attrs : { 'data-messageId' : history.id}, props : { className : "bx-messenger-history-item"+(history.senderId == this.settings.userId?"": " bx-messenger-history-item-2") }, children : [
									BX.create("div", { props : { className : "bx-messenger-history-item-name" }, html : this.users[history.senderId].name+' <span class="bx-messenger-history-hide">[</span><span class="bx-messenger-history-item-date">'+BX.Messenger.FormatDate(history.date)+'</span><span class="bx-messenger-history-hide">]</span><span class="bx-messenger-history-item-delete-icon" title="'+BX.message('IM_MESSENGER_HISTORY_DELETE')+'" data-id="'+history.id+'"></span>'}),
									BX.create("div", { props : { className : "bx-messenger-history-item-text" }, html : this.prepareText(history.text)}),
									BX.create("div", { props : { className : "bx-messenger-history-hide" }, html : '&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;'})
								]})
							);
						}
					};
					this.popupHistoryScroll.reDraw();
				}, this),
				onfailure: function(data)	{} 
			});
		}
	}, this));
	
	BX.bind(this.popupHistorySearchInput, "keyup", BX.delegate(function(event){
		if (event.keyCode == 27)
			this.popupHistorySearchInput.value = '';
		
		if (this.popupHistorySearchInput.value.length < 3)
		{
			this.historySearch = "";
			this.drawHistory(userId);
			return false;
		}
			
		this.historySearch = this.popupHistorySearchInput.value; 
		this.drawHistory(userId);
		
		clearTimeout(this.historySearchTimeout);
		if (this.popupHistorySearchInput.value != '')
		{
			this.historySearchTimeout = setTimeout(BX.delegate(function(){
				BX.ajax({
					url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
					method: 'POST',
					dataType: 'json',
					data: {'IM_HISTORY_SEARCH' : 'Y', 'USER_ID' : userId, 'SEARCH' : this.popupHistorySearchInput.value, 'sessid': BX.bitrix_sessid()},
					onsuccess: BX.delegate(function(data){
						if (data.MESSAGE.length == 0)
							return;

						for (var i in data.MESSAGE)
						{	
							this.message[i] = data.MESSAGE[i];
						}
						for (var i in data.USERS_MESSAGE)
						{	
							if (this.history[i])
								this.history[i] = BX.util.array_merge(this.history[i], data.USERS_MESSAGE[i]); 
							else
								this.history[i] = data.USERS_MESSAGE[i];
						}
						this.history[i].sort(function(i, ii) {ii = parseInt(ii);i = parseInt(i);if (i > ii) {	return -1; }	else if (i < ii) {return 1;}else{	return 0; }});
						this.drawHistory(data.USER_ID);						
					}, this),
					onfailure: function(data)	{} 
				});
			}, this), 1000);
		}

		return BX.PreventDefault(event);
	}, this));
};

BX.Messenger.prototype.openMessenger = function(userId, send)
{
	send = send == false? false: true;
	
	if (this.popupMessenger != null)
		this.popupMessenger.destroy();

	//this.contactListFocusOut()
		
	if (userId == null)
	{	
		for (var i in this.unreadMessage)
			userId = i;
				
		if (userId == null && this.users[this.currentTab])		
			userId = this.currentTab;
				
		if (userId == null)
			return false;
	}
	else
		userId = parseInt(userId);
	
	this.currentTab = userId;
	
	if (this.openTab[userId] == undefined)
		this.openTab[userId] = true;
	
	if (send)
	{
		BX.localStorage.set('mot', this.openTab, 15);
		BX.localStorage.set('mom', this.currentTab, 15);
	}
	
	var arTabs = [];
	var arTabsContent = [];
	var loadMessage = false;
	for (var i in this.openTab)
	{		
		var user = this.users[i];
		if (user == undefined)
			continue;
			
		var active = i == userId? "bx-messenger-tab-active": "";
		
		var unread = this.unreadMessage[i] && i != userId ? "bx-messenger-tab-new-message": "";
		
		arTabs.push(BX.create("a", {attrs: {href: "#", 'data-userId': user.id}, props : { className : "bx-messenger-tab bx-messenger-tab-"+user.status+" "+unread+" "+active }, children : [
			BX.create("span", { props : { className : "bx-messenger-tab-status" }}),
			BX.create("span", { props : { className : "bx-messenger-tab-name" }, html : user.name}),
			BX.create("span", { props : { className : "bx-messenger-tab-close-wrap" }, children : [
				BX.create("span", { props : { className : "bx-messenger-tab-close" }})
			]})
		]}));
		
		var lastMessage = lastMessageElement = lastMessageUserId = lastMessageElementDate = null;
		
		arMessage = [];
		active = i == userId? "block": "none";
		var redrawMessage = false;
		if (this.showMessage[i] != undefined && this.showMessage[i].length > 0)
		{
			if (i == userId)
			{
				loadMessage = false;
				if (this.showMessage[i].length < 15 && this.unreadMessage[i])
				{
					loadMessage = true;
					for(var j in this.showMessage[i])
					{
						if (this.unreadMessage[i][j] == undefined)
						{
							loadMessage = false;
						}
					}
				}
			}
		}
		else if (this.showMessage[i] == undefined)
		{
			arMessage = [BX.create("div", { props : { className : "bx-messenger-content-load"}, children : [
				BX.create('span', { props : { className : "bx-messenger-content-load-img" }}),
				BX.create("span", { props : { className : "bx-messenger-content-load-text"}, html: BX.message('IM_MESSENGER_LOAD_MESSAGE')})
			]})];
			this.redrawTab[user.id] = user.id;
			this.showMessage[i] = [];
			if (i == userId)
				loadMessage = true;
		}
		else if (this.redrawTab[user.id] && this.showMessage[i].length == 0)
		{
			arMessage = [BX.create("div", { props : { className : "bx-messenger-content-load"}, children : [
				BX.create('span', { props : { className : "bx-messenger-content-load-img" }}),
				BX.create("span", { props : { className : "bx-messenger-content-load-text"}, html: BX.message("IM_MESSENGER_LOAD_MESSAGE")})
			]})];
			this.showMessage[i] = [];
			if (i == userId)
				loadMessage = true;
		}
		else		
		{
			arMessage = [BX.create("div", { props : { className : "bx-messenger-content-empty"}, children : [
				BX.create("span", { props : { className : "bx-messenger-content-load-text"}, html: BX.message("IM_MESSENGER_NO_MESSAGE")})
			]})];
		}
		var element = BX.create("span", {attrs: {'data-userId': user.id}, props : { className : "bx-messenger-tab-content"}, children : arMessage});
		element.style.display = active;
		arTabsContent.push(element);
	}
	this.readMessage(userId);
	
	this.popupMessenger = new BX.PopupWindow('bx-messenger-popup-messenger', null, {
		lightShadow : true,
		offsetTop: 0,
		offsetLeft: -66,
		autoHide: false,
		draggable: {restrict: true},
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.delegate(function() { 
				this.popupMessenger = null; 
				this.setUpdateStateStep();
			}, this)
		},
		titleBar: {content: BX.create('span', {props : { className : "bx-messenger-title" }, html: BX.message('IM_MESSENGER_MESSAGES')})},
		closeIcon : {'marginTop': '5px', 'marginRight': '0px'},
		content : this.popupMessengerElements = BX.create("div", { props : { className : "bx-messenger-box" }, children : [BX.create("div", { props : { className : "bx-messenger-box-wrap" }, children: [
			BX.create("div", { props : { className : "bx-messenger-tabs" }, children : arTabs}),
			BX.create("div", { props : { className : "bx-messenger-body" }, children : [
				BX.create("span", { props : { className : "bx-messenger-content" }, children : arTabsContent })
			]}),
			BX.create("div", { props : { className : "bx-messenger-textarea-place" }, children : [
				BX.create("div", { props : { className : "bx-messenger-textarea" }, children : [
					this.popupMessengerTextarea = BX.create("textarea", { props : { value: (this.textareaHistory[userId]? this.textareaHistory[userId]: ''), className : "bx-messenger-textarea-input" }})
				]}),
				BX.create("div", { props : { className : "bx-messenger-textarea-icons" }, children : [
					BX.create("a", {attrs: {href: "#history", title: BX.message("IM_MESSENGER_HISTORY")}, props : { className : "bx-messenger-textarea-icon bx-messenger-textarea-icon-history" }})
					//BX.create("a", {attrs: {href: "#file", title: BX.message("IM_MESSENGER_SEND_FILE")}, props : { className : "bx-messenger-textarea-icon bx-messenger-textarea-icon-file" }})
				]}),
				BX.create("div", { props : { className : "bx-messenger-textarea-send" }, children : [
					BX.create("a", {attrs: {href: "#send"}, events : { click : BX.delegate(this.sendMessage, this)}, children : [
						BX.create("span", { props : { className : "bx-messenger-textarea-send-left" }}),
						BX.create("span", { props : { className : "bx-messenger-textarea-send-center" }, html : BX.message('IM_MESSENGER_SEND_MESSAGE')}),
						BX.create("span", { props : { className : "bx-messenger-textarea-send-right" }})
					]}),
					BX.create("span", { props : { className : "bx-messenger-textarea-cntr-enter"}, html: (BX.browser.IsMac()? "Alt+Enter": "Ctrl+Enter") })
				]}),
				BX.create("div", { props : { className : "bx-messenger-clear" }})
			]})
		]})]})
	});
	this.popupMessenger.show();
	this.popupMessenger.adjustPosition();
	this.setUpdateStateStep();
	
	this.popupMessengerTextareaPlace = BX.findChild(this.popupMessengerElements, {className : "bx-messenger-textarea-place"}, true);
	
	this.popupMessengerBody = BX.findChild(this.popupMessengerElements, {className : "bx-messenger-body"}, true);
	
	this.popupMessengerScroll = new BXScrollbar(this.popupMessengerBody);
	this.popupMessengerScroll.moveToEnd();

	this.popupMessengerBodyWrap = BX.findChild(this.popupMessengerBody, {className : "bx-messenger-content"}, true);
	this.popupMessengerTabs = BX.findChildren(this.popupMessengerElements, {className : "bx-messenger-tab"}, true);
	this.popupMessengerTabsContent = BX.findChildren(this.popupMessengerElements, {className : "bx-messenger-tab-content"}, true);	
	
	for (var i = 0; i < this.popupMessengerTabs.length; i++) 
	{
		this.popupMessengerTabsByUser[this.popupMessengerTabsContent[i].getAttribute('data-userId')] = this.popupMessengerTabs[i];
		this.popupMessengerTabsContentByUser[this.popupMessengerTabsContent[i].getAttribute('data-userId')] = this.popupMessengerTabsContent[i];
	}
	this.popupMessengerContentCurrent = this.popupMessengerTabsContentByUser[userId];

	this.popupMessengerTextarea.focus();
	
	var hOpen = BX.findChild(this.popupMessengerTextareaPlace, {className : "bx-messenger-textarea-icon-history"}, true);	

	if (loadMessage || this.forceLoadMessage)
	{	
		if (this.userInGroup.last.users)
		{
			if (this.settings.viewGroup)
			{
				this.userInGroup['last']['users'].push(userId);
				this.userInGroup['last']['users'] = BX.util.array_unique(this.userInGroup['last']['users']);
			}
			else
			{
				this.woUserInGroup['last']['users'].push(userId);
				this.woUserInGroup['last']['users'] = BX.util.array_unique(this.woUserInGroup['last']['users']);
			}
		}
			
		this.loadLastMessage(userId);
	}
	if (this.showMessage[userId].length > 0)
		this.drawTab(userId, this.popupMessengerContentCurrent, true);
	
	BX.bind(hOpen, "click", BX.delegate(function(e) {
		this.openHistory(this.currentTab);
	}, this));
	
	BX.bind(this.popupMessengerTextarea, "keydown", BX.delegate(function(e) {
		if (e.ctrlKey == true && e.keyCode == 13)
			this.sendMessage();
		else if (e.altKey == true && e.keyCode == 13 && BX.browser.IsMac())
			this.sendMessage();
		
		clearTimeout(this.textareaHistoryTimeout);
		this.textareaHistoryTimeout = setTimeout(BX.delegate(function(){
			this.textareaHistory[this.currentTab] = this.popupMessengerTextarea.value; 
		}, this), 200);
	}, this));	
	
	BX.bindDelegate(this.popupMessengerElements, 'click', {className: 'bx-messenger-tab'}, BX.delegate(function(e) {
		for (var i in this.popupMessengerTabs)
		{
			if (this.popupMessengerTabs[i] == BX.proxy_context)
			{
				var userId = this.popupMessengerTabs[i].getAttribute('data-userId');
				break;
			}
		}
		if (this.popupMessengerTabsContentByUser[userId] == undefined)
			return false;
			
		for (var i in this.popupMessengerTabs)
		{
			if (this.popupMessengerTabs[i] != BX.proxy_context)
				BX.removeClass(this.popupMessengerTabs[i], 'bx-messenger-tab-active');
		}
		
		BX.addClass(BX.proxy_context, 'bx-messenger-tab-active');	
		BX.removeClass(BX.proxy_context, 'bx-messenger-tab-new-message');	
		
		this.currentTab = userId;
		
		BX.localStorage.set('mom', this.currentTab, 15);
		
		this.readMessage(userId);
		this.popupMessengerTextarea.value = this.textareaHistory[this.currentTab]? this.textareaHistory[this.currentTab]: "";
		
		this.popupMessengerTextarea.focus();
		
		for (var i in this.popupMessengerTabsContent)
			this.popupMessengerTabsContent[i].style.display = 'none';

		this.popupMessengerTabsContentByUser[this.currentTab].style.display = 'block';
		
		this.popupMessengerContentCurrent = this.popupMessengerTabsContentByUser[this.currentTab];
		
		if (this.redrawTab[userId])
			this.loadLastMessage(userId);
		
		if (this.popupMessengerTabsContentByUser[userId]);
			this.drawTab(userId, this.popupMessengerTabsContentByUser[userId], false);
				
		this.popupMessengerScroll.reDraw();
		this.popupMessengerScroll.moveToEnd();
		return BX.PreventDefault(e);
	},this));	
	
	BX.bindDelegate(this.popupMessengerElements, 'click', {className: 'bx-messenger-tab-close'}, BX.delegate(function(e) {
		delete this.openTab[this.currentTab];
		BX.localStorage.set('mot', this.openTab, 15);
		
		delete this.popupMessengerTabsContentByUser[this.currentTab];
		var userId = null;
		for (var i in this.popupMessengerTabsContentByUser)
			userId = i;

		this.currentTab = null;
		this.openMessenger(userId);

		return BX.PreventDefault(e);
	},this));
};

BX.Messenger.prototype.sendMessage = function(recipientId, fake)
{
	fake = fake == true? true: false;
	
	clearTimeout(this.textareaHistoryTimeout);
	BX.focus(this.popupMessengerTextarea);
	
	this.popupMessengerTextarea.value = BX.util.trim(this.popupMessengerTextarea.value);
	if (this.popupMessengerTextarea.value.length == 0)
		return false;
		
	if (BX.findChild(this.popupMessengerContentCurrent, {className : "bx-messenger-content-load"}, true))
		return false;
		
	var elEmpty = BX.findChild(this.popupMessengerContentCurrent, {className : "bx-messenger-content-empty"}, true);	
	if (elEmpty)
		BX.remove(elEmpty);
	
	recipientId = recipientId > 0 ? recipientId: this.popupMessengerContentCurrent.getAttribute('data-userId');
		
	this.message['temp'+this.messageTmpIndex] = {'id' : 'temp'+this.messageTmpIndex, 'senderId' : this.settings.userId, 'recipientId' : recipientId, 'date' : Math.floor((new Date).getTime() / 1000), 'text' : this.prepareText(this.popupMessengerTextarea.value, true) };
	if (!this.showMessage[recipientId])
		this.showMessage[recipientId] = [];
	this.showMessage[recipientId].push('temp'+this.messageTmpIndex);

	this.drawMessage(this.popupMessengerContentCurrent, recipientId, this.message['temp'+this.messageTmpIndex], true, true);
	
	var messageTmpIndex = this.messageTmpIndex;
	var messageText = this.popupMessengerTextarea.value;
	
	BX.ajax({
		url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
		method: 'POST',
		dataType: 'json',
		lsId: 'IM_SEND_MESSAGE_'+recipientId+messageTmpIndex,
		lsTimeout: 5,
		data: {'IM_SEND_MESSAGE' : fake? 'N' : 'Y', 'ID' : 'temp'+messageTmpIndex, 'RECIPIENT_ID' : recipientId, 'MESSAGE' : messageText, 'TAB' : this.currentTab, 'TABS' : this.openTab, 'sessid': BX.bitrix_sessid()},
		onsuccess: BX.delegate(function(data) {
			if (data.ERROR.length == 0)
			{
				this.message[data.TMP_ID].id = data.ID;
				this.message[data.ID] = this.message[data.TMP_ID];
				var message = this.message[data.ID];
				var element = BX.findChild(this.popupMessengerTabsContentByUser[data.RECIPIENT_ID], {attribute: {'data-messageid': ''+data.TMP_ID+''}}, true);
				element.setAttribute('data-messageid',	''+data.ID+''); 

				var idx = BX.util.array_search(''+data.TMP_ID+'', this.showMessage[data.RECIPIENT_ID]);
				this.showMessage[data.RECIPIENT_ID][idx] = ''+data.ID+'';

				var messageUser = this.users[message.senderId];
				var lastMessageElementDate = BX.findChild(element, {className : "bx-messenger-content-item-date"}, true);
				if (lastMessageElementDate)
					lastMessageElementDate.innerHTML = messageUser.name+' &nbsp; '+BX.Messenger.FormatDate(message.date);
				if (this.history[data.RECIPIENT_ID])	
					this.history[data.RECIPIENT_ID].push(message.id)	
				else
					this.history[data.RECIPIENT_ID] = [message.id];

				this.popupMessengerScroll.reDraw();
				this.popupMessengerScroll.moveToEnd();
				
				this.updateStateVeryFastCount = 2;
				this.updateStateFastCount = 5;
				this.setUpdateStateStep();
			} 
			else
			{
				var element = BX.findChild(this.popupMessengerTabsContentByUser[data.RECIPIENT_ID], {attribute: {'data-messageid': ''+data.TMP_ID+''}}, true);
				var lastMessageElementDate = BX.findChild(element, {className : "bx-messenger-content-item-date"}, true);
				lastMessageElementDate.innerHTML = data.ERROR;
			}
			for (var i in data.MESSAGE)
			{	
				this.message[i] = data.MESSAGE[i];
			}
			for (var i in data.USERS_MESSAGE)
			{	
				data.USERS_MESSAGE[i].sort(function(s1, s2) {s2 = parseInt(s2);s1 = parseInt(s1);if (s1 > s2) {return 1; }	else if (s1 < s2) {return -1;}else{	return 0; }});
				if (this.showMessage[i])
				{
					for (var j = 0; j < data.USERS_MESSAGE[i].length; j++) 
					{
						if (!BX.util.in_array(data.USERS_MESSAGE[i][j], this.showMessage[i]))
						{
							this.showMessage[i].push(data.USERS_MESSAGE[i][j]);
							this.drawMessage(this.popupMessengerTabsContentByUser[i], i, this.message[data.USERS_MESSAGE[i][j]], this.currentTab == i? true: false);
						}
					}
				}
				else
				{
					this.showMessage[i] = data.USERS_MESSAGE[i];
				}
			}

			this.changeUnreadMessage(data.UNREAD_MESSAGE);	
						
			if (!fake)
				BX.localStorage.set('msm', {'recipientId': data.RECIPIENT_ID, 'text' : messageText, 'index' : messageTmpIndex}, 5);
		}, this),
		onfailure: BX.delegate(function(data)	{
			var element = BX.findChild(this.popupMessengerContentCurrent, {attribute: {'data-messageid': 'temp'+messageTmpIndex+''}}, true);
			var lastMessageElementDate = BX.findChild(element, {className : "bx-messenger-content-item-date"}, true);
			if (lastMessageElementDate)
				lastMessageElementDate.innerHTML = BX.message('IM_MESSENGER_NOT_DELIVERED');
			
			this.popupMessengerScroll.reDraw();
			this.popupMessengerScroll.moveToEnd();
		}, this)
	});
	
	this.popupMessengerTextarea.value = '';
	this.textareaHistory[this.currentTab] = '';
	setTimeout(BX.delegate(function(){
		this.popupMessengerTextarea.value = '';
	}, this), 0);
	this.messageTmpIndex++;
}

BX.Messenger.prototype.prepareText = function(text, prepare)
{
	prepare = prepare == true? true: false;
	if (prepare)
	{
		text = BX.util.htmlspecialchars(text);
		text = text.replace(/\n/gi, '<br>');
	}
	text = BX.util.trim(text);
	
	return text;
}

BX.Messenger.prototype.drawTab = function(userId, content, scroll)
{
	if (this.popupMessenger == null)
		return false;
	scroll = scroll == false? false: true;

	content.innerHTML = '';
	if (this.showMessage[userId].length <= 0)
	{
		if (!this.redrawTab[userId])
			content.appendChild(BX.create("div", { props : { className : "bx-messenger-content-empty"}, children : [
				BX.create("span", { props : { className : "bx-messenger-content-load-text"}, html: BX.message("IM_MESSENGER_NO_MESSAGE")})
			]}));
		else
			content.appendChild(BX.create("div", { props : { className : "bx-messenger-content-load"}, children : [
				BX.create('span', { props : { className : "bx-messenger-content-load-img" }}),
				BX.create("span", { props : { className : "bx-messenger-content-load-text"}, html: BX.message("IM_MESSENGER_LOAD_MESSAGE")})
			]}));
	}
	this.showMessage[userId].sort(function(s1, s2) {s2 = parseInt(s2);s1 = parseInt(s1);if (s1 > s2) {return 1; }	else if (s1 < s2) {return -1;}else{	return 0; }});
	for (var i = 0; i < this.showMessage[userId].length; i++) 
	{
		this.drawMessage(content, userId, this.message[this.showMessage[userId][i]], false);
	}
	if (scroll)
	{
		this.popupMessengerScroll.reDraw();
		this.popupMessengerScroll.moveToEnd();
	}
	
	delete this.redrawTab[userId];
}
BX.Messenger.prototype.drawMessage = function(content, userId, message, scroll, temp)
{
	if (message == undefined)
		return false;
		
	if (!this.history[userId])
		this.history[userId] = [];
	if (parseInt(message.id))
		this.history[userId].push(message.id);
	
	if (content == undefined)
		return message.id;

	var messageId = 0;
	var skipAddMessage = false;
	var messageUser = this.users[message.senderId];
	scroll = scroll == false? false: true;
	temp = temp == true? true: false;
	
	if (content.lastChild)
	{
		if (content.lastChild.getAttribute('data-senderId') == undefined)
		{
			var elEmpty = BX.findChild(this.popupMessengerContentCurrent, {className : "bx-messenger-content-empty"}, true);	
			if (elEmpty)
				BX.remove(elEmpty);
		}
	}
	if (content.lastChild)
	{
		if (content.lastChild.getAttribute('data-senderId') == undefined)
		{
			var elEmpty = BX.findChild(this.popupMessengerContentCurrent, {className : "bx-messenger-content-empty"}, true);	
			if (elEmpty)
				BX.remove(elEmpty);
		}
		if (message.senderId == content.lastChild.getAttribute('data-senderId') && parseInt(message.date)-300 < parseInt(content.lastChild.getAttribute('data-messageDate')))
		{
			var lastMessageElement = BX.findChild(content.lastChild, {className : "bx-messenger-content-item-text-message"}, true);
			lastMessageElement.innerHTML = lastMessageElement.innerHTML+'<div class="bx-messenger-hr"></div>'+this.prepareText(message.text);
			
			var lastMessageElementDate = BX.findChild(content.lastChild, {className : "bx-messenger-content-item-date"}, true);
			lastMessageElementDate.innerHTML = (temp? BX.message('IM_MESSENGER_DELIVERED'): messageUser.name+' &nbsp; '+BX.Messenger.FormatDate(message.date));
			
			content.lastChild.setAttribute('data-messageDate', message.date);
			content.lastChild.setAttribute('data-messageId', message.id);
			content.lastChild.setAttribute('data-senderId', message.senderId);
			
			messageId = message.id;
			skipAddMessage = true;
		}
	}

	if (!skipAddMessage)
	{
		if (content.lastChild)
			messageId = content.lastChild.getAttribute('data-messageId');
		
		if (message.senderId == this.settings.userId)
		{
			content.appendChild(BX.create("div", { attrs : { 'data-senderId' : message.senderId, 'data-messageDate' : message.date, 'data-messageId' : message.id }, props: { className : "bx-messenger-content-item"}, children: [
				BX.create("div", { props : { className : "bx-messenger-history-hide"}, html : messageUser.name+' ['+BX.Messenger.FormatDate(message.date)+']' }),
				BX.create("span", { props : { className : "bx-messenger-content-item-content"}, children : [
					BX.create("span", { props : { className : "bx-messenger-content-item-text-top"}}),
					BX.create("span", { props : { className : "bx-messenger-content-item-text-center"}, children: [
						lastMessageElement = BX.create("span", {  props : { className : "bx-messenger-content-item-text-message"}, html: this.prepareText(message.text)}),
						BX.create("span", { props : { className : "bx-messenger-content-item-date"}, html: (temp? BX.message('IM_MESSENGER_DELIVERED'): messageUser.name+' &nbsp; '+BX.Messenger.FormatDate(message.date))}),
						BX.create("span", { props : { className : "bx-messenger-clear"}})
					]}),
					BX.create("span", { props : { className : "bx-messenger-content-item-text-bottom"}})
				]}),
				BX.create("span", { props : { className : "bx-messenger-content-item-avatar"}, children : [
					BX.create("span", { props : { className : "bx-messenger-content-item-arrow"}}),
					BX.create('img', { props : { className : "bx-messenger-content-item-avatar-img" }, attrs : {src : messageUser.avatar}})
				]}),
				BX.create("div", { props : { className : "bx-messenger-history-hide"}, html : '&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;' })
			]}));
		} 
		else 
		{
			content.appendChild(BX.create("div", { attrs : { 'data-senderId' : message.senderId, 'data-messageDate' : message.date, 'data-messageId' : message.id }, props: { className : "bx-messenger-content-item bx-messenger-content-item-2"}, children: [
				BX.create("div", { props : { className : "bx-messenger-history-hide"}, html : messageUser.name+' ['+BX.Messenger.FormatDate(message.date)+']' }),
				BX.create("span", { props : { className : "bx-messenger-content-item-avatar"}, children : [
					BX.create("span", { props : { className : "bx-messenger-content-item-arrow"}}),
					BX.create('img', { props : { className : "bx-messenger-content-item-avatar-img" }, attrs : {src : messageUser.avatar}})
				]}),
				BX.create("span", { props : { className : "bx-messenger-content-item-content"}, children : [
					BX.create("span", { props : { className : "bx-messenger-content-item-text-top"}}),
					BX.create("span", { props : { className : "bx-messenger-content-item-text-center"}, children: [
						lastMessageElement = BX.create("span", {  props : { className : "bx-messenger-content-item-text-message"}, html: this.prepareText(message.text)}),
						BX.create("span", { props : { className : "bx-messenger-content-item-date"}, html: (temp? BX.message('IM_MESSENGER_DELIVERED'): messageUser.name+' &nbsp; '+BX.Messenger.FormatDate(message.date))}),
						BX.create("span", { props : { className : "bx-messenger-clear"}})
					]}),
					BX.create("span", { props : { className : "bx-messenger-content-item-text-bottom"}})
				]}),
				BX.create("div", { props : { className : "bx-messenger-history-hide"}, html : '&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;' })
			]}));
		}
	}

	if (scroll)
	{
		this.popupMessengerScroll.reDraw();
		this.popupMessengerScroll.moveToEnd();
	}

	return messageId;
}

BX.Messenger.prototype.contactListRedraw = function(send)
{
	if (this.popupContactList == null)
		return false;
	
	this.closeMenuPopup();
	
	send = send == false? false: true;
	
	if (!this.settings.viewOffline)
		BX.removeClass(this.contactListPanelViewOffline, 'bx-messenger-cl-panel-offline-active');
	else
		BX.addClass(this.contactListPanelViewOffline, 'bx-messenger-cl-panel-offline-active');
		
	if (!this.settings.viewGroup)
		BX.removeClass(this.contactListPanelViewGroup, 'bx-messenger-cl-panel-group-active');
	else
		BX.addClass(this.contactListPanelViewGroup, 'bx-messenger-cl-panel-group-active');
	
	BX.cleanNode(this.popupContactListElementsWrap);
	BX.adjust(this.popupContactListElementsWrap, {children: this.contactListPrepareList()});
	this.popupContactListScroll.reDraw();	
	
	if (send)
		BX.localStorage.set('mrd', {viewGroup: this.settings.viewGroup, viewOffline: this.settings.viewOffline}, 5);
}

BX.Messenger.prototype.contactListPrepareList = function()
{
	var items = [];
	var groups = {};
	
	var activeSearch = this.contactListSearch.length == 0? false: true;
	
	var viewGroup =  this.settings.viewGroup;//this.contactListSearch.length == 0? this.settings.viewGroup: false;
	var viewOffline =  activeSearch? true: this.settings.viewOffline;
		
	if (viewGroup)
		groups = this.groups;
	else
		groups = this.woGroups;
		
	for (var i in groups)
	{
		group = groups[i];
			
		if (!group.name || !BX.type.isNotEmptyString(group.name))
			continue;

		userItems = [];	
		
		var userInGroup = {};
		if (viewGroup)
			userInGroup = this.userInGroup[i];
		else
			userInGroup = this.woUserInGroup[i];
		
		if (userInGroup)
		{
			for (j = 0, len = userInGroup.users.length; j < len; j++)
			{
				var user = this.users[userInGroup.users[j]];
				if (user == undefined || this.settings.userId == user.id)
					continue;
					
				if (activeSearch && user.name.toLowerCase().indexOf(this.contactListSearch.toLowerCase()) < 0)
					continue;
				
				var newMessage = '';
				if (this.unreadMessage[user.id])
					newMessage = 'bx-messenger-cl-status-new-message';
			
				if (i != 'last' && viewOffline == false && user.status == "offline" && newMessage == '')
					continue;
					
				var div = BX.create("div", {
					props : { className: "bx-messenger-cl-item bx-messenger-cl-status-" +user.status+ " " +newMessage },
					attrs : { 'data-userId' : user.id, 'data-name' : user.name, 'data-status' : user.status, 'data-avatar' : user.avatar },
					html :  '<div class="bx-messenger-cl-item-wrap"><span class="bx-messenger-cl-status"></span><span class="bx-messenger-cl-user">'+user.name+'</span><span class="bx-messenger-cl-avatar">'+(user.avatar == ""? '': '<img src="'+user.avatar+'" alt="" height="21" border="0" width="21">')+'</span></div>'
				});
				userItems.push(div);
			}
			if (userItems.length > 0)
			{
				var div = BX.create("div", {
					props : { className: "bx-messenger-cl-group" +  (activeSearch || group.status == "open" ? " bx-messenger-cl-group-open" : "")},
					children : [
						BX.create("div", {props : { className: "bx-messenger-cl-group-title"}, attrs : { 'data-groupId' : group.id }, children : [
							BX.create("span", {props : { className: "bx-messenger-cl-group-title-left"}}),
							BX.create("span", {props : { className: "bx-messenger-cl-group-title-text"}, attrs : { title : group.name }, html : group.name}),
							BX.create("span", {props : { className: "bx-messenger-cl-group-title-right"}})
						]}),
						BX.create("span", {props : { className: "bx-messenger-cl-group-wrapper"}, children : userItems})
					]
				});
				items.push(div);
			}
			
		}
	}
	if (items.length <= 0)
	{
		var div = BX.create("div", {
			props : { className: "bx-messenger-cl-item-empty"},
			html :  BX.message('IM_MESSENGER_CL_EMPTY')
		});
		items.push(div);
	}
	return items;
};

BX.Messenger.prototype.openContactList = function()
{
	if (this.popupContactList !== null)
	{
		//this.contactListFocusOut();
		this.popupContactList.close();
		return false;
	}
	this.popupContactList = new BX.PopupWindow('bx-messenger-popup-contact-list', this.notifier.panel, {
		lightShadow : true,
		offsetTop: 10,
		offsetLeft: -28,
		autoHide: false,
		/*draggable: {restrict: true},*/
		bindOptions: this.notifier.settings.panelPosition.vertical == "bottom"? {position: "top", forceTop: true}: {position: "bottom"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.delegate(function() {
				this.popupContactList = null; 
				this.setUpdateStateStep();
			}, this)
		},
		titleBar: {content: BX.create('span', {props : { className : "bx-messenger-title" }, html: BX.message('IM_MESSENGER_CONTACT_LIST')+'<span class="bx-messenger-cl-search"></span>'})},
		closeIcon : {'marginTop': '5px', 'marginRight': '0px'},
		content : this.popupContactListWrap = BX.create("div", { children : [
			BX.create('div', {props : { className : "bx-messenger-cl-search-wrap" }, html: '<input type="text" class="bx-messenger-cl-search-input" value="'+this.contactListSearch+'" />'}),
			this.popupContactListElements = BX.create("div", { props : { className : "bx-messenger-cl" }, children : [			
				BX.create("div", { props : { className : "bx-messenger-cl-wrap" }, children: this.contactListPrepareList()})		
			]}),
			this.contactListPanel = BX.create('div', {props : { className : "bx-messenger-cl-panel" }, children : [ BX.create('div', {props : { className : "bx-messenger-cl-panel-wrap" }, children : [
				this.contactListPanelStatus = BX.create("span", { props : { className : "bx-messenger-cl-panel-status-wrap bx-messenger-cl-panel-status-"+this.settings.status }, html: '<span class="bx-messenger-cl-panel-status"></span><span class="bx-messenger-cl-panel-status-text">'+BX.message("IM_STATUS_"+this.settings.status.toUpperCase())+'</span><span class="bx-messenger-cl-panel-status-arrow"></span>'}),
				BX.create('span', {props : { className : "bx-messenger-cl-panel-right-wrap" }, children : [
					this.contactListPanelViewOffline = BX.create("span", { props : { title : BX.message("IM_MESSENGER_VIEW_OFFLINE"), className : "bx-messenger-cl-panel-offline-wrap"+(this.settings.viewOffline? ' bx-messenger-cl-panel-offline-active': '') }}),
					this.contactListPanelViewGroup = BX.create("span", { props : { title : BX.message("IM_MESSENGER_VIEW_GROUP"), className : "bx-messenger-cl-panel-group-wrap"+(this.settings.viewGroup? ' bx-messenger-cl-panel-group-active': '') }})
				]})
			]}) ]})
		]})
	});
	this.popupContactList.show();
	this.setUpdateStateStep();
		
	this.popupContactListScroll = new BXScrollbar(this.popupContactListElements);
	this.popupContactListElementsWrap = BX.findChild(this.popupContactListElements, {className : "bx-messenger-cl-wrap"}, true);
		
	BX.bind(this.contactListPanelStatus, "click", BX.delegate(this.openStatusMenu, this));
	BX.bind(this.contactListPanelStatus, "contextmenu", BX.delegate(this.openStatusMenu, this));
	
	BX.bind(this.contactListPanelViewOffline, "click", BX.delegate(function(){
		this.settings.viewOffline = this.settings.viewOffline? false: true;
		BX.userOptions.save('IM', 'settings', 'viewOffline', this.settings.viewOffline? 'Y': 'N');
		this.contactListRedraw();
	}, this));
	BX.bind(this.contactListPanelViewGroup, "click", BX.delegate(function(){
		this.settings.viewGroup = this.settings.viewGroup? false: true;
		BX.userOptions.save('IM', 'settings', 'viewGroup', this.settings.viewGroup? 'Y': 'N');
		this.contactListRedraw();
	}, this));
	
	this.popupContactListSearchInput = BX.findChild(this.popupContactList.popupContainer, {className : "bx-messenger-cl-search-input"}, true);
	
	if(this.contactListSearch != '')
		this.openSearch(true, false);
	
	BX.bind(BX.findChild(this.popupContactList.popupContainer, {className : "bx-messenger-cl-search"}, true), "click",  BX.delegate(this.openSearch, this));
	BX.bind(this.popupContactListSearchInput, "keydown", (this.popupContactListSearch = BX.delegate(this.newSearch, this)));
	BX.bind(this.popupContactListSearchInput, "keyup", (this.popupContactListSearchKey = BX.delegate(this.newSearchKey, this)));
		
	BX.bindDelegate(this.popupContactListElements, 'click', {className: 'bx-messenger-cl-group-title'}, BX.delegate(function(e) {
		var id = BX.proxy_context.getAttribute('data-groupId');
		var status = '';
		var wrapper = BX.findNextSibling(BX.proxy_context, {className: 'bx-messenger-cl-group-wrapper'});
		
		if (wrapper.childNodes.length > 0)
		{
			if (BX.hasClass(BX.proxy_context.parentNode, 'bx-messenger-cl-group-open'))
			{
				status = 'close';
				BX.removeClass(BX.proxy_context.parentNode, 'bx-messenger-cl-group-open');
			}
			else
			{
				status = 'open';
				BX.addClass(BX.proxy_context.parentNode, 'bx-messenger-cl-group-open');

			}
			BX.userOptions.save('IM', 'groupStatus', id, status);
			this.popupContactListScroll.reDraw();	
		}
		else
		{
			if (BX.hasClass(BX.proxy_context.parentNode, 'bx-messenger-cl-group-open'))
			{
				status = 'close';
				BX.removeClass(BX.proxy_context.parentNode, 'bx-messenger-cl-group-open');
			}
			else
			{
				status = 'open';
				BX.addClass(BX.proxy_context.parentNode, 'bx-messenger-cl-group-open');
			}
			BX.userOptions.save('IM', 'groupStatus', id, status);
			this.popupContactListScroll.reDraw();
		}
		
		if (this.settings.viewGroup)
			this.groups[id].status = status;
		else
			this.woGroups[id].status = status;
			
		BX.localStorage.set('mgp', {'id': id, 'status': status}, 5);
		
	}, this));
	
	BX.bindDelegate(this.popupContactListElements, "contextmenu", {className: 'bx-messenger-cl-item'}, BX.delegate(function(e) {
		var userId = BX.proxy_context.getAttribute('data-userId');
		this.contactListMenu(userId, BX.proxy_context);
		return BX.PreventDefault(e);
	}, this));	
	
	BX.bindDelegate(this.popupContactListElements, "click", {className: 'bx-messenger-cl-item'}, BX.delegate(function(e) {
		this.closeMenuPopup();
		var userId = BX.proxy_context.getAttribute('data-userId');
		this.openMessenger(userId);
		return BX.PreventDefault(e);
	}, this));
	
	BX.bindDelegate(this.popupContactListElements, 'mouseover', {className: 'bx-messenger-cl-item'}, function(e) {
		BX.addClass(this, 'bx-messenger-cl-item-hover');
		return BX.PreventDefault(e);
	});	
	BX.bindDelegate(this.popupContactListElements, 'mouseout', {className: 'bx-messenger-cl-item'}, function(e) {
		BX.removeClass(this, 'bx-messenger-cl-item-hover');
		return BX.PreventDefault(e);
	});		
	//BX.bind(this.popupContactList.popupContainer, "click", BX.delegate(function(e){
	//	this.contactListFocusIn();
	//	return BX.PreventDefault(e);
	//}, this));
	
	//this.contactListFocusIn();
};

BX.Messenger.prototype.loadLastMessage = function(userId)
{
	BX.ajax({
		url: '/bitrix/components/bitrix/im.messenger/im.ajax.php',
		method: 'POST',
		dataType: 'json',
		lsId: 'IM_LOAD_LAST_MESSAGE_'+userId,
		lsTimeout: 15,
		data: {'IM_LOAD_LAST_MESSAGE' : 'Y', 'USER_ID' : userId, 'TAB' : this.currentTab, 'TABS' : this.openTab, 'sessid': BX.bitrix_sessid()},
		onsuccess: BX.delegate(function(data){
			var messageCnt = 0
			for (var i in data.MESSAGE)
			{	
				messageCnt++;
				this.message[i] = data.MESSAGE[i];
			}

			if (messageCnt <= 0)
				delete this.redrawTab[data.USER_ID];
				
			for (var i in data.USERS_MESSAGE)
			{	
				if (!this.forceLoadMessage && this.showMessage[i])
					this.showMessage[i] = BX.util.array_unique(BX.util.array_merge(this.showMessage[i], data.USERS_MESSAGE[i])); 
				else
					this.showMessage[i] = data.USERS_MESSAGE[i];
			}
			if (this.showMessage[i])
				this.showMessage[i].sort(function(s1, s2) {s2 = parseInt(s2);s1 = parseInt(s1);if (s1 > s2) {return 1; }	else if (s1 < s2) {return -1;}else{	return 0; }});
			
			this.changeUnreadMessage(data.UNREAD_MESSAGE);	
			
			this.drawTab(data.USER_ID, this.popupMessengerTabsContentByUser[data.USER_ID], this.currentTab == data.USER_ID? true: false);
			
			this.forceLoadMessage = false;
		}, this),
		onfailure: function(data)	{} 
	});
}

BX.Messenger.prototype.contactListFocusIn = function()
{
	this.popupContactListFocus = true;
	BX.bind(document, "keydown", (this.popupContactListSearch = BX.delegate(this.newSearch, this)));
	BX.bind(document, "keyup", (this.popupContactListSearchKey = BX.delegate(this.newSearchKey, this)));
	BX.onCustomEvent(this, 'onContactListFocusIn', [true]);
}

BX.Messenger.prototype.contactListFocusOut = function()
{
	this.popupContactListFocus = false; 
	BX.unbind(document, "keydown", this.popupContactListSearch);
	BX.unbind(document, "keyup", this.popupContactListSearchKey);
	BX.onCustomEvent(this, 'onContactListFocusOut', [true]);
}

BX.Messenger.prototype.newSearchKey = function(event)
{
	if (event.keyCode == 27)
		this.popupContactListSearchInput.value = '';
			
	this.contactListSearch = BX.util.trim(this.popupContactListSearchInput.value); 
	
	BX.localStorage.set('mns', this.contactListSearch, 5);
	
	this.contactListRedraw(false);
}
BX.Messenger.prototype.newSearch = function(event)
{
	//if (!this.popupContactListFocus)
	//	return false;
		
	event = event || null;
	if (event != null)
	{
		if (event.ctrlKey || event.altKey || event.shiftKey)
			return false;
	}
	this.openSearch(true, true, event);
}

BX.Messenger.prototype.openSearch = function(forceOpen, send, event)
{
	if (this.popupContactList == null)
		return false;
		
	forceOpen = forceOpen == true? true: false;
	send = send == false? false: true;
	
	if (forceOpen || !BX.hasClass(this.popupContactList.popupContainer, "bx-messenger-cl-search-active"))
	{
		BX.addClass(this.popupContactList.popupContainer, "bx-messenger-cl-search-active");
		if (this.popupContactListSearchInput.value != '' && this.contactListSearch == '')
		{
			this.contactListSearch = this.popupContactListSearchInput.value;
			this.contactListRedraw(false);
		}
		BX.focus(this.popupContactListSearchInput);
		if (send)
			BX.localStorage.set('mos', {'button': true, 'text': this.contactListSearch}, 5);
	}
	else
	{
		if (this.contactListSearch != '')
		{
			this.contactListSearch = '';
			this.contactListRedraw(send);
		}
		BX.removeClass(this.popupContactList.popupContainer, "bx-messenger-cl-search-active");
		if (send)
			BX.localStorage.set('mos', {'button': false, 'text': this.contactListSearch}, 5);
	}
}

BX.Messenger.prototype.openStatusMenu = function(event)
{
	event = event || window.event;
	
	if (this.popupStatusMenu !== null)
	{
		this.popupStatusMenu.destroy();
		return BX.PreventDefault(event);
	}
	
	menuItems = [
		{icon: 'bx-messenger-status-online', text: BX.message("IM_STATUS_ONLINE"), onclick: BX.delegate(function(){ this.setStatus('online'); this.closeMenuPopup(); }, this)},
		{icon: 'bx-messenger-status-dnd', text: BX.message("IM_STATUS_DND"), onclick: BX.delegate(function(){ this.setStatus('dnd'); this.closeMenuPopup(); }, this)}
	];
		
	this.popupStatusMenu = new BX.PopupWindow('bx-messenger-popup-status-menu', this.contactListPanelStatus, {
		lightShadow : true,
		offsetTop: -3,
		offsetLeft: 0,
		autoHide: true,
		closeByEsc: true,
		bindOptions: {position: "top"},
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.delegate(function() { this.popupStatusMenu = null; }, this)
		},
		content : BX.create("div", { props : { className : "bx-messenger-popup-menu" }, children: [
			BX.create("div", { props : { className : "bx-messenger-popup-menu-items" }, children: BX.Messenger.MenuPrepareList(this.contactListPanelStatus, menuItems)})
		]})
	});
	this.popupStatusMenu.setAngle({offset: 18});
	this.popupStatusMenu.show();
	
	return BX.PreventDefault(event);
};

BX.Messenger.prototype.contactListMenu = function(userId, element)
{	
	if (this.popupContactListMenu !== null)
	{
		this.popupContactListMenu.destroy();
		return false;
	}	
	
	menuItems = [
		{icon: 'bx-messenger-menu-write', text: BX.message('IM_MESSENGER_WRITE_MESSAGE'), onclick: BX.delegate(function(){ this.openMessenger(userId); this.closeMenuPopup(); }, this)},
		{icon: 'bx-messenger-menu-history', text: BX.message('IM_MESSENGER_OPEN_HISTORY'), onclick: BX.delegate(function(){ this.openHistory(userId); this.closeMenuPopup();}, this)},		
		//{icon: 'bx-messenger-menu-video', text: BX.message('IM_MESSENGER_OPEN_VIDEO'), onclick: BX.delegate(function(){ this.closePopup(); }, this)},		
		{icon: 'bx-messenger-menu-profile', text: BX.message('IM_MESSENGER_OPEN_PROFILE'), href: this.users[userId].profile, onclick: BX.delegate(function(){ this.closeMenuPopup(); }, this)}
	];

	this.popupContactListMenu = new BX.PopupWindow('bx-messenger-popup-menu', element, {
		lightShadow : true,
		offsetTop: -3,
		offsetLeft: 0,
		autoHide: true,
		closeByEsc: true,
		events : {
			onPopupClose : function() { this.destroy() },
			onPopupDestroy : BX.delegate(function() { this.popupContactListMenu = null; }, this)
		},
		content : BX.create("div", { props : { className : "bx-messenger-popup-menu" }, children: [
			BX.create("div", { props : { className : "bx-messenger-popup-menu-items" }, children: BX.Messenger.MenuPrepareList(this, menuItems)})
		]})
	});
	this.popupContactListMenu.setAngle({offset: 18});
	this.popupContactListMenu.show();
};


BX.Messenger.prototype.adjustPopup = function(event)
{
	if (this.popupContactList !== null)
		this.popupContactList.adjustPosition();	
};

BX.Messenger.prototype.closeMenuPopup = function()
{
	if (this.popupContactListMenu != null)
		this.popupContactListMenu.destroy();
	if (this.popupStatusMenu != null)
		this.popupStatusMenu.destroy();
}


BX.Messenger.MenuPrepareList = function(element, menuItems)
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
			props : { className: "bx-messenger-popup-menu-item" +  (BX.type.isNotEmptyString(item.className) ? " " + item.className : "")},
			attrs : { title : item.title ? item.title : "",  href : item.href ? item.href : ""},
			events : item.onclick && BX.type.isFunction(item.onclick) ? { click : BX.delegate(item.onclick, element) } : null,
			html :  '<span class="bx-messenger-popup-menu-item-left"></span>'+(item.icon? '<span class="bx-messenger-popup-menu-item-icon '+item.icon+'"></span>':'')+'<span class="bx-messenger-popup-menu-item-text">' + item.text + '</span><span class="bx-messenger-popup-menu-right"></span>'
		});

		if (item.href)
			a.href = item.href; 
		items.push(a);
	}
	return items;
};

BX.Messenger.FormatDate = function(timestamp)
{
	var format = [
		["tommorow", "tommorow, H:i"],
		["today", "today, H:i"],
		["yesterday", "yesterday, H:i"],
		["", BX.date.convertBitrixFormat(BX.message("FORMAT_DATETIME"))]
	];
	return BX.date.format(format, parseInt(timestamp));
}

BX.Messenger.prototype.changeFavicon = function(faviconUrl, blink, blinkUrl)
{
	faviconUrl = faviconUrl && faviconUrl != ''? faviconUrl: '';
	blink = blink == true ? true: false;
	
	var favicon = BX.findChild(this.windowHead, {tagName : "link", attribute: {'rel': 'shortcut icon'}}, false);
	if (favicon)
	{
		if (this.windowFavicon == null)
			this.windowFavicon = favicon.href;
		BX.remove(favicon);
	} 
	else if (this.windowFavicon == null)
		this.windowFavicon = '//'+location.host+'/favicon.ico';
	
	if (faviconUrl != '')
		this.windowHead.appendChild(BX.create("link", {attrs : { 'href' : faviconUrl, 'type' : 'image/x-icon', 'rel' : 'shortcut icon'}}));  
	
	clearTimeout(this.windowFaviconTimeout);
	if (blink)
	{
		blinkUrl = blinkUrl == undefined ? this.windowFavicon: blinkUrl;
		this.windowFaviconTimeout = setTimeout(BX.delegate(function(){	
			this.changeFavicon(blinkUrl, true, faviconUrl)
		}, this), this.windowFavicon != blinkUrl? 1000: 3000);
	}
}

BX.Messenger.prototype.storageSet = function(params)
{		
	if (params.key == 'mus')
	{
		this.updateState(true);
	}
	else if (params.key == 'mms')
	{
		this.setStatus(params.value, false);
	}
	else if (params.key == 'mot')
	{
		this.openTab = params.value;
	}
	else if (params.key == 'mom')
	{
		if (this.popupMessenger != null)
			this.openMessenger(params.value, false);
	}
	else if (params.key == 'mrd')
	{
		this.settings.viewGroup = params.value.viewGroup;
		this.settings.viewOffline = params.value.viewOffline;
		
		this.contactListRedraw(false);
	}
	else if (params.key == 'mgp')
	{
		if (this.settings.viewGroup)
			this.groups[params.value.id].status = params.value.status;
		else
			this.woGroups[params.value.id].status = params.value.status;
			
		this.contactListRedraw(false);
	}
	else if (params.key == 'mrm')
	{
		this.readMessage(params.value, false);
	}
	else if (params.key == 'mnm')
	{
	//	this.flashMessage = params.value;
	//	this.newMessage(false);
	}
	else if (params.key == 'mclr')
	{
	//	this.contactListRedraw(false);
	}
	else if (params.key == 'mns')
	{
		if (this.popupContactListSearchInput != null)
			this.popupContactListSearchInput.value = params.value;
		
		this.contactListSearch = params.value;	
		
		this.contactListRedraw(false);
	}
	else if (params.key == 'mos')
	{
		if (this.popupContactListSearchInput != null)
			this.popupContactListSearchInput.value = params.value.text;
		
		this.contactListSearch = params.value.text;	
		this.openSearch(params.value.button, false);
	}
	else if (params.key == 'msm')
	{
		if (this.popupMessengerTextarea)
			this.popupMessengerTextarea.value = params.value.text;
		this.messageTmpIndex = params.value.index;
		this.sendMessage(params.value.recipientId, true);
	}
	else if (params.key == 'uss')
	{
		this.updateStateStep = parseInt(params.value);
	}
	else if (params.key == 'mumc')
	{
		this.unreadMessage = params.value;
		this.updateMessageCount();
	}
};
})();