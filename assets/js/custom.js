var pricetovalue = "";
jQuery(document).ready(function() {

	jQuery(document).on('keypress', '.select2-search__field', function () {
    jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
});

	setTimeout(function(){
	if(jQuery("#LF_main_search-0").length > 0){
	    if( sessionStorage.getItem("slug")!="" && sessionStorage.getItem("slug") != null && jQuery('#pageSlug-0').val() == sessionStorage.getItem("slug")){
	        
			if(sessionStorage.getItem("LF_priceto_search")!="" && sessionStorage.getItem("LF_priceto_search") != "null"){
			 var setValueTo = sessionStorage.getItem('LF_priceto_search');
			 if(jQuery('#LF_priceto_search-0 option[value='+sessionStorage.getItem("LF_priceto_search")+']').length > 0 )
			 {
			 	jQuery("#LF_priceto_search-0").val(sessionStorage.getItem("LF_priceto_search"));
			 }
			 else
			 {
				jQuery("#LF_priceto_search-0").append(new Option(setValueTo,setValueTo ,true, true));
			 }
			 
			 sessionStorage.setItem("LF_priceto_search", ''); 
			}
			
			
			
			if(sessionStorage.getItem("LF_pricefrom_search")!="" && sessionStorage.getItem("LF_pricefrom_search") != "null"){
			 var setValueFrom = sessionStorage.getItem('LF_pricefrom_search');
                         if(jQuery('#LF_pricefrom_search-0 option[value='+sessionStorage.getItem("LF_pricefrom_search")+']').length > 0)
                         {
                                jQuery("#LF_pricefrom_search-0").val(sessionStorage.getItem("LF_pricefrom_search"));
                         }
                         else
                         {
                                jQuery("#LF_pricefrom_search-0").append(new Option(setValueFrom,setValueFrom ,true, true));
                         }

			 sessionStorage.setItem("LF_pricefrom_search", '');
			 
			}
			
		     if(sessionStorage.getItem("LF_sale")!="" && sessionStorage.getItem("LF_sale") != null ){
			 jQuery("#LF_sale-0").val(sessionStorage.getItem("LF_sale"));
			 sessionStorage.setItem("LF_sale", '');
			}
			if(sessionStorage.getItem("LF_bedroom")!="" && sessionStorage.getItem("LF_bedroom") != null){
			 jQuery("#LF_bedroom-0").val(sessionStorage.getItem("LF_bedroom"));
			 sessionStorage.setItem("LF_bedroom", '');
			}
			if(sessionStorage.getItem("LF_bathroom")!="" && sessionStorage.getItem("LF_bathroom") != null){
			 jQuery("#LF_bathroom-0").val(sessionStorage.getItem("LF_bathroom"));
			 sessionStorage.setItem("LF_bathroom", '');
			}

			if(sessionStorage.getItem("LF_property_search")!="" && sessionStorage.getItem("LF_property_search") != null){
			 jQuery("#LF_property_search-0").val(sessionStorage.getItem("LF_property_search"));
				sessionStorage.setItem("LF_property_search", '');
			}
			if(sessionStorage.getItem("main_search")!="" && sessionStorage.getItem("main_search") != null){
			 jQuery("#LF_main_search-0").val(sessionStorage.getItem("main_search"));
			 sessionStorage.setItem("main_search", '');
			}
			
			if(sessionStorage.getItem("LF_municipalities")!="" && sessionStorage.getItem("LF_municipalities") != null){
			 var prevMuni = sessionStorage.getItem("LF_municipalities");
			 if(jQuery('#LF_municipalities-0 option[value='+sessionStorage.getItem("LF_municipalities")+']').length > 0)
                         {
                                jQuery("#LF_municipalities-0").val(sessionStorage.getItem("LF_municipalities"));
                         }
                         else
                         {
                                jQuery("#LF_municipalities-0").append(new Option(prevMuni,prevMuni ,false,false));
                         }
			 sessionStorage.setItem("LF_municipalities", '');
			}

			if(sessionStorage.getItem("LF_waterfront")!="" && sessionStorage.getItem("LF_waterfront") != null) {
				if(sessionStorage.getItem("LF_waterfront") == "yes"){
                         		jQuery("#waterfront-0").attr("checked",true);
		                         sessionStorage.setItem("LF_waterfront", 'no');
				}
				else
				{
					jQuery("#waterfront-0").attr("checked",false);
                                         sessionStorage.setItem("LF_waterfront", 'yes');
				}
                        }
			
			
			
			
			
			if(sessionStorage.getItem("pageNo")!="" && sessionStorage.getItem("pageNo") != null){
				 var indexData = jQuery('.LF-pagination>li>a[data-page = '+sessionStorage.getItem("pageNo")+']').closest('.LF-pagination').data('index');
				 var pageNo = jQuery('.LF-pagination>li>a[data-page = '+sessionStorage.getItem("pageNo")+']').attr('data-page');
				 $dataID = jQuery('.LF-pagination>li>a[data-page = '+sessionStorage.getItem("pageNo")+']').closest('#listing-'+indexData);
				 sessionStorage.setItem("pageNo", '');
				 LFPagination(indexData,pageNo,$dataID); 
				 
			}else {
			  var tagSearch = jQuery('#search-0').val();
			
			if(tagSearch!='only'){
				jQuery('#listing-0 .LF-btn-search').trigger('click');
			}
	 
            }			
		}else {
		
		    var tagSearch = jQuery('#search-0').val();
			var ids = jQuery('#ids-0').val();
			if(tagSearch!='only'){
				jQuery('#listing-0 .LF-btn-search').trigger('click');
			}
		}
			
	 }
	}, 1000);
	 
	
	
	
	
	
    var maxHeight = 0;

    jQuery(".LF-address").each(function() {
        if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
    });

    jQuery(".LF-listigs").each(function(index) {
        if (jQuery(this)) {
            jQuery(this).attr('id','listing-'+index);
            jQuery(this).find('.LF-pagination,.LF-sortblock,.LF-btn-search').attr('data-index', index);
            jQuery(this).find('input,select').each(function () {
                const id = jQuery(this).attr('id');
                jQuery(this).attr('id', id+'-'+index);
            });
        }
    });

    jQuery(".LF-address").height(maxHeight);
    
	/* var tagSearch = jQuery('#search-0').val();
    var ids = jQuery('#ids-0').val();
    if(tagSearch!='only' && ids == ''){
        jQuery('#listing-0 .LF-btn-search').trigger('click');
    } */
});
var noofcol = jQuery('#noofcol').val();
var per_row = jQuery('#per_row').val();

if(per_row==''){
    noofcol = noofcol;
}
else{
    noofcol = per_row;
}
if(noofcol>4){
    noofcol = 4;
}
var options = {
    cellAlign: 'left',
    contain: true,
    pageDots: false
}
/*var options = {
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: noofcol,
    slidesToScroll: noofcol,
    swipeToSlide: true,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
}*/
jQuery(document).ready(function(){
    
	 

});


//listing pagination and sort ajax
jQuery(document).on('click', '.LF-pagination>li>a', function() {
     var indexData = jQuery(this).closest('.LF-pagination').data('index');
     var pageNo = jQuery(this).attr('data-page');
	 $dataID = jQuery(this).closest('#listing-'+indexData);
	 LFPagination(indexData,pageNo,$dataID);
});
  function LFPagination(indexData,pageNo,$dataID){
   

    var main_search = jQuery('#LF_main_search-'+indexData).val();
    var LF_municipalities = jQuery('#LF_municipalities-'+indexData).val();
    var LF_sale = jQuery('#LF_sale-'+indexData).val();
    var LF_bedroom = jQuery('#LF_bedroom-'+indexData).val();
    var LF_bathroom = jQuery('#LF_bathroom-'+indexData).val();
    var LF_property_search = jQuery('#LF_property_search-'+indexData).val();
    var LF_pricefrom_search = jQuery('#LF_pricefrom_search-'+indexData).val();
    var LF_priceto_search = jQuery('#LF_priceto_search-'+indexData).val();
    var waterfront = jQuery('input[name="waterfront"]:checked').val();
   
    var LF_sort = jQuery("input[name='LF-sort']:checked").val();
    var LF_defaultagents = jQuery('#defaultagents-'+indexData).val();
    var LF_defaultoffice = jQuery('#defaultoffice-'+indexData).val();
    var LF_defaultopenhouse = jQuery('#defaultopenhouse-'+indexData).val();
    var slug = jQuery('#pageSlug-'+indexData).val();
    var tagSearch = jQuery('#search-'+indexData).val();
    var tagStyle = jQuery('#style-'+indexData).val();
    var tagids = jQuery('#ids-'+indexData).val();
    var pagination = jQuery('#pagination-'+indexData).val();
    var priceorder = jQuery('#priceorder-'+indexData).val();
    var LF_per_row = jQuery('#per_row-'+indexData).val();
    var LF_list_per_page = jQuery('#list_per_page-'+indexData).val();


	sessionStorage.setItem("pageNo", pageNo);
	sessionStorage.setItem("slug", slug);
	sessionStorage.setItem("LF_bedroom", LF_bedroom);
	sessionStorage.setItem("LF_bathroom", LF_bathroom);
	sessionStorage.setItem("main_search", main_search);
	sessionStorage.setItem("LF_municipalities", LF_municipalities);
	sessionStorage.setItem("LF_sale", LF_sale);
	sessionStorage.setItem("LF_property_search", LF_property_search);
    sessionStorage.setItem("LF_pricefrom_search", LF_pricefrom_search);
	sessionStorage.setItem("LF_priceto_search", LF_priceto_search);

	if(waterfront == 'y' && typeof waterfront !== 'undefined')
	{
		sessionStorage.setItem("LF_waterfront", "yes");
	}
	else
	{
		sessionStorage.setItem("LF_waterfront", "no");
	}

	
    var search, sale, municipalities, bedroom, bathroom, property_Type, priceFrom, priceTo, waterFront, page, LF_sort, defaultoffice, defaultagents, defaultopenhouse,srch,style,ids,pagi,priord,per_row,list_per_page;

    var flag = 0;


    if(jQuery.trim(LF_defaultopenhouse) !=''){
        defaultopenhouse = '&openhouse='+LF_defaultopenhouse;
    }
    else{
        defaultopenhouse = '';
    }

    if(jQuery.trim(LF_list_per_page) !=''){
        list_per_page = '&list_per_page='+LF_list_per_page;
    }
    else{
        list_per_page = '';
    }

    if(jQuery.trim(LF_per_row) !='' && typeof LF_per_row !== 'undefined'){
        per_row = '&per_row='+LF_per_row;
    }
    else{
        per_row = '';
    }
    // alert(LF_per_row);

    if(jQuery.trim(pagination) != '' && typeof pagination !== 'undefined') {
        pagi = '&pagination='+pagination;
    }
    else{
        pagi = '';
    }
    if(jQuery.trim(priceorder) != '' && typeof priceorder !== 'undefined') {
        priord = '&priceorder='+priceorder;
    }
    else{
        priord = '';
    }

    if(jQuery.trim(tagSearch) != '' && typeof tagSearch !== 'undefined') {
        srch = '&search='+tagSearch;
    }
    else{
        srch = '';
    }
    if(jQuery.trim(tagStyle) != '' && typeof tagStyle !== 'undefined') {
        style = '&style='+tagStyle;
    }
    else{
        style = '';
    }
    if(jQuery.trim(tagids) != '' && typeof tagids !== 'undefined') {
        ids = '&ids='+tagids;
    }
    else{
        ids = '';
    }
    if(jQuery.trim(LF_defaultoffice) != ''){
        defaultoffice = '&offices='+ LF_defaultoffice;
    }
    else{
        defaultoffice = '';
    }
    if(jQuery.trim(LF_defaultagents)!=''){
        defaultagents = '&agents=' + LF_defaultagents;
    }
    else{
        defaultagents = '';
    }
    if (jQuery.trim(LF_sort) != '' && typeof LF_sort !== 'undefined') {
        sort = '&sort=' + LF_sort;
    } else {
        sort = '&sort=ASC';
    }

    if (jQuery.trim(main_search) != '' && typeof main_search !== 'undefined') {
        if((main_search.length<2 || main_search.length>20) && main_search!=''){
            jQuery('.formmessage').html('<div class="alert-error">Search should be 2 to 20 characters long.</div>');
            flag++;
        }
        else{
            jQuery('.formmessage').html('');
        }
        search = '&mainSearch=' + main_search;
    } else {
        search = '';
    }

    if (jQuery.trim(LF_municipalities) != '0' && typeof LF_municipalities !== 'undefined') {
        municipalities = '&LF_municipalities=' + LF_municipalities;
    } else {
        var defaultlocation = jQuery('#defaultlocation-'+indexData).val();
        if(defaultlocation!='' && tagSearch=='no'){
            municipalities = '&LF_municipalities=' + defaultlocation;
        }
        else{
            municipalities = '';
        }
    }

    if (LF_sale != '0' && typeof LF_sale !== 'undefined') {
        sale = '&sale=' + LF_sale;
    } else {
        var defaultSale = jQuery('#defaultsale-'+indexData).val();
        if(defaultSale!='' && tagSearch=='no'){
           sale =  '&sale=' +defaultSale;
        }
        else{
            sale = '';
        }
    }

    if (LF_bedroom != '0' && typeof LF_bedroom !== 'undefined') {
        bedroom = '&bedroom=' + LF_bedroom;
    } else {
        bedroom = '';
    }

    if (LF_bathroom != '0' && typeof LF_bathroom !== 'undefined') {
        bathroom = '&bathroom=' + LF_bathroom;
    } else {
        bathroom = '';
    }

    if (LF_property_search != '' && typeof LF_property_search !== 'undefined') {
        property_Type = '&property_Type=' + LF_property_search;
    } else {
        var defaultType = jQuery('#defaultSearchType-'+indexData).val();
        if(defaultType!=''){
            property_Type = '&property_Type=' + defaultType;
        }
        else{
            property_Type = '';
        }
    }

    if (LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') {
        priceFrom = '&priceFrom=' + LF_pricefrom_search;
    } else {
        priceFrom = '';
    }

    if (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') {
        priceTo = '&priceTo=' + LF_priceto_search;
    } else {
        priceTo = '';
    }

    if (waterfront == 'y' && typeof waterfront !== 'undefined') {
        waterFront = '&waterFront=' + waterfront;
    } else {
        var defaultwaterfront = jQuery('#defaultwaterfront-'+indexData).val();
        if(defaultwaterfront!='' && ( defaultwaterfront == 'yes' || defaultwaterfront == 'y') && (tagSearch!='yes' && tagSearch != '')){
            waterFront = '&waterFront=y';
        }
        else{
            waterFront = '';
        }
        // waterFront = '';
    }

    if (pageNo != '' && typeof pageNo !== 'undefined') {
        page = '&page=' + pageNo;
    } else {
        page = '';
    }
    if ((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined')) {
      if(parseInt(LF_pricefrom_search) > parseInt(LF_priceto_search)){
	    alert("Price from can't be greater then Price to.");
	    return false;
	  }
	}
   

    if(flag==0){
        jQuery.ajax({
            method: 'POST',
            url: LF_custom.ajaxurl,
            data: "action=LF_pagination&token=" + LF_custom.security + page + search + municipalities + sale + bedroom + bathroom + property_Type + priceFrom + priceTo + waterFront + sort + defaultoffice + defaultagents + defaultopenhouse + '&slug='+slug + srch + style + ids + pagi + priord + per_row + '&index='+indexData + list_per_page,
            beforeSend: function() {
                $dataID.css('opacity', '0.5');
            },
            success: function(response) {
                // jQuery('#LF-listigs').html(response);
                $dataID.html(response);
		if((LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') && (jQuery('#LF_priceto_search-0 option[value='+LF_priceto_search+']').length == 0 ))
                         {
                                jQuery("#LF_priceto_search-0").append(new Option(LF_priceto_search,LF_priceto_search ,true, true));
                         }
                if((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (jQuery('#LF_pricefrom_search-0 option[value='+LF_pricefrom_search+']').length == 0 ))
                         {
                                jQuery("#LF_pricefrom_search-0").append(new Option(LF_pricefrom_search,LF_pricefrom_search ,true, true));
                         }
                if(tagStyle=='horizontal'){
                    jQuery(".horizantal-slide").flickity(options)
                }
            },
            complete: function() {
                var maxHeight = 0;
                jQuery(".LF-address").each(function() {
                    if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
                });
                jQuery(".LF-address").height(maxHeight);
                $dataID.css('opacity', '1');
				jQuery("#LF_pricefrom_search-0").select2( {
					placeholder: "Price From",
					allowClear: true,
					tags: true
				} );
				 jQuery("#LF_priceto_search-0").select2( {
					placeholder: "Price To",
					allowClear: true,
					tags: true
				});



            }
        });
    }
};

jQuery(document).on('click', '.LF-Bsort', function() {
	jQuery("input[name='LF-sort'][value=" + jQuery(this).val() + "]").attr('checked', 'checked').trigger("click");
});

jQuery(document).on('click', '.LF-sort', function() {
    var indexData = jQuery(this).closest('.LF-sortblock').data('index');
    var main_search = jQuery('#LF_main_search-'+indexData).val();
    var LF_municipalities = jQuery('#LF_municipalities-'+indexData).val();
    var LF_sale = jQuery('#LF_sale-'+indexData).val();
    var LF_bedroom = jQuery('#LF_bedroom-'+indexData).val();
    var LF_bathroom = jQuery('#LF_bathroom-'+indexData).val();
    var LF_property_search = jQuery('#LF_property_search-'+indexData).val();
    var LF_pricefrom_search = jQuery('#LF_pricefrom_search-'+indexData).val();
    var LF_priceto_search = jQuery('#LF_priceto_search-'+indexData).val();
    var waterfront = jQuery('input[name="waterfront"]:checked').val();
    var pageNo = jQuery(this).attr('data-page');
    var LF_sort = jQuery("input[name='LF-sort']:checked").val();
    var LF_defaultagents = jQuery('#defaultagents-'+indexData).val();
    var LF_defaultoffice = jQuery('#defaultoffice-'+indexData).val();
    var LF_defaultopenhouse = jQuery('#defaultopenhouse-'+indexData).val();
    var slug = jQuery('#pageSlug-'+indexData).val();
    var tagSearch = jQuery('#search-'+indexData).val();
    var tagStyle = jQuery('#style-'+indexData).val();
    var tagids = jQuery('#ids-'+indexData).val();
    var pagination = jQuery('#pagination-'+indexData).val();
    var priceorder = jQuery('#priceorder-'+indexData).val();
    var LF_per_row = jQuery('#per_row-'+indexData).val();
    var LF_list_per_page = jQuery('#list_per_page-'+indexData).val();

    var search, sale, municipalities, bedroom, bathroom, property_Type, priceFrom, priceTo, waterFront, page, LF_sort, defaultoffice, defaultagents, defaultopenhouse,srch,style,ids,pagi,priord,per_row,list_per_page;

    var flag = 0;

    if(jQuery.trim(LF_defaultopenhouse) !=''){
        defaultopenhouse = '&openhouse='+LF_defaultopenhouse;
    }
    else{
        defaultopenhouse = '';
    }

	if(jQuery.trim(LF_list_per_page) !=''){
        list_per_page = '&list_per_page='+LF_list_per_page;
    }
    else{
        list_per_page = '';
    }

    if(jQuery.trim(LF_per_row) !='' && typeof LF_per_row !== 'undefined'){
        per_row = '&per_row='+LF_per_row;
    }
    else{
        per_row = '';
    }
    // alert(LF_per_row);

    if(jQuery.trim(pagination) != '' && typeof pagination !== 'undefined') {
        pagi = '&pagination='+pagination;
    }
    else{
        pagi = '';
    }
    if(jQuery.trim(priceorder) != '' && typeof priceorder !== 'undefined') {
        priord = '&priceorder='+priceorder;
    }
    else{
        priord = '';
    }

    if(jQuery.trim(tagSearch) != '' && typeof tagSearch !== 'undefined') {
        srch = '&search='+tagSearch;
    }
    else{
        srch = '';
    }
    if(jQuery.trim(tagStyle) != '' && typeof tagStyle !== 'undefined') {
        style = '&style='+tagStyle;
    }
    else{
        style = '';
    }
    if(jQuery.trim(tagids) != '' && typeof tagids !== 'undefined') {
        ids = '&ids='+tagids;
    }
    else{
        ids = '';
    }
    if(jQuery.trim(LF_defaultoffice) != ''){
        defaultoffice = '&offices='+ LF_defaultoffice;
    }
    else{
        defaultoffice = '';
    }
    if(jQuery.trim(LF_defaultagents)!=''){
        defaultagents = '&agents=' + LF_defaultagents;
    }
    else{
        defaultagents = '';
    }
    if (jQuery.trim(LF_sort) != '' && typeof LF_sort !== 'undefined') {
        sort = '&sort=' + LF_sort;
    } else {
        sort = '&sort=ASC';
    }

    if (jQuery.trim(main_search) != '' && typeof main_search !== 'undefined') {
        if((main_search.length<2 || main_search.length>20) && main_search!=''){
            jQuery('.formmessage').html('<div class="alert-error">Search should be 2 to 20 characters long.</div>');
            flag++;
        }
        else{
            jQuery('.formmessage').html('');
        }
        search = '&mainSearch=' + main_search;
    } else {
        search = '';
    }

    if (jQuery.trim(LF_municipalities) != '0' && typeof LF_municipalities !== 'undefined') {
        municipalities = '&LF_municipalities=' + LF_municipalities;
    } else {
        var defaultlocation = jQuery('#defaultlocation-'+indexData).val();
        if(defaultlocation!='' && tagSearch=='no'){
            municipalities = '&LF_municipalities=' + defaultlocation;
        }
        else{
            municipalities = '';
        }
    }

    if (LF_sale != '0' && typeof LF_sale !== 'undefined') {
        sale = '&sale=' + LF_sale;
    } else {
        var defaultSale = jQuery('#defaultsale-'+indexData).val();
        if(defaultSale!='' && tagSearch=='no'){
           sale =  '&sale=' +defaultSale;
        }
        else{
            sale = '';
        }
    }

    if (LF_bedroom != '0' && typeof LF_bedroom !== 'undefined') {
        bedroom = '&bedroom=' + LF_bedroom;
    } else {
        bedroom = '';
    }

    if (LF_bathroom != '0' && typeof LF_bathroom !== 'undefined') {
        bathroom = '&bathroom=' + LF_bathroom;
    } else {
        bathroom = '';
    }

    if (LF_property_search != '' && typeof LF_property_search !== 'undefined') {
        property_Type = '&property_Type=' + LF_property_search;
    } else {
        var defaultType = jQuery('#defaultSearchType-'+indexData).val();
        if(defaultType!=''){
            property_Type = '&property_Type=' + defaultType;
        }
        else{
            property_Type = '';
        }
    }

    if (LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') {
        priceFrom = '&priceFrom=' + LF_pricefrom_search;
    } else {
        priceFrom = '';
    }

    if (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') {
        priceTo = '&priceTo=' + LF_priceto_search;
    } else {
        priceTo = '';
    }

    if (waterfront == 'y' && typeof waterfront !== 'undefined') {
        waterFront = '&waterFront=' + waterfront;
    } else {
        var defaultwaterfront = jQuery('#defaultwaterfront-'+indexData).val();
        if(defaultwaterfront!='' && ( defaultwaterfront == 'yes' || defaultwaterfront == 'y') && (tagSearch!='yes' && tagSearch != '')){
            waterFront = '&waterFront=y';
        }
        else{
            waterFront = '';
        }
        // waterFront = '';
    }

    if (pageNo != '' && typeof pageNo !== 'undefined') {
        page = '&page=' + pageNo;
    } else {
        page = '';
    }

	if ((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined')) {
      if(parseInt(LF_pricefrom_search) > parseInt(LF_priceto_search)){
	    alert("Price from can't be greater then Price to.");
	    return false;
	  }
	}

    $dataID = jQuery(this).closest('#listing-'+indexData);

    if(flag==0){
        jQuery.ajax({
            method: 'POST',
            url: LF_custom.ajaxurl,
            data: "action=LF_pagination&token=" + LF_custom.security + page + search + municipalities + sale + bedroom + bathroom + property_Type + priceFrom + priceTo + waterFront + sort + defaultoffice + defaultagents + defaultopenhouse + '&slug='+slug + srch + style + ids + pagi + priord + per_row + '&index='+indexData + list_per_page,
            beforeSend: function() {
                $dataID.css('opacity', '0.5');
            },
            success: function(response) {
                // jQuery('#LF-listigs').html(response);
                $dataID.html(response);
		if((LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') && (jQuery('#LF_priceto_search-0 option[value='+LF_priceto_search+']').length == 0 ))
                         {
                                jQuery("#LF_priceto_search-0").append(new Option(LF_priceto_search,LF_priceto_search ,true, true));
                         }
                if((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (jQuery('#LF_pricefrom_search-0 option[value='+LF_pricefrom_search+']').length == 0 ))
                         {
                                jQuery("#LF_pricefrom_search-0").append(new Option(LF_pricefrom_search,LF_pricefrom_search ,true, true));
                         }
                if(tagStyle=='horizontal'){
                    jQuery(".horizantal-slide").flickity(options)
                }
            },
            complete: function() {
                var maxHeight = 0;
                jQuery(".LF-address").each(function() {
                    if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
                });
                jQuery(".LF-address").height(maxHeight);
                $dataID.css('opacity', '1');
				jQuery("#LF_pricefrom_search-0").select2( {
					placeholder: "Price From",
					allowClear: true,
					tags: true
				} );
				 jQuery("#LF_priceto_search-0").select2( {
					placeholder: "Price To",
					allowClear: true,
					tags: true
				});


            }
        });
    }
});

jQuery(document).on('click', '.LF-btn-search', function() {
    var indexData = jQuery(this).data('index');

    var main_search = jQuery('#LF_main_search-'+indexData).val();
    var LF_municipalities = jQuery('#LF_municipalities-'+indexData).val();
    var LF_sale = jQuery('#LF_sale-'+indexData).val();
    var LF_bedroom = jQuery('#LF_bedroom-'+indexData).val();
    var LF_bathroom = jQuery('#LF_bathroom-'+indexData).val();
    var LF_property_search = jQuery('#LF_property_search-'+indexData).val();
    var LF_pricefrom_search = jQuery('#LF_pricefrom_search-'+indexData).val();
    var LF_priceto_search = jQuery('#LF_priceto_search-'+indexData).val();
    var waterfront = jQuery('input[name="waterfront"]:checked').val();
    var LF_sort = jQuery("input[name='LF-sort']:checked").val();
    var LF_defaultagents = jQuery('#defaultagents-'+indexData).val();
    var LF_defaultoffice = jQuery('#defaultoffice-'+indexData).val();
    var LF_defaultopenhouse = jQuery('#defaultopenhouse-'+indexData).val();
    var slug = jQuery('#pageSlug-'+indexData).val();
    var tagSearch = jQuery('#search-'+indexData).val();
    var tagStyle = jQuery('#style-'+indexData).val();
    var tagids = jQuery('#ids-'+indexData).val();
    var pagination = jQuery('#pagination-'+indexData).val();
    var priceorder = jQuery('#priceorder-'+indexData).val();
    var LF_per_row = jQuery('#per_row-'+indexData).val();
    var LF_list_per_page = jQuery('#list_per_page-'+indexData).val();
    var flag = 0;
	
	
    var search, municipalities, sale, bedroom, bathroom, property_Type, priceFrom, priceTo, waterFront, LF_sort, defaultoffice, defaultagents, defaultopenhouse,srch,style,ids,pagi,priord, per_row, list_per_page;

   
	sessionStorage.setItem("pageNo", "");
	sessionStorage.setItem("slug", slug);
	sessionStorage.setItem("LF_bedroom", LF_bedroom);
	sessionStorage.setItem("LF_bathroom", LF_bathroom);
	sessionStorage.setItem("main_search", main_search);
	sessionStorage.setItem("LF_municipalities", LF_municipalities);
	sessionStorage.setItem("LF_sale", LF_sale);
	sessionStorage.setItem("LF_property_search", LF_property_search);
	sessionStorage.setItem("LF_pricefrom_search", LF_pricefrom_search);
	sessionStorage.setItem("LF_priceto_search", LF_priceto_search);

	if(waterfront == 'y' && typeof waterfront !== 'undefined')
        {
                sessionStorage.setItem("LF_waterfront", "yes");
        }
        else
        {
                sessionStorage.setItem("LF_waterfront", "no");
        }	

    if(jQuery.trim(LF_per_row) !='' && typeof LF_per_row !== 'undefined'){
        per_row = '&per_row='+LF_per_row;
    }
    else{
        per_row = '';
    }

	if(jQuery.trim(LF_list_per_page) !=''){
        list_per_page = '&list_per_page='+LF_list_per_page;
    }
    else{
        list_per_page = '';
    }

    if(jQuery.trim(pagination) != '' && typeof pagination !== 'undefined') {
        pagi = '&pagination='+pagination;
    }
    else{
        pagi = '';
    }
    if(jQuery.trim(priceorder) != '' && typeof priceorder !== 'undefined') {
        priord = '&priceorder='+priceorder;
    }
    else{
        priord = '';
    }

    if(jQuery.trim(tagSearch) != '' && typeof tagSearch !== 'undefined') {
        srch = '&search='+tagSearch;
    }
    else{
        srch = '';
    }

    if(jQuery.trim(tagStyle) != '' && typeof tagStyle !== 'undefined') {
        style = '&style='+tagStyle;
    }
    else{
        style = '';
    }
    if(jQuery.trim(tagids) != '' && typeof tagids !== 'undefined') {
        ids = '&ids='+tagids;
    }
    else{
        ids = '';
    }

    if(jQuery.trim(LF_defaultopenhouse) !=''){
        defaultopenhouse = '&openhouse='+LF_defaultopenhouse;
    }
    else{
        defaultopenhouse = '';
    }
    if(jQuery.trim(LF_defaultoffice) != '' && typeof LF_defaultoffice !== 'undefined'){
        defaultoffice = '&offices='+ LF_defaultoffice;
    }
    else{
        defaultoffice = '';
    }
    if(jQuery.trim(LF_defaultagents)!='' && typeof LF_defaultagents !== 'undefined'){
        defaultagents = '&agents=' + LF_defaultagents;
    }
    else{
        defaultagents = '';
    }
    if (jQuery.trim(LF_sort) != '' && typeof LF_sort !== 'undefined') {
        sort = '&sort=' + LF_sort;
    } else {
        sort = '&sort=ASC';
    }

    if (jQuery.trim(LF_municipalities) != '0' && typeof LF_municipalities !== 'undefined') {
        municipalities = '&LF_municipalities=' + LF_municipalities;
    } else {
        var defaultlocation = jQuery('#defaultlocation-'+indexData).val();
        if(defaultlocation!='' && tagSearch=='no'){
            municipalities = '&LF_municipalities=' + defaultlocation;
        }
        else{
            municipalities = '';
        }
    }

    if (jQuery.trim(main_search) != '' && typeof main_search !== 'undefined') {
        if((main_search.length<2 || main_search.length>20) && main_search!=''){
            jQuery('.formmessage').html('<div class="alert-error">Search should be 2 to 20 characters long.</div>');
            flag++;
        }
        else{
            jQuery('.formmessage').html('');
        }
        search = '&mainSearch=' + main_search;
    } else {
        search = '';
    }

    if (LF_sale != '0' && typeof LF_sale !== 'undefined') {
        sale = '&sale=' + LF_sale;
    } else {
        var defaultSale = jQuery('#defaultsale-'+indexData).val();
        if(defaultSale!='' && tagSearch=='no'){
           sale =  '&sale=' +defaultSale;
        }
        else{
            sale = '';
        }
    }

    if (LF_bedroom != '0' && typeof LF_bedroom !== 'undefined') {
        bedroom = '&bedroom=' + LF_bedroom;
    } else {
        bedroom = '';
    }

    if (LF_bathroom != '0' && typeof LF_bathroom !== 'undefined') {
        bathroom = '&bathroom=' + LF_bathroom;
    } else {
        bathroom = '';
    }

    if (LF_property_search != '' && typeof LF_property_search !== 'undefined') {
        property_Type = '&property_Type=' + LF_property_search;
    } else {
        var defaultType = jQuery('#defaultSearchType-'+indexData).val();
        if(defaultType!=''){
            property_Type = '&property_Type=' + defaultType;
        }
        else{
            property_Type = '';
        }
    }

    if (LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') {
        priceFrom = '&priceFrom=' + LF_pricefrom_search;
    } else {
        priceFrom = '';
    }

    if (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') {
        priceTo = '&priceTo=' + LF_priceto_search;
    } else {
        priceTo = '';
    }

	if (waterfront == 'y' && typeof waterfront !== 'undefined') {
        waterFront = '&waterFront=' + waterfront;
    } else {
        var defaultwaterfront = jQuery('#defaultwaterfront-'+indexData).val();
        if(defaultwaterfront!='' && ( defaultwaterfront == 'yes' || defaultwaterfront == 'y') && (tagSearch!='yes' && tagSearch != '')){
            waterFront = '&waterFront=y';
        }
        else{
            waterFront = '';
        }
    }

	if ((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined')) {
      if(parseInt(LF_pricefrom_search) > parseInt(LF_priceto_search)){
	    alert("Price from can't be greater then Price to.");
	    return false;
	  }
	}
	$dataID = jQuery(this).closest('#listing-'+indexData);
    if(flag==0){
        jQuery.ajax({
            method: 'POST',
            url: LF_custom.ajaxurl,
            data: "action=LF_search&token=" + LF_custom.security + search + municipalities + sale + bedroom + bathroom + property_Type + priceFrom + priceTo + waterFront + sort + defaultoffice + defaultagents + defaultopenhouse + '&slug='+slug + srch + style + ids + pagi + priord + per_row + '&index='+indexData + list_per_page,
            beforeSend: function() {
                $dataID.css('opacity', '0.5');
            },
            success: function(response) {
                $dataID.html(response);
		if((LF_priceto_search != '' && typeof LF_priceto_search !== 'undefined') && (jQuery('#LF_priceto_search-0 option[value='+LF_priceto_search+']').length == 0 ))
                         {
                                jQuery("#LF_priceto_search-0").append(new Option(LF_priceto_search,LF_priceto_search ,true, true));
                         }
		if((LF_pricefrom_search != '' && typeof LF_pricefrom_search !== 'undefined') && (jQuery('#LF_pricefrom_search-0 option[value='+LF_pricefrom_search+']').length == 0 ))
                         {
                                jQuery("#LF_pricefrom_search-0").append(new Option(LF_pricefrom_search,LF_pricefrom_search ,true, true));
                         }

                if(tagStyle == 'horizontal'){
                    jQuery(".horizantal-slide").flickity(options)
                }
            },
            complete: function() {
                
				var maxHeight = 0;
                jQuery(".LF-address").each(function() {
                    if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
                });
                jQuery(".LF-address").height(maxHeight);
                $dataID.css('opacity', '1');
				
				jQuery("#LF_pricefrom_search-0").select2( {
					placeholder: "Price From",
					allowClear: true,
					tags: true
				} ).on("change", function(e) {
                        var isNew = jQuery(this).find('[data-select2-tag="true"]');
                      if(isNew.length){
                        jQuery(this).removeAttr('selected');
                        isNew.replaceWith('<option selected value="'+isNew.val()+'">'+isNew.val()+'</option>');
                }
        }).on('select2:open', function(e){
    jQuery('.select2-search__field').attr('placeholder', 'Numbers only...');
});
				 jQuery("#LF_priceto_search-0").select2( {
					placeholder: "Price To",
					allowClear: true,
					tags: true
				}).on("change", function(e) {
                        var isNew = jQuery(this).find('[data-select2-tag="true"]');
                      if(isNew.length){
			jQuery(this).removeAttr('selected');
                        isNew.replaceWith('<option selected value="'+isNew.val()+'">'+isNew.val()+'</option>');
                }
        }).on('select2:open', function(e){
    jQuery('.select2-search__field').attr('placeholder', 'Numbers only...');
});

                
				
			}
        });
    }
});

jQuery(document).on('submit', '#formInquiry', function() {
    var flag=0;
    var form = jQuery('#formInquiry').serialize();
    var captcha = jQuery('#recaptcha').val();
    var txtName = jQuery('#txtName').val();
    var txtemail = jQuery('#txtemail').val();
    var txtMessage = jQuery('#txtMessage').val();

    if (captcha != '' && typeof captcha !== 'undefined') {
        if(jQuery.trim(txtName)==''){
            jQuery('#txtName_error').text('Name field is required.');
            flag++;
        }
        else if(txtName.length<2 || txtName.length>20){
            jQuery('#txtName_error').text('Name should be 2 to 20 characters long.');
            flag++;
        }
        else{
            jQuery('#txtName_error').text('');
        }
        regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(jQuery.trim(txtemail)==''){
            jQuery('#txtemail_error').text('Email field is required.');
            flag++;
        }
        else if(!regex.test(txtemail)){
            jQuery('#txtemail_error').text('This email is invalid.');
            flag++;
        }
        else{
            jQuery('#txtemail_error').text('');
        }
        if(jQuery.trim(txtMessage)==''){
            jQuery('#txtMessage_error').text('Message field is required.');
            flag++;
        }
        else if(txtMessage.length<2 || txtMessage.length>140){
            jQuery('#txtMessage_error').text('Message should be 2 to 140 characters long.');
            flag++;
        }
        else{
            jQuery('#txtMessage_error').text('');
        }

        if(grecaptcha.getResponse() == "") {
            jQuery('#recaptcha_error').text('Please select captcha.');
            flag++;
        }
        else{
            jQuery('#recaptcha_error').text('');
        }
    }

    if(flag==0){
        jQuery('.mailmessage').html('');
        jQuery.ajax({
            method: 'POST',
            url: LF_custom.ajaxurl,
            data: 'action=LF_send_inquiryMail&token=' + LF_custom.security + '&' + form,
            dataType: "json",
            success: function(result) {

                if (result.response == '1') {
                    jQuery('#txtName').val('');
                    jQuery('#txtemail').val('');
                    jQuery('#txtMessage').val('');
					jQuery('#txtName_error').text('');
                    jQuery('#txtemail_error').text('');
                    jQuery('#txtMessage_error').text('');
                    jQuery('.mailmessage').html('<div class="alert-success">Mail sent successfully.</div>');
                }
                else if(result.response==2){
                    jQuery('#txtName_error').text(result.message.name);
                    jQuery('#txtemail_error').text(result.message.email);
                    jQuery('#txtMessage_error').text(result.message.message);
                }
                else{
					jQuery('#txtName_error').text('');
                    jQuery('#txtemail_error').text('');
                    jQuery('#txtMessage_error').text('');
                    jQuery('.mailmessage').html('<div class="alert-error">Ouch!! Failed to send mail.</div>');
                    jQuery('#mailsent').val('0');
                }
            }
        });
        return false;
    }
    else if(jQuery('#mailsent').val()==0){
        return false;
    }
    else{
        return false;
    }
});

function onSubmit(token) {
    jQuery("#formInquiry").submit();
}
function resetSearch(){
    // location.reload();
    //jQuery('.LF-row').css('opacity','0.5');
    //jQuery('.LF-listigs').load(location.href+" .LF-listigs>*","");
             
			
			 jQuery("#LF_priceto_search-0").val('');
			 sessionStorage.setItem("LF_priceto_search", ''); 

			sessionStorage.setItem("LF_waterfront", sessionStorage.getItem("LF_waterfront_default"));		
			if(sessionStorage.getItem("LF_waterfront") == "yes")
			{
				jQuery("#waterfront-0").attr("checked",true);
			}
			else
			{
				jQuery("#waterfront-0").attr("checked",false);
			}
 
			 jQuery("#LF_pricefrom_search-0").val('');
			 sessionStorage.setItem("LF_pricefrom_search", '');
			 
			 jQuery("#LF_sale-0").val(sessionStorage.getItem("LF_sale_default"));
			 sessionStorage.setItem("LF_sale", '');
			
			 jQuery("#LF_bedroom-0").val(0);
			 sessionStorage.setItem("LF_bedroom", '');
			
			 jQuery("#LF_bathroom-0").val(0);
			 sessionStorage.setItem("LF_bathroom", '');
			
             jQuery("#LF_property_search-0").val(sessionStorage.getItem("LF_property_search_default"));
			 sessionStorage.setItem("LF_property_search", '');
			
			 jQuery("#LF_main_search-0").val('');
			 sessionStorage.setItem("main_search", '');
			
			 jQuery("#LF_municipalities-0").val(sessionStorage.getItem("LF_municipalities_default"));
			 sessionStorage.setItem("LF_municipalities", '');
			 
			 setTimeout(function(){
             jQuery('#listing-0 .LF-btn-search').trigger('click');
			 },2000);
}
jQuery(document).on('click','.btn_close_model',function(){
    jQuery.ajax({
        method: 'POST',
        url: LF_custom.ajaxurl,
        data:"action=LF_SessionStart&token=" + LF_custom.security,
        success:function(data){
            jQuery('#Modal').hide();

        }
    });
});
jQuery(document).on('click','.LF-btn-close',function(){
    // jQuery('#Modal').hide();
    // window.location.href="";
    parent.history.back();

});
jQuery(document).ready(function(){
    jQuery('.LF-page-title').each(function(index){
        if(index!=0){
            jQuery('.LF-page-title').eq(index).remove();
        }
    });
    jQuery('.LF-description').each(function(i){
        if(i!=0){
            jQuery('.LF-description').eq(i).remove();
        }
    });

	jQuery("#LF_pricefrom_search-0").select2( {
		placeholder: "Price From",
		allowClear: true,
		tags: true,
});

	 jQuery("#LF_priceto_search-0").select2( {
		placeholder: "Price To",
		allowClear: true,
		  tags: true,
		searchInputPlaceholder: "Numbers Only"
	});


});


