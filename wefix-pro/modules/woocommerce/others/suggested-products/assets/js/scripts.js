jQuery.noConflict();
jQuery(document).ready(function(){

    'use strict';

    if ( typeof dtspObjects !== 'undefined' ) {

        if(dtspObjects.enable_suggested_products) {
            
            if (jQuery.cookie('wdt-suggested-product-cookie') == 'closed') {
                jQuery('.suggested-product-list').remove();
            }
            
              jQuery('.wdt_close').bind('click',function(){
                jQuery('.suggested-product-list').remove();
                jQuery.cookie('wdt-suggested-product-cookie', 'closed', {expires:1, path:'/'});
              });      
            
            var elements = jQuery('.suggested-product-list li');
            var init_element = 0;
            var i = 0;
            elements.removeClass('active');
            function suggestedProductElement() { 
                if ( i % 2 == 0) {
                    var currentItem = elements.eq(init_element);      
                    currentItem.addClass('active');
                    setTimeout(function(){ 
                        currentItem.removeClass('active')
                    }, 4000);
                
                    init_element++;
                    if(elements.length == init_element) {
                        init_element = 0;
                    }
                }
                i++;
            }
            
            setInterval(function(){ 
                suggestedProductElement();
            }, 4000);
        }
    }

});