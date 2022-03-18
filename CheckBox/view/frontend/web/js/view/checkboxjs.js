define(
    [
    'ko','uiComponent','jquery','jquery-ui-modules/widget','mage/url','domReady!' 
  ],function (ko, Component,$,url) {
    "use strict";
    return Component.extend({  
    defaults: 
   {
    cookieMessages: [],
    template: 'ISN_CheckBox/checkboxtemplate'
    },
    
    initObservable: function () {
      
        var simple_cookie = $.cookie('CheckBox'); 
        if(simple_cookie=="true"){
            this._super()
            .observe({
                isRegisterNewsletter: ko.observable(simple_cookie)                        
            });
        }
        else{
            this._super()
            .observe({
                isRegisterNewsletter: ko.observable(false)                        
            });
        }
        this.isRegisterNewsletter.subscribe(function (newValue) {
            if(newValue){
                $.cookie('CheckBox', true );
                var vall=$('#place-order-newsletter').val();
                $.cookie('CheckBoxValues', vall );
                require(["jquery",'mage/url'],function($,url) {
                    $(document).ready(function() {
                        var linkUrl = url.build('check/index/index');
                        console.log(linkUrl);
                        $.ajax({
                            url: linkUrl,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                customdata1: newValue,
                            }
                        });
                    });
                });
                console.log('checked');
            }else{  
                $.cookie('CheckBox', false);  
                var vall=$('#place-order-newsletter').val();
                console.log("vslllll"+vall);
                require(["jquery",'mage/url'],function($,url) {
                    $(document).ready(function() {
                        var linkUrl = url.build('check/index/index');
                        console.log(linkUrl);
                        $.ajax({
                            url: linkUrl,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                customdata1: newValue,
                            }
                        });
                    });
                });
                console.log('Unchecked');
            }
        });
        return this;
    }
    });
    }
);