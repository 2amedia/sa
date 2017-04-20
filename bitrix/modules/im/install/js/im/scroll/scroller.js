(function(window){

    var  BXScrollbar = window.BXScrollbar = function (scrollBox){

        this.scrollBox = scrollBox;

        this.scrollFlag = false;
        this.eventFlag = false;

        this.scrollContent = BX.create('DIV',{
            props:{className:'bx-scroller-content'},
            html:this.scrollBox.innerHTML
        });

        this.scrollContWrap = BX.create('div',{
            props:{className:'bx-scroller-content-wrap'},
            children:[this.scrollContent]
        });

        this.scrollBox.innerHTML='';

        this.scrollBox.appendChild(this.scrollContWrap);

        if(/Chrome/i.test(navigator.userAgent)){
            this.photoIMG = BX.create('img',{
                    props:{
                        className:'scroll-img'
                    },
                    attrs:{src:'/bitrix/js/im/scroll/scroll-img.gif'}

                }
            );
        }

        if(this.photoIMG){
            this.draggerCont = BX.create('span',{
                props: {className: 'bx-scroller-dragger-cont'},
                children:[this.photoIMG]
            });

        }else{
            this.draggerCont = BX.create('span',{
                props: {className: 'bx-scroller-dragger-cont'}
            });
        }

        this.draggerCont = BX.create('span',{
            props: {className: 'bx-scroller-dragger-cont'},
            children:[this.photoIMG]
        });

        this.dragger = BX.create('div',{
            props: {className: 'bx-scroller-dragger'},
            children:[
                    BX.create('span', {
                        props: {className: 'bx-scroller-dragger-top'}
                    }),
                    this.draggerCont,
                    BX.create('span', {
                        props: {className: 'bx-scroller-dragger-bottom'}
                    })
            ]
        });

        this.scrollLine = BX.create('span',{
            props: {className: 'bx-scroller-line'},
            html:'&nbsp;'
        });

        this.scrollArrowStart = BX.create('span',{
            props: {className: 'bx-scroller-startArow-wrap'},
            html:'<span class="bx-scroller-startArow"></span>'
        });

        this.scrollArrowfinish = BX.create('span',{
            props: {className: 'bx-scroller-finishArow-wrap'},
            html:'<span class="bx-scroller-finishArow"></span>'
        });

        this.draggerWraper = BX.create('DIV', {
            props: {className: 'bx-scroller-dragger-wrapper'},
            children:[this.dragger, this.scrollLine, this.scrollArrowStart, this.scrollArrowfinish]
        });


        this.scrollBox.appendChild(this.draggerWraper);

        BX.bind(this.draggerWraper, 'mouseover', function(){BX.addClass(this,'bx-dragger-hover')});
        BX.bind(this.draggerWraper, 'mouseout', function(){BX.removeClass(this,'bx-dragger-hover')});
        BX.bind(this.scrollArrowStart, 'mouseover', function(){BX.addClass(this,'bx-arrowSt-hover')});
        BX.bind(this.scrollArrowStart, 'mouseout', function(){BX.removeClass(this,'bx-arrowSt-hover')});
        BX.bind(this.scrollArrowfinish, 'mouseover', function(){BX.addClass(this,'bx-arrowFin-hover')});
        BX.bind(this.scrollArrowfinish, 'mouseout', function(){BX.removeClass(this,'bx-arrowFin-hover')});

        this.bordTop = 0;
        this.bordBot= 0;
        this.scrollBoxStyleWidth = parseInt(BX.style(this.scrollBox, 'width'));
        this.scrollVertical();


    }
    
    BXScrollbar.prototype.scrollVertical = function(){

        if(this.dragger_counter){
            this.scrollFlag = true;
        }else{
            BX.addClass(this.scrollBox, 'bx-scroller');

            if(BX.style(this.scrollBox, 'border-top-width') && BX.style(this.scrollBox, 'border-top-width') != 'medium'){
                this.bordTop = parseInt(BX.style(this.scrollBox, 'border-top-width'))
            }
            if(BX.style(this.scrollBox, 'border-bottom-width') && BX.style(this.scrollBox, 'border-top-width') != 'medium'){
                this.bordBot = parseInt(BX.style(this.scrollBox, 'border-bottom-width'))
            }
        }

        this.scrollBoxHeight = BX.pos(this.scrollBox).height;

        if(this.bordTop > 0){
            this.scrollBoxHeight -= this.bordTop
        }
        if(this.bordBot > 0){
            this.scrollBoxHeight -= this.bordBot
        }

        this.boxSize = this.scrollBoxHeight - 36;

        this.pct =  this.scrollContent.offsetHeight / (this.scrollBoxHeight / 100);

        if(this.pct <= 100){
            if(this.scrollFlag){
                this.scrollContent.style.top = 0 + 'px';
                BX.unbind(this.scrollBox, 'mousewheel', BX.proxy(this.mouseWheelMove, this));
                this.mouseWheelFlag = false;

                this.scrollBox.style.paddingRight = 0 + 'px';

                if(!BX.browser.IsDoctype() && BX.browser.IsIE()){}
                else{
                    this.scrollBox.style.width = this.scrollBoxStyleWidth + 'px';
                }
            }
            this.draggerWraper.style.display='none';
            return false
        }

        if(BX.style(this.scrollBox, 'width') != 'auto'){
            if(!BX.browser.IsDoctype() && BX.browser.IsIE()){}
            else{
                if(parseInt(BX.style(this.scrollBox, 'width')) < this.scrollBoxStyleWidth){}
                else{
                    this.scrollBox.style.width = this.scrollBoxStyleWidth - 23 + 'px';
                    this.scrollBox.style.paddingRight = 23 + 'px';
                }

            }
        }

        this.draggerWraper.style.display='block';
        this.dragger_counter = this.boxSize  / this.pct * 100;
        this.dragger_counter = Math.round(this.dragger_counter);


        var mindrag = 0;
        if(this.dragger_counter < 20){
            /*this.dragger_counter = (this.boxSize - mindrag) / this.pct * 100;*/
            mindrag = 20 - this.dragger_counter;
            this.dragger_counter = 20;
        }

        this.dragger.style.height = parseInt(this.dragger_counter) +'px';

        if(this.photoIMG){
            this.photoIMG.style.height = this.dragger_counter +'px';
        }

        this.draggerCont.style.height = this.dragger_counter-2 + 'px';

        if(BX.browser.IsIE()){
            for(var i=0; i < this.dragger.childNodes.length; i++){
                this.dragger.childNodes[i].setAttribute('UNSELECTABLE', 'on')
            }
        }

        this.sizeScrollCounter = this.boxSize - this.dragger_counter;
        this.accelerator = (this.scrollContent.offsetHeight-this.scrollBoxHeight) / (this.boxSize-this.dragger_counter);
        this.contentWeelCounter = this.scrollBoxHeight - this.scrollContent.offsetHeight;


        if(this.scrollFlag && BX.style(this.dragger, 'top')){

            var topCont = parseInt(BX.style(this.scrollContent, 'top')) * (-1) / this.accelerator;
            if(BX.style(this.scrollContent, 'top') == 'auto') topCont = 0;
            topCont = Math.round(topCont);

            if(topCont > this.sizeScrollCounter){
                this.dragger.style.top = this.sizeScrollCounter + 'px';
                if(this.scrollBoxHeight < this.scrollContent.offsetHeight){
                    this.scrollContent.style.top = this.scrollBoxHeight - this.scrollContent.offsetHeight + 'px' ;
                }
            }
            else{
                this.dragger.style.top = topCont + 'px';
            }

        }

        if(!this.scrollFlag) BX.bind(this.scrollBox, 'mousedown', BX.proxy(this.scrolling, this));
        if(!this.mouseWheelFlag) BX.bind(this.scrollBox, 'mousewheel', BX.proxy(this.mouseWheelMove, this));
        
        this.scrollLine.style.height = this.boxSize +'px';
        this.draggerWraper.style.height = this.boxSize +'px';

        if(this.photoIMG){
            this.photoIMG.onselectstart = BX.False;
            this.photoIMG.ondragstart = BX.False;
            this.photoIMG.style.MozUserSelect = "none";
        }

    };

    BXScrollbar.prototype.scrolling = function(event){

        event = event || window.event;
        if (!event.target) {
            event.target = event.srcElement
        }

        this.elemWrap  = this.draggerWraper.getBoundingClientRect();
        var elem  = this.dragger.getBoundingClientRect();

        this.draggerCounter = 0;


        this.draggerCounter =  event.clientY - elem.top;

        if(event.target == this.dragger || event.target.parentNode == this.dragger || event.target.parentNode.parentNode == this.dragger){
            BX.bind(document, 'mousemove', BX.proxy(this.move, this));
            BX.bind(document, 'mouseup', BX.proxy(this.stop_move, this));
            BX.addClass(this.dragger, 'bx-scroller-active');
            if(this.photoIMG){this.photoIMG.setAttribute('src', '/bitrix/js/im/scroll/scroll-img-active.gif')}
        }
        else if(event.target == this.scrollArrowStart || event.target == this.scrollArrowStart.childNodes[0]){
            BX.PreventDefault(event);
            this.arrowMove('start');
        }
        else if(event.target == this.scrollArrowfinish || event.target == this.scrollArrowfinish.childNodes[0]){
            BX.PreventDefault(event);
            this.arrowMove('finish');
        }
        else if(event.target == this.draggerWraper || event.target == this.scrollLine){
            BX.PreventDefault(event);
            this.lineScrollMove(event)
        }

    };

    BXScrollbar.prototype.move = function(event){

        event = event || window.event;
        if (!event.target) {
            event.target = event.srcElement
        }

        if(!BX.browser.IsIE()){
            window.getSelection().removeAllRanges()
        }

        var contentTop = parseInt(this.scrollContent.style.top)||0;

        if(contentTop <= (this.contentWeelCounter/100)*90){
            if(!this.eventFlag){
                this.createEvent();
            }
        }

        var range = event.clientY - this.elemWrap.top - this.draggerCounter;

        if(range < 0){
            range = 0;
        }
        else if(range > this.sizeScrollCounter){
            range = this.sizeScrollCounter
        }
        this.dragger.style.top = range + 'px';

        this.scrollContent.style.top = - (Math.ceil(range * this.accelerator)) +'px';


    };

    BXScrollbar.prototype.mouseWheelMove = function(event){

        if(event == event){
            event = event || window.event;
            BX.PreventDefault(event);
        }

        var eventDet = event.detail;
        var eventDel = event.wheelDelta;
        var scrollSpeed = 0;

        if(this.accelerator < 5){ scrollSpeed = 20}
        else if(5 < this.accelerator && this.accelerator < 10){ scrollSpeed = 17}
        else if(10 < this.accelerator && this.accelerator < 15) {scrollSpeed = 14}
        else if(15 < this.accelerator && this.accelerator < 20) {scrollSpeed = 11}
        else if(20 < this.accelerator && this.accelerator < 25) {scrollSpeed = 8}
        else if(25 < this.accelerator && this.accelerator < 30) {scrollSpeed = 5}
        else if(30 < this.accelerator && this.accelerator < 35) {scrollSpeed = 2}
        else if(35 < this.accelerator) {scrollSpeed = 1}

        if(BX.browser.IsMac()){

           if(eventDet > 0){
               scrollSpeed = eventDet;
               eventDet = 3
           }
           if(eventDet < 0){
               scrollSpeed = eventDet*(-1);
               eventDet = -3
           }
            if(eventDel < 0){
                scrollSpeed = Math.round((eventDel*(-1)/10));
                eventDel = -120;

            }
           if(eventDel > 0){
               scrollSpeed = Math.round(eventDel/10);
               eventDel = 120;
           }
           if(scrollSpeed>10) scrollSpeed=10;
           if(this.accelerator > 30) scrollSpeed = scrollSpeed/2;
        }
        
        var contentTop = parseInt(this.scrollContent.style.top)||0;

        if(contentTop <= (this.contentWeelCounter/100)*90){
            this.createEvent();
        }

        var draggerTop = parseInt(this.dragger.style.top)||0;
        var dragTopCount = this.boxSize - draggerTop - this.dragger_counter;

        if(eventDet == 3 || eventDel == -120 || event == 'finish'){
            if(contentTop <= this.contentWeelCounter){
                return false;
            }
            else if(dragTopCount >= scrollSpeed){
                contentTop -= Math.round(this.accelerator*scrollSpeed);
                this.dragger.style.top = draggerTop + scrollSpeed + 'px';
                this.scrollContent.style.top = contentTop + 'px';

                return false;
            }
            else if(dragTopCount < scrollSpeed){
                this.dragger.style.top = this.sizeScrollCounter + 'px';
                this.scrollContent.style.top = this.contentWeelCounter + 'px';
                return false;
            }


        }
        else if(eventDet == -3 || eventDel == 120 || event == 'start'){

            if(contentTop >= 0){
                return false;
            }
            else if(draggerTop >= scrollSpeed){
                contentTop += Math.round(this.accelerator*scrollSpeed);
                this.dragger.style.top = draggerTop - scrollSpeed + 'px';
                this.scrollContent.style.top = contentTop + 'px';
                return false;
            }
            else if(draggerTop <=scrollSpeed){
                this.dragger.style.top = 0 + 'px';
                this.scrollContent.style.top = 0 + 'px';
                return false;
            }
        }

    };

    BXScrollbar.prototype.arrowMove = function(arrow){

        this.mouseWheelMove(arrow);

        var _this = this;
        var idTimeout = setTimeout(function(){_this.arrowMoveInterval(arrow)}, 350);
        function clTimeout(){
            clearTimeout(idTimeout);
            BX.unbind(document, 'mouseup',clTimeout);
        }
        BX.bind(document, 'mouseup',clTimeout);
    };

    BXScrollbar.prototype.arrowMoveInterval = function(arrow){
        var _this = this;
        var idInterval = setInterval(function(){_this.mouseWheelMove(arrow)}, 80);
        function clInterval (){
            clearInterval(idInterval);
            BX.unbind(document, 'mouseup', clInterval);
        }
        BX.bind(document, 'mouseup',clInterval );
    };

    BXScrollbar.prototype.reDraw = function(){
            this.scrollVertical();
            this.eventFlag = false;
    };

    BXScrollbar.prototype.createEvent = function(){
        if(this.eventFlag) return;
        
        BX.onCustomEvent(this, 'onScrollEnd');
        this.eventFlag = true;
    };

    BXScrollbar.prototype.lineScrollMove = function(event){
        event = event || window.event;

        var mouseRate = event.clientY - this.elemWrap.top;
        var scrollCenter = event.clientY - this.elemWrap.top - Math.round(this.dragger_counter/2);
        var minPosition = Math.round(this.dragger_counter/2);
        var maxPosition = this.sizeScrollCounter + Math.round(this.dragger_counter/2);

        if(mouseRate <= minPosition){
            this.dragger.style.top = 0 +  'px';
            this.scrollContent.style.top = 0 +'px';
        }else if(mouseRate >= maxPosition){
            this.dragger.style.top = this.sizeScrollCounter +  'px';
            this.scrollContent.style.top = this.scrollBoxHeight - this.scrollContent.offsetHeight +'px';
        }
        else{
            this.dragger.style.top = scrollCenter +  'px';
            this.scrollContent.style.top = -(Math.round(scrollCenter * this.accelerator)) +'px';
        }

    };

    BXScrollbar.prototype.moveToEnd = function(){

        if(this.pct <= 100) return;

        this.dragger.style.top = this.sizeScrollCounter + 'px';
        this.scrollContent.style.top = this.contentWeelCounter + 'px'
    };
    
    BXScrollbar.prototype.stop_move = function(event){
        BX.removeClass(this.dragger, 'bx-scroller-active');
        BX.unbind(document, 'mousemove', BX.proxy(this.move, this));
        BX.unbind(document, 'mouseup', BX.proxy(this.stop_move, this));
        if(this.photoIMG){
            this.photoIMG.setAttribute('src', '/bitrix/js/im/scroll/scroll-img.gif')
        }
        
        BX.PreventDefault(event);

    }
    
})(window);