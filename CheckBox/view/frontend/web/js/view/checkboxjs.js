define(
    [
    'ko',
    'uiComponent',
    'jquery',
    'jquery-ui-modules/widget',
    'mage/url' 
  ],
    function (ko, Component,$,url) 
   {
    "use strict";
    return Component.extend({  
    defaults: 
   {
    cookieMessages: [],
    template: 'ISN_CheckBox/checkboxtemplate'
    },
    initObservable: function () {
        this._super()
        .observe({
            isRegisterNewsletter: ko.observable(true)                        
        });
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