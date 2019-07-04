<?php
add_action('admin_menu','LF_create_admin_main_menu');

/**
* this function creates entries (Menu and submenu) in wordpress admin section
*/
function LF_create_admin_main_menu()
{
	add_menu_page(__('LF Listings'),__('LF Listings'),'manage_options','LF-setting','LF_settings_view_creator','dashicons-editor-ul',50);
	
	add_submenu_page( 'LF-setting', __('LF Settings'), __('LF Settings'), 'manage_options', 'LF-setting', 'LF_settings_view_creator');

	add_submenu_page( 'LF-setting', __('LF Listings Tags'), __('LF Listings Tags'), 'manage_options', 'LF-listings', 'LF_main_menu_view_creator');
}


/**
* this function renders the setting page view.
*/
function LF_settings_view_creator()
{
	echo '<div class="LF-header">
	<img src="'.plugins_url('assets/images/LF-Listings-logo-sm.png',__FILE__).'" alt="" width="250">
	</div>';
	echo '<div class="wrap">';
	echo '<h1 class="wp-heading-inline">'.get_admin_page_title().'</h1>';
	?>
	<div class="LF-tabSection">
		<div class="LF-tab-link">
			<button class="LF-tablink LF-active" data-id="account_info">Account Info</button>
			<button class="LF-tablink" data-id="listings">Listings Config.</button>
			<button class="LF-tablink" data-id="Integrations">Integrations</button>
			<button class="LF-tablink" data-id="custom_css">Custom CSS</button>
		</div>
		<div class="LF-clear"></div>
		<div class="LF-tab-content">
			<div id="account_info" class="LF-tabcontent LF-fade">
				<div class="LF-msg-account"></div>
				<form method="post" name="LF-general-form" id="LF-general-form">
					<div class="LF-form-width">
						<div class="LF-form-group">
							<label for="LF_user_name">User Name: </label>
							<input type="text" name="LF_user_name" class="LF-form-control" id="LF_user_name" value="<?php echo LF_get_settings('user_name');?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_password">Password: </label>
							<input type="password" name="LF_password" class="LF-form-control" id="LF_password" value="<?php echo LF_get_settings('password')?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_email">To Email: </label>
							<input type="Email" name="LF_email" id="LF_email" class="LF-form-control" value="<?php echo LF_get_settings('email')?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_fromemail">From Email: </label>
							<input type="Email" name="LF_fromemail" id="LF_fromemail" class="LF-form-control" value="<?php echo LF_get_settings('fromEmail')?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_Office_id">Office Id: </label>
							<input type="text" name="LF_Office_id" id="LF_Office_id" class="LF-form-control" value="<?php echo LF_get_settings('office_id')?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_agent_id">Agent Id: </label>
							<input type="text" name="LF_agent_id" id="LF_agent_id" class="LF-form-control" value="<?php echo LF_get_settings('agent_id')?>">
						</div>
					</div>
					<input type="button" name="submit" id="LF-save-general-setting" class="button button-primary" value="Save">
				</form>
			</div>

			<div id="listings" class="LF-tabcontent">
				<div class="LF-msg-listing"></div>
				<div class="LF-form-width">
					<form method="post" name="LF-listing-form" id="LF-listing-form">
						<div class="LF-form-group">
							<label for="LF_show_search">Homepage Listings category:</label>
							<?php
							$args         = array(
								'post_type'   => 'page',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'order'=>'ASC'
							);
							$shortcode = 'LF-Listings';
							$query_result = new WP_Query($args);
							
							?>
							<select name="homepageSlug" id="homepageSlug" class="LF-form-control">
								<?php
								if(count($query_result->posts) == 0)
									echo '<option value="">No page with LF-Listings tag. Please create one for more options.</option>';
								foreach ($query_result->posts as $post) {
									if(LF_get_settings('LF_homepageSlug') == $post->post_name){
										$selected = "selected";
									}
									else{
										$selected = '';
									}
									if (false !== strpos($post->post_content, $shortcode)) {
										echo '<option value="'.$post->post_name.'" '.$selected.'>'.$post->post_title.'</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="LF-form-group">
							<label for="LF_show_search">Show Search Panel:</label>
							<select name="LF_show_search" id="LF_show_search" class="LF-form-control">
								<option value="yes" <?php if(LF_get_settings('LF_show_search')=='yes'){ echo "selected";}?>>Yes</option>
								<option value="no" <?php if(LF_get_settings('LF_show_search')=='no'){ echo "selected";}?>>No</option>
							</select>
						</div>
						<div class="LF-form-group">
							<?php $LF_cities = getCities();?>
							<?php
							$DBLF_Municipalities = explode(',',LF_get_settings('LF_Municipalities'));
							?>
							<label for="LF_Municipalities">Municipalities:</label>
							<select name="LF_Municipalities[]" multiple="multiple" id="LF_Municipalities" class="LF-form-control">
							
								<?php
								foreach($LF_cities->results->cities as $LF_city){
									if(in_array($LF_city,$DBLF_Municipalities)){
										$select = 'selected';
									}
									else{
										$select = '';
									}
									echo '<option value="'.$LF_city.'" '.$select.'>'.$LF_city.'</option>';
								}
								?>
							</select>
						</div>
						<div class="LF-form-group">
							<label for="LF_column">No of column: </label>
							<select name="LF_column" id="LF_column" class="LF-form-control">
								<?php for($i=0;$i<=4;$i++):?>
									<?php
									if(!empty(LF_get_settings('LF_column')) and LF_get_settings('LF_column')==$i)
									{
										$select='selected';
									}
									else{
										if($i==3){
											$select='selected';
										}
										else{
											$select='';
										}
									}
									?>
									<option value="<?= $i?>" <?= $select;?>><?= $i;?></option>
								<?php endfor;?>
							</select>
						</div>
						<div class="LF-form-group">
							<label for="LF_page">List per page: </label>
							<input type="number" name="LF_page" id="LF_page" onkeypress="return event.charCode != 45" min=0 max=48 class="LF-form-control" value="<?= empty(LF_get_settings('LF_page'))?12:LF_get_settings('LF_page');?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_show_priceOrder">Show Price Order:</label>
							<select name="LF_show_priceOrder" id="LF_show_priceOrder" class="LF-form-control">
								<option value="yes" <?php if(LF_get_settings('LF_show_priceOrder')=='yes'){ echo "selected";}?>>Yes</option>
								<option value="no" <?php if(LF_get_settings('LF_show_priceOrder')=='no'){ echo "selected";}?>>No</option>
							</select>
						</div>
						<div class="LF-form-group">
							<label for="LF_show_search">Default Price order: </label>
							<select name="LF_priceOrder" id="LF_priceOrder" class="LF-form-control">
								<option value="ASC" <?php if(LF_get_settings('LF_priceOrder')=='ASC'){ echo "selected";}?>>Low</option>
								<option value="DESC" <?php if(LF_get_settings('LF_priceOrder')=='DESC'){ echo "selected";}?>>High</option>
							</select>
						</div>
						<div class="LF-form-group">
							<label for="LF_mapApi">Image Width (in pixel): </label>
							<input type="number" min=0 onkeypress="return event.charCode != 45" name="LF_imageWidth" id="LF_imageWidth" class="LF-form-control" value="<?php echo !empty(LF_get_settings('LF_imageWidth'))? LF_get_settings('LF_imageWidth'):'';?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_mapApi">Image Height (in pixel): </label>
							<input type="number" min=0 onkeypress="return event.charCode != 45" name="LF_imageHeight" id="LF_imageHeight" class="LF-form-control" value="<?php echo !empty(LF_get_settings('LF_imageHeight'))? LF_get_settings('LF_imageHeight'):'';?>">
						</div>
						<div class="LF-form-group">
							<label for="LF_detail_footer">Inquiry Mail text: </label>
							<textarea name="LF_MailText" id="LF_MailText" cols="30" rows="5" class="LF-form-control"><?php echo !empty(LF_get_settings('LF_MailText'))? LF_get_settings('LF_MailText'):'';?></textarea>
						</div>
						<div class="LF-form-group">
							<label for="LF_detail_footer">Property Footer: </label>
							<textarea name="LF_detail_footer" id="LF_detail_footer" cols="30" rows="5" class="LF-form-control"><?php echo !empty(LF_get_settings('LF_detail_footer'))? LF_get_settings('LF_detail_footer'):'';?></textarea>
						</div>
						<div class="LF-form-group">
							<label for="">Terms of use popup: </label>
							<?php
							$term = stripslashes_deep(LF_get_settings('termsandcondition'));
							if(!empty($term)){
								$content = $term;
							}
							else{
								$content = '';
							}
							$editor_id = 'termsandcondition';
							wp_editor( $content, $editor_id);
							?>
						</div>
						<br>
						<div class="LF-form-group">
							<input type="button" name="submit" id="LF-save-listing-setting" class="button button-primary" value="Save">
						</div>
					</form>
				</div>
			</div>
			
			<div id="Integrations" class="LF-tabcontent">
				<div class="LF-msg-integration"></div>
				<div class="LF-form-width">
					<form method="post" name="LF-integration-form" id="LF-integration-form">
						<div class="LF-form-group">
							<label for="LF_mapApi">Google Map API Key: </label>
							<input type="text" name="LF_mapApi" id="LF_mapApi" class="LF-form-control" value="<?php echo !empty(LF_get_settings('LF_mapApiKey'))? LF_get_settings('LF_mapApiKey'):'';?>">
						</div>
						<div class="LF-form-group">
							<input type="checkbox" name="LF_turn_off_map" value="1" id="LF_mapApi" <?php if(!empty(LF_get_settings('LF_turn_off_map')) && LF_get_settings('LF_turn_off_map') == 1 ){ echo "checked"; } ?>><label for="LF_mapApi" id="new_label">Turn off map display: </label>
						</div>
						<div class="LF-form-group">
							<label for="LF_reCaptchastate">Google reCAPTCHA Type: </label><br>
							<input type="radio" name="LF_reCaptchastate" value="yes" <?php if(LF_get_settings('LF_reCaptchastate')=='yes'){ echo 'checked';}?>> "i'm not a robot" Checkbox
							<br>
							<input type="radio" name="LF_reCaptchastate" value="no" <?php if(LF_get_settings('LF_reCaptchastate')=='no'){ echo 'checked';}?>> Invisible reCAPTCHA badge
							<br>
							<input type="radio" name="LF_reCaptchastate" value="no-captch" <?php if(LF_get_settings('LF_reCaptchastate')=='no-captch'){ echo 'checked';}?>> No reCAPTCHA
						</div>
						<div class="LF-form-group">
							<label for="LF_reCaptcha">Google reCAPTCHA v2 Site Key: </label>
							<input type="text" name="LF_reCaptcha" id="LF_reCaptcha" class="LF-form-control" value="<?php echo !empty(LF_get_settings('LF_reCaptcha'))? LF_get_settings('LF_reCaptcha'):'';?>">
						</div>
						<br>
						<div class="LF-form-group">
							<input type="button" name="submit" id="LF-save-integration-setting" class="button button-primary" value="Save">
						</div>
					</form>
				</div>
			</div>

			<div id="custom_css" class="LF-tabcontent LF-fade" style="display: none;">
				<div class="LF-msg-custom"></div>
				<form method="post" name="LF-listingDetails-form" id="LF-listingDetails-form">
					<?php
					$stylesheet = plugin_dir_path( __FILE__ ).'assets/css/style.css';
					?>
					<div class="LF-form-group">
						<label for="LF_customCss">Custom CSS: </label>
						<textarea name="LF_customCss" id="LF_customCss" class="LF-form-control"><?php echo stripslashes_deep(LF_get_settings('customCss'));//stripslashes_deep(file_get_contents($stylesheet));?></textarea>
					</div>
					<input type="button" name="submit" id="LF-save-listingDetails-setting" class="button button-primary" value="Save">
				</form>
			</div>
		</div>
	</div>
	<?php
	echo '</div>';
}

add_action('admin_enqueue_scripts', 'LF_admin_css');

/**
* this function loads up the necessary css for admin view.
*/
function LF_admin_css()
{
	if(isset($_GET['page']) && ($_GET['page']=='LF-setting' || $_GET['page']=='LF-listings')){
		wp_register_style('LF_stylesheet',plugins_url('assets/css/style.css',__FILE__));
		wp_enqueue_style('LF_stylesheet');
		wp_register_style('LF_adminstyle',plugins_url('assets/css/admin-style.css',__FILE__));
		wp_enqueue_style('LF_adminstyle');
		wp_register_style('LF_codeeditor',plugins_url('assets/css/codemirror.css',__FILE__));
		wp_enqueue_style('LF_codeeditor');
		wp_register_style('bootstrap-multiselect',plugins_url('assets/css/bootstrap-multiselect.css',__FILE__));
		wp_enqueue_style('bootstrap-multiselect');
		wp_register_style('bootstrap.min',plugins_url('assets/css/bootstrap.min.css',__FILE__));
		wp_enqueue_style('bootstrap.min');
	}
}

/**
* this function loads up the necessary JS for admin footer.
*/
add_action('admin_footer','LF_admin_js');

function LF_admin_js()
{
	wp_enqueue_script( 'bootstrap.min.js', plugins_url('assets/js/bootstrap.min.js',__FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'bootstrap-multiselect.js', plugins_url('assets/js/bootstrap-multiselect.js',__FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'codemirror.js', plugins_url('assets/js/codemirror.js',__FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'xml.js', plugins_url('assets/js/xml.js',__FILE__), array('jquery'), '1.0.0', true );
	$token = wp_create_nonce("savepluginData");
	?>
	<script>
	//Write code to manage listing per page count
	jQuery("#LF_page").on('mouseout mouseenter keyup',function(){ 
		//alert("tet");
		if(jQuery(this).val()>48){
			jQuery(this).val("");
			jQuery(this).val(48);
			alert("Max Value should be 48");
		}
	});
		jQuery(document).on('click','.LF-tablink',function(){
			jQuery('.LF-tablink').removeClass('LF-active');
			jQuery(this).addClass('LF-active');
			var activePan = jQuery(this).attr('data-id');
			jQuery('.LF-tabcontent').removeClass('LF-fade');
			jQuery('#'+activePan).addClass('LF-fade');
		});

	//multiple select box for municipalities
	jQuery(document).ready(function($){
		jQuery('#LF_Municipalities').multiselect({
			buttonText: function(options, select) {
				console.log(select[0].length);
				if (options.length === 0) {
					return 'None selected';
				}
				if (options.length === select[0].length) {
					return 'All selected ('+select[0].length+')';
				}
				else if (options.length >= 4) {
					return options.length + ' selected';
				}
				else {
					var labels = [];
					options.each(function() {
						labels.push(jQuery(this).val());
					});
					return labels.join(', ') + '';
				}
			}

		});
	
		<?php if(isset($_GET['page']) and $_GET['page'] == 'LF-setting'){?>
			var codeEditor = CodeMirror.fromTextArea(document.getElementById("LF_customCss"), {
				lineNumbers: true,
				mode: "text/html",
				matchBrackets: true,
				indentWithTabs: true,
				lineWrapping: true
			});
			function updateTextArea() {
				codeEditor.save();
			}
			codeEditor.on('change', updateTextArea);
			$('button.LF-tablink').click(function(){
				$('#custom_css').hide();
			});
			$('button[data-id="custom_css"]').click(function(){ 
				$('#custom_css').show();
				codeEditor.refresh();
			});
		<?php }?>
		$(document).on('click','#LF-save-listing-setting',function(){
			var form = $('#LF-listing-form').serialize();
			var token = '<?php echo $token; ?>';
			var termsandcondition = tinymce.activeEditor.getContent();
			$.ajax({
				method: 'POST',
				url:ajaxurl,
				data:'action=LF_save_listing_config_data&token='+token+'&'+form+'&termsandcondition='+termsandcondition,
				success: function(data){
					$('html, body').animate({
						scrollTop: $('body').offset().top - 20
					}, 'slow');
					if($.trim(data)=='1'){

						$('.LF-msg-listing').html('<div class="notice notice-success is-dismissible"><p>Data saved successfully.</p></div>');
					}
					else{
						$('.LF-msg-listing').html('<div class="notice notice-error is-dismissible"><p>Please try again...</p></div>');
					}
				}
			});
		});

		$(document).on('click','#LF-save-general-setting',function(){
			var form = $('#LF-general-form').serialize();
			var token = '<?php echo $token; ?>';
			$.ajax({
				method: 'POST',
				url:ajaxurl,
				data:'action=LF_save_account_info_data&token='+token+'&'+form,
				success: function(data){
					$('html, body').animate({
						scrollTop: $('body').offset().top - 20
					}, 'slow');
					if($.trim(data)=='1'){

						$('.LF-msg-account').html('<div class="notice notice-success is-dismissible"><p>Data saved successfully.</p></div>');
					}
					else{
						$('.LF-msg-account').html('<div class="notice notice-error is-dismissible"><p>Please try again...</p></div>');
					}
				}
			});
		});

		$(document).on('click','#LF-save-integration-setting',function(){
			var form = $('#LF-integration-form').serialize();
			var token = '<?php echo $token; ?>';
			$.ajax({
				method: 'POST',
				url:ajaxurl,
				data:'action=LF_save_integration_data&token='+token+'&'+form,
				success: function(data){
					$('html, body').animate({
						scrollTop: $('body').offset().top - 20
					}, 'slow');
					if($.trim(data)=='1'){
						$('.LF-msg-integration').html('<div class="notice notice-success is-dismissible"><p>Data saved successfully.</p></div>');
					}
					else{
						$('.LF-msg-integration').html('<div class="notice notice-error is-dismissible"><p>Please try again...</p></div>');
					}
				}
			});
		});

		$(document).on('click','#LF-save-listingDetails-setting',function(){
			var form = $('#LF-listingDetails-form').serialize();
			var token = '<?php echo $token; ?>';
			$.ajax({
				method: 'POST',
				url:ajaxurl,
				data:'action=LF_save_custom_css_data&token='+token+'&'+form,
				success: function(data){
					$('html, body').animate({
						scrollTop: $('body').offset().top - 20
					}, 'slow');
					if($.trim(data)=='1'){
						$('.LF-msg-custom').html('<div class="notice notice-success is-dismissible"><p>Data saved successfully.</p></div>');
					}
					else{
						$('.LF-msg-custom').html('<div class="notice notice-error is-dismissible"><p>Please try again...</p></div>');
					}
				}
			});
		});

	});
</script>
<?php
}

add_action( 'wp_ajax_LF_save_account_info_data', 'LF_save_account_info_data' );

	/**
	* this function saves the data of account info section to the database.
	*/
	function LF_save_account_info_data()
	{
		check_ajax_referer( 'savepluginData', 'token' );

		$user_name = sanitize_text_field($_POST['LF_user_name']);
		$password = sanitize_text_field($_POST['LF_password']);
		$email = sanitize_text_field($_POST['LF_email']);
		$fromEmail = sanitize_text_field($_POST['LF_fromemail']);
		$office_id = sanitize_text_field($_POST['LF_Office_id']);
		$agent_id = sanitize_text_field($_POST['LF_agent_id']);

		if(isset($user_name) and $user_name!=''){
			LF_add_settings('user_name',$user_name);
		}

		if(isset($password) and $password!=''){
			LF_add_settings('password',$password);
		}

		if(isset($email) and $email != ''){
			LF_add_settings('email',$email);
		}

		if(isset($fromEmail)){
			LF_add_settings('fromEmail',$fromEmail);
		}
		if(isset($office_id) and $office_id!=''){
			LF_add_settings('office_id',$office_id);
		}

		if(isset($agent_id) and $agent_id!=''){
			LF_add_settings('agent_id',$agent_id);
		}

		echo '1';
		die();
	}


	add_action('wp_ajax_LF_save_listing_config_data','LF_save_listing_config_data');

	/**
	* this function saves the data of Listing config section to the database.
	*/
	function LF_save_listing_config_data()
	{
		check_ajax_referer( 'savepluginData', 'token' );
		$homepageSlug = sanitize_text_field($_POST['homepageSlug']);
		$LF_show_search = sanitize_text_field($_POST['LF_show_search']);
		$LF_column = sanitize_text_field($_POST['LF_column']);
		$LF_page = sanitize_text_field($_POST['LF_page']);
		$LF_show_priceOrder = sanitize_text_field($_POST['LF_show_priceOrder']);
		$LF_priceOrder = sanitize_text_field($_POST['LF_priceOrder']);
		$imageWidth = sanitize_text_field($_POST['LF_imageWidth']);
		$imageHeight = sanitize_text_field($_POST['LF_imageHeight']);
		$LF_Municipalities = implode(',',$_POST['LF_Municipalities']);
		$LF_detail_footer = $_POST['LF_detail_footer'];
		$LF_MailText = $_POST['LF_MailText'];
		$termsandcondition = $_POST['termsandcondition'];

		if(isset($homepageSlug)){
			LF_add_settings('LF_homepageSlug',$homepageSlug);
		}
		if(isset($LF_show_search) and $LF_show_search!=''){
			LF_add_settings('LF_show_search',$LF_show_search);
		}
		if(isset($LF_Municipalities)){
			LF_add_settings('LF_Municipalities',$LF_Municipalities);
		}
		if(isset($LF_column) and $LF_column!=''){
			LF_add_settings('LF_column',$LF_column);
		}
		if(isset($LF_page) and $LF_page!=''){
			if($LF_page>48){
				$LF_page=48;
			}
			LF_add_settings('LF_page',$LF_page);
		}
		if(isset($LF_show_priceOrder)){
			LF_add_settings('LF_show_priceOrder',$LF_show_priceOrder);
		}
		if(isset($LF_priceOrder)){
			LF_add_settings('LF_priceOrder',$LF_priceOrder);
		}
		if(isset($imageWidth)){
			LF_add_settings('LF_imageWidth', $imageWidth);
		}
		if(isset($imageHeight)){
			LF_add_settings('LF_imageHeight', $imageHeight);
		}
		if(isset($LF_detail_footer)){
			LF_add_settings('LF_detail_footer', $LF_detail_footer);
		}
		if(isset($LF_MailText)){
			LF_add_settings('LF_MailText', $LF_MailText);
		}
		if(isset($termsandcondition)){
			LF_add_settings('termsandcondition',$termsandcondition);
		}
		echo 1;
		die();
	}


	add_action('wp_ajax_LF_save_custom_css_data','LF_save_custom_css_data');

	/**
	* this function saves the data of Integrations section to the database.
	*/
	function LF_save_integration_data(){
		check_ajax_referer( 'savepluginData', 'token' );

		$mapApi = sanitize_text_field($_POST['LF_mapApi']);
		$LF_reCaptcha = sanitize_text_field($_POST['LF_reCaptcha']);
		$LF_reCaptchastate = sanitize_text_field($_POST['LF_reCaptchastate']);
		$LF_turn_off_map = sanitize_text_field($_POST['LF_turn_off_map']);
		if(isset($mapApi)){
			LF_add_settings('LF_mapApiKey',$mapApi);
		}
		if(isset($LF_reCaptchastate)){
			LF_add_settings('LF_reCaptchastate',$LF_reCaptchastate);			
		}
		if(isset($LF_reCaptcha)){
			LF_add_settings('LF_reCaptcha',$LF_reCaptcha);
		}
		if(isset($LF_turn_off_map)){
			LF_add_settings('LF_turn_off_map',$LF_turn_off_map);
		}
		echo 1;
		die();
	}
	add_action('wp_ajax_LF_save_integration_data','LF_save_integration_data');

	/**
	* this function saves the data of Custom css section to the database.
	*/
	function LF_save_custom_css_data(){
		check_ajax_referer( 'savepluginData', 'token' );
		$customCss = $_POST['LF_customCss'];
		LF_add_settings('customCss',$customCss);
		$stylesheet = plugin_dir_path( __FILE__ ).'assets/css/style.css';
		file_put_contents($stylesheet, stripslashes_deep($customCss));
		echo 1;
		die();
	}

	add_action('wp_enqueue_scripts', 'LF_front_css');

	function LF_front_css()
	{
		$page_id = get_the_ID();
		$option_id_array = get_option('LF-Listings');

		if (in_array($page_id, $option_id_array))
		{
			wp_register_style('LF_stylesheet',plugins_url('assets/css/style.css',__FILE__));
			wp_enqueue_style('LF_stylesheet');
			wp_enqueue_style('slick.css',plugins_url('assets/css/slick.css',__FILE__));
			wp_enqueue_style('slick-theme.css',plugins_url('assets/css/slick-theme.css',__FILE__));
			wp_enqueue_style('jquery.fancybox.css',plugins_url('assets/css/jquery.fancybox.css',__FILE__));
			wp_enqueue_style('flickity.min.css',plugins_url('assets/css/flickity.min.css',__FILE__));
			wp_enqueue_style('select2.min.css',plugins_url('assets/css/select2.min.css',__FILE__));

			?>

			<style type="text/css">
				select[name="LF_bedroom"]{
					background-image: url('<?php echo plugins_url('assets/images/bed.png',__FILE__)?>');
					background-repeat: no-repeat;
					background-position: 90% center;
				}
				select[name="LF_bathroom"]{
					background-image: url('<?php echo plugins_url('assets/images/bath.png',__FILE__)?>');
					background-repeat: no-repeat;
					background-position: 90% center;
				}
			</style>
			<?php
		}
		else{
			?>
			<style type="text/css">
				#Modal{
					display: none !important;
				}
			</style>
			<?php
		}
	}

	add_action('wp_footer','LF_front_js');
	function LF_front_js(){
		$page_id = get_the_ID();
		$option_id_array = get_option('LF-Listings');

		if (in_array($page_id, $option_id_array)) {
			?>
			<?php
			wp_enqueue_script( 'LF_customJs', plugins_url('assets/js/custom.js',__FILE__), array('jquery'), '1.0.0', true );
			wp_localize_script( 'LF_customJs', 'LF_custom', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'my-special-string' )
			));
			wp_enqueue_script( 'jquery.fancybox.pack.js', plugins_url('assets/js/jquery.fancybox.pack.js',__FILE__), array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'jquery.fancybox.thumbs.js', plugins_url('assets/js/jquery.fancybox-thumbs.js',__FILE__), array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'slick.min.js', plugins_url('assets/js/slick.min.js',__FILE__), array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'flickity.pkgd.min.js', plugins_url('assets/js/flickity.pkgd.min.js',__FILE__), array('jquery'), '1.0.0', true );
			wp_enqueue_script( 'select2.min.js', plugins_url('assets/js/select2.min.js',__FILE__), array('jquery'), '1.0.0', true );
			
			?>
			<script src="https://www.google.com/recaptcha/api.js" async defer></script>
			<script type="text/javascript">
				var noofcol = jQuery('#noofcol').val();
				if(noofcol>4){
					noofcol = 4;
				}
				jQuery(document).ready(function() {
					jQuery('.fancybox-thumbs').fancybox({
						prevEffect : 'none',
						nextEffect : 'none',

						closeBtn  : true,
						arrows    : true,
						nextClick : true,

						helpers : {
							thumbs : {
								width  : 50,
								height : 50
							}
						}
					});

					jQuery('.slider-single').slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false,
						fade: false,
						adaptiveHeight: true,
						infinite: false,
						useTransform: true,
						speed: 400,
						focusOnSelect: true,
						cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
					});

					jQuery('.slider-nav').on('init', function(event, slick) {
						jQuery('.slider-nav .slick-slide.slick-current').addClass('is-active');
					})
					.slick({
						slidesToShow: 5,
						slidesToScroll: 3,
						dots: false,
						focusOnSelect: true,
						infinite: true,
						responsive: [{
							breakpoint: 1024,
							settings: {
								slidesToShow: 4,
								slidesToScroll: 4,
							}
						}, {
							breakpoint: 640,
							settings: {
								slidesToShow: 3,
								slidesToScroll: 3,
							}
						}, {
							breakpoint: 420,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 2,
							}
						}]
					});

					jQuery('.horizantal-slide').flickity({
				  // options
				  cellAlign: 'left',
				  contain: true,
				  pageDots: false
				});
				/*jQuery('.horizantal-slide').slick({
					dots: false,
					infinite: true,
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
				});*/

				jQuery('.slider-single').on('afterChange', function(event, slick, currentSlide) {
					jQuery('.slider-nav').slick('slickGoTo', currentSlide);
					var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
					jQuery('.slider-nav .slick-slide.is-active').removeClass('is-active');
					jQuery(currrentNavSlideElem).addClass('is-active');
				});

				jQuery('.slider-nav').on('click', '.slick-slide', function(event) {
					event.preventDefault();
					var goToSingleSlide = jQuery(this).data('slick-index');

					jQuery('.slider-single').slick('slickGoTo', goToSingleSlide);
				});
				
			 
			});
            
		</script>
		<?php if(!empty(LF_get_settings('LF_mapApiKey'))):?>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo LF_get_settings('LF_mapApiKey');?>&callback&callback=initMap"></script>
		<?php endif;?>
		<script type="text/javascript">
			// Get the modal
			var modal = document.getElementById('myModal');

			// Get the button that opens the modal
			var btn = document.getElementById("myBtn");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks the button, open the modal
			btn.onclick = function() {
				modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
		</script>
		<?php
	}
}

function LF_find_shortcode_occurences($shortcode, $post_type = 'page')
{
	$found_ids = array();
	$args         = array(
		'post_type'   => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);
	$query_result = new WP_Query($args);
	foreach ($query_result->posts as $post) {
		if (false !== strpos($post->post_content, $shortcode)) {
			$found_ids[] = $post->ID;
		}
	}
	return $found_ids;
}

function LF_find_shortcode_occurencesName($shortcode, $post_type = 'page')
{
	$found_content = array();
	$args         = array(
		'post_type'   => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'order'=>'ASC'
	);
	$query_result = new WP_Query($args);
	// print_r($query_result);
	foreach ($query_result->posts as $post) {
		if (false !== strpos($post->post_content, $shortcode)) {
			$found_content['content'] = $post->post_content;
			$found_content['slug'] = $post->post_name;
			$found_content['title'] = $post->post_title;
		}
	}
	return $found_content;
}

function getCurrentPageSlug()
{
	$slugs = explode('/',$_SERVER['REQUEST_URI']);
	$slugs = array_filter($slugs, function($value) { return $value !== ''; });
	$slug = $slugs[1];
	return $slug;
}

function LF_save_option_shortcode_post_id_array( $post_id )
{
	if ( wp_is_post_revision( $post_id ) OR 'page' != get_post_type( $post_id )) {
		return;
	}
	$option_name = 'LF-Listings';
	$id_array = LF_find_shortcode_occurences($option_name);
	$autoload = 'yes';
	if (false == add_option($option_name, $id_array, '', $autoload)) update_option($option_name, $id_array);
}

add_action('save_post', 'LF_save_option_shortcode_post_id_array' );
?>
