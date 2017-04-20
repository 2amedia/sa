/**
 * @bxjs_lang_path js_phone_call_view.php
 */
(function()
{
	/* Phone Call UI */
	var nop = function(){};
	var layouts = {
		simple: 'simple',
		crm: 'crm'
	};

	var baseZIndex = 15000;
	var defaults = {
		restApps: []		//{id: int, name: string}
	};

	var desktopEvents = {
		setTitle: 'phoneCallViewSetTitle',
		setStatus: 'phoneCallViewSetStatus',
		setUiState: 'phoneCallViewSetUiState',
		setDeviceCall: 'phoneCallViewSetDeviceCall',
		setCrmEntity: 'phoneCallViewSetCrmEntity',
		setPortalCall: 'phoneCallViewSetPortalCall',
		setPortalCallUserId: 'phoneCallViewSetPortalCallUserId',
		setPortalCallData: 'phoneCallViewSetPortalCallData',
		setConfig: 'phoneCallViewSetConfig',
		reloadCrmCard: 'phoneCallViewReloadCrmCard',
		setCallId: 'phoneCallViewSetCallId',
		closeWindow: 'phoneCallViewCloseWindow',

		onHold: 'phoneCallViewOnHold',
		onUnHold: 'phoneCallViewOnUnHold',
		onMute: 'phoneCallViewOnMute',
		onUnMute: 'phoneCallViewOnUnMute',
		onMakeCall: 'phoneCallViewOnMakeCall',
		onCallListMakeCall: 'phoneCallViewOnCallListMakeCall',
		onAnswer: 'phoneCallViewOnAnswer',
		onSkip: 'phoneCallViewOnSkip',
		onHangup: 'phoneCallViewOnHangup',
		onClose: 'phoneCallViewOnClose',
		onStartTransfer: 'phoneCallViewOnStartTransfer',
		onCancelTransfer: 'phoneCallViewOnCancelTransfer',
		onBeforeUnload: 'phoneCallViewOnBeforeUnload',
		onSwitchDevice: 'phoneCallViewOnSwitchDevice',
		onQualityGraded: 'phoneCallViewOnQualityGraded',
		onDialpadButtonClicked: 'phoneCallViewOnDialpadButtonClicked'
	};

	BX.PhoneCallView = function(params)
	{
		this.id = 'im-phone-call-view';
		this.BXIM = params.BXIM || window.BXIM;

		if(!BX.type.isPlainObject(params))
			params = {};

		this.keypad = null;

		//params
		this.phoneNumber = params.phoneNumber || 'hidden';
		this.companyPhoneNumber = params.companyPhoneNumber || '';
		this.direction = params.direction || BX.PhoneCallView.Direction.incoming;
		this.fromUserId = params.fromUserId;
		this.toUserId = params.toUserId;
		this.config = params.config || {};
		this.callId = params.callId || '';

		//associated crm entities
		this.crmEntityType = params.crmEntityType || '';
		this.crmEntityId = params.crmEntityId || 0;
		this.crmActivityId = params.crmActivityId || 0;
		this.crmActivityEditUrl = params.crmActivityEditUrl || '';
		this.externalRequests = {};

		//portal call
		this.portalCallUserId = params.portalCallUserId;
		this.portalCallData = params.portalCallData;

		//flags
		this.hasSipPhone = (params.hasSipPhone === true);
		this.deviceCall = (params.deviceCall === true);
		this.portalCall = (params.portalCall === true);
		this.crm = (params.crm === true);
		this.held = false;
		this.muted = false;
		this.recording = (params.recording === true);
		this.makeCall = (params.makeCall === true); // emulate pressing on "dial" button right after showing call view
		this.closable = false;

		this.title = '';
		this._uiState = params.uiState || BX.PhoneCallView.UiState.idle;
		this.statusText = params.statusText || '';
		this.progress = '';
		this.quality = 0;
		this.qualityPopup = null;
		this.qualityGrade = 0;
		this.initialWidth = 0;

		//timer
		this.lastTimestamp = 0;
		this.elaplsedMilliSeconds = 0;
		this.timerInterval = null;

		this.elements = {
			main: null,
			title: null,
			sections: {
				status: null,
				timer: null,
				crmButtons: null
			},
			avatar: null,
			progress: null,
			timer: null,
			status: null,
			qualityMeter: null,
			crmCard: null,
			crmButtons: null,
			buttonsContainer: null,
			topLevelButtonsContainer: null,
			topButtonsContainer: null, //well..
			buttons: {},
			sidebarContainer: null,
			tabsContainer: null,
			tabsBodyContainer: null,
			tabs: {
				callList: null,
				webform: null,
				app: null
			},
			tabsBody: {
				callList: null,
				webform: null,
				app: null
			},
			moreTabs: null
		};

		var uiStateButtons = this.getUiStateButtons(this._uiState);
		this.buttonLayout = uiStateButtons.layout;
		this.buttons = uiStateButtons.buttons;

		if(!BX.type.isPlainObject(params.events))
			params.events = {};

		this.callbacks = {
			hold: BX.type.isFunction(params.events.hold) ? params.events.hold : nop,
			unhold: BX.type.isFunction(params.events.unhold) ? params.events.unhold : nop,
			mute: BX.type.isFunction(params.events.mute) ? params.events.mute : nop,
			unmute: BX.type.isFunction(params.events.unmute) ? params.events.unmute : nop,
			makeCall: BX.type.isFunction(params.events.makeCall) ? params.events.makeCall : nop,
			callListMakeCall: BX.type.isFunction(params.events.callListMakeCall) ? params.events.callListMakeCall : nop,
			answer: BX.type.isFunction(params.events.answer) ? params.events.answer : nop,
			skip: BX.type.isFunction(params.events.skip) ? params.events.skip : nop,
			hangup: BX.type.isFunction(params.events.hangup) ? params.events.hangup : nop,
			close: BX.type.isFunction(params.events.close) ? params.events.close : nop,
			transfer: BX.type.isFunction(params.events.transfer) ? params.events.transfer : nop,
			cancelTransfer: BX.type.isFunction(params.events.cancelTransfer) ? params.events.cancelTransfer : nop,
			switchDevice: BX.type.isFunction(params.events.switchDevice) ? params.events.switchDevice : nop,
			qualityGraded: BX.type.isFunction(params.events.qualityGraded) ? params.events.qualityGraded : nop,
			dialpadButtonClicked: BX.type.isFunction(params.events.dialpadButtonClicked) ? params.events.dialpadButtonClicked : nop
		};

		this.popup = null;

		// event handlers
		this._onHoldButtonClickHandler = this._onHoldButtonClick.bind(this);
		this._onMuteButtonClickHandler = this._onMuteButtonClick.bind(this);
		this._onTransferButtonClickHandler = this._onTransferButtonClick.bind(this);
		this._onTransferCancelButtonClickHandler = this._onTransferCancelButtonClick.bind(this);
		this._onDialpadButtonClickHandler = this._onDialpadButtonClick.bind(this);
		this._onHangupButtonClickHandler = this._onHangupButtonClick.bind(this);
		this._onCloseButtonClickHandler = this._onCloseButtonClick.bind(this);
		this._onMakeCallButtonClickHandler = this._onMakeCallButtonClick.bind(this);
		this._onNextButtonClickHandler = this._onNextButtonClick.bind(this);
		this._onRedialButtonClickHandler = this._onRedialButtonClick.bind(this);
		this._onFoldButtonClickHandler = this._onFoldButtonClick.bind(this);
		this._onAnswerButtonClickHandler = this._onAnswerButtonClick.bind(this);
		this._onSkipButtonClickHandler = this._onSkipButtonClick.bind(this);
		this._onSwitchDeviceButtonClickHandler = this._onSwitchDeviceButtonClick.bind(this);
		this._onQualityMeterClickHandler = this._onQualityMeterClick.bind(this);
		this._onPullEventCrmHandler = this._onPullEventCrm.bind(this);

		this._externalEventHandler = this._onExternalEvent.bind(this);
		this._unloadHandler = this._onWindowUnload.bind(this);

		// tabs
		this.hiddenTabs = [];
		this.currentTabName = '';
		this.moreTabsMenu = null;

		// callList
		this.callListId = params.callListId || 0;
		this.callListStatusId = params.callListStatusId || null;
		this.callListItemIndex = params.callListItemIndex || null;
		this.callListView = null;
		this.currentEntity = null;
		this.callingEntity = null;

		// webform
		this.webformId = params.webformId || 0;
		this.webformSecCode = params.webformSecCode || '';
		this.webformLoaded = false;
		this.formManager = null;

		// partner data
		this.restAppLayoutLoaded = false;
		this.restAppLayoutLoading = false;

		// desktop integration
		this.callWindow = null;
		this.slave = params.slave === true;
		this.desktop = new Desktop({
			BXIM: this.BXIM,
			parentPhoneCallView: this,
			closable: (this.callListId > 0 ? true : this.closable)
		});

		this.currentLayout = (this.callListId > 0 ? layouts.crm : layouts.simple);
		this.init();
		this.setTitle(this.createTitle());
		if(params.hasOwnProperty('uiState'))
		{
			this.setUiState(params['uiState']);
		}

		window.test = this;
	};

	BX.PhoneCallView.ButtonLayouts = {
		centered: 'centered',
		spaced: 'spaced'
	};

	BX.PhoneCallView.create = function(params)
	{
		return new BX.PhoneCallView(params);
	};

	BX.PhoneCallView.prototype.init = function()
	{
		var self = this;

		if(BX.MessengerCommon.isDesktop() && !this.slave)
		{
			this.desktop.openCallWindow();
			this.bindMasterDesktopEvents();

			window.addEventListener('beforeunload', this._unloadHandler); //master window unload
			return;
		}

		this.elements.main = this.createLayout();
		this.updateView();

		if(this.isDesktop())
		{
			document.body.appendChild(this.elements.main);
			//this.desktop.resize(this.initialWidth, this.elements.main.clientHeight);
			this.desktop.resizeTo(this.elements.main);
			this.bindSlaveDesktopEvents();
		}
		else
		{
			this.popup = this.createPopup();
			BX.addCustomEvent(window, "onLocalStorageSet", this._externalEventHandler);
		}

		if(this.callListId > 0)
		{
			this.callListView = new CallList({
				node: this.elements.tabsBody.callList,
				id: this.callListId,
				statusId: this.callListStatusId,
				itemIndex: this.callListItemIndex,
				makeCall: this.makeCall,
				BXIM: this.BXIM,
				onSelectedItem: this.onCallListSelectedItem.bind(this)
			});

			this.callListView.init(function()
			{
				if(self.makeCall)
				{
					self._onMakeCallButtonClick();
				}
			});
			this.setUiState(BX.PhoneCallView.UiState.outgoing);
		}
		else if(this.crm)
		{
			this.loadCrmCard(this.crmEntityType, this.crmEntityId);
		}

		BX.addCustomEvent("onPullEvent-crm", this._onPullEventCrmHandler);
	};

	BX.PhoneCallView.setDefaults = function(params)
	{
		for(paramName in params)
		{
			if(params.hasOwnProperty(paramName) && defaults.hasOwnProperty(paramName))
			{
				defaults[paramName] = params[paramName];
			}
		}
	};

	BX.PhoneCallView.prototype.show = function()
	{
		if(!this.popup)
			return;

		this.popup.show();
	};

	BX.PhoneCallView.prototype.createPopup = function()
	{
		var self = this;

		return new BX.PopupWindow(self.getId(), null, {
			content: this.elements.main,
			closeIcon: false,
			noAllPaddings: true,
			zIndex: baseZIndex,
			offsetLeft: 0,
			offsetTop: 0,
			closeByEsc: false,
			draggable: {restrict: false},
			overlay: {backgroundColor: 'black', opacity: 30},
			events: {
				onPopupClose: function()
				{
					self.callbacks.close();
				}
			}
		});
	};

	BX.PhoneCallView.prototype.createLayout = function()
	{
		if(this.currentLayout == layouts.crm)
			return this.createLayoutCrm();
		else
			return this.createLayoutSimple();
	};

	BX.PhoneCallView.prototype.createLayoutCrm = function()
	{
		var result = BX.create("div", {props: {className: 'im-phone-call-top-level'}, children: [
			this.elements.topLevelButtonsContainer = BX.create("div"),
			BX.create("div", {props: {className: 'im-phone-call-wrapper'}, children: [
				BX.create("div", {props: {className: 'im-phone-call-container'}, children: [

					BX.create("div", {props: {className: 'im-phone-call-header-container'}, children: [
						BX.create("div", {props: {className: 'im-phone-call-header'}, children: [
							this.elements.title = BX.create('div', {props: {className: 'im-phone-call-title-text'}, html: this.title})
						]})
					]}),
					this.elements.crmCard = BX.create("div", {props: {className: 'im-phone-call-crm-card'}}),
					this.elements.sections.status = BX.create("div", {props: {className: 'im-phone-call-section'}, style: {display: 'none'}, children: [
						BX.create("div", {props: {className: 'im-phone-call-status-description'}, children: [
							this.elements.status = BX.create("div", {props: {className: 'im-phone-call-status-description-item'}})
						]})
					]}),
					this.elements.sections.timer = BX.create("div", {props: {className: 'im-phone-call-section'}, style: {display: 'none'}, children: [
						BX.create("div", {props: {className: 'im-phone-call-status-timer'}, children: [
							BX.create("div", {props: {className: 'im-phone-call-status-timer-item'}, children: [
								this.elements.timer = BX.create("span")
							]})
						]})
					]}),
					this.elements.sections.crmButtons = BX.create("div", {props: {className: 'im-phone-call-section'}, style: {display: 'none'}, children: [
						this.elements.crmButtons = BX.create("div", {props: {className: 'im-phone-call-crm-buttons'}})
					]}),
					this.elements.buttonsContainer = BX.create("div", {props: {className: 'im-phone-call-buttons-container'}}),
					this.elements.topButtonsContainer = BX.create("div", {props: {className: 'im-phone-call-buttons-container-top'}})
				]})
			]})
		]});

		this.createSidebarLayout();
		if(this.elements.sidebarContainer)
		{
			result.appendChild(this.elements.sidebarContainer);
			this.initialWidth = Math.min(Math.floor(screen.width * 0.8), 1200);

			setTimeout(function(){
				this.checkMoreButton();
			}.bind(this), 0);

		}
		else
		{
			this.initialWidth = 550;
		}

		result.style.width = this.initialWidth + 'px';
		return result;
	};

	BX.PhoneCallView.prototype.showSections = function(sections)
	{
		var self = this;
		if(!BX.type.isArray(sections))
			return;

		sections.forEach(function(sectionName)
		{
			if(self.elements.sections[sectionName])
				self.elements.sections[sectionName].style.removeProperty('display');
		});
	};

	BX.PhoneCallView.prototype.hideSections = function(sections)
	{
		var self = this;
		if(!BX.type.isArray(sections))
			return;

		sections.forEach(function(sectionName)
		{
			if(self.elements.sections[sectionName])
				self.elements.sections[sectionName].style.display = 'none';
		});
	};

	BX.PhoneCallView.prototype.showOnlySections = function(sections)
	{
		var self = this;
		if(!BX.type.isArray(sections))
			return;

		var sectionsIndex = {};
		sections.forEach(function(sectionName)
		{
			sectionsIndex[sectionName] = true;
		});

		for(var sectionName in this.elements.sections)
		{
			if(!this.elements.sections[sectionName])
				return;


			if(sectionsIndex[sectionName])
				this.elements.sections[sectionName].style.removeProperty('display');
			else
				this.elements.sections[sectionName].style.display = 'none';
		}
	};

	BX.PhoneCallView.prototype.createSidebarLayout = function()
	{
		var self = this;
		var tabs = [];
		var tabsBody = [];
		var hasSidebar = false;

		if (this.callListId > 0)
		{
			hasSidebar = true;
			this.elements.tabs.callList = BX.create("span", {
				props: {className: 'im-phone-sidebar-tab'},
				dataset: {tabId : 'callList', tabBodyId: 'callList'},
				text: BX.message('IM_PHONE_CALL_VIEW_CALL_LIST_TITLE'),
				events: {click: this._onTabHeaderClick.bind(this)}
			});
			tabs.push(this.elements.tabs.callList);
			this.elements.tabsBody.callList = BX.create('div');
			tabsBody.push(this.elements.tabsBody.callList);
		}

		if (this.webformId > 0)
		{
			hasSidebar = true;
			this.elements.tabs.webform = BX.create("span", {
				props: {className: 'im-phone-sidebar-tab'},
				dataset: {tabId : 'webform',  tabBodyId: 'webform'},
				text: BX.message('IM_PHONE_CALL_VIEW_WEBFORM_TITLE'),
				events: {click: this._onTabHeaderClick.bind(this)}
			});
			tabs.push(this.elements.tabs.webform);
			this.elements.tabsBody.webform = BX.create('div', {props: {className: 'im-phone-call-form-container'}});
			tabsBody.push(this.elements.tabsBody.webform);

			this.formManager = new FormManager({
				node: this.elements.tabsBody.webform,
				onFormSend: this._onFormSend.bind(this)
			})
		}

		if (defaults.restApps.length > 0)
		{
			hasSidebar = true;
			defaults.restApps.forEach(function(restApp)
			{
				var restAppId = restApp.id;
				var tabId = 'restApp' + restAppId;
				self.elements.tabs[tabId] = BX.create("span", {
					props: {className: 'im-phone-sidebar-tab'},
					dataset: {tabId : tabId, tabBodyId: 'app', restAppId: restAppId},
					text: BX.util.htmlspecialchars(restApp.name),
					events: {click: self._onTabHeaderClick.bind(self)}
				});
				tabs.push(self.elements.tabs[tabId]);

			});
			self.elements.tabsBody.app = BX.create('div', {props: {className: 'im-phone-call-app-container'}});
			tabsBody.push(self.elements.tabsBody.app);
		}

		if(hasSidebar)
		{
			this.elements.sidebarContainer = BX.create("div", {props: {className: 'im-phone-sidebar-wrap'}, children: [
				BX.create("div", {props: {className: 'im-phone-sidebar-tabs-container'}, children: [
					this.elements.tabsContainer = BX.create("div", {props: {className: 'im-phone-sidebar-tabs-left'}, children: tabs}),
					BX.create("div", {props: {className: 'im-phone-sidebar-tabs-right'}, children: [
						this.elements.moreTabs = BX.create("span", {
							props: {className: 'im-phone-sidebar-tab im-phone-sidebar-tab-more'},
							style: {display: 'none'},
							dataset: {},
							text: BX.message('IM_PHONE_CALL_VIEW_MORE'),
							events: {click: this._onTabMoreClick.bind(this)}
						})
					]})
				]}),
				this.elements.tabsBodyContainer = BX.create("div", {props: {className: 'im-phone-sidebar-tabs-body-container'}, children: tabsBody})
			]});

			if(this.callListId > 0)
				this.setActiveTab({tabId: 'callList', tabBodyId: 'callList'});
			else if (this.webformId > 0)
				this.setActiveTab({tabId: 'webform', tabBodyId: 'webform'});
			else if (defaults.restApps.length > 0)
				this.setActiveTab({tabId: 'restApp' + defaults.restApps[0].id, tabBodyId: 'app', restAppId: defaults.restApps[0].id});
		}
	};

	BX.PhoneCallView.prototype.createLayoutSimple = function()
	{
		var portalCallUserImage = '';
		if(this.isPortalCall() && this.portalCallData.hrphoto && this.portalCallData.hrphoto[this.portalCallUserId])
		{
			portalCallUserImage = this.portalCallData.hrphoto[this.portalCallUserId];
		}
		var result = BX.create("div", {props: {className: 'im-phone-call-wrapper'}, children: [
			BX.create("div", {props: {className: 'im-phone-call-container'}, children: [
				BX.create("div", {props: {className: 'im-phone-calling-section'}, children: [
					this.elements.title = BX.create("div", {props: {className: 'im-phone-calling-text'}})
				]}),
				BX.create("div", {props: {className: 'im-phone-call-section im-phone-calling-progress-section'}, children: [
					BX.create("div", {props: {className: 'im-phone-calling-progress-container'}, children: [
						BX.create("div", {props: {className: 'im-phone-calling-progress-container-block-l'}, children: [
							BX.create("div", {props: {className: 'im-phone-calling-progress-phone'}})
						]}),
						BX.create("div", {props: {className: 'im-phone-calling-progress-container-block-c'}, children: [
							BX.create("div", {props: {className: 'im-phone-calling-progress-bar'}})
						]}),
						BX.create("div", {props: {className: 'im-phone-calling-progress-container-block-r'}, children: [
							this.elements.avatar = BX.create("div", {
								props: {className: 'im-phone-calling-progress-customer'},
								style: portalCallUserImage == '' ?  {} : {'background-image': 'url(' + portalCallUserImage +')'}
							})
						]})
					]})
				]}),
				BX.create("div", {props: {className: 'im-phone-call-section'}, children: [
					this.elements.status = BX.create("div", {props: {className: 'im-phone-calling-process-status'}})
				]}),
				this.elements.buttonsContainer = BX.create("div", {props: {className: 'im-phone-call-buttons-container'}})
			]})
		]});

		this.initialWidth = 550;
		if(!this.isDesktop())
		{
			result.style.width = this.initialWidth + 'px';
		}
		return result;
	};

	BX.PhoneCallView.prototype.setActiveTab = function(params)
	{
		var tabId = params.tabId;
		var tabBodyId = params.tabBodyId;
		var restAppId = params.restAppId || '';
		params.hidden = params.hidden === true;
		for(tab in this.elements.tabs)
		{
			if(BX.type.isDomNode(this.elements.tabs[tab]))
			{
				if(tab == tabId)
					BX.addClass(this.elements.tabs[tab], 'im-phone-sidebar-tab-active');
				else
					BX.removeClass(this.elements.tabs[tab], 'im-phone-sidebar-tab-active');
			}
		}

		if(params.hidden)
			BX.addClass(this.elements.moreTabs, 'im-phone-sidebar-tab-active');
		else
			BX.removeClass(this.elements.moreTabs, 'im-phone-sidebar-tab-active');

		for(tab in this.elements.tabsBody)
		{
			if(BX.type.isDomNode(this.elements.tabsBody[tab]))
			{
				if(tab == tabBodyId)
					this.elements.tabsBody[tab].style.removeProperty('display');
				else
					this.elements.tabsBody[tab].style.display = 'none';
			}
		}

		this.currentTabName = tabId;

		if(tabId === 'webform' && !this.webformLoaded)
		{
			this.loadForm({
				id: this.webformId,
				secCode: this.webformSecCode
			})
		}

		if(restAppId != '')
		{
			this.loadRestApp({
				id: restAppId,
				callId: this.BXIM.webrtc.phoneCallId,
				node: this.elements.tabsBody.app
			});
		}
	};

	BX.PhoneCallView.prototype.isCurrentTabHidden = function()
	{
		var result = false;
		for(var i = 0; i < this.hiddenTabs.length; i++)
		{
			if(this.hiddenTabs[i].dataset.tabId == this.currentTabName)
			{
				result = true;
				break;
			}
		}
		return result;
	};

	BX.PhoneCallView.prototype.checkMoreButton = function()
	{
		if(!this.elements.tabsContainer)
			return;

		var tabs = this.elements.tabsContainer.children;
		var currentTab;
		this.hiddenTabs = [];

		for(var i = 0; i < tabs.length; i++)
		{
			currentTab = tabs.item(i);
			if(currentTab.offsetTop > 7)
			{
				this.hiddenTabs.push(currentTab);
			}
		}
		if(this.hiddenTabs.length > 0)
			this.elements.moreTabs.style.removeProperty('display');
		else
			this.elements.moreTabs.style.display = 'none';

		if(this.isCurrentTabHidden())
			BX.addClass(this.elements.moreTabs, 'im-phone-sidebar-tab-active');
		else
			BX.removeClass(this.elements.moreTabs, 'im-phone-sidebar-tab-active');
	};

	BX.PhoneCallView.prototype._onTabHeaderClick = function(e)
	{
		if(this.moreTabsMenu)
			this.moreTabsMenu.close();

		this.setActiveTab({
			tabId: e.target.dataset.tabId,
			tabBodyId: e.target.dataset.tabBodyId,
			restAppId: e.target.dataset.restAppId || '',
			hidden: false
		});
	};

	BX.PhoneCallView.prototype._onTabMoreClick = function(e)
	{
		var self = this;
		if(this.hiddenTabs.length == 0)
			return;

		if(this.moreTabsMenu)
		{
			this.moreTabsMenu.close();
			return;
		}

		var menuItems = [];
		this.hiddenTabs.forEach(function(tabElement)
		{
			menuItems.push({
				id: "selectTab_" + tabElement.dataset.tabId,
				text: tabElement.innerText,
				onclick: function()
				{
					self.moreTabsMenu.close();
					self.setActiveTab({
						tabId: tabElement.dataset.tabId,
						tabBodyId: tabElement.dataset.tabBodyId,
						restAppId: tabElement.dataset.restAppId || '',
						hidden: true
					});
				}
			})
		});

		this.moreTabsMenu = BX.PopupMenu.create(
			'phoneCallViewMoreTabs',
			this.elements.moreTabs,
			menuItems,
			{
				autoHide: true,
				offsetTop: 0,
				offsetLeft: 0,
				angle: {position: "top"},
				parentPopup: this.popup,
				events: {
					onPopupClose : function()
					{
						self.moreTabsMenu.popupWindow.destroy();
						BX.PopupMenu.destroy('phoneCallViewMoreTabs');
					},
					onPopupDestroy: function ()
					{
						self.moreTabsMenu = null;
					}
				}
			}
		);
		this.moreTabsMenu.popupWindow.show();
	};


	BX.PhoneCallView.prototype.getId = function()
	{
		return this.id;
	};

	BX.PhoneCallView.prototype.createTitle = function()
	{
		var callTitle = '';
		if(this.phoneNumber == 'unknown')
		{
			return BX.message('IM_PHONE_CALL_VIEW_NUMBER_UNKNOWN');
		}
		if (this.phoneNumber == 'hidden')
		{
			callTitle = BX.message('IM_PHONE_HIDDEN_NUMBER');
		}
		else
		{
			callTitle = this.phoneNumber.toString();

			if (callTitle.substr(0,1) == '8' || callTitle.substr(0,1) == '+')
			{
			}
			else if (!isNaN(parseInt(callTitle)) && callTitle.length >= 10)
			{
				callTitle = '+'+callTitle;
			}
		}

		if (this.isTransfer())
		{
			callTitle = BX.message('IM_PHONE_CALL_TRANSFER').replace('#PHONE#', callTitle);
		}
		else if(this.isCallback())
		{
			callTitle = BX.message('IM_PHONE_CALLBACK_TO').replace('#PHONE#', callTitle);
		}
		else if(this.isPortalCall())
		{
			switch (this.direction)
			{
				case BX.PhoneCallView.Direction.incoming:
					callTitle = BX.message("IM_M_CALL_VOICE_FROM").replace('#USER#', this.portalCallData.users[this.portalCallUserId].name);
					break;
				case BX.PhoneCallView.Direction.outgoing:
					callTitle = BX.message("IM_M_CALL_VOICE_TO").replace('#USER#', this.portalCallData.users[this.portalCallUserId].name);
					break;
			}
		}
		else
		{
			callTitle = BX.message(this.direction === BX.PhoneCallView.Direction.incoming ? 'IM_PHONE_CALL_VOICE_FROM': 'IM_PHONE_CALL_VOICE_TO').replace('#PHONE#', callTitle);

			if (this.direction === BX.PhoneCallView.Direction.incoming && this.companyPhoneNumber)
			{
				callTitle = callTitle + ', ' + BX.message('IM_PHONE_CALL_TO_PHONE').replace('#PHONE#', this.companyPhoneNumber);
			}
		}

		return callTitle;
	};

	BX.PhoneCallView.prototype.renderTitle = function(title)
	{
		return title;
	};

	BX.PhoneCallView.prototype.renderAvatar = function()
	{
		var portalCallUserImage = '';
		if(this.isPortalCall() && this.elements.avatar && this.portalCallData.hrphoto && this.portalCallData.hrphoto[this.portalCallUserId])
		{
			portalCallUserImage = this.portalCallData.hrphoto[this.portalCallUserId];

			BX.adjust(this.elements.avatar, {
				style: portalCallUserImage == '' ? {} :  {'background-image': 'url(' + portalCallUserImage +')'}
			});
		}
	};
	
	BX.PhoneCallView.prototype._getCrmEditUrl = function(entityTypeName, entityId)
	{
		if(!BX.type.isNotEmptyString(entityTypeName))
			return '';

		entityId = parseInt(entityId) || 0;

		return '/crm/' + entityTypeName.toLowerCase() + '/edit/' + entityId.toString() + '/';
	};

	BX.PhoneCallView.prototype._generateExternalContext = function()
	{
		return this._getRandomString(16);
	};

	BX.PhoneCallView.prototype._getRandomString = function (len)
	{
		charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var randomString = '';
		for (var i = 0; i < len; i++) {
			var randomPoz = Math.floor(Math.random() * charSet.length);
			randomString += charSet.substring(randomPoz,randomPoz+1);
		}
		return randomString;
	};

	BX.PhoneCallView.prototype.setTitle = function(title)
	{
		this.title = title;
		if(this.isDesktop())
		{
			if(this.slave)
			{
				BXDesktopWindow.SetProperty('title', title);
			}
			else
			{
				BX.desktop.onCustomEvent(desktopEvents.setTitle, [title]);
			}
		}

		if(this.elements.title)
		{
			this.elements.title.innerHTML = this.renderTitle(this.title);
		}
	};

	BX.PhoneCallView.prototype.getTitle = function()
	{
		return this.title;
	};

	BX.PhoneCallView.prototype.setQuality = function(quality)
	{
		this.quality = quality;

		if(this.elements.qualityMeter)
			this.elements.qualityMeter.style.width = this.getQualityMeterWidth();
	};

	BX.PhoneCallView.prototype.getQualityMeterWidth = function()
	{
		if(this.quality > 0 && this.quality <= 5)
			return this.quality * 20 + '%';
		else
			return '0';
	};

	BX.PhoneCallView.prototype.setProgress = function(progress)
	{
		this.progress = progress;

		if(!this.elements.progress)
			return;

		BX.cleanNode(this.elements.progress);
		this.elements.progress.appendChild(this.renderProgress());
	};

	BX.PhoneCallView.prototype.setStatusText = function(statusText)
	{
		if(this.isDesktop() && !this.slave)
		{
			BX.desktop.onCustomEvent(desktopEvents.setStatus, [statusText]);
			return;
		}

		this.statusText = statusText;
		if(this.elements.status)
			this.elements.status.innerText = this.statusText;
	};

	BX.PhoneCallView.prototype.setConfig = function(config)
	{
		if(!BX.type.isPlainObject(config))
			return;

		this.config = config;
		if(!this.isDesktop() || this.slave)
		{
			this.renderCrmButtons();
		}
		this.setOnSlave(desktopEvents.setConfig, [config]);
	};

	BX.PhoneCallView.prototype.setCallId = function(callId)
	{
		this.callId = callId;
		this.setOnSlave(desktopEvents.setCallId, [callId]);
	};

	BX.PhoneCallView.prototype.setButtons = function(buttons, layout)
	{
		if(!BX.PhoneCallView.ButtonLayouts[layout])
			layout = BX.PhoneCallView.ButtonLayouts.centered;

		this.buttonLayout = layout;
		this.buttons = buttons;
		this.renderButtons();
	};

	BX.PhoneCallView.prototype.setUiState = function(uiState)
	{
		this._uiState = uiState;

		var stateButtons = this.getUiStateButtons(uiState);
		this.buttons = stateButtons.buttons;
		this.buttonLayout = stateButtons.layout;

		switch (uiState)
		{
			case BX.PhoneCallView.UiState.incoming:
				this.setClosable(false);
				this.showOnlySections(['status']);
				this.renderCrmButtons();
				this.stopTimer();
				break;
			case BX.PhoneCallView.UiState.transferIncoming:
				this.setClosable(false);
				this.showOnlySections(['status']);
				this.renderCrmButtons();
				this.stopTimer();
				break;
			case BX.PhoneCallView.UiState.outgoing:
				this.setClosable(true);
				this.showOnlySections(['status']);
				this.renderCrmButtons();
				this.stopTimer();
				this.hideCallIcon();
				break;
			case BX.PhoneCallView.UiState.connectingIncoming:
				this.setClosable(false);
				this.showOnlySections(['status']);
				this.renderCrmButtons();
				this.stopTimer();
				break;
			case BX.PhoneCallView.UiState.connectingOutgoing:
				this.setClosable(false);
				this.showOnlySections(['status']);
				this.renderCrmButtons();
				this.showCallIcon();
				this.stopTimer();
				break;
			case BX.PhoneCallView.UiState.connected:
				if(this.deviceCall)
					this.setClosable(true);
				else
					this.setClosable(false);

				this.showSections(['status', 'timer']);
				this.renderCrmButtons();
				this.showCallIcon();
				this.startTimer();
				break;
			case BX.PhoneCallView.UiState.transferring:
				this.setClosable(false);
				this.showSections(['status', 'timer']);
				this.renderCrmButtons();
				break;
			case BX.PhoneCallView.UiState.idle:
				this.setClosable(true);
				this.stopTimer();
				this.hideCallIcon();
				this.showOnlySections(['status']);
				this.renderCrmButtons();
				break;
			case BX.PhoneCallView.UiState.error:
				this.setClosable(true);
				this.stopTimer();
				this.hideCallIcon();
				break;
			case BX.PhoneCallView.UiState.moneyError:
				this.setClosable(true);
				this.stopTimer();
				this.hideCallIcon();
				break;
			case BX.PhoneCallView.UiState.sipPhoneError:
				this.setClosable(true);
				this.stopTimer();
				this.hideCallIcon();
				break;
			case BX.PhoneCallView.UiState.redial:
				this.setClosable(true);
				this.stopTimer();
				this.hideCallIcon();
				break;
		}

		if(this.isDesktop() && !this.slave)
		{
			BX.desktop.onCustomEvent(desktopEvents.setUiState, [uiState]);
			return;
		}

		this.renderButtons();
		this.adjust();
	};

	BX.PhoneCallView.prototype.isHeld = function()
	{
		return this.held;
	};

	BX.PhoneCallView.prototype.setHeld = function(held)
	{
		this.held = held;
	};

	BX.PhoneCallView.prototype.setRecording = function(recording)
	{
		this.recording = recording;
	};

	BX.PhoneCallView.prototype.isRecording = function()
	{
		return this.recording;
	};

	BX.PhoneCallView.prototype.isMuted = function()
	{
		return this.muted;
	};

	BX.PhoneCallView.prototype.setMuted = function(muted)
	{
		this.muted = muted;
	};

	BX.PhoneCallView.prototype.isTransfer = function()
	{
		return (this.direction === BX.PhoneCallView.Direction.incomingTransfer);
	};

	BX.PhoneCallView.prototype.isCallback = function()
	{
		return (this.direction === BX.PhoneCallView.Direction.callback);
	};

	BX.PhoneCallView.prototype.isPortalCall = function()
	{
		return this.portalCall;
	};

	BX.PhoneCallView.prototype.setCallback = function(eventName, callback)
	{
		if(!this.callbacks.hasOwnProperty(eventName))
			return false;

		this.callbacks[eventName] = BX.type.isFunction(callback) ? callback : nop;
	};

	BX.PhoneCallView.prototype.setDeviceCall = function(deviceCall)
	{
		this.deviceCall = deviceCall;

		if(this.elements.buttons.sipPhone)
		{
			if(deviceCall)
				BX.addClass(this.elements.buttons.sipPhone, 'active');
			else
				BX.removeClass(this.elements.buttons.sipPhone, 'active');
		}

		if(this.isDesktop() && !this.slave)
		{
			BX.desktop.onCustomEvent(desktopEvents.setDeviceCall, [deviceCall]);
		}
	};

	BX.PhoneCallView.prototype.setCrmEntity = function (params)
	{
		this.crmEntityType = params.type;
		this.crmEntityId = params.id;
		this.crmActivityId = params.activityId;
		this.crmActivityEditUrl = params.activityEditUrl;

		if(this.isDesktop() && !this.slave)
		{
			BX.desktop.onCustomEvent(desktopEvents.setCrmEntity, [params]);
		}
	};

	BX.PhoneCallView.prototype.loadCrmCard = function(entityType, entityId)
	{
		var self = this;
		var params = {
			'sessid': BX.bitrix_sessid(),
			'COMMAND': 'getCrmCard',
			'IM_PHONE': 'Y',
			'IM_AJAX_CALL': 'Y',
			'PARAMS': {
				'ENTITY_TYPE': entityType,
				'ENTITY_ID': entityId
			}
		};

		BX.ajax({
			url: this.BXIM.pathToCallAjax+'?CALL_CRM_CARD&V='+this.BXIM.revision,
			method: 'POST',
			datatype: 'html',
			data: params,
			onsuccess: function(HTML)
			{
				if(self.currentLayout == layouts.simple)
				{
					var newMainElement = self.createLayoutCrm();
					self.elements.main.parentNode.replaceChild(newMainElement, self.elements.main);
					self.elements.main = newMainElement;
					self.currentLayout = layouts.crm;
					self.setUiState(self._uiState);
					self.setStatusText(self.statusText);
				}
				if(self.elements.crmCard)
				{
					self.elements.crmCard.innerHTML = HTML;
					setTimeout(function(){self.adjust();}, 100);
				}

				self.renderCrmButtons();
			}
		});
	};

	BX.PhoneCallView.prototype.reloadCrmCard = function()
	{
		if(this.isDesktop() && !this.slave)
		{
			BX.desktop.onCustomEvent(desktopEvents.reloadCrmCard, []);
		}
		else
		{
			this.loadCrmCard(this.crmEntityType, this.crmEntityId);
		}
	};

	BX.PhoneCallView.prototype.setPortalCallUserId = function(userId)
	{
		this.portalCallUserId = userId;
		this.setOnSlave(desktopEvents.setPortalCallUserId, [userId]);

		if(this.portalCallData && this.portalCallData.users[this.portalCallUserId])
		{
			this.renderAvatar();
			if(!this.slave)
			{
				this.setTitle(BX.message("IM_M_CALL_VOICE_TO").replace('#USER#', this.portalCallData.users[this.portalCallUserId].name));
			}
		}
	};

	BX.PhoneCallView.prototype.setPortalCall = function(portalCall)
	{
		this.portalCall = (portalCall == true);
		this.setOnSlave(desktopEvents.setPortalCall, [portalCall]);
	};

	BX.PhoneCallView.prototype.setPortalCallData = function(data)
	{
		this.portalCallData = data;
		this.setOnSlave(desktopEvents.setPortalCallData, [data]);
	};

	BX.PhoneCallView.prototype.setOnSlave = function(message, parameters)
	{
		if(this.isDesktop() && !this.slave)
		{
			BX.desktop.onCustomEvent(message, parameters);
		}
	};

	BX.PhoneCallView.prototype.updateView = function()
	{
		if(this.elements.title)
			this.elements.title.innerHTML = this.getTitle();

		if(this.elements.progress)
		{
			BX.cleanNode(this.elements.progress);
			this.elements.progress.appendChild(this.renderProgress());
		}

		if(this.elements.status)
			this.elements.status.innerText = this.statusText;

		this.renderButtons();
	};

	BX.PhoneCallView.prototype.renderProgress = function()
	{
		var result;
		var progress = this.progress;
		if (progress == 'connect')
		{
			result = BX.create("div", { props : { className : 'bx-messenger-call-overlay-progress'}, children: [
				BX.create("img", { props : { className : 'bx-messenger-call-overlay-progress-status bx-messenger-call-overlay-progress-status-anim-1'}}),
				BX.create("img", { props : { className : 'bx-messenger-call-overlay-progress-status bx-messenger-call-overlay-progress-status-anim-2'}})
			]});
		}
		else if (progress == 'online')
		{
			result =  BX.create("div", { props : { className : 'bx-messenger-call-overlay-progress bx-messenger-call-overlay-progress-online'}, children: [
				BX.create("img", { props : { className : 'bx-messenger-call-overlay-progress-status bx-messenger-call-overlay-progress-status-anim-3'}})
			]});
		}
		else if (progress == 'wait' || progress == 'offline' || progress == 'error')
		{
			if (progress == 'offline')
			{
				this.BXIM.playSound('error');
			}
			else if (progress == 'error')
			{
				progress = 'offline';
			}
			result =  BX.create("div", { props : { className : 'bx-messenger-call-overlay-progress bx-messenger-call-overlay-progress-'+progress}});
		}
		else
		{
			result =  BX.create("div", { props : { className : 'bx-messenger-call-overlay-progress bx-messenger-call-overlay-progress-'+progress}});
		}
		return result;
	};

	/**
	 * @param uiState BX.PhoneCallView.UiState
	 * @returns object {buttons: string[], layout: string}
	 */
	BX.PhoneCallView.prototype.getUiStateButtons = function(uiState)
	{
		var result = {
			buttons: [],
			layout: BX.PhoneCallView.ButtonLayouts.centered
		};
		switch (uiState)
		{
			case BX.PhoneCallView.UiState.incoming:
				result.buttons = ['answer', 'skip'];
				break;
			case BX.PhoneCallView.UiState.transferIncoming:
				result.buttons = ['answer', 'skip'];
				break;
			case BX.PhoneCallView.UiState.outgoing:
				result.buttons = ['call'];
				if(this.callListId > 0)
				{
					result.buttons.push('next');
					if(!this.isDesktop())
					{
						result.buttons.push('fold');
						result.buttons.push('topClose');
					}
				}
				break;
			case BX.PhoneCallView.UiState.connectingIncoming:
				result.buttons = ['hangup'];
				break;
			case BX.PhoneCallView.UiState.connectingOutgoing:
				if(this.hasSipPhone)
				{
					result.buttons.push('sipPhone');
				}
				result.buttons.push('hangup');
				break;
			case BX.PhoneCallView.UiState.error:
				if(this.callListId > 0)
				{
					result.buttons = ['redial', 'next', 'topClose'];
					if(!this.isDesktop())
						result.buttons.push('fold');
				}
				else
				{
					result.buttons.push('close');
				}
				break;
			case BX.PhoneCallView.UiState.moneyError:
				result.buttons = ['notifyAdmin', 'close'];
				break;
			case BX.PhoneCallView.UiState.sipPhoneError:
				result.buttons = ['sipPhone', 'close'];
				break;
			case BX.PhoneCallView.UiState.connected:
				if(this.callListId > 0)
					result.buttons = ['hold', 'mute', 'dialpad', 'qualityMeter'];
				else
					result.buttons = ['hold', 'mute', 'transfer', 'dialpad', 'qualityMeter'];

				if(this.deviceCall)
					result.buttons.push('close');
				else
					result.buttons.push('hangup');

				result.layout = BX.PhoneCallView.ButtonLayouts.spaced;
				break;
			case BX.PhoneCallView.UiState.transferring:
				result.buttons = ['transferCancel'];
				break;
			case BX.PhoneCallView.UiState.idle:
				if (this.hasSipPhone)
					result.buttons = ['close'];
				else if (this.direction == BX.PhoneCallView.Direction.incoming)
					result.buttons = ['close'];
				else if (this.direction == BX.PhoneCallView.Direction.outgoing)
				{
					result.buttons = ['redial'];
					if(this.callListId > 0)
					{
						result.buttons.push('next');
					}
				}
				if(this.callListId > 0 && !this.isDesktop())
				{
					result.buttons.push('fold');
					result.buttons.push('topClose');
				}
				break;
			case BX.PhoneCallView.UiState.redial:
				result.buttons = ['redial'];
		}

		return result;
	};

	BX.PhoneCallView.prototype.renderButtons = function()
	{
		var self = this;
		var buttonsFragment = document.createDocumentFragment();
		var topButtonsFragment = document.createDocumentFragment();
		var topLevelButtonsFragment = document.createDocumentFragment();
		var buttonNode;
		var subContainers = {
			left: null,
			right: null
		};
		this.elements.buttons = {};
		if(this.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
		{
			subContainers.left = BX.create('div', {props: {className: 'im-phone-call-buttons-container-left'}});
			subContainers.right = BX.create('div', {props: {className: 'im-phone-call-buttons-container-right'}});
			buttonsFragment.appendChild(subContainers.left);
			buttonsFragment.appendChild(subContainers.right);
		}

		this.buttons.forEach(function(buttonName)
		{
			switch (buttonName)
			{
				case 'hold':
					buttonNode = self._renderSimpleButton('', 'im-phone-call-btn-hold', self._onHoldButtonClickHandler);
					if(self.isHeld())
						BX.addClass(buttonNode, 'active');

					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.left.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);

					break;
				case 'mute':
					buttonNode = self._renderSimpleButton('', 'im-phone-call-btn-mute', self._onMuteButtonClickHandler);
					if(self.isMuted())
						BX.addClass(buttonNode, 'active');

					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.left.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);

					break;
				case 'transfer':
					buttonNode = self._renderSimpleButton('', 'im-phone-call-btn-transfer', self._onTransferButtonClickHandler);
					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.left.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);

					break;
				case 'transferCancel':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_M_CALL_BTN_RETURN'),
						'im-phone-call-btn im-phone-call-btn-blue im-phone-call-btn-arrow',
						self._onTransferCancelButtonClickHandler
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'dialpad':
					buttonNode = self._renderSimpleButton('', 'im-phone-call-btn-dialpad', self._onDialpadButtonClickHandler);
					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.left.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);

					break;
				case 'call':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_PHONE_CALL'),
						'im-phone-call-btn im-phone-call-btn-green',
						self._onMakeCallButtonClickHandler
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'answer':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_PHONE_BTN_ANSWER'),
						'im-phone-call-btn im-phone-call-btn-green',
						self._onAnswerButtonClickHandler
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'skip':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_PHONE_BTN_BUSY'),
						'im-phone-call-btn im-phone-call-btn-red',
						self._onSkipButtonClickHandler
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'hangup':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_M_CALL_BTN_HANGUP'),
						'im-phone-call-btn im-phone-call-btn-red  im-phone-call-btn-tube',
						self._onHangupButtonClickHandler
					);
					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.right.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);

					break;
				case 'close':
					buttonNode =  self._renderSimpleButton(
						BX.message('IM_M_CALL_BTN_CLOSE'),
						'im-phone-call-btn im-phone-call-btn-red',
						self._onCloseButtonClickHandler
					);
					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.right.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);
					
					break;
				case 'topClose':
					buttonNode = BX.create("div", {
						props: {className: 'im-phone-call-top-close-btn'},
						events: {
							click: self._onCloseButtonClickHandler
						}
					});
					topLevelButtonsFragment.appendChild(buttonNode);
					break;
				case 'notifyAdmin':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_M_CALL_BTN_NOTIFY_ADMIN'),
						'im-phone-call-btn im-phone-call-btn-blue im-phone-call-btn-arrow',
						function() { self.callbacks.notifyAdmin() }
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'sipPhone':
					buttonNode = self._renderSimpleButton('', (self.deviceCall ? 'im-phone-call-btn-phone active' : 'im-phone-call-btn-phone'), self._onSwitchDeviceButtonClickHandler);
					if(self.buttonLayout == BX.PhoneCallView.ButtonLayouts.spaced)
						subContainers.left.appendChild(buttonNode);
					else
						buttonsFragment.appendChild(buttonNode);
					break;
				case 'qualityMeter':
					buttonNode = BX.create("span", {
						props: {className: 'im-phone-call-btn-signal'},
						events: {click: self._onQualityMeterClickHandler},
						children: [
							BX.create("span", {props: {className: 'im-phone-call-btn-signal-icon-container'}, children: [
								BX.create("span", {props: {className: 'im-phone-call-btn-signal-background'}}),
								self.elements.qualityMeter = BX.create("span", {
									props: {className: 'im-phone-call-btn-signal-active'},
									style: {width: self.getQualityMeterWidth()}
								})
							]})
						]
					});
					buttonsFragment.appendChild(buttonNode);

					break;
				case 'settings':
					// todo
					break;
				case 'next':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_M_CALL_BTN_NEXT'),
						'im-phone-call-btn im-phone-call-btn-gray im-phone-call-btn-arrow',
						self._onNextButtonClickHandler
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'redial':
					buttonNode = self._renderSimpleButton(
						BX.message('IM_M_CALL_BTN_RECALL'),
						'im-phone-call-btn im-phone-call-btn-green',
						self._onMakeCallButtonClickHandler
					);
					buttonsFragment.appendChild(buttonNode);
					break;
				case 'fold':
					buttonNode = BX.create("div", {props: {className: 'im-phone-btn-arrow active'}, children: [
						BX.create("div", {props: {className: 'im-phone-btn-arrow-inner'}})
					], events: {
						click: self._onFoldButtonClickHandler
					}});
					topButtonsFragment.appendChild(buttonNode);
					break;
				default:
					throw "Unknown button " + buttonName;
			}

			if(buttonNode)
			{
				self.elements.buttons[buttonName] = buttonNode;
			}
		});
		if(this.elements.buttonsContainer)
		{
			BX.cleanNode(this.elements.buttonsContainer);
			this.elements.buttonsContainer.appendChild(buttonsFragment);
		}
		if(this.elements.topButtonsContainer)
		{
			BX.cleanNode(this.elements.topButtonsContainer);
			this.elements.topButtonsContainer.appendChild(topButtonsFragment);
		}
		if(this.elements.topLevelButtonsContainer)
		{
			BX.cleanNode(this.elements.topLevelButtonsContainer);
			this.elements.topLevelButtonsContainer.appendChild(topLevelButtonsFragment);
		}
	};

	BX.PhoneCallView.prototype.renderCrmButtons = function()
	{
		var self = this;
		var buttons = [];
		var buttonsFragment = document.createDocumentFragment();

		if(!this.elements.crmButtons)
			return;

		if(this.crmActivityId > 0)
			buttons = ['addComment'];

		if(this.crmEntityType == 'CONTACT')
		{
			buttons.push('addDeal');
			buttons.push('addInvoice');
		}
		else if (this.crmEntityType == 'COMPANY')
		{
			buttons.push('addDeal');
			buttons.push('addInvoice');
		}
		else if (this.crmEntityType == '' && this.config.CRM_CREATE == 'none')
		{
			buttons.push('addLead');
			buttons.push('addContact');
		}

		if(buttons.length  > 0)
		{
			buttons.forEach(function(buttonName)
			{
				var buttonNode;
				switch (buttonName)
				{
					case 'addComment':
						buttonNode = BX.create("div", {
							props: {className: 'im-phone-call-crm-button-comment'},
							text: BX.message('IM_PHONE_ACTION_CRM_COMMENT'),
							events: {click: self._onAddCommentButtonClick.bind(self)}
						});
						break;
					case 'addDeal':
						buttonNode = BX.create("div", {
							props: {className: 'im-phone-call-crm-button-item'},
							text: BX.message('IM_PHONE_ACTION_CRM_DEAL'),
							events: {click: self._onAddDealButtonClick.bind(self)}
						});
						break;
					case 'addInvoice':
						buttonNode = BX.create("div", {
							props: {className: 'im-phone-call-crm-button-item'},
							text: BX.message('IM_PHONE_ACTION_CRM_INVOICE'),
							events: {click: self._onAddInvoiceButtonClick.bind(self)}
						});
						break;
					case 'addLead':
						buttonNode = BX.create("div", {
							props: {className: 'im-phone-call-crm-button-item'},
							text: BX.message('IM_CRM_BTN_NEW_LEAD'),
							events: {click: self._onAddLeadButtonClick.bind(self)}
						});
						break;
					case 'addContact':
						buttonNode = BX.create("div", {
							props: {className: 'im-phone-call-crm-button-item'},
							text: BX.message('IM_CRM_BTN_NEW_CONTACT'),
							events: {click: self._onAddContactButtonClick.bind(self)}
						});
						break;
				}
				buttonsFragment.appendChild(buttonNode);
			});

			BX.cleanNode(this.elements.crmButtons);
			this.elements.crmButtons.appendChild(buttonsFragment);
			this.showSections(['crmButtons']);
		}
		else
		{
			BX.cleanNode(this.elements.crmButtons);
			this.hideSections(['crmButtons']);
		}
	};

	BX.PhoneCallView.prototype._renderSimpleButton = function(text, className, clickCallback)
	{
		var params = { };
		if (text != '')
			params.text = text;

		if (className != '')
			params.props = {className: className};

		if (BX.type.isFunction(clickCallback))
			params.events = {click: clickCallback};

		return BX.create('span', params);
	};

	BX.PhoneCallView.prototype.loadForm = function(params)
	{
		if(!this.formManager)
			return;

		this.formManager.load({
			id: params.id,
			secCode: params.secCode
		})
	};

	BX.PhoneCallView.prototype.unloadForm = function()
	{
		if(!this.formManager)
			return;

		this.formManager.unload();
		BX.cleanNode(this.elements.tabsBody.webform);
	};

	BX.PhoneCallView.prototype._onFormSend = function(e)
	{
		if(!this.callListView)
			return;

		var currentElement = this.callListView.getCurrentElement();
		this.callListView.setWebformResult(currentElement.ELEMENT_ID, e.resultId);
	};

	BX.PhoneCallView.prototype.loadRestApp = function(params)
	{
		var self = this;
		var restAppId = params.id;
		var callId = params.callId;
		var node = params.node;

		if(this.restAppLayoutLoaded)
		{
			BX.rest.AppLayout.getPlacement('CALL_CARD').load(restAppId);
			return;
		}

		if(this.restAppLayoutLoading)
		{
			return;
		}
		this.restAppLayoutLoading = true;

		var data = {
			'sessid': BX.bitrix_sessid(),
			'REST_APP_ID': restAppId,
			'CALL_ID': callId
		};

		BX.ajax({
			url: '/bitrix/tools/voximplant/rest_app.php',
			method: 'POST',
			dataType: 'html',
			data: data,
			onsuccess: function(HTML)
			{
				node.innerHTML = HTML;
				self.restAppLayoutLoaded = true;
				self.restAppLayoutLoading = false;
			}
		});
	};

	BX.PhoneCallView.prototype.unloadRestApps = function()
	{
		var placement = BX.rest.AppLayout.getPlacement('CALL_CARD');
		if(this.restAppLayoutLoaded && placement)
		{
			placement.destroy();
		}
	};

	BX.PhoneCallView.prototype._onHoldButtonClick = function(e)
	{
		if (this.isHeld())
		{
			this.held = false;
			BX.removeClass(this.elements.buttons.hold, 'active');
			if(this.isDesktop() && this.slave)
				BX.desktop.onCustomEvent(desktopEvents.onUnHold, []);
			else
				this.callbacks.unhold();
		}
		else
		{
			this.held = true;
			BX.addClass(this.elements.buttons.hold, 'active');
			if(this.isDesktop() && this.slave)
				BX.desktop.onCustomEvent(desktopEvents.onHold, []);
			else
				this.callbacks.hold();
		}
	};

	BX.PhoneCallView.prototype._onMuteButtonClick = function(e)
	{
		if (this.isMuted())
		{
			this.muted = false;
			BX.removeClass(this.elements.buttons.mute, 'active');
			if(this.isDesktop() && this.slave)
				BX.desktop.onCustomEvent(desktopEvents.onUnMute, []);
			else
				this.callbacks.unmute();
		}
		else
		{
			this.muted = true;
			BX.addClass(this.elements.buttons.mute, 'active');
			if(this.isDesktop() && this.slave)
				BX.desktop.onCustomEvent(desktopEvents.onMute, []);
			else
				this.callbacks.mute();
		}
	};
	BX.PhoneCallView.prototype._onTransferButtonClick = function(e)
	{
		var self = this;
		this.transferPopup = TransferPopup.create({
			bindElement: this.elements.buttons.transfer,
			BXIM: this.BXIM,
			onSelect: function(e)
			{
				if(self.isDesktop() && self.slave)
					BX.desktop.onCustomEvent(desktopEvents.onStartTransfer, [e]);
				else
					self.callbacks.transfer(e);

			},
			onDestroy: function()
			{
				self.transferPopup = null;
			}
		});

		this.transferPopup.show();
	};

	BX.PhoneCallView.prototype._onTransferCancelButtonClick = function(e)
	{
		if(this.isDesktop() && this.slave)
			BX.desktop.onCustomEvent(desktopEvents.onCancelTransfer, []);
		else
			this.callbacks.cancelTransfer();
	};

	BX.PhoneCallView.prototype._onDialpadButtonClick = function(e)
	{
		var self = this;
		this.keypad = new Keypad({
			bindElement: this.elements.buttons.dialpad,
			hideDial: true,
			onButtonClick: function(e)
			{
				var key = e.key;
				if(self.isDesktop() && self.slave)
					BX.desktop.onCustomEvent(desktopEvents.onDialpadButtonClicked, [key]);
				else
					self.callbacks.dialpadButtonClicked(key);
			},
			onClose: function(e)
			{
				self.keypad.destroy();
				self.keypad = null;
			}
		});
		self.keypad.show();
	};
	BX.PhoneCallView.prototype._onHangupButtonClick = function(e)
	{
		if(this.isDesktop() && this.slave)
			BX.desktop.onCustomEvent(desktopEvents.onHangup, []);
		else
			this.callbacks.hangup();
	};
	BX.PhoneCallView.prototype._onCloseButtonClick = function(e)
	{
		if(this.isDesktop() && this.slave)
			BX.desktop.onCustomEvent(desktopEvents.onClose, []);
		else
			this.callbacks.close();
	};
	BX.PhoneCallView.prototype._onMakeCallButtonClick = function(e)
	{
		var event = {};
		var self = this;
		if(this.callListId > 0)
		{
			this.callingEntity = this.currentEntity;

			if(this.currentEntity.phones.length == 0)
			{
				// show keypad and dial entered number
				this.keypad = new Keypad({
					bindElement: this.elements.buttons.call ? this.elements.buttons.call : null,
					onClose: function()
					{
						self.keypad.destroy();
						self.keypad = null;
					},
					onDial: function(e)
					{
						self.keypad.close();
						var event = {
							phoneNumber: e.phoneNumber,
							crmEntityType: self.crmEntityType,
							crmEntityId: self.crmEntityId,
							callListId: self.callListId
						};

						if(self.isDesktop() && self.slave)
							BX.desktop.onCustomEvent(desktopEvents.onCallListMakeCall, [event]);
						else
							self.callbacks.callListMakeCall(event);
					}
				});
				this.keypad.show();
			}
			else
			{
				// just dial the number
				event.phoneNumber = this.currentEntity.phones[0].VALUE;
				event.crmEntityType = this.crmEntityType;
				event.crmEntityId = this.crmEntityId;
				event.callListId = this.callListId;
				if(this.isDesktop() && this.slave)
					BX.desktop.onCustomEvent(desktopEvents.onCallListMakeCall, [event]);
				else
					this.callbacks.callListMakeCall(event);
			}
		}
		else
		{
			if(this.isDesktop() && this.slave)
				BX.desktop.onCustomEvent(desktopEvents.onMakeCall, [this.phoneNumber]);
			else
				this.callbacks.makeCall(this.phoneNumber);
		}
	};
	BX.PhoneCallView.prototype._onNextButtonClick = function(e)
	{
		if(!this.callListView)
			return;

		this.setUiState(BX.PhoneCallView.UiState.outgoing);
		this.callListView.moveToNextItem();
		this.setStatusText('');
	};

	BX.PhoneCallView.prototype._onRedialButtonClick = function(e)
	{

	};

	BX.PhoneCallView.prototype._onAddCommentButtonClick = function(e)
	{
		if(this.crmActivityEditUrl)
			window.open(this.crmActivityEditUrl);
	};

	BX.PhoneCallView.prototype._onAddDealButtonClick = function(e)
	{
		var url = this._getCrmEditUrl('DEAL', 0);
		var externalContext = this._generateExternalContext();
		if(this.crmEntityType === 'CONTACT')
			url = BX.util.add_url_param(url, { contact_id: this.crmEntityId });
		else if(this.crmEntityType === 'COMPANY')
			url = BX.util.add_url_param(url, { company_id: this.crmEntityId });

		url = BX.util.add_url_param(url, { external_context: externalContext });
		if(this.callListId > 0)
		{
			url = BX.util.add_url_param(url, { call_list_id: this.callListId });
			url = BX.util.add_url_param(url, { call_list_element: this.currentEntity.id });
		}

		this.externalRequests[externalContext] = {
			type: 'add',
			context: externalContext,
			window: window.open(url)
		};
	};

	BX.PhoneCallView.prototype._onAddInvoiceButtonClick = function(e)
	{
		var url = this._getCrmEditUrl('INVOICE', 0);
		var externalContext = this._generateExternalContext();
		if(this.crmEntityType === 'CONTACT')
			url = BX.util.add_url_param(url, { contact: this.crmEntityId });
		else if(this.crmEntityType === 'COMPANY')
			url = BX.util.add_url_param(url, { company: this.crmEntityId });

		url = BX.util.add_url_param(url, { external_context: externalContext });
		if(this.callListId > 0)
		{
			url = BX.util.add_url_param(url, { call_list_id: this.callListId });
			url = BX.util.add_url_param(url, { call_list_element: this.currentEntity.id });
		}

		this.externalRequests[externalContext] = {
			type: 'add',
			context: externalContext,
			window: window.open(url)
		};
	};

	BX.PhoneCallView.prototype._onAddLeadButtonClick = function(e)
	{
		var url = this._getCrmEditUrl('LEAD', 0);
		url = BX.util.add_url_param(url, {
				phone: this.phoneNumber,
				origin_id: 'VI_' + this.callId
		});
		window.open(url);
	};

	BX.PhoneCallView.prototype._onAddContactButtonClick = function(e)
	{
		var url = this._getCrmEditUrl('CONTACT', 0);
		url = BX.util.add_url_param(url, {
			phone: this.phoneNumber,
			origin_id: 'VI_' + this.callId
		});
		window.open(url);
	};

	BX.PhoneCallView.prototype._onFoldButtonClick = function(e)
	{
		this.fold();
	};

	BX.PhoneCallView.prototype._onAnswerButtonClick = function(e)
	{
		if(this.isDesktop() && this.slave)
			BX.desktop.onCustomEvent(desktopEvents.onAnswer, []);
		else
			this.callbacks.answer();
	};

	BX.PhoneCallView.prototype._onSkipButtonClick = function(e)
	{
		if(this.isDesktop() && this.slave)
			BX.desktop.onCustomEvent(desktopEvents.onSkip, []);
		else
			this.callbacks.skip();
	};

	BX.PhoneCallView.prototype._onSwitchDeviceButtonClick = function(e)
	{
		if(this.isDesktop() && this.slave)
			BX.desktop.onCustomEvent(desktopEvents.onSwitchDevice, []);
		else
			this.callbacks.switchDevice();
	};

	BX.PhoneCallView.prototype._onQualityMeterClick = function(e)
	{
		var self = this;
		this.showQualityPopup({
			onSelect: function(qualityGrade)
			{
				self.qualityGrade = qualityGrade;
				self.closeQualityPopup();
				if(self.isDesktop() && self.slave)
					BX.desktop.onCustomEvent(desktopEvents.onQualityGraded, [qualityGrade]);
				else
					self.callbacks.qualityGraded(qualityGrade);
			}
		});
	};

	BX.PhoneCallView.prototype._onExternalEvent = function(params)
	{
		params = BX.type.isPlainObject(params) ? params : {};
		params.key = params.key || '';

		var value = params.value || {};
		value.entityTypeName = value.entityTypeName || '';
		value.context = value.context || '';
		value.isCanceled = BX.type.isBoolean(value.isCanceled) ? value.isCanceled : false;

		if(value.isCanceled)
			return;

		if(params.key === "onCrmEntityCreate" && this.externalRequests[value.context])
		{
			if(this.externalRequests[value.context])
			{
				if (this.externalRequests[value.context]['type'] == 'create')
				{
					this.crmEntityType = value.entityTypeName;
					this.crmEntityId = value.entityInfo.id;
					this.loadCrmCard(this.crmEntityType, this.crmEntityId);
				}
				else if (this.externalRequests[value.context]['type'] == 'add')
				{
					// reload crm card
					this.loadCrmCard(this.crmEntityType, this.crmEntityId);
				}

				if(this.externalRequests[value.context]['window'])
					this.externalRequests[value.context]['window'].close();

				delete this.externalRequests[value.context];
			}
		}
	};

	BX.PhoneCallView.prototype._onPullEventCrm = function(command, params)
	{
		if(command === 'external_event')
		{
			if(params.NAME === 'onCrmEntityCreate' && params.IS_CANCELED == false)
			{
				var eventParams = params.PARAMS;
				if(this.externalRequests[eventParams.context])
				{
					var crmEntityType = eventParams.entityTypeName;
					var crmEntityId = eventParams.entityInfo.id;
					
					if(this.callListView)
					{
						var currentElement = this.callListView.getCurrentElement();
					}
				}
			}
		}
	};

	BX.PhoneCallView.prototype.onCallListSelectedItem = function(entity)
	{
		this.currentEntity = entity;
		this.crmEntityType = entity.type;
		this.crmEntityId = entity.id;
		if(entity.phones.length > 0)
			this.phoneNumber = entity.phones[0].VALUE;
		else
			this.phoneNumber = 'unknown';

		this.setTitle(this.createTitle());
		this.loadCrmCard(entity.type, entity.id);
		if(this.currentTabName === 'webform')
		{
			this.formManager.unload();
			this.formManager.load({
				id: this.webformId,
				secCode: this.webformSecCode
			})
		}
		if(this._uiState === BX.PhoneCallView.UiState.redial)
			this.setUiState(BX.PhoneCallView.UiState.outgoing);

		this.updateView();
	};

	BX.PhoneCallView.prototype._onWindowUnload = function()
	{
		this.close();
	};

	BX.PhoneCallView.prototype.showCallIcon = function()
	{
		if(!this.callListView)
			return;

		if(!this.callingEntity)
			return;

		this.callListView.setCallingElement(this.callingEntity.statusId, this.callingEntity.index);
	};

	BX.PhoneCallView.prototype.hideCallIcon = function()
	{
		if(!this.callListView)
			return;

		this.callListView.resetCallingElement();
	};

	BX.PhoneCallView.prototype.startTimer = function()
	{
		if(this.timerInterval)
			return;

		this.lastTimestamp = (new Date()).getTime();
		this.elaplsedMilliSeconds = 0;
		this.timerInterval = setInterval(this.updateTimer.bind(this), 1000);
		this.renderTimer();
	};

	BX.PhoneCallView.prototype.updateTimer = function()
	{
		var currentTimestamp = (new Date()).getTime();
		this.elaplsedMilliSeconds += (currentTimestamp - this.lastTimestamp);
		this.lastTimestamp = currentTimestamp;
		this.renderTimer();
	};

	BX.PhoneCallView.prototype.renderTimer = function()
	{
		if(!this.elements.timer)
			return;

		var elapsedSeconds = Math.floor(this.elaplsedMilliSeconds / 1000);
		var minutes = Math.floor(elapsedSeconds / 60).toString();
		if(minutes.length < 2)
			minutes = '0' + minutes;
		var seconds = (elapsedSeconds % 60).toString();
		if(seconds.length < 2)
			seconds = '0' + seconds;
		var template = (this.isRecording() ? BX.message('IM_PHONE_TIMER_WITH_RECORD') : BX.message('IM_PHONE_TIMER_WITHOUT_RECORD'));

		this.elements.timer.innerText = template.replace('#MIN#', minutes).replace('#SEC#', seconds);
	};

	BX.PhoneCallView.prototype.stopTimer = function()
	{
		if(!this.timerInterval)
			return;

		clearInterval(this.timerInterval);
		this.timerInterval = null;
	};

	BX.PhoneCallView.prototype.showQualityPopup = function(params)
	{
		if(!BX.type.isPlainObject(params))
			params = {};

		if(!BX.type.isFunction(params.onSelect))
			params.onSelect = BX.DoNothing;

		var self = this;
		var elements = {
			'1': null,
			'2': null,
			'3': null,
			'4': null,
			'5': null
		};
		var createStar = function(grade)
		{
			return BX.create("div", {
				props: {className: 'im-phone-popup-rating-stars-item ' + (self.qualityGrade == grade ? 'im-phone-popup-rating-stars-item-active' : '')},
				dataset: {grade: grade},
				events: {
					click: function(e)
					{
						BX.PreventDefault(e);
						var grade = e.currentTarget.dataset.grade;
						params.onSelect(grade);
					}
				}
			});
		};

		this.qualityPopup = new BX.PopupWindow('PhoneCallViewQualityGrade', this.elements.qualityMeter, {
			darkMode: true,
			closeByEsc: true,
			autoHide: true,
			zIndex: baseZIndex + 200,
			noAllPaddings: true,
			overlay: {
				backgroundColor: 'white',
				opacity: 0
			},
			bindOptions: {
				position: 'top'
			},
			angle: {
				position: 'bottom',
				offset: 30
			},
			content: BX.create("div", {props: {className: 'im-phone-popup-rating'}, children: [
				BX.create("div", {props: {className: 'im-phone-popup-rating-title'}, text: BX.message('IM_PHONE_CALL_VIEW_RATE_QUALITY')}),
				BX.create("div", {props: {className: 'im-phone-popup-rating-stars'}, children: [
					elements['1'] = createStar(1),
					elements['2'] = createStar(2),
					elements['3'] = createStar(3),
					elements['4'] = createStar(4),
					elements['5'] = createStar(5)
				], events: {
					mouseover: function(){
						if(elements[self.qualityGrade])
							BX.removeClass(elements[self.qualityGrade], 'im-phone-popup-rating-stars-item-active');
					},
					mouseout: function(){
						if(elements[self.qualityGrade])
							BX.addClass(elements[self.qualityGrade], 'im-phone-popup-rating-stars-item-active');
					}
				}})
			]}),
			events: {
				onPopupClose: function()
				{
					this.destroy();
				},
				onPopupDestroy: function()
				{
					self.qualityPopup = null;
				}
			}
		});

		this.qualityPopup.show();
	};

	BX.PhoneCallView.prototype.closeQualityPopup = function()
	{
		if(this.qualityPopup)
			this.qualityPopup.close();
	};

	BX.PhoneCallView.prototype.fold = function()
	{
		var self = this;
		var foldedCallView = BX.FoldedCallView.getInstance();
		var popupNode = this.popup.popupContainer;
		var overlayNode = this.popup.overlay.element;
		
		BX.addClass(popupNode, 'im-phone-call-view-folding');
		BX.addClass(overlayNode, 'popup-window-overlay-im-phone-call-view-folding');
		setTimeout(
			function()
			{
				self.close();
				foldedCallView.fold({
					callListId: self.callListId,
					webformId: self.webformId,
					webformSecCode: self.webformSecCode,
					currentItemIndex: self.callListView.currentItemIndex,
					currentItemStatusId: self.callListView.currentStatusId,
					statusList: self.callListView.statuses,
					entityType: self.callListView.entityType
				}, true);
			},
			300
		);
	};

	BX.PhoneCallView.prototype.bindSlaveDesktopEvents = function()
	{
		var self = this;
		BX.desktop.addCustomEvent(desktopEvents.setTitle, this.setTitle.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setStatus, this.setStatusText.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setUiState, this.setUiState.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setDeviceCall, this.setDeviceCall.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setCrmEntity, this.setCrmEntity.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.reloadCrmCard, this.reloadCrmCard.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setPortalCall, this.setPortalCall.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setPortalCallUserId, this.setPortalCallUserId.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setPortalCallData, this.setPortalCallData.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setConfig, this.setConfig.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.setCallId, this.setCallId.bind(this));
		BX.desktop.addCustomEvent(desktopEvents.closeWindow, function(){window.close()});

		BX.bind(window, "beforeunload", function ()
		{
			BX.unbindAll(window, "beforeunload");
			BX.desktop.onCustomEvent(desktopEvents.onBeforeUnload, []);
		});

		BX.bind(window, "resize", function()
		{
			self.initialWidth = window.innerWidth;
		});

		/*BX.bind(window, "keydown", function(e)
		{
			if(e.keyCode === 27)
			{
				BX.desktop.onCustomEvent(desktopEvents.onBeforeUnload, []);
			}
		}.bind(this));*/
	};

	BX.PhoneCallView.prototype.bindMasterDesktopEvents = function()
	{
		var self = this;
		BX.desktop.addCustomEvent(desktopEvents.onHold, function(){self.callbacks.hold()});
		BX.desktop.addCustomEvent(desktopEvents.onUnHold, function(){self.callbacks.unhold()});
		BX.desktop.addCustomEvent(desktopEvents.onMute, function(){self.callbacks.mute()});
		BX.desktop.addCustomEvent(desktopEvents.onUnMute, function(){self.callbacks.unmute()});
		BX.desktop.addCustomEvent(desktopEvents.onMakeCall, function(phoneNumber){self.callbacks.makeCall(phoneNumber)});
		BX.desktop.addCustomEvent(desktopEvents.onCallListMakeCall, function(e){self.callbacks.callListMakeCall(e)});
		BX.desktop.addCustomEvent(desktopEvents.onAnswer, function(){self.callbacks.answer()});
		BX.desktop.addCustomEvent(desktopEvents.onSkip, function(){self.callbacks.skip()});
		BX.desktop.addCustomEvent(desktopEvents.onHangup, function(){self.callbacks.hangup()});
		BX.desktop.addCustomEvent(desktopEvents.onClose, function(){self.close()});
		BX.desktop.addCustomEvent(desktopEvents.onStartTransfer, function(e){self.callbacks.transfer(e)});
		BX.desktop.addCustomEvent(desktopEvents.onCancelTransfer, function(){self.callbacks.cancelTransfer()});
		BX.desktop.addCustomEvent(desktopEvents.onSwitchDevice, function(){self.callbacks.switchDevice()});
		BX.desktop.addCustomEvent(desktopEvents.onBeforeUnload, function(){
			self.desktop.window = null;
			self.callbacks.hangup();
		}); //slave window unload
		BX.desktop.addCustomEvent(desktopEvents.onQualityGraded, function(grade){self.callbacks.qualityGraded(grade)});
		BX.desktop.addCustomEvent(desktopEvents.onDialpadButtonClicked, function(grade){self.callbacks.dialpadButtonClicked(grade)});
	};

	BX.PhoneCallView.prototype.unbindDesktopEvents = function()
	{
		for(eventId in desktopEvents)
		{
			if(desktopEvents.hasOwnProperty(eventId))
			{
				BX.desktop.removeCustomEvents(desktopEvents[eventId]);
			}
		}
	};

	BX.PhoneCallView.prototype.isDesktop = function()
	{
		return BX.MessengerCommon.isDesktop();
	};

	BX.PhoneCallView.prototype.setClosable = function(closable)
	{
		closable = (closable == true);
		this.closable = closable;
		if(this.isDesktop())
		{
			//this.desktop.setClosable(closable);
		}
		else if(this.popup)
		{
			this.popup.setClosingByEsc(closable);
			//this.popup.setAutoHide(closable);
		}
	};

	BX.PhoneCallView.prototype.isClosable = function()
	{
		return this.closable;
	};

	BX.PhoneCallView.prototype.adjust = function()
	{
		if(this.popup)
		{
			this.popup.adjustPosition();
		}

		if(this.isDesktop() && this.slave)
		{
			//this.desktop.resize(this.initialWidth, this.elements.main.clientHeight);
			this.desktop.resizeTo(this.elements.main, true);
		}
	};

	BX.PhoneCallView.prototype.close = function()
	{
		if (this.popup)
			this.popup.close();

		if(this.desktop.window)
		{
			BX.desktop.onCustomEvent(desktopEvents.closeWindow, []);
			//this.desktop.window.ExecuteCommand('close');
			//this.desktop.window = null;
		}

		this.callbacks.close();
	};

	BX.PhoneCallView.prototype.dispose = function()
	{
		BX.removeCustomEvent("onPullEvent-crm", this._onPullEventCrmHandler);
		this.unloadRestApps();
		this.unloadForm();

		if(this.popup)
		{
			this.popup.destroy();
			this.popup = null;
		}

		if(this.qualityPopup)
			this.qualityPopup.close();

		if(this.transferPopup)
			this.transferPopup.close();

		if(this.keypad)
			this.keypad.close();

		if(this.isDesktop())
		{
			this.unbindDesktopEvents();
			if(this.desktop.window)
			{
				BX.desktop.onCustomEvent(desktopEvents.closeWindow, []);
				//this.desktop.window.ExecuteCommand('close');
				this.desktop.window = null;
			}
			if(!this.slave)
			{
				window.removeEventListener('beforeunload', this._unloadHandler); //master window unload
			}
		}
	};

	BX.PhoneCallView.Direction = {
		incoming: 'incoming',
		outgoing: 'outgoing',
		incomingTransfer: 'incomingTransfer',
		callback: 'callback'
	};

	BX.PhoneCallView.UiState = {
		incoming: 1,
		transferIncoming: 2,
		outgoing: 3,
		connectingIncoming: 4,
		connectingOutgoing: 5,
		connected: 6,
		transferring: 7,
		idle: 8,
		error: 9,
		moneyError: 10,
		sipPhoneError: 11,
		redial: 12
	};

	var Desktop = function(params)
	{
		this.BXIM = params.BXIM;
		this.parentPhoneCallView = params.parentPhoneCallView;
		this.closable = params.closable;
		this.title = params.title || '';
		this.window = null;
	};

	Desktop.prototype.openCallWindow = function(content, js, params)
	{
		if (!BX.MessengerCommon.isDesktop())
			return false;
		params = params || {};

		if(params.minSettingsWidth)
			this.minSettingsWidth = params.minSettingsWidth;

		if(params.minSettingsHeight)
			this.minSettingsHeight = params.minSettingsHeight;

		BX.desktop.createWindow("callWindow", BX.delegate(function(callWindow) {
			//callWindow.SetProperty("clientSize", {Width: 500, Height: 600});
			callWindow.SetProperty("resizable", false);
			callWindow.SetProperty("title", this.title);
			callWindow.SetProperty("closable", true);
			//callWindow.OpenDeveloperTools();
			callWindow.ExecuteCommand("html.load", this.getHtmlPage(content, js, {}));
			this.window = callWindow;
		}, this));
	};

	Desktop.prototype.setClosable = function(closable)
	{
		this.closable = (closable == true);
		if(this.window)
		{
			this.window.SetProperty("closable", this.closable);
		}
	};

	Desktop.prototype.setTitle = function(title)
	{
		this.title = title;
		if(this.window)
			this.window.SetProperty("title", title)
	};

	Desktop.prototype.getHtmlPage = function(content, jsContent, initImJs, bodyClass)
	{
		if (!BX.MessengerCommon.isDesktop()) return;

		content = content || '';
		jsContent = jsContent || '';
		bodyClass = bodyClass || '';

		var initImConfig = typeof(initImJs) == "undefined" || typeof(initImJs) != "object"? {}: initImJs;
		initImJs = typeof(initImJs) != "undefined";
		if (this.htmlWrapperHead == null)
			this.htmlWrapperHead = document.head.outerHTML.replace(/BX\.PULL\.start\([^)]*\);/g, '');

		if (content != '' && BX.type.isDomNode(content))
			content = content.outerHTML;

		if (jsContent != '' && BX.type.isDomNode(jsContent))
			jsContent = jsContent.outerHTML;

		if (jsContent != '')
			jsContent = '<script type="text/javascript">BX.ready(function(){'+jsContent+'});</script>';

		var initJs = '';
		if (initImJs == true)
		{
			initJs = "<script type=\"text/javascript\">"+
				"BX.ready(function() {"+
					"BXIM = new BX.IM(null, {"+
						"'init': false,"+
						"'colors' : "+(this.BXIM.colors? JSON.stringify(this.BXIM.colors): "false")+","+
						"'settings' : "+JSON.stringify(this.BXIM.settings)+","+
						"'settingsView' : "+JSON.stringify(this.BXIM.settingsView)+","+
						"'updateStateInterval': '"+this.BXIM.updateStateInterval+"',"+
						"'desktop': "+BX.MessengerCommon.isPage()+","+
						"'desktopVersion': "+this.BXIM.desktopVersion+","+
						"'ppStatus': false,"+
						"'ppServerStatus': false,"+
						"'xmppStatus': "+this.BXIM.xmppStatus+","+
						"'bitrixNetwork': "+this.BXIM.bitrixNetwork+","+
						"'bitrixNetwork2': "+this.BXIM.bitrixNetwork2+","+
						"'bitrixOpenLines': "+this.BXIM.bitrixOpenLines+","+
						"'bitrix24': "+this.BXIM.bitrix24+","+
						"'bitrixIntranet': "+this.BXIM.bitrixIntranet+","+
						"'bitrixXmpp': "+this.BXIM.bitrixXmpp+","+
						"'bitrixMobile': "+this.BXIM.bitrixMobile+","+
						"'files' : "+(initImConfig.files? JSON.stringify(initImConfig.files): '{}')+","+
						"'notify' : "+(initImConfig.notify? JSON.stringify(initImConfig.notify): '{}')+","+
						"'users' : "+(initImConfig.users? JSON.stringify(initImConfig.users): '{}')+","+
						"'chat' : "+(initImConfig.chat? JSON.stringify(initImConfig.chat): '{}')+","+
						"'userChat' : "+(initImConfig.userChat? JSON.stringify(initImConfig.userChat): '{}')+","+
						"'userInChat' : "+(initImConfig.userInChat? JSON.stringify(initImConfig.userInChat): '{}')+","+
						"'hrphoto' : "+(initImConfig.hrphoto? JSON.stringify(initImConfig.hrphoto): '{}')+","+
						"'phoneCrm' : "+(initImConfig.phoneCrm? JSON.stringify(initImConfig.phoneCrm): '{}')+","+
						"'generalChatId': "+this.BXIM.messenger.generalChatId+","+
						"'canSendMessageGeneralChat': "+this.BXIM.messenger.canSendMessageGeneralChat+","+
						"'userId': "+this.BXIM.userId+","+
						"'userEmail': '"+this.BXIM.userEmail+"',"+
						"'userColor': '"+this.BXIM.userColor+"',"+
						"'userGender': '"+this.BXIM.userGender+"',"+
						"'userExtranet': "+this.BXIM.userExtranet+","+
						"'disk': {'enable': "+(this.disk? this.disk.enable: false)+"},"+
						"'path' : "+JSON.stringify(this.BXIM.path)+
					"});"+
					"PCW = new BX.PhoneCallView({" +
						"'slave': true, "+
						"'callId': '" + this.parentPhoneCallView.callId + "'," +
						"'uiState': " + this.parentPhoneCallView._uiState + "," +
						"'phoneNumber': '" + this.parentPhoneCallView.phoneNumber + "'," +
						"'companyPhoneNumber': '" + this.parentPhoneCallView.companyPhoneNumber + "'," +
						"'direction': '" + this.parentPhoneCallView.direction + "'," +
						"'fromUserId': '" + this.parentPhoneCallView.fromUserId + "'," +
						"'toUserId': '" + this.parentPhoneCallView.toUserId + "'," +
						"'crm': " + this.parentPhoneCallView.crm + "," +
						"'hasSipPhone': " + this.parentPhoneCallView.hasSipPhone + "," +
						"'deviceCall': " + this.parentPhoneCallView.deviceCall + "," +
						"'transfer': " + this.parentPhoneCallView.transfer + "," +
						"'callback': " + this.parentPhoneCallView.callback + "," +
						"'crmEntityType': '" + this.parentPhoneCallView.crmEntityType + "'," +
						"'crmEntityId': '" + this.parentPhoneCallView.crmEntityId + "'," +
						"'crmActivityId': " + this.parentPhoneCallView.crmActivityId + "," +
						"'crmActivityEditUrl': '" + this.parentPhoneCallView.crmActivityEditUrl + "'," +
						"'callListId': " + this.parentPhoneCallView.callListId + "," +
						"'callListStatusId': '" + this.parentPhoneCallView.callListStatusId + "'," +
						"'callListItemIndex': " + this.parentPhoneCallView.callListItemIndex + "," +
						"'config': " + (this.parentPhoneCallView.config ? JSON.stringify(this.parentPhoneCallView.config): '{}') + "," +
						"'portalCall': " + (this.parentPhoneCallView.portalCall ? 'true' : 'false') + "," +
						"'portalCallData': " + (this.parentPhoneCallView.portalCallData ? JSON.stringify(this.parentPhoneCallView.portalCallData) : '{}') + "," +
						"'portalCallUserId': " + this.parentPhoneCallView.portalCallUserId + "," +
					"});"+
				"});"+
				"</script>";
		}
		return '<!DOCTYPE html><html>'+this.htmlWrapperHead+'<body class="im-desktop im-desktop-popup '+bodyClass+'"><div id="placeholder-messanger">'+content+'</div>'+initJs+jsContent+'</body></html>';
	};

	Desktop.prototype.addCustomEvent = function(eventName, eventHandler)
	{
		if (!BX.MessengerCommon.isDesktop())
			return false;

		BX.desktop.addCustomEvent(eventName, eventHandler);
	};

	Desktop.prototype.onCustomEvent = function(windowTarget, eventName, arEventParams)
	{
		if (!BX.MessengerCommon.isDesktop())
			return false;

		BX.desktop.onCustomEvent(windowTarget, eventName, arEventParams);
	};
	
	Desktop.prototype.resize = function(width, height)
	{
		BXDesktopWindow.SetProperty("clientSize", {Width: width, Height: height});
	};

	Desktop.prototype.resizeTo = function(node, center)
	{
		if(!BX.type.isDomNode(node))
			return;

		center = (center == true);

		BXDesktopWindow.SetProperty("clientSize", {Width: node.clientWidth, Height: node.clientHeight});

		if(center)
			BXDesktopWindow.ExecuteCommand("center");


	};

	Desktop.prototype.setWindowPosition = function (params)
	{
		BXDesktopWindow.SetProperty("position", params);
	};

	var CallList = function(params)
	{
		this.node = params.node;
		this.id = params.id;
		this.ajaxUrl = '/bitrix/components/bitrix/crm.activity.call_list/ajax.php';

		this.entityType = '';

		this.statuses = {}; // {STATUS_ID (string): { STATUS_NAME; string, CLASS: string, ITEMS: []}
		this.elements = {};
		this.currentStatusId = params.callListStatusId || 'IN_WORK';
		this.currentItemIndex = params.itemIndex || 0;
		this.callingStatusId = null;
		this.callingItemIndex = null;

		this.itemActionMenu = null;
		this.callbacks = {
			onError: BX.type.isFunction(params.onError) ? params.onError : nop,
			onSelectedItem: BX.type.isFunction(params.onSelectedItem) ? params.onSelectedItem : nop
		};

		this.showLimit = 10;
		this.showDelta = 10;
	};

	CallList.prototype.init = function(next)
	{
		if(!BX.type.isFunction(next))
			next = BX.DoNothing;

		var self = this;
		this.load(function()
		{
			if(self.statuses[self.currentStatusId].ITEMS.length  > 0)
			{
				self.render();
				self.selectItem(self.currentStatusId, self.currentItemIndex);
				next();
			}
			else
			{
				BX.debug('empty call list. don\'t know what to do');
			}
		})
	};

	CallList.prototype.load = function(next)
	{
		var self = this;
		var params = {
			'sessid': BX.bitrix_sessid(),
			'ajax_action': 'GET_CALL_LIST',
			'callListId': this.id
		};

		BX.ajax({
			url: this.ajaxUrl,
			method: 'POST',
			dataType: 'json',
			data: params,
			onsuccess: function(data)
			{
				if(!data.ERROR)
				{
					if(BX.type.isArray(data.STATUSES))
					{
						//self.statuses = data.STATUSES;
						data.STATUSES.forEach(function(statusRecord)
						{
							self.statuses[statusRecord.STATUS_ID] = statusRecord;
							self.statuses[statusRecord.STATUS_ID].ITEMS = [];
						});

						data.ITEMS.forEach(function(item)
						{
							self.statuses[item.STATUS_ID].ITEMS.push(item);
						});
					}
					self.entityType = data.ENTITY_TYPE;
					if(self.statuses[self.currentStatusId].ITEMS.length == 0)
					{
						self.currentStatusId = self.getNonEmptyStatusId();
						self.currentItemIndex = 0;
					}
					next();
				}
				else
				{
					console.log(data);
				}
			}
		});
	};

	CallList.prototype.selectItem = function(statusId, newIndex)
	{
		var currentNode = this.statuses[this.currentStatusId].ITEMS[this.currentItemIndex]._node;
		BX.removeClass(currentNode, 'im-phone-call-list-customer-block-active');

		if(this.itemActionMenu)
			this.itemActionMenu.close();

		var entity = {
			type: this.entityType,
			id: this.statuses[statusId].ITEMS[newIndex].ELEMENT_ID,
			phones: this.statuses[statusId].ITEMS[newIndex].PHONES,
			statusId: statusId,
			index: newIndex
		};

		this.currentStatusId = statusId;
		this.currentItemIndex = newIndex;

		currentNode = this.statuses[this.currentStatusId].ITEMS[this.currentItemIndex]._node;
		BX.addClass(currentNode, 'im-phone-call-list-customer-block-active');

		this.callbacks.onSelectedItem(entity);
	};

	CallList.prototype.moveToNextItem = function()
	{
		var newIndex = this.currentItemIndex+1;
		if(newIndex>= this.statuses[this.currentStatusId].ITEMS.length)
			newIndex = 0;

		this.selectItem(this.currentStatusId, newIndex);
	};

	CallList.prototype.setCallingElement = function(statusId, index)
	{
		this.callingStatusId = statusId;
		this.callingItemIndex = index;
		currentNode = this.statuses[this.callingStatusId].ITEMS[this.callingItemIndex]._node;
		BX.addClass(currentNode, 'im-phone-call-list-customer-block-calling');
	};

	CallList.prototype.resetCallingElement = function()
	{
		if(this.callingStatusId === null || this.callingItemIndex === null)
			return;

		currentNode = this.statuses[this.callingStatusId].ITEMS[this.callingItemIndex]._node;
		BX.removeClass(currentNode, 'im-phone-call-list-customer-block-calling');
		this.callingStatusId = null;
		this.callingItemIndex = null;
	};

	CallList.prototype.render = function()
	{
		BX.cleanNode(this.node); // BX.create("div", {props: {className: ''}})
		var layout = BX.create("div", {props: {className: 'im-phone-call-list-container'}, children: this.renderStatusBlocks()});
		this.node.appendChild(layout);
	};

	CallList.prototype.renderStatusBlocks = function()
	{
		var self =this;
		var result = [];
		var statusId;
		var className;

		for(statusId in this.statuses)
		{
			var status = this.statuses[statusId];
			if (status.ITEMS.length == 0)
				continue;

			status._node = this.renderStatusBlock(status);
			result.push(status._node);
		}
		return result;
	};

	CallList.prototype.renderStatusBlock = function(status)
	{
		var animationTimeout;
		var itemsNode;
		var measuringNode;
		var statusId = status.STATUS_ID;

		if(!status.hasOwnProperty('_folded'))
			status._folded = false;

		className = 'im-phone-call-list-block';

		if(status.CLASS != '')
			className = className + ' ' + status.CLASS;

		return BX.create("div", {props: {className: className}, children: [
			BX.create("div", {
				props: {className: 'im-phone-call-list-block-title' + (status._folded ? '' : ' active')},
				children: [
					BX.create("span", {text: this.getStatusTitle(statusId)}),
					BX.create("div", {props: {className: 'im-phone-call-list-block-title-arrow'}})
				],
				events: {
					click: function(e)
					{
						clearTimeout(animationTimeout);
						status._folded = !status._folded;
						if (status._folded)
						{
							BX.removeClass(e.target, 'active');
							itemsNode.style.height = measuringNode.clientHeight.toString() + 'px';
							animationTimeout = setTimeout(function ()
							{
								itemsNode.style.height = 0;
							}, 50);
						}
						else
						{
							BX.addClass(e.target, 'active');
							itemsNode.style.height = 0;
							animationTimeout = setTimeout(function ()
							{
								itemsNode.style.height = measuringNode.clientHeight + 'px';
							}, 50);
						}
						BX.PreventDefault(e);
					}
				}
			}),
			itemsNode = BX.create("div", {
				props: {className: 'im-phone-call-list-items-block'},
				children:[
					measuringNode = BX.create("div", {props: {className: 'im-phone-call-list-items-measuring'}, children: this.renderCallListItems(statusId)})
				],
				events: {
					'transitionend': function()
					{
						if(!status._folded)
						{
							itemsNode.style.removeProperty('height');
						}
					}
				}
			})
		]});
	};

	CallList.prototype.renderCallListItems = function(statusId)
	{
		var result = [];
		var status = this.statuses[statusId];

		if(status._shownCount > 0)
		{
			if (status._shownCount > status.ITEMS.length)
				status._shownCount = status.ITEMS.length;
		}
		else
		{
			status._shownCount = Math.min(this.showLimit, status.ITEMS.length);
		}

		for(var i = 0; i < status._shownCount; i++)
		{
			result.push(this.renderCallListItem(status.ITEMS[i], statusId, i));
		}

		if(status.ITEMS.length > status._shownCount)
		{
			status._showMoreNode = BX.create("div", {props: {className: 'im-phone-call-list-show-more-wrap'}, children: [
				BX.create("span", {
					props: {className: 'im-phone-call-list-show-more-button'},
					dataset: {statusId: statusId},
					text: BX.message('IM_PHONE_CALL_LIST_MORE').replace('#COUNT#', (status.ITEMS.length - status._shownCount)),
					events: {click: this.onShowMoreClick.bind(this)}
				})
			]});
			result.push(status._showMoreNode);
		}
		else
		{
			status._showMoreNode = null;
		}

		return result;
	};

	CallList.prototype.renderCallListItem = function(itemDescriptor, statusId, itemIndex)
	{
		var statusName = this.statuses[statusId].NAME;
		var self = this;

		var phonesText = '';
		if(BX.type.isArray(itemDescriptor.PHONES))
		{
			itemDescriptor.PHONES.forEach(function(phone, index)
			{
				if(index != 0)
				{
					phonesText += '; ';
				}

				phonesText += BX.util.htmlspecialchars(phone.VALUE);
			})
		}


		itemDescriptor._node = BX.create("div", {
			props: {className: (this.currentStatusId == statusId && this.currentItemIndex == itemIndex ? 'im-phone-call-list-customer-block im-phone-call-list-customer-block-active' : 'im-phone-call-list-customer-block')},
			children: [
				BX.create("div", {props: {className: 'im-phone-call-list-customer-block-action'}, children: [BX.create("span", {text: statusName})], events: {
					click: function(e)
					{
						if(self.itemActionMenu)
							self.itemActionMenu.popupWindow.close();
						else
							self.showItemMenu(itemDescriptor, e.target);

						BX.PreventDefault(e);
					}
				}}),
				BX.create("div", {props: {className: 'im-phone-call-list-item-customer-name'}, children: [
					BX.create("a", {attrs: {href: itemDescriptor.EDIT_URL, target: '_blank'}, text: itemDescriptor.NAME, events: {
						click: function(e)
						{
							window.open(itemDescriptor.EDIT_URL);
							BX.PreventDefault(e);
						}
					}})
				]}),
				(itemDescriptor.POST ? BX.create("div", {props: {className: 'im-phone-call-list-item-customer-info'}, text: itemDescriptor.POST}) : null),
				(itemDescriptor.COMPANY_TITLE ? BX.create("div", {props: {className: 'im-phone-call-list-item-customer-info'}, text: itemDescriptor.COMPANY_TITLE}) : null),
				(phonesText ? BX.create("div", {props: {className: 'im-phone-call-list-item-customer-info'}, text: phonesText}) : null)
			],
			events: {
				click: function()
				{
					if(self.currentStatusId != itemDescriptor.STATUS_ID || self.currentItemIndex != itemIndex)
						self.selectItem(itemDescriptor.STATUS_ID, itemIndex);
				}
			}
		});

	 	return itemDescriptor._node;
	};

	CallList.prototype.onShowMoreClick = function(e)
	{
		var statusId = e.target.dataset.statusId;
		var status = this.statuses[statusId];

		status._shownCount += this.showDelta;
		if(status._shownCount > status.ITEMS.length)
			status._shownCount = status.ITEMS.length;

		var newStatusNode = this.renderStatusBlock(status);
		status._node.parentNode.replaceChild(newStatusNode, status._node);
		status._node = newStatusNode;
	};

	CallList.prototype.showItemMenu = function(callListItem, node)
	{
		var self = this;
		var menuItems = [];
		var menuItem;
		for(statusId in this.statuses)
		{
			menuItem = {
				id: "setStatus_" + statusId,
				text: this.statuses[statusId].NAME,
				onclick: this.actionMenuItemClickHandler(callListItem.ELEMENT_ID, statusId).bind(this)
			};
			menuItems.push(menuItem);
		}
		menuItems.push({
			id: 'callListItemActionMenu_delimiter',
			delimiter: true

		});
		menuItems.push({
			id: "defer15min",
			text: BX.message('IM_PHONE_CALL_VIEW_CALL_LIST_DEFER_15_MIN'),
			onclick: function()
			{
				self.itemActionMenu.popupWindow.close();
				self.setElementRank(callListItem.ELEMENT_ID, callListItem.RANK + 35);
			}
		});
		menuItems.push({
			id: "defer1hour",
			text: BX.message('IM_PHONE_CALL_VIEW_CALL_LIST_DEFER_HOUR'),
			onclick: function()
			{
				self.itemActionMenu.popupWindow.close();
				self.setElementRank(callListItem.ELEMENT_ID, callListItem.RANK + 185);
			}
		});
		menuItems.push({
			id: "moveToEnd",
			text: BX.message('IM_PHONE_CALL_VIEW_CALL_LIST_TO_END'),
			onclick: function()
			{
				self.itemActionMenu.popupWindow.close();
				self.setElementRank(callListItem.ELEMENT_ID, callListItem.RANK + 5100);
			}
		});

		this.itemActionMenu = BX.PopupMenu.create(
			'callListItemActionMenu',
			node,
			menuItems,
			{
				autoHide: true,
				offsetTop: 0,
				offsetLeft: 0,
				angle: {position: "top"},
				zIndex: baseZIndex + 200,
				events: {
					onPopupClose : function()
					{
						self.itemActionMenu.popupWindow.destroy();
						BX.PopupMenu.destroy('callListItemActionMenu');
					},
					onPopupDestroy: function ()
					{
						self.itemActionMenu = null;
					}
				}
			}
		);
		this.itemActionMenu.popupWindow.show();
	};

	CallList.prototype.actionMenuItemClickHandler = function(elementId, statusId)
	{
		var self = this;
		return function()
		{
			self.itemActionMenu.popupWindow.close();
			self.setElementStatus(elementId, statusId);
		}
	};

	CallList.prototype.setElementRank = function(elementId, rank)
	{
		var self = this;
		this.executeItemAction({
			action: 'SET_ELEMENT_RANK',
			parameters: {
				callListId: this.id,
				elementId: elementId,
				rank: rank
			},
			successCallback: function(data)
			{
				if(data.ITEMS)
				{
					self.repopulateItems(data.ITEMS);
					self.render();
				}
			}
		});
	};

	CallList.prototype.setElementStatus = function(elementId, statusId)
	{
		var self = this;
		this.executeItemAction({
			action: 'SET_ELEMENT_STATUS',
			parameters: {
				callListId: this.id,
				elementId: elementId,
				statusId: statusId
			},
			successCallback: function(data)
			{
				self.repopulateItems(data.ITEMS);
				self.render();
			}
		})
	};

	/**
	 * @param {int} elementId
	 * @param {int} webformResultId
	 */
	CallList.prototype.setWebformResult = function(elementId, webformResultId)
	{
		this.executeItemAction({
			action: 'SET_WEBFORM_RESULT',
			parameters: {
				callListId: this.id,
				elementId: elementId,
				webformResultId: webformResultId
			}
		})
	};

	CallList.prototype.executeItemAction = function (params)
	{
		var self = this;

		if(!BX.type.isPlainObject(params))
			params = {};

		if(!BX.type.isFunction(params.successCallback))
			params.successCallback = BX.DoNothing;

		var requestParams = {
			'sessid': BX.bitrix_sessid(),
			'ajax_action': params.action,
			'parameters': params.parameters
		};

		BX.ajax({
			url: this.ajaxUrl,
			method: 'POST',
			dataType: 'json',
			data: requestParams,
			onsuccess: function(data)
			{
				params.successCallback(data);
			}
		});
	};

	CallList.prototype.repopulateItems = function(items)
	{
		var self = this;
		for(statusId in this.statuses)
		{
			this.statuses[statusId].ITEMS = [];
		}

		items.forEach(function(item)
		{
			self.statuses[item.STATUS_ID].ITEMS.push(item);
		});

		if(this.statuses[this.currentStatusId].ITEMS.length == 0)
		{
			this.currentStatusId = this.getNonEmptyStatusId();
			this.currentItemIndex = 0;
		}
		else
		{
			if(this.currentItemIndex >= this.statuses[this.currentStatusId].ITEMS.length)
				this.currentItemIndex = 0;
		}

		this.selectItem(this.currentStatusId, this.currentItemIndex);
	};

	CallList.prototype.getNonEmptyStatusId = function()
	{
		var foundStatusId = false;

		for(statusId in this.statuses)
		{
			if(this.statuses[statusId].ITEMS.length > 0)
			{
				foundStatusId = statusId;
				break;
			}
		}
		return foundStatusId;
	};

	CallList.prototype.getCurrentElement = function()
	{
		return this.statuses[this.currentStatusId].ITEMS[this.currentItemIndex];
	};

	CallList.prototype.getStatusTitle = function(statusId)
	{
		var count = this.statuses[statusId].ITEMS.length;

		return BX.util.htmlspecialchars(this.statuses[statusId].NAME) + ' (' +  count.toString() + ')';
	};

	var foldedCallListInstance = null;
	var avatars = {};

	BX.FoldedCallView = function(params)
	{
		this.ajaxUrl = '/bitrix/components/bitrix/crm.activity.call_list/ajax.php';
		this.currentItem = {};
		this.callListParams = {
			id: 0,
			webformId: 0,
			webformSecCode: '',
			itemIndex: 0,
			itemStatusId: '',
			statusList: {},
			entityType: ''
		};
		this.node = null;
		this.elements = {
			avatar: null,
			callButton: null,
			nextButton: null,
			unfoldButton: null
		};
		this._lsKey = 'bx-im-folded-call-view-data';
		this._lsTtl = 86400;
		this.init();
	};

	BX.FoldedCallView.getInstance = function()
	{
		if(foldedCallListInstance == null)
			foldedCallListInstance = new BX.FoldedCallView();

		return foldedCallListInstance;
	};

	BX.FoldedCallView.prototype.init = function()
	{
		this.load();
		if(this.callListParams.id > 0)
		{
			this.currentItem = this.callListParams.statusList[this.callListParams.itemStatusId].ITEMS[this.callListParams.itemIndex];
			this.render();
		}
	};
	
	BX.FoldedCallView.prototype.load = function()
	{
		var savedData = BX.localStorage.get(this._lsKey);
		if(BX.type.isPlainObject(savedData))
		{
			this.callListParams = savedData;
		}
	};
	
	BX.FoldedCallView.prototype.destroy = function()
	{
		if(this.node)
		{
			BX.cleanNode(this.node, true);
			this.node = null;
		}

		BX.localStorage.remove(this._lsKey);
	};

	BX.FoldedCallView.prototype.store = function()
	{
		BX.localStorage.set(this._lsKey, this.callListParams, this._lsTtl);
	};

	BX.FoldedCallView.prototype.fold = function(params, animation)
	{
		animation = (animation == true);
		this.callListParams.id = params.callListId;
		this.callListParams.webformId = params.webformId;
		this.callListParams.webformSecCode = params.webformSecCode;
		this.callListParams.itemIndex = params.currentItemIndex;
		this.callListParams.itemStatusId = params.currentItemStatusId;
		this.callListParams.statusList = params.statusList;
		this.callListParams.entityType = params.entityType;
		this.currentItem = this.callListParams.statusList[this.callListParams.itemStatusId].ITEMS[this.callListParams.itemIndex];
		this.store();
		this.render(animation);
	};

	BX.FoldedCallView.prototype.unfold = function(makeCall)
	{
		var self = this;
		BX.addClass(this.node, "im-phone-folded-call-view-unfold");
		this.node.addEventListener('animationend', function() {
			if(self.node)
			{
				BX.cleanNode(self.node, true);
				self.node = null;
			}

			BX.localStorage.remove(self._lsKey);
			if(!window.BXIM || self.callListParams.id == 0)
				return false;

			var restoredParams = {};
			if(self.callListParams.webformId > 0 && self.callListParams.webformSecCode != '')
			{
				restoredParams.webformId = self.callListParams.webformId;
				restoredParams.webformSecCode = self.callListParams.webformSecCode;
			}
			restoredParams.callListStatusId =self.callListParams.itemStatusId;
			restoredParams.callListItemIndex = self.callListParams.itemIndex;
			restoredParams.makeCall = makeCall;

			window.BXIM.startCallList(self.callListParams.id, restoredParams);
		});
	};

	BX.FoldedCallView.prototype.moveToNext = function()
	{
		this.callListParams.itemIndex++;
		if(this.callListParams.itemIndex >= this.callListParams.statusList[this.callListParams.itemStatusId].ITEMS.length)
			this.callListParams.itemIndex = 0;

		this.currentItem = this.callListParams.statusList[this.callListParams.itemStatusId].ITEMS[this.callListParams.itemIndex];
		this.store();
		this.render();
	};

	BX.FoldedCallView.prototype.render = function(animation)
	{
		var self = this;
		animation = (animation == true);
		if(this.node == null)
		{
			this.node = BX.create("div", {
				props: {id: 'im-phone-folded-call-view', className: 'im-phone-call-wrapper im-phone-call-wrapper-fixed'},
				events: {
					dblclick: this._onViewDblClick.bind(this)
				}
			});
			document.body.appendChild(this.node);
		}
		else
		{
			BX.cleanNode(this.node);
		}

		this.node.appendChild(BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-left'}, style: (animation? {bottom: '-90px'} : {}), children: [
			BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user'}, children: [
				BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user-image'}, children: [
					this.elements.avatar = BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user-image-item'}})
				]}),
				BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user-info'}, children: this.renderUserInfo()})
			]})
		]}));

		this.node.appendChild(BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-right'}, children: [
			BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-btn-container'}, children: [
				this.elements.callButton = BX.create("span", {
					props: {className: 'im-phone-call-btn im-phone-call-btn-green'},
					text: BX.message('IM_PHONE_CALL_VIEW_FOLDED_BUTTON_CALL'),
					events: {
						click: this._onDialButtonClick.bind(this)
					}
				}),
				this.elements.nextButton = BX.create("span", {
					props: {className: 'im-phone-call-btn im-phone-call-btn-gray im-phone-call-btn-arrow'},
					text: BX.message('IM_PHONE_CALL_VIEW_FOLDED_BUTTON_NEXT'),
					events: {
						click: this._onNextButtonClick.bind(this)
					}
				})
			]})
		]}));

		this.node.appendChild(BX.create("div", {props: {className: 'im-phone-btn-block'}, children: [
				this.elements.unfoldButton = BX.create("div", {
					props: {className: 'im-phone-btn-arrow'},
					children: [
						BX.create("div", {props: {className: 'im-phone-btn-arrow-inner'}})
					],
					events: {
						click: this._onUnfoldButtonClick.bind(this)
					}
				})
			]})
		);

		if(avatars[this.currentItem.ELEMENT_ID])
		{
			this.elements.avatar.style.backgroundImage = 'url(\'' + BX.util.htmlspecialchars(avatars[this.currentItem.ELEMENT_ID]) + '\')';
		}
		else
		{
			this.loadAvatar(this.callListParams.entityType, this.currentItem.ELEMENT_ID);
		}

		if(animation)
		{
			BX.addClass(this.node, 'im-phone-folded-call-view-fold');
			this.node.addEventListener('animationend', function()
			{
				BX.removeClass(self.node, 'im-phone-folded-call-view-fold');
			})
		}
	};

	BX.FoldedCallView.prototype.renderUserInfo = function()
	{
		var result = [];

		result.push(BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user-name'}, text: this.currentItem.NAME}));
		if(this.currentItem.POST)
			result.push(BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user-item'}, text: this.currentItem.POST}));
		if(this.currentItem.COMPANY_TITLE)
			result.push(BX.create("div", {props: {className: 'im-phone-call-wrapper-fixed-user-item'}, text: this.currentItem.COMPANY_TITLE}));

		return result;
	};

	BX.FoldedCallView.prototype.loadAvatar = function(entityType, entityId)
	{
		var self = this;
		BX.ajax({
			url: this.ajaxUrl,
			method: 'POST',
			dataType: 'json',
			data: {
				'sessid': BX.bitrix_sessid(),
				'ajax_action': 'GET_AVATAR',
				'entityType': entityType,
				'entityId': entityId
			},
			onsuccess: function(data)
			{
				if(!data.avatar)
					return;

				avatars[entityId] = data.avatar;
				if(self.currentItem.ELEMENT_ID == entityId && self.elements.avatar)
				{
					self.elements.avatar.style.backgroundImage = 'url(\'' + BX.util.htmlspecialchars(data.avatar) + '\')';
				}
			}
		});
	};

	BX.FoldedCallView.prototype._onViewDblClick = function(e)
	{
		BX.PreventDefault(e);
		this.unfold(false);
	};

	BX.FoldedCallView.prototype._onDialButtonClick = function(e)
	{
		BX.PreventDefault(e);
		this.unfold(true);
	};

	BX.FoldedCallView.prototype._onNextButtonClick = function(e)
	{
		BX.PreventDefault(e);
		this.moveToNext();
	};

	BX.FoldedCallView.prototype._onUnfoldButtonClick = function(e)
	{
		BX.PreventDefault(e);
		this.unfold(false);
	};

	var TransferPopup = function(params)
	{
		this.bindElement = BX.type.isDomNode(params.bindElement) ? params.bindElement : null;
		this.callbacks = {
			onSelect: BX.type.isFunction(params.onSelect) ? params.onSelect : BX.DoNothing,
			onDestroy: BX.type.isFunction(params.onDestroy) ? params.onDestroy : BX.DoNothing
		};
		this.popup = null;
		this.selectedUserId = 0;

		this.BXIM = params.BXIM;
		
		this.elements = {
			destinationContainer: null,
			input: null
		};
	};

	TransferPopup.create = function(params)
	{
		return new TransferPopup(params);
	};

	TransferPopup.prototype.show = function()
	{
		if(!this.popup)
		{
			this.popup = this.createPopup();
			this.popup.setAngle({offset: BX.MessengerCommon.isPage()? 32: 198});
			this.bindEvents();
		}

		this.popup.show();
		this.elements.input.focus();
	};

	TransferPopup.prototype.close = function()
	{
		if(this.popup)
			this.popup.close();
	};

	TransferPopup.prototype.createPopup = function()
	{
		var self = this;
		return new BX.PopupWindow('bx-messenger-popup-transfer', this.bindElement, {
			//parentPopup: this.parentPopup,
			zIndex: baseZIndex + 200,
			lightShadow : true,
			offsetTop: 5,
			offsetLeft: BX.MessengerCommon.isPage()? 5: -162,
			autoHide: true,
			closeByEsc: true,
			content: this.render(),
			buttons: [
				new BX.PopupWindowButton({
					text: BX.message('IM_M_CALL_BTN_TRANSFER'),
					className: "popup-window-button-accept",
					events: {
						click: function(e)
						{
							var hasExternalPhones = false;

							if (self.selectedUserId == 0)
								return false;

							if(self.BXIM.messenger.phones && self.BXIM.messenger.phones[self.selectedUserId])
							{
								if (
									self.BXIM.messenger.phones[self.selectedUserId].PERSONAL_MOBILE
									|| self.BXIM.messenger.phones[self.selectedUserId].PERSONAL_PHONE
									|| self.BXIM.messenger.phones[self.selectedUserId].WORK_PHONE
								)
								{
									hasExternalPhones = true;
								}
							}

							if (!hasExternalPhones)
							{
								self.popup.close();
								self.callbacks.onSelect({
									type: 'user',
									userId: self.selectedUserId
								});
							}
							else
							{
								self.BXIM.messenger.openPopupMenu(
									e.target,
									'callTransferMenu',
									true,
									{
										userId: self.selectedUserId,
										zIndex: baseZIndex + 210,
										onSelect: function(e)
										{
											self.popup.close();
											self.callbacks.onSelect(e);
										}
									}
								);
							}
					}}
				}),
				new BX.PopupWindowButton({
					text: BX.message('IM_M_CHAT_BTN_CANCEL'),
					events: {
						click: function()
						{
							self.popup.close();
						}
				}})
			],
			events: {
				onPopupClose : function() { this.destroy() },
				onPopupDestroy : function() { self.popup = null; self.elements.contactList = null; self.callbacks.onDestroy(); }
			}
		});
	};

	TransferPopup.prototype.render = function()
	{
		return BX.create("div", { props : { className : "bx-messenger-popup-newchat-wrap" }, children: [
			BX.create("div", { props : { className : "bx-messenger-popup-newchat-caption" }, html: BX.message('IM_M_CALL_TRANSFER_TEXT')}),
			BX.create("div", { props : { className : "bx-messenger-popup-newchat-box bx-messenger-popup-newchat-dest bx-messenger-popup-newchat-dest-even" }, children: [
				this.elements.destinationContainer = BX.create("span", { props : { className : "bx-messenger-dest-items" }}),
				this.elements.input = BX.create("input", {props : { className : "bx-messenger-input" }, attrs: {type: "text", placeholder: BX.message(this.BXIM.bitrixIntranet ? 'IM_M_SEARCH_PLACEHOLDER_CP': 'IM_M_SEARCH_PLACEHOLDER'), value: ''}})
			]}),
			this.elements.contactList = BX.create("div", { props : { className : "bx-messenger-popup-newchat-box bx-messenger-popup-newchat-cl bx-messenger-recent-wrap" }, children: []})
		]})
	};

	TransferPopup.prototype.bindEvents = function(params)
	{
		var self = this;
		var maxUsers = 1;
		BX.MessengerCommon.contactListSearchClear();
		if (!this.BXIM.messenger.contactListLoad)
		{
			this.elements.contactList.appendChild(BX.create("div", {
				props : { className: "bx-messenger-cl-item-load"},
				html : BX.message('IM_CL_LOAD')
			}));

			BX.MessengerCommon.contactListGetFromServer(function()
			{
				BX.MessengerCommon.contactListPrepareSearch(
					'popupTransferDialogContactListElements',
					self.elements.contactList,
					self.elements.input.value,
					{
						'viewChat': false,
						'viewOpenChat': false,
						'viewOffline': false,
						'viewBot': false,
						'viewOnlyIntranet': true,
						'viewOfflineWithPhones': true
					}
				);
			});
		}
		else
		{
			BX.MessengerCommon.contactListPrepareSearch(
				'popupTransferDialogContactListElements',
				this.elements.contactList,
				this.elements.input.value,
				{
					'viewChat': false,
					'viewOpenChat': false,
					'viewOffline': false,
					'viewBot': false,
					'viewOnlyIntranet': true,
					'viewOfflineWithPhones': true
				}
			);
		}
		//BX.bindDelegate(this.elements.contactList, "click", {className: 'bx-messenger-chatlist-more'}, BX.delegate(this.messenger.toggleChatListGroup, this.messenger));

		BX.addClass(this.popup.popupContainer, "bx-messenger-mark");
		BX.bind(this.popup.popupContainer, "click", BX.PreventDefault);

		BX.bind(this.elements.input, "keyup", BX.delegate(function(event){
			if (event.keyCode == 16 || event.keyCode == 17 || event.keyCode == 18 || event.keyCode == 20 || event.keyCode == 244 || event.keyCode == 224 || event.keyCode == 91)
				return false;

			if (event.keyCode == 27 && this.elements.input.value != '')
				BX.MessengerCommon.preventDefault(event);

			if (event.keyCode == 27)
			{
				this.elements.input.value = '';
			}

			if (event.keyCode == 8)
			{
				var lastId = null;
				var arMentionSort = BX.util.objectSort(this.popupChatDialogUsers, 'date', 'asc');
				for (var i = 0; i < arMentionSort.length; i++)
				{
					lastId = arMentionSort[i].id;
				}
				if (lastId)
				{
					delete this.popupChatDialogUsers[lastId];
					this.redrawChatDialogDest();
				}
			}

			if (event.keyCode == 13)
			{
				this.elements.input.value = '';
				var item = BX.findChildByClassName(this.elements.contactList, "bx-messenger-cl-item");
				if (item)
				{
					if (this.elements.input.value != '')
					{
						this.elements.input.value = '';
					}
					if (this.selectedUserId > 0)
					{
						maxUsers = maxUsers + 1;
						if (maxUsers> 0)
							BX.show(this.elements.input);
						this.selectedUserId = 0;
					}
					else
					{
						if (maxUsers> 0)
						{
							maxUsers = maxUsers - 1;
							if (maxUsers<= 0)
								BX.hide(this.elements.input);

							this.selectedUserId = item.getAttribute('data-userId');
						}
					}
					this.redrawTransferDialogDest();
				}
			}

			BX.MessengerCommon.contactListPrepareSearch('popupTransferDialogContactListElements', this.elements.contactList, this.elements.input.value, {'viewChat': false, 'viewOpenChat': false, 'viewOffline': false, 'viewBot': false, 'viewOnlyIntranet': true, 'viewOfflineWithPhones': true, timeout: 100});
		}, this));

		BX.bindDelegate(this.elements.destinationContainer, "click", {className: 'bx-messenger-dest-del'}, BX.delegate(function() {
			this.selectedUserId = 0;
			maxUsers = maxUsers + 1;
			if (maxUsers> 0)
				BX.show(this.elements.input);
			this.redrawTransferDialogDest();
		}, this));
		BX.bindDelegate(this.elements.contactList, "click", {className: 'bx-messenger-cl-item'}, BX.delegate(function(e) {
			if (this.elements.input.value != '')
			{
				this.elements.input.value = '';
				BX.MessengerCommon.contactListPrepareSearch('popupTransferDialogContactListElements', this.elements.contactList, '', {'viewChat': false, 'viewOpenChat': false, 'viewOffline': false, 'viewBot': false, 'viewOnlyIntranet': true, 'viewOfflineWithPhones': true});
			}
			if (this.selectedUserId)
			{
				maxUsers = maxUsers+1;
				this.selectedUserId = 0;
			}
			else
			{
				if (maxUsers <= 0)
					return false;
				maxUsers = maxUsers - 1;
				this.selectedUserId = BX.proxy_context.getAttribute('data-userId');
			}

			if (maxUsers <= 0)
				BX.hide(this.elements.input);
			else
				BX.show(this.elements.input);

			this.redrawTransferDialogDest();

			return BX.PreventDefault(e);
		}, this));
	};

	TransferPopup.prototype.redrawTransferDialogDest = function()
	{
		var content = '';
		var count = 0;

		var isQueue = this.selectedUserId.toString().substr(0, 5) == 'queue';
		var queueId = isQueue? this.selectedUserId.toString().substr(5): 0;

		if (isQueue)
		{
			var queueName = this.selectedUserId;
			for (var i = 0; i < this.queue.length; i++)
			{
				if (this.queue[i].ID == queueId)
				{
					queueName = this.queue[i].NAME;
					break;
				}
			}

			count++;
			content += '<span class="bx-messenger-dest-block bx-messenger-dest-block-extranet">'+
				'<span class="bx-messenger-dest-text">'+queueName+'</span>'+
				'<span class="bx-messenger-dest-del" data-userId="'+this.selectedUserId+'"></span></span>';
		}
		else if (this.selectedUserId > 0)
		{
			count++;
			content += '<span class="bx-messenger-dest-block'+(this.BXIM.messenger.users[this.selectedUserId].extranet? ' bx-messenger-dest-block-extranet': '')+'">'+
				'<span class="bx-messenger-dest-text">'+(this.BXIM.messenger.users[this.selectedUserId].name)+'</span>'+
				'<span class="bx-messenger-dest-del" data-userId="'+this.selectedUserId+'"></span></span>';
		}

		this.elements.destinationContainer.innerHTML = content;
		this.elements.destinationContainer.parentNode.scrollTop = this.elements.destinationContainer.parentNode.offsetHeight;

		if (BX.util.even(count))
			BX.addClass(this.elements.destinationContainer.parentNode, 'bx-messenger-popup-newchat-dest-even');
		else
			BX.removeClass(this.elements.destinationContainer.parentNode, 'bx-messenger-popup-newchat-dest-even');

		this.elements.input.focus();
	};

	TransferPopup.prototype.destroy = function()
	{
		this.BXIM.messenger.closeMenuPopup();
	};
	
	var Keypad = function(params)
	{
		if(!BX.type.isPlainObject(params))
			params = {};

		this.bindElement = params.bindElement || null;
		this.lastNumber = params.lastNumber || '';

		//flags
		this.hideDial = params.hideDial == true;
		this.plusEntered = false;

		this.callbacks = {
			onButtonClick: BX.type.isFunction(params.onButtonClick) ? params.onButtonClick : BX.DoNothing,
			onDial: BX.type.isFunction(params.onDial) ? params.onDial : BX.DoNothing,
			onClose: BX.type.isFunction(params.onClose) ? params.onClose : BX.DoNothing
		};

		this.elements = {
			inputContainer: null,
			input: null
		};
		this.plusKeyTimeout = null;

		this.popup = this.createPopup();
	};

	Keypad.prototype.createPopup = function()
	{
		var self = this;
		return new BX.PopupWindow('phone-call-view-popup-keypad', this.bindElement, {
			darkMode: true,
			closeByEsc: true,
			autoHide: true,
			zIndex: baseZIndex + 200,
			content: this.render(),
			noAllPaddings: true,
			overlay: {
				backgroundColor: 'white',
				opacity: 0
			},
			events: {
				onPopupClose: function()
				{
					self.callbacks.onClose();
				}
			}
		});
	};

	Keypad.prototype.render = function()
	{
		var self = this;
		var createNumber = function(number)
		{
			var classSuffix;
			if(number == '*')
				classSuffix = '10';
			else if (number == '#')
				classSuffix = '11';
			else
				classSuffix = number;
			return BX.create("span", {
				dataset: {'digit': number},
				props: {className : "bx-messenger-calc-btn bx-messenger-calc-btn-" + classSuffix},
				children:[
					BX.create("span", {props: {className: 'bx-messenger-calc-btn-num'}})
				],
				events: {
					mousedown: self._onKeyButtonMouseDown.bind(self),
					mouseup: self._onKeyButtonMouseUp.bind(self)
				}
			});
		};

		return BX.create("div", {props: {className : "bx-messenger-calc-wrap" + (BX.MessengerCommon.isPage() ? ' bx-messenger-calc-wrap-desktop': '') }, children: [
			BX.create("div", { props : { className : "bx-messenger-calc-body" }, children: [
				this.elements.inputContainer = BX.create("div", { props: {className: 'bx-messenger-calc-panel'}, children: [
					BX.create("span", {props: {className: "bx-messenger-calc-panel-delete"}, events: {
						click: this._onDeleteButtonClick.bind(this)
					}}),
					this.elements.input = BX.create("input", {
						attrs: {'readonly': this.callActive? true: false, type: "text", value: '', placeholder: BX.message(this.callActive? 'IM_PHONE_PUT_DIGIT': 'IM_PHONE_PUT_NUMBER')},
						props: { className : "bx-messenger-calc-panel-input" },
						events: {
							keydown: this._onInputKeydown.bind(this),
							keyup: function()
							{
								self._onAfterNumberChanged();
							}
						}
					})
				]}),
				BX.create("div", {
					props: {className : "bx-messenger-calc-btns-block"},
					children: [
						createNumber('1'),
						createNumber('2'),
						createNumber('3'),
						createNumber('4'),
						createNumber('5'),
						createNumber('6'),
						createNumber('7'),
						createNumber('8'),
						createNumber('9'),
						createNumber('*'),
						createNumber('0'),
						createNumber('#')
					]
				})
			]}),
			this.hideDial ? null :  BX.create("div", { props : { className : "bx-messenger-call-btn-wrap" }, children: [
				BX.create("span", {
					props: {className: "bx-messenger-call-btn"},
					children: [
						BX.create("span", {props: {className: "bx-messenger-call-btn-icon"}}),
						BX.create("span", {props: {className: "bx-messenger-call-btn-text"}, html: BX.message('IM_PHONE_CALL')})
					],
					events: {
						click: this._onDialButtonClick.bind(this)
					}
				}),
				this.lastNumber == '' ? null: BX.create("span", {
					props: {className : "bx-messenger-call-btn-2" },
					attrs: {title: BX.message('IM_M_CALL_BTN_RECALL_3')},
					children: [
						BX.create("span", { props : { className : "bx-messenger-call-btn-2-icon" }})
					],
					events: {
						click: this._onDialLastButtonClick.bind(this),
						mouseover: function()
						{
							self.element.input.setAttribute('placeholder', self.lastNumber);
						},
						mouseout: function()
						{
							self.elements.input.setAttribute('placeholder', BX.message('IM_PHONE_PUT_NUMBER'));
						}
					}
				})
			]})
		]});
	};

	Keypad.prototype._onInputKeydown = function(e)
	{
		if (e.keyCode == 13)
		{
			this.callbacks.onDial({
				phoneNumber: this.elements.input.value
			});
		}
		else if (e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 8 || e.keyCode == 107 || e.keyCode == 46 || e.keyCode == 35 || e.keyCode == 36) // left, right, backspace, num plus, home, end
		{}
		else if ((e.keyCode == 61 || e.keyCode == 187 || e.keyCode == 51 || e.keyCode == 56) && e.shiftKey) // +
		{}
		else if ((e.keyCode == 67 || e.keyCode == 86 || e.keyCode == 65 || e.keyCode == 88) && (e.metaKey || e.ctrlKey)) // ctrl+v/c/a/x
		{}
		else if (e.keyCode >= 48 && e.keyCode <= 57 && !e.shiftKey) // 0-9
		{}
		else if (e.keyCode >= 96 && e.keyCode <= 105 && !e.shiftKey) // extra 0-9
		{}
		else
		{
			return BX.PreventDefault(e);
		}
	};

	Keypad.prototype._onAfterNumberChanged = function()
	{
		if (this.elements.input.value.length > 0)
			BX.addClass(this.elements.inputContainer, 'bx-messenger-calc-panel-active');
		else
			BX.removeClass(this.elements.inputContainer, 'bx-messenger-calc-panel-active');

		this.elements.input.focus();
	};

	Keypad.prototype._onDeleteButtonClick = function()
	{
		this.elements.input.value = this.elements.input.value.substr(0, this.elements.input.value.length-1);
		this._onAfterNumberChanged();
	};

	Keypad.prototype._onDialButtonClick = function()
	{
		this.callbacks.onDial({
			phoneNumber: this.elements.input.value
		});
	};

	Keypad.prototype._onDialLastButtonClick = function()
	{
		this.callbacks.onDial({
			phoneNumber: this.lastNumber
		});
	};

	Keypad.prototype._onKeyButtonMouseDown = function(e)
	{
		BX.PreventDefault(e);
		var key = e.currentTarget.dataset.digit.toString();
		var self = this;
		if (key == 0)
		{
			this.plusKeyTimeout = setTimeout(function() {
				self.plusEntered = true;
				self.elements.input.value = self.elements.input.value + '+';
			}, 500);
		}
	};

	Keypad.prototype._onKeyButtonMouseUp = function(e)
	{
		BX.PreventDefault(e);
		var key = e.currentTarget.dataset.digit.toString();
		if (key == 0)
		{
			clearTimeout(this.plusKeyTimeout);
			if (!this.plusEntered)
				this.elements.input.value = this.elements.input.value + '0';

			this.plusEntered = false;
		}
		else
		{
			this.elements.input.value = this.elements.input.value + key;
		}
		this._onAfterNumberChanged();
		this.callbacks.onButtonClick({
			key: key
		});
	};

	Keypad.prototype.show = function()
	{
		if (this.popup)
		{
			this.popup.show();
			this.elements.input.focus();
		}
	};

	Keypad.prototype.close = function()
	{
		if(this.popup)
			this.popup.close();
	};

	Keypad.prototype.destroy = function()
	{
		if(this.popup)
			this.popup.destroy();

		this.popup = null;
	};

	BX.PhoneCallView.Keypad = Keypad;

	var FormManager = function(params)
	{
		this.node = params.node;
		this.currentForm = null;
		this.callbacks = {
			onFormLoad: BX.type.isFunction(params.onFormLoad) ? params.onFormLoad : BX.DoNothing,
			onFormUnLoad: BX.type.isFunction(params.onFormUnLoad) ? params.onFormUnLoad : BX.DoNothing,
			onFormSend: BX.type.isFunction(params.onFormSend) ? params.onFormSend : BX.DoNothing
		}
	};

	/**
 	 * @param {object} params
	 * @param {int} params.id
	 * @param {string} params.secCode
	 */
	FormManager.prototype.load = function(params)
	{
		var formData = this.getFormData(params);
		window.Bitrix24FormLoader.load(formData);
		this.currentForm = formData;
	};

	FormManager.prototype.unload = function()
	{
		if(this.currentForm)
		{
			window.Bitrix24FormLoader.unload(this.currentForm);
			this.currentForm = null;
		}
	};

	/**
	 * @param {object} params
	 * @param {int} params.id
	 * @param {string} params.secCode
	 * @returns {object}
	 */
	FormManager.prototype.getFormData = function (params)
	{
		return {
			id: params.id,
			sec: params.secCode,
			type: 'inline',
			lang: 'ru',
			ref: window.location.href,
			node: this.node,
			handlers:
			{
				'load': this._onFormLoad.bind(this),
				'unload': this._onFormUnLoad.bind(this),
				'send': this.onFormSend.bind(this)
			},
			options:
			{
				'borders': false,
				'logo': false
			}
		}
	};

	FormManager.prototype._onFormLoad = function(form)
	{
		this.callbacks.onFormLoad(form);
	};

	FormManager.prototype._onFormUnLoad = function(form)
	{
		this.callbacks.onFormUnLoad(form);
	};

	FormManager.prototype.onFormSend = function(form)
	{
		this.callbacks.onFormSend(form);
	};
})();