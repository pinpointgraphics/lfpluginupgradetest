<?php

/**
* this function adds key value pair to database.
* like username = lflister
*/
function LF_add_settings($meta_key,$meta_value)
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	$table_name = $wpdb->prefix.'LF_listing_settings';

	$result = $wpdb->get_row( "SELECT * FROM $table_name WHERE meta_key = '".$meta_key."'" );

	if($result !== null)
	{
		$wpdb->update( $table_name, ['meta_value'=>$meta_value],['meta_key'=>$meta_key], $format = null, $where_format = null );
	}
	else
	{
		$result = $wpdb->replace( $table_name, ['meta_key'=>$meta_key,'meta_value'=>$meta_value],['%s','%s']);
	}

	if($result)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
* this function updates the existing key value pair in db.
*/
function LF_update_settings($meta_key,$meta_value)
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix.'LF_listing_settings';
	$wpdb->update( $table_name, ['meta_value'=>$meta_value],['meta_key'=>$meta_key], $format = null, $where_format = null );
}

/**
* this function gets the value of the perticular key
*/
function LF_get_settings($meta_key)
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix.'LF_listing_settings';

	$result = $wpdb->get_row( "SELECT * FROM $table_name WHERE meta_key = '".$meta_key."'" );

	if($result){
		return $result->meta_value;
	}
	else{
		return false;
	}

}

/**
* this function gets the token from the listing provider.
* so that we can get the listings information.
*/
function getToken()
{
	$url = API_URL.'/tokens';
	$username = LF_get_settings('user_name');
	$password = LF_get_settings('password');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$token = curl_exec($ch);
	curl_close($ch);

	if($token == "Invalid credentials.")
	{
		die($token.' Please check credentials in the LF-Listings Setting menu.');
	}
	
	return $token;
}

/**
* this function get the list of cities for given agent id.
*/
function getCities()
{
	$url = API_URL.'/accounts/'.LF_get_settings('agent_id').'?fields=cities';
	$username = LF_get_settings('user_name');
	$password = LF_get_settings('password');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$cities = curl_exec($ch);
	curl_close($ch);
	return json_decode($cities);

}

/**
* this function get the listings as per the search parameters.
*/
function getLFListings($page='',$mainSearch='', $municipalities='',$sale='',$bedroom='',$bathroom='',$property_Type='',$priceFrom='',$priceTo='',$waterFront='',$sort='',$offices='',$agents='',$openhouse='',$slug='',$search='',$style='',$ids='',$pagination='',$priceorder='',$per_row='',$index='',$list_per_page)
{

	if(empty($search) OR $search=='yes' OR $search=='only'){
		if(LF_get_settings('LF_show_search')=='yes' || (($search=='yes' OR $search=='only') AND LF_get_settings('LF_show_search')!='yes')){
			?>
			<div class="LF-row">
				<form method="post" name="search">
					<div class="LF-col-md-12">
						<div class="formmessage"></div>
					</div>
					<div class="LF-col-md-6">
						<div class="LF-form-group">
							<input type="text" name="LF_main_search" id="LF_main_search-<?php echo $index;?>" class="LF-form-control" placeholder="Search by Location, City, Postal Code or ID#" value="<?php echo !empty($mainSearch)?$mainSearch:'';?>" maxlength="20">
						</div>
					</div>
					<div class="LF-col-md-6">
						<?php
						$LF_Municipalities = explode(',',LF_get_settings('LF_Municipalities'));
						?>
						<div class="LF-form-group">
							<select name="LF_municipalities" id="LF_municipalities-<?php echo $index;?>" class="LF-form-control">
								<option value="0">All Municipalities</option>
								<?php
								foreach($LF_Municipalities as $LF_Municipalitie):
									if($LF_Municipalitie == $municipalities){
										$select = 'selected';
									}
									else{
										$select = '';
									}
									echo '<option value="'.$LF_Municipalitie.'"'.$select.'>'.$LF_Municipalitie.'</option>';
								endforeach;
								?>
							</select>
						</div>
					</div>
					<div class="LF-col-md-4">
						<div class="LF-form-group">
							<select name="LF_sale" id="LF_sale-<?php echo $index;?>" class="LF-form-control">
								<option value="0">For Sale or Rent</option>
								<option value="sale" <?php if($sale=='sale'){ echo 'selected';}?>>Sale</option>
								<option value="rent" <?php if($sale=='rent'){ echo 'selected';}?>>Rent</option>
							</select>
						</div>
					</div>
					<div class="LF-col-md-4">
						<div class="LF-form-group">
							<select name="LF_bedroom" id="LF_bedroom-<?php echo $index;?>" class="LF-form-control">
								<option value="0">Any</option>
								<option value="1" <?php if($bedroom=='1'){ echo 'selected';}?>>1</option>
								<option value="2" <?php if($bedroom=='2'){ echo 'selected';}?>>2</option>
								<option value="3" <?php if($bedroom=='3'){ echo 'selected';}?>>3</option>
								<option value="4" <?php if($bedroom=='4'){ echo 'selected';}?>>4</option>
								<option value="5" <?php if($bedroom=='5'){ echo 'selected';}?>>5+</option>
							</select>
						</div>
					</div>
					<div class="LF-col-md-4">
						<div class="LF-form-group">
							<select name="LF_bathroom" id="LF_bathroom-<?php echo $index;?>" class="LF-form-control">
								<option value="0">Any</option>
								<option value="1" <?php if($bathroom=='1'){ echo 'selected';}?>>1</option>
								<option value="2" <?php if($bathroom=='2'){ echo 'selected';}?>>2</option>
								<option value="3" <?php if($bathroom=='3'){ echo 'selected';}?>>3</option>
								<option value="4" <?php if($bathroom=='4'){ echo 'selected';}?>>4</option>
								<option value="5" <?php if($bathroom=='5'){ echo 'selected';}?>>5+</option>
							</select>
						</div>
					</div>
					<div class="LF-col-md-4">
						<div class="LF-form-group">
							<select name="LF_property_search" id="LF_property_search-<?php echo $index;?>" class="LF-form-control">
								<option value="any" selected="">All Property Types</option>
								<option value="residential" <?php if($property_Type=='residential'){ echo 'selected';}?>>Residential</option>
								<option value="commercial" <?php if($property_Type=='commercial'){ echo 'selected';}?>>Commercial</option>
								<option value="condo" <?php if($property_Type=='condo'){ echo 'selected';}?>>Condo/Strata</option>
								<option value="recreational" <?php if($property_Type=='recreational'){ echo 'selected';}?>>Recreational</option>
								<option value="agriculture" <?php if($property_Type=='agriculture'){ echo 'selected';}?>>Agriculture</option>
								<option value="land" <?php if($property_Type=='land'){ echo 'selected';}?>>Vacant Land</option>
							</select>
						</div>
					</div>
					<div class="LF-col-md-4">
						<div class="LF-form-group">
							<select id="LF_pricefrom_search-<?php echo $index;?>" name="LF_pricefrom_search" class="LF-form-control">
								<option value="">Price From</option>
								<option value="0" <?php if($priceFrom=='0'){ echo 'selected';}?>>0</option>
							     <?php 
								    
							       for($i=25000;$i <=500000;$i+=25000){
							         ?>
							       <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								  <?php } ?>
								 <?php 
								    $value = 500000;
							       for($i=550000;$i <=1000000;$i+=50000){
							       ?>
							     <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								 <?php } ?>
								 
								 <?php 
								  
							       for($i=1100000;$i <=2000000;$i+=100000){
							         ?>
							     <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								 <?php } ?>
								 <?php 
								    
							       for($i=2500000;$i <=7500000;$i+=500000){
							        ?>
							     <option value="<?php echo $i;?>" <?php if($priceFrom==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								 <?php } ?>
								 
								<option value="10000000 " <?php if($priceFrom=='10000000'){ echo 'selected';}?>>10,000,000 </option>
								<option value="15000000" <?php if($priceFrom=='15000000'){ echo 'selected';}?>>15,000,000</option>
								<option value="20000000" <?php if($priceFrom=='20000000'){ echo 'selected';}?>>20,000,000</option>
							</select>
						</div>
					</div>
					<div class="LF-col-md-4">
						<div class="LF-form-group">
							<select id="LF_priceto_search-<?php echo $index;?>" name="LF_priceto_search" class="LF-form-control">
								<option value="">Price To</option>
								<option value="0" <?php if($priceTo=='0'){ echo 'selected';}?>>0</option>
							     <?php 
								    
							       for($i=25000;$i <=500000;$i+=25000){
							         ?>
							       <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								  <?php } ?>
								 <?php 
								    $value = 500000;
							       for($i=550000;$i <=1000000;$i+=50000){
							       ?>
							     <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								 <?php } ?>
								 
								 <?php 
								  
							       for($i=1100000;$i <=2000000;$i+=100000){
							         ?>
							     <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								 <?php } ?>
								 <?php 
								    
							       for($i=2500000;$i <=7500000;$i+=500000){
							        ?>
							     <option value="<?php echo $i;?>" <?php if($priceTo==$i){ echo 'selected';}?>><?php echo number_format($i);?></option>
								 <?php } ?>
								 
								 <option value="10000000 " <?php if($priceTo=='10000000'){ echo 'selected';}?>>10,000,000 </option>
								<option value="15000000" <?php if($priceTo=='15000000'){ echo 'selected';}?>>15,000,000</option>
								<option value="20000000" <?php if($priceTo=='20000000'){ echo 'selected';}?>>20,000,000</option>
								
							</select>
						</div>
					</div>
					<div class="LF-col-md-12">
						<div class="LF-form-group">
							<label id="waterfront-search" for="waterfront">
								<input id="waterfront-<?php echo $index;?>" name="waterfront" <?php if(isset($waterFront) and $waterFront=='y'){ echo 'checked';}?> value="y" type="checkbox">Show waterfront properties only
							</label>
						</div>
						<div class="LF-form-group">
							<button class="LF-btn LF-btn-search" type="button" data-index="<?php echo $index;?>">Search</button>
							<button class="LF-btn LF-btn-reset" type="button" onclick="resetSearch()">Reset</button>
						</div>
					</div>
				</form>
			</div>
			<?php
		} //end check search enable/disable from admin
	} //end search tag in shortcode
	if(!empty($page)){
		$page = '&page='.$page;
	}
	else{
		$page = '';
	}
	if(!empty($mainSearch)){
		$mainSearch='&search='.urlencode($mainSearch);
	}
	else{
		$mainSearch = '';
	}

	if(!empty($municipalities)){
		$municipality = '&area='.urlencode($municipalities);
	}
	else{
		$municipality = '';
	}
	if(!empty($sale)){
		$LF_sale = '&sale='.$sale;
	}
	else{
		$LF_sale = '';
	}

	if(!empty($bedroom)){
		$bedroom = '&bed='.$bedroom;
	}
	else{
		$bedroom = '';
	}

	if(!empty($bathroom)){
		$bathroom = '&bath='.$bathroom;
	}
	else{
		$bathroom='';
	}

	if(!empty($property_Type)){
		$propertyType = '&type='.$property_Type;
	}
	else{
		$propertyType = '';
	}

	if(!empty($priceFrom)){
		$priceFrom = '&pricefrom='.$priceFrom;
	}
	else{
		$priceFrom = '';
	}

	if(!empty($priceTo)){
		$LF_priceTo = '&priceto='.$priceTo;
	}
	else{
		$LF_priceTo = '';
	}

	if(!empty($waterFront)){
		$LF_waterFront = '&waterfront='.$waterFront;
	}
	else{
		$LF_waterFront='';
	}
	if(!empty($offices)){
		$office = '&offices='.$offices;
	}
	else{
		$office = '';
	}
	if(!empty($agents)){
		$agent = '&agents='.$agents;
	}
	else{
		$agent = '';
	}
	if(!empty($openhouse)){
		$LF_openhouse = '&openhouse='.$openhouse;
	}
	else{
		$LF_openhouse = '';
	}
	if(!empty($ids))
	{
		$id = '&ids='.$ids;
	}
	else
	{
		$id = '';
	}


	$token = getToken();
	$agent_id = LF_get_settings('agent_id');
	$office_id = LF_get_settings('office_id');

	if($style=='horizontal'){
		$paginate = '50';
	}
	elseif(!empty($list_per_page)){
		if($list_per_page>48){
			$paginate = 48;
		}
		else{
			$paginate = $list_per_page;
		}
	}	
	else{
		$paginate = LF_get_settings('LF_page');
	}

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => API_URL."/properties?token=".$token."&agent_id=".$agent_id."&office_id=".$office_id."&paginate=".$paginate."&sort=".$sort.$page.$mainSearch.$LF_sale.$bedroom.$bathroom.$propertyType.$priceFrom.$LF_priceTo.$LF_waterFront.$municipality.$office.$agent.$id.$LF_openhouse,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {

		$page_id = get_the_ID();

		$pageSlug = $slug;

		$result = json_decode($response);
		if(empty($result)){
			return true;
		}
		?>
		<div class="LF-row">
			<input type="hidden" name="pageSlug" id="pageSlug-<?php echo $index;?>" value="<?php echo $slug;?>">

			<input type="hidden" name="defaultSearchType" id="defaultSearchType-<?php echo $index;?>" value="<?php echo !empty($property_Type)?$property_Type:'';?>">

			<input type="hidden" name="defaultagents" id="defaultagents-<?php echo $index;?>" value="<?php echo !empty($agents)?$agents:'';?>">

			<input type="hidden" name="defaultoffice" id="defaultoffice-<?php echo $index;?>" value="<?php echo !empty($offices)?$offices:'';?>">

			<input type="hidden" name="defaultlocation" id="defaultlocation-<?php echo $index;?>" value="<?php echo !empty($municipalities)?$municipalities:'';?>">

			<input type="hidden" name="defaultsale" id="defaultsale-<?php echo $index;?>" value="<?php echo !empty($sale)?$sale:'';?>">

			<input type="hidden" name="ids" id="ids-<?php echo $index;?>" value="<?php echo !empty($ids)?$ids:'';?>">

			<input type="hidden" name="defaultopenhouse" id="defaultopenhouse-<?php echo $index;?>" value="<?php echo !empty($openhouse)?$openhouse:'';?>">

			<input type="hidden" name="defaultwaterfront" id="defaultwaterfront-<?php echo $index;?>" value="<?php echo !empty($waterFront)?$waterFront:'';?>">

			<input type="hidden" name="search" id="search-<?php echo $index;?>" value="<?php echo !empty($search)?$search:'';?>">

			<input type="hidden" name="style" id="style-<?php echo $index;?>" value="<?php echo !empty($style)?$style:'';?>">

			<input type="hidden" name="noofcol" id="noofcol-<?php echo $index;?>" value="<?php echo !empty(LF_get_settings('LF_column'))?LF_get_settings('LF_column'):'';?>">

			<input type="hidden" name="pagination" id="pagination-<?php echo $index;?>" value="<?php echo !empty($pagination)?$pagination:'';?>">
			
			<input type="hidden" name="priceorder" id="priceorder-<?php echo $index;?>" value="<?php echo !empty($priceorder)?$priceorder:'';?>">

			<input type="hidden" name="per_row" id="per_row-<?php echo $index;?>" value="<?php echo !empty($per_row)?$per_row:'';?>">

			<input type="hidden" name="list_per_page" id="list_per_page-<?php echo $index;?>" value="<?php echo !empty($list_per_page)?$list_per_page:'';?>">


			<?php
			// if(empty($search) or $search!="only" or $search=="no" or $search == 'yes'){
			if($result->error==false){
				$current_page = $result->results->current_page;
				$last = ceil($result->results->total / $result->results->per_page);
				$links = 5;
				$a = ceil($links/2);
				$start      = ( ( $current_page - $links + $a) > 0 ) ? $current_page - $links + $a : 1;
				$end        = ( ( $current_page + $links - $a) < $last ) ? $current_page + $links - $a: $last;
				$class      = ( $current_page == 1 ) ? "disabled" : "";

				$html       = '<ul class="LF-pagination" data-index="'.$index.'">';

				if($current_page>1){
					$prev=$current_page-1;
					$html   .= '<li><a href="javascript:void(0);" data-page="'.$prev.'">Prev</a></li>';
				}

				if ( $start > 1 ) {
					$html   .= '<li><a href="javascript:void(0);" data-page="1">1</a></li>';
					$html   .= '<li class="disabled"><span>...</span></li>';
				}
				if($end>1){
					for ( $i = $start ; $i <= $end; $i++ ) {
						$class  = ( $current_page == $i ) ? "active" : "";
						$html   .= '<li class="' . $class . '"><a href="javascript:void(0);" data-page="'.$i.'">' . $i . '</a></li>';
					}
				}

				if ( $end < $last ) {
					$html   .= '<li class="disabled"><span>...</span></li>';
					$html   .= '<li><a href="javascript:void(0);" data-page="'.$last.'">' . $last . '</a></li>';
				}

				if($current_page < $last){
					$next = $current_page + 1;
					$html   .= '<li><a href="javascript:void(0);" data-page="'.$next.'">Next</a></li>';
				}
				$html       .= '</ul><div class="LF-clear"></div>';
				
				if(!empty($current_page)){
				 $_SEESION['current_page'] = $current_page;
				}else { $_SEESION['current_page'] = 1;}
				
				if($sort == 'ASC'){
					$ascchecked = 'checked';
				}
				else{
					$ascchecked = '';
				}

				if($sort == 'DESC'){
					$descchecked = 'checked';
				}
				else{
					$descchecked = '';
				}

				echo '<div class="LF-col-md-7">';
				if((empty($pagination) || $pagination == 'yes') and $style != 'horizontal'){
					echo $html;
				}
				echo '</div>';
				if((empty($priceorder) && LF_get_settings('LF_show_priceOrder')=='yes') || ( !empty($priceorder) && $priceorder!='no')){
						echo '<div class="LF-col-md-5">
						<div class="LF-sortblock" data-index="'.$index.'">
						<label>Order by price: </lable>
						Low <input type="radio" class="LF-sort" name="LF-sort" value="ASC" id="asc-'.$index.'" '.$ascchecked.'>
						High <input type="radio" class="LF-sort" name="LF-sort" value="DESC" id="desc-'.$index.'" '.$descchecked.'>
						</div>
						</div>';
					
				}
				echo '<div class="clear"></div>';

				//get column from admin setting
				if(empty($per_row)){
					$column = LF_get_settings('LF_column');
				}
				else{
					$column = $per_row;
				}
				// $column = LF_get_settings('LF_column');
				switch($column){
					case 0:
					$col=0;
					break;
					case 1:
					$col=12;
					break;
					case 2:
					$col=6;
					break;
					case 3:
					$col=4;
					break;
					case 4:
					$col=3;
					break;
					default:
					$col=3;
					break;
				}
				
				if(!empty($style) and $style == 'horizontal'){
					echo '<div class="horizantal-slide">';
				}
				foreach($result->results->data as $propertyList):
					if($col==0):
						?>
						<div class="LF-col-md-12">
							<div class="LF-listing-details LF-listview">
								<div class="LF-row">
									<div class="LF-col-md-4">
										<div class="LF-image">
											<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower(str_replace(' ','-',$propertyList->City)).'/'.strtolower($propertyList->FriendlyUrl);?>">
												<img src="<?php echo getLFImageProxy($propertyList->ListingThumb);?>" alt="">
											</a>
										</div>
									</div>
									<div class="LF-col-md-8">
										<div class="LF-header">
											<span class="LF-heading-link"><?php echo '#'.$propertyList->OriginatingSystemKey?></span>
										</div>
										<div class="LF-details">
											<div class="LF-price"><?php echo '$'.$propertyList->ListPriceFormatted;?></div>
											<div class="LF-address">
												<?php echo $propertyList->FullAddress;?>
												<p><?php echo $propertyList->BuildingAreaTotal.' '.$propertyList->BuildingAreaUnits?></p>
											</div>
											<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower(str_replace(' ','-',$propertyList->City)).'/'.strtolower($propertyList->FriendlyUrl);?>" class="LF-btn LF-btn-link">View Details</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					else:
						?>
						<div class="LF-col-md-<?= $col?> LF-col-sm-6 LF-col-xs-12">
							<div class="LF-listing-details LF-gridview">
								<div class="LF-header">
									<span class="LF-heading-link"><?php echo '#'.$propertyList->OriginatingSystemKey?></span>
								</div>
								<div class="LF-image">
									<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower(str_replace(' ','-',$propertyList->City)).'/'.strtolower($propertyList->FriendlyUrl);?>">
										<img src="<?php echo getLFImageProxy($propertyList->ListingThumb);?>" alt="">
									</a>
								</div>
								<div class="LF-details">
									<a href="<?php echo home_url($pageSlug).'/'.$propertyList->ListingKey.'/'.strtolower(str_replace(' ','-',$propertyList->City)).'/'.strtolower($propertyList->FriendlyUrl);?>" class="LF-btn LF-btn-link">View Details</a>
									<div class="LF-price"><?php echo '$'.$propertyList->ListPriceFormatted;?></div>
									<div class="LF-address">
										<?php echo $propertyList->FullAddress;?>
										<p><?php echo $propertyList->BuildingAreaTotal.' '.$propertyList->BuildingAreaUnits?></p>
									</div>
								</div>
							</div>
						</div>
						<?php
					endif;
				endforeach;
				if(!empty($style) and $style == 'horizontal'){
					echo '</div>';
				}
				echo '<div class="clear"></div>';
				echo '<div class="LF-col-md-7">';
				if((empty($pagination) || $pagination == 'yes') and $style != 'horizontal'){
					echo $html;
				}
				echo '</div>';
				if((empty($priceorder) && LF_get_settings('LF_show_priceOrder')=='yes') || ( !empty($priceorder) && $priceorder!='no')){
					echo '<div class="LF-col-md-5">
						<div class="LF-sortblock" data-index="'.$index.'">
						<label>Order by price: </lable>
						Low <input type="radio" class="LF-Bsort" name="LF-Bsort" value="ASC" id="Basc-'.$index.'" '.$ascchecked.'>
						High <input type="radio" class="LF-Bsort" name="LF-Bsort" value="DESC" id="Bdesc-'.$index.'" '.$descchecked.'>
						</div>
						</div>';
                               	
				}
			}
			else{
				echo '<div class="LF-col-md-12"><p>Sorry, your search did not return any results. Please try again with different search parameters.</p></div>';
			}
			// }
			?>
		</div>
		<div class="LF-disclaimer"><?php echo LF_get_settings('LF_detail_footer');?></div>
		<?php
	}
}

/**
* this function gives detail of perticular db.
*/
function getLFListingsDetails($listkey){
	$token = getToken();

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => API_URL."/properties?token=".$token."&listkey=".$listkey,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		$result = $err;
	} else {

		$result = json_decode($response);
	}
	return $result;
}

/**
* this function returns the image url with perticular height and width.
*/
function getLFImageProxy($url){
	$curl = curl_init();
	$imageWidth = LF_get_settings('LF_imageWidth');
	$imageHeight = LF_get_settings('LF_imageHeight');
	if(!empty($imageWidth) and !empty($imageHeight)){
		return $url."&w=".$imageWidth."&h=".$imageHeight;
	}
	else{
		return $url;
	}
}

?>
