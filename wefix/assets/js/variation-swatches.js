jQuery(document).ready(function($) { 
   
    var $document = jQuery(document);

	jQuery(document).on('click', '.wdt_video_controls .wdt-product-play', function (e) {
		e.preventDefault(); 

		var $video = jQuery(this).closest('.wdt_video_controls').prev('video').get(0);

		if ($video) {
			$video.play();
			jQuery(this).hide();
			jQuery(this).siblings('.wdt-product-pause').show();
		}
	});

	jQuery(document).on('click', '.wdt_video_controls .wdt-product-pause', function (e) {
		e.preventDefault(); 

		var $video = jQuery(this).closest('.wdt_video_controls').prev('video').get(0);

		if ($video) {
			$video.pause();
			jQuery(this).hide();
			jQuery(this).siblings('.wdt-product-play').show();
		}
	});

    /*wishlist code */
    var tinv_wishlist = jQuery('.tinv-wishlist');  
    var $body = jQuery('body');
    var $swiperContainer = jQuery('.wdt-product-image-gallery').closest('.swiper-container');
    var swiper = $swiperContainer[0]?.swiper; 
    if (typeof Swiper !== 'undefined') {
        new Swiper('.product-thumb .primary-image-wrapper', {
            loop: false,
            scrollbar: {
                el: ".product-thumb .swiper-scrollbar",
                hide: false,
            },
            navigation: {
                nextEl: ".product-thumb .swiper-button-next",
                prevEl: ".product-thumb .swiper-button-prev",
            },
            slidesPerView: 1,
            spaceBetween: 10,
        });
    }

    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    } 
    var optionTextSplitRegex = /,\s*/;
    
    var swatchVar = $('.swatch');
    if(swatchVar){
        swatchVar.each(function() {
        var newStyle = $(this).find('div').attr('data-newstyle');
        if (newStyle) {
          $(this).find('div').attr('style', newStyle);
          $(this).find('div').removeAttr('data-newstyle');
        }
      });
    }
    var $addToCartBtn = jQuery('.woocommerce-variation-add-to-cart button');
     
    $document.on('click', '.product_swatch', debounce(function(e) {
        e.preventDefault();
        var $this = jQuery(this); 
        if ($this.hasClass('selected')) {
            return;
        } 
        var attributeValue = $this.data('attribute-value'); 
        $this.closest('.attribute-swatches').find('.wdt-swatches-support').html(attributeValue);
        var swatchData = $this.data(); 
        var productId = swatchData.product;
        var swatchProductId = ".proswatch-" + productId;
        var $attributeGroup = $this.closest('.attribute-swatches'); 
        $this.addClass('available attribute-selectedswatches selected')
             .siblings('.product_swatch').removeClass('attribute-selectedswatches'); 
        if (swiper && swatchData.attachId) { 
            try {
                var $targetSlide = jQuery('.wdt-product-image.swiper-slide:not(.swiper-slide-duplicate)[data-variant_id="' + swatchData.attachId + '"]');
                if (!$targetSlide.length) {
                    $targetSlide = jQuery('.wdt-product-image[data-variant_id="' + swatchData.attachId + '"]');
                }
                
                if ($targetSlide.length) {
                    var slideIndex = $targetSlide.data('swiper-slide-index') || $targetSlide.index();
                    swiper.slideTo(slideIndex, 300);
                }
            } catch (error) {
                //console.error('Swiper error:', error);
            }
        }
        else { 
			var newele = $this.data('attach-id');
            $('figure.woocommerce-product-gallery__wrapper img').addClass('newwww')

            $('figure.woocommerce-product-gallery__wrapper div').removeClass('flex-active-slide'); 

            var targetIndex = -1;
            $('figure.woocommerce-product-gallery__wrapper img').each(function(index) {
                if ($(this).data('variant_id') == newele) {
                    targetIndex = index;
                    return false; 
                }
            }); 
            if (targetIndex >= 0) {
                var $gallery = $('.woocommerce-product-gallery');
                var gallery = $gallery.data('flexslider');
                
                if (gallery) {
                    gallery.flexAnimate(targetIndex);
                } else { 
                    $gallery.on('woocommerce_gallery_init_slider', function() {
                        $(this).data('flexslider').flexAnimate(targetIndex);
                    });
                }
            }

        }
     
        var selectedAttributes = {};
        var selectedValues = [];
        jQuery('.product_swatch.selected').each(function() {
            var data = jQuery(this).data();
            selectedAttributes[data.attributeName] = data.attributeValue;
            selectedValues.push(data.attributeValue.toLowerCase());
        });

        var selectedValuesStr = selectedValues.join(', '); 
        var $attributeSelect = jQuery('.all-attributes-' + productId); 
        var $priceDisplay = jQuery('.wdt-single-product-price .price , .summary p.price ');
        var options = $attributeSelect.find('option');
        var matchedOption = null;
        var matchedOptionTexts = [];
        
        options.each(function() {
            var $option = jQuery(this);
            var optionText = $option.text().trim().toLowerCase(); 
            if (optionText === selectedValuesStr) {
                matchedOption = $option;
                return false;  
            } 
            var optionParts = optionText.split(optionTextSplitRegex);
            var allMatch = selectedValues.every(function(val) {
                return optionParts.includes(val);
            });
            
            if (allMatch) {
                matchedOptionTexts.push(optionText);
                $option.prop('selected', true);
            }
        }); 
        if (matchedOption) {
            $priceDisplay.html('<span class="woocommerce-Price-amount amount">'+ matchedOption.data('price') + '</span>' );
            matchedOption.prop('selected', true).trigger('change'); 
        } 
        jQuery(swatchProductId).each(function() {
            var $swatch = jQuery(this);
            var swatchValue = $swatch.data('attribute-value')?.toLowerCase();
            var isAvailable = matchedOptionTexts.some(function(optionText) {
                var parts = optionText.split(optionTextSplitRegex);
                return parts.includes(swatchValue);
            });
            $swatch.toggleClass('available', isAvailable);
        }); 
    
        var attributeName = $this.data('attribute-name');
        var attributeValue = $this.data('attribute-value'); 
        var productId = $this.data('product');
        var attach_imageid = $this.data('attach-id');
    
        try { 
            var swiperContainer = $('.wdt-product-image-gallery').closest('.swiper-container');
            var swiper = swiperContainer[0]?.swiper;
         
            if (!swiper) {
                swiper = document.querySelector('.swiper-container')?.swiper;
            }
         
            if (!swiper) {
                swiper = document.querySelector('.wdt-product-image-gallery')?.swiper;
            }
        
            if (!swiper) {
               
            }
        
            var targetSlide = $('.wdt-product-image.swiper-slide:not(.swiper-slide-duplicate)[data-variant_id="' + attach_imageid + '"]');
            
            if (!targetSlide.length) { 
                targetSlide = $('.wdt-product-image[data-variant_id="' + attach_imageid + '"]');
            }
        
            if (targetSlide.length) {
                var slideIndex; 
                if (targetSlide.attr('data-swiper-slide-index')) {
                    slideIndex = parseInt(targetSlide.attr('data-swiper-slide-index'));
                }  
                else {
                    slideIndex = targetSlide.index();
                } 
                swiper.slideTo(slideIndex, 300); 
            } else {
            }
        } catch (error) {
        }
    
        jQuery.ajax({
            url: ajax_object.ajaxurl,
            nonce: ajax_object.ajax_nonce,
            type: 'POST',
            data: {
                action: 'swatches_shop',
                attribute_name: swatchData.attributeName,
                attribute_value: swatchData.attributeValue,
                selected_attributes: selectedAttributes,
                product_id: productId 
            },
            success: function(response) {
            }
        });
    }, 100));  
     
    $(document).on('change', '.attribute-swatchesselect select, .attribute-swatchesselectbox select', debounce(function(e) { 
        var $select = $(this);
        if (jQuery(this).find('option:selected').is(':first-child')) {
			jQuery('.product_swatch').addClass('available');
		} else { 
			jQuery('.product_swatch').removeClass('available'); 
		} 
        
        var $swatchWrapper = jQuery(this).closest('.attribute-swatchesselectbox, .attribute-swatchesselect');
        var productId = $swatchWrapper.data('product-id'); 
        var product_image = jQuery('.post-' + productId + ' .primary-image img');

        var imageUrl = jQuery(this).find('option:selected').data('variantimage');
        var product_image_selector = $(this).closest('.post-' + productId + ' .primary-image img');
                    var $image = jQuery(product_image_selector);

        if ($image.length > 0) {
            var $image = product_image;  $image.closest('.primary-image').addClass('loading');

            // Preload new image
            var img = new Image();
            img.onload = function() { 
                $image.removeAttr('style').attr('src', imageUrl);
                $image.closest('.primary-image').removeClass('loading');
            };
            img.src = imageUrl;
        } 
        else if ($swatchWrapper.closest('.attribute-swatchesselectbox').length) {
            var $productImage = $('.post-' + productId + ' .primary-image').find('img').first();

            // Add loading indicator
            $productImage.closest('.primary-image').addClass('loading');

            var img = new Image();
            img.onload = function() {
                $productImage.removeAttr('style').attr('src', imageUrl);
                $productImage.closest('.primary-image').removeClass('loading');

                var thumbSwiper = document.querySelector('.product-thumb .primary-image-wrapper').swiper;
                if (thumbSwiper) {
                    thumbSwiper.slideTo(0, 0);
                }
            };
            img.src = imageUrl;
        }
                      
		var main_div = '.post-' + productId;
		var $container = jQuery(main_div);
		var $buttonLink = $container.find('a.wdt-button.too-small.button.product_type_variable');  
		$buttonLink.text('loading'); 

		var product_price = '.wdt-swatch-product-price'; 
		
		var variantId = jQuery(this).find('option:selected').val(); 
		jQuery('.variation_id').val(variantId);
		jQuery('.variation-id-field').val(variantId);     
		var $clickedElement = jQuery(this); 
		jQuery.ajax({
			url: ajax_object.ajaxurl,
			nonce: ajax_object.ajax_nonce,
			type: 'POST',
			data: {
				action: 'getproduct_details', 
				variant_id: variantId,
				product_id: productId 
			},
			success: function(response) {
				if (response.success) {  
					
					if (variantId === '0') { 
						var btnAddtocart = $('.single_add_to_cart_button');
						$addToCartBtn.addClass('disabled'); if(btnAddtocart) { btnAddtocart.addClass('disabled'); }
						if (tinv_wishlist.length) { $('a.tinvwl_add_to_wishlist_button').addClass('disabled-add-wishlist');}
					} else { 
						$addToCartBtn.removeClass('disabled');  $('.single_add_to_cart_button').removeClass('disabled'); 
						if (tinv_wishlist.length) {
							if (response.data.in_wishlist) {
								$('a.tinvwl_add_to_wishlist_button').removeClass('disabled-add-wishlist');
								$('a.tinvwl_add_to_wishlist_button').addClass('tinvwl-product-in-list');
							} else { 
								$('a.tinvwl_add_to_wishlist_button').removeClass('disabled-add-wishlist');
							}                            
						}
					}

					
					var attributes = response.data.attributes;     
					$buttonLink.attr('data-variant_id',variantId);
					if (attributes && typeof attributes === 'object') {
						let attributeParams = '';
						for (const [key, value] of Object.entries(attributes)) {
							attributeParams += `&attribute_${key}=${encodeURIComponent(value)}`;
						} 
						var addToCartUrl = `?add-to-cart=${productId}`;
					
						$buttonLink
						.attr('href', addToCartUrl)
						.text('Add to Cart');
						$buttonLink.hide(); 

						var $existingButton = $buttonLink.next('.add_to_cart_variantbutton');

						if ($existingButton.length === 0) { 
							$buttonLink.after(
								`<button class="add_to_cart_variantbutton" data-product_id="${productId}" data-variant_id="${variantId}">Add to Cart</button>`
							);
						} else { 
							$existingButton
							.attr('data-product_id', productId)
							.attr('data-variant_id', variantId)
							.text('Add to Cart');
						}


						jQuery('a.wdt-button.too-small.button.product_type_variable').addClass('ajax_add_to_cart_variant');
						jQuery('a.wdt-button.too-small.button.product_type_variable').addClass('add_to_cart_button'); 
					}  
						
					$clickedElement.closest('li.product-grid-view').addClass('remove_secondaryimg');
					var add_to_cart_button = '.post-'+productId+ ' .add_to_cart_button';   
					jQuery('.stock-status').text(response.data.variation_data.stock_status); 
					jQuery(add_to_cart_button).attr("href", response.data.cart_url);     
					var shortDescription = jQuery('.woocommerce-product-details__short-description'); 
					if (shortDescription.length) { 
						shortDescription.html(response.data.variation_data.description);
					}     
					var variantSku = jQuery('.sku_wrapper');    
					if (variantSku.length) {
						$('.sku_wrapper span.sku').html(response.data.variation_data.sku);                         
					}
					var variantSku = jQuery('.weight_wrapper');    
					if (variantSku.length) {
						$('.weight_wrapper span.product_weight').html(response.data.variation_data.weight);                         
					}    
					var variantSku = jQuery('.dimensions_wrapper');    
					if (variantSku.length) {
						$('.dimensions_wrapper span.product_dimensions').html(response.data.variation_data.length + ' x ' + response.data.variation_data.width + ' x ' + response.data.variation_data.height);                         
					}                                 
					var productStock = jQuery('.wdt-single-product-stock');
                    if (productStock.length && response.data.variation_data) {
                        var stockQty = response.data.variation_data.stock_quantity;
                        var totalStock = response.data.variation_data.total_stock || stockQty;
                        var percentage = (totalStock > 0) ? (stockQty / totalStock) * 100 : 0;

                        if (stockQty !== null && stockQty !== 0 ) {
                            var stockHtml  = '<div class="wdt-single-product-stock in_stock">';
                            stockHtml += '<div class="stock-message">Hurry! Only ' + stockQty + ' items left in stock!</div>';
                            stockHtml += '<div class="stock-progress">';
                            stockHtml += '<div class="stock-progress-bar" style="width:' + percentage + '%;"></div>';
                            stockHtml += '</div></div>';

                            productStock.replaceWith(stockHtml);
                        } else {
                            var stockHtml  = '<div class="wdt-single-product-stock out_of_stock">';
                            stockHtml += '<div class="wdt-stock-message">Out of stock</div>';
                            stockHtml += '</div>';
                            productStock.replaceWith(stockHtml);
                        }
                    }

				}  
			}
		});
    }, 100));
    
    jQuery(document).on('click', '.add_to_cart_variantbutton', function(e) {
        e.preventDefault();
    
        var button = jQuery(this);
        var productId = button.data('product_id');
        var variantId = button.data('variant_id');
    
        jQuery.ajax({
            url: wc_add_to_cart_params.ajax_url,  
            nonce: ajax_object.ajax_nonce,
            type: 'POST',
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: productId,
                variation_id: variantId, 
                quantity: 1
            },
            success: function(response) {
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                } else { 
                    jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, button]);
                    
                }
            }
        });
    });
      
    $document.on('click', '.clear_swatchespro', debounce(function(e) {  
		e.preventDefault();
		let productId = jQuery(this).data('product-id');    
		jQuery('.proswatch-'+productId).removeClass('selected');
		jQuery('.proswatch-'+productId).removeClass('attribute-selectedswatches');
		jQuery('.product_swatch').addClass('available');
		jQuery('.wdt-swatches-support').html('');
		$addToCartBtn.removeClass('disabled');
		jQuery.ajax({
			type: 'POST',
			url: ajax_object.ajaxurl,
			nonce: ajax_object.ajax_nonce,
			data: {
				action: 'getproduct_details',
				product_id: productId
			},
			beforeSend: function() { 
			},
			success: function(response) { 
				if (response.success) {
						var product_price = '.post-' + productId + ' .product-price';  
						const firstOption = $('.all-attributes-' + productId + ' option').first();
						firstOption.prop('selected', true).trigger('change'); 
					jQuery('.woocommerce-variation-add-to-cart button').addClass('disabled');
				} else { 
				}
			},
			error: function() {
			}
		});
    }, 100)); 
    
    /* Listing page code */  
      
    $document.on('click', '.swatch', debounce(function(e) { 
        e.preventDefault(); 
        var $this = jQuery(this); 
        if ($this.hasClass('selected')) {
            return;
        } 
        var swatchData = $this.data();
        var productId = swatchData.product;
        var swatchProductId = ".swatch-" + productId;
        $this.addClass('available attribute-swatchesselect selected')
             .siblings('.swatch').removeClass('attribute-selectedswatches'); 
       	$this.addClass('available attribute-swatchesselect selected')
             .siblings('.swatch').removeClass('available');  
       	$this.addClass('available attribute-swatchesselect selected')
             .siblings('.swatch').removeClass('selected');  
     
        var selectedAttributes = {};
        var selectedValues = [];
        jQuery(swatchProductId + '.selected').each(function() {
			var data = jQuery(this).data();
			selectedAttributes[data.attributeName] = data.attributeValue;
			selectedValues.push(data.attributeValue.toLowerCase());
        });
        var selectedValuesStr = selectedValues.join(', '); 
        var $attributeSelect = jQuery('.all-attributes-' + productId);
        var post_productId = '.post-' + productId + ' .product-price'; 
        var $priceDisplay = jQuery(post_productId);
        var $addToCartBtn = jQuery('.woocommerce-variation-add-to-cart button'); 
        var options = $attributeSelect.find('option');
        var matchedOption = null;
        var matchedOptionTexts = [];
        
        options.each(function() {
            var $option = jQuery(this);
            var optionText = $option.text().trim().toLowerCase(); 
            if (optionText === selectedValuesStr) {
                matchedOption = $option;
                return false;  
            } 
            var optionParts = optionText.split(optionTextSplitRegex);
            var allMatch = selectedValues.every(function(val) {
                return optionParts.includes(val);
            });
            
            if (allMatch) {
                matchedOptionTexts.push(optionText);
                $option.prop('selected', true);
            }
        }); 
        if (matchedOption) {
            $priceDisplay.text(matchedOption.data('price'));
            matchedOption.prop('selected', true).trigger('change'); 
        } 
        jQuery(swatchProductId).each(function() {
            var $swatch = jQuery(this);
            var swatchValue = $swatch.data('attribute-value')?.toLowerCase();
            var isAvailable = matchedOptionTexts.some(function(optionText) {
                var parts = optionText.split(optionTextSplitRegex);
                return parts.includes(swatchValue);
            });
            $swatch.toggleClass('available', isAvailable);
        }); 
    
        var attributeName = $this.data('attribute-name');
        var attributeValue = $this.data('attribute-value'); 
        var productId = $this.data('product');
        var attach_imageid = $this.data('attach-id');
    
        
        jQuery.ajax({
            url: ajax_object.ajaxurl,
            nonce: ajax_object.ajax_nonce,
            type: 'POST',
            data: {
                action: 'swatches_shop',
                attribute_name: swatchData.attributeName,
                attribute_value: swatchData.attributeValue,
                selected_attributes: selectedAttributes,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    $addToCartBtn.removeClass('disabled');
                }
            }
        });
    }, 100));  
    
    jQuery('.clear_swatches').on('click', function() { 
        let productId = jQuery(this).data('product-id');   
        jQuery('.swatch-'+productId).removeClass('selected');
        
        jQuery.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            nonce: ajax_object.ajax_nonce,
            data: {
                action: 'getproduct_details',
                product_id: productId 
            },
            beforeSend: function() { 
            },
            success: function(response) {
                if (response.success) {
                    jQuery('.swatch-'+productId).removeAttr('style'); 
    
    
                    var product_price = '.post-' + productId + ' .product-price';
                    var product_image = '.post-' + productId + ' .primary-image img';
                    var add_to_cart_button = '.post-' + productId + ' .add_to_cart_button'; 
    
                    jQuery(product_price).text(response.data.price);
                    jQuery('.stock-status').text(response.data.stock_status);
                    jQuery(add_to_cart_button).attr("href", response.data.cart_url);
                    
                } else { 
                }
            },
            error: function() {
            }
        });
    });     
               
});