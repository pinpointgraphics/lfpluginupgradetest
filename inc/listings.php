<?php
add_action( 'wp_ajax_LF_pagination', 'LF_pagination' );
add_action( 'wp_ajax_nopriv_LF_pagination', 'LF_pagination' );

function LF_pagination(){
	check_ajax_referer( 'my-special-string', 'token' );
// print_r($_POST);
// exit();
	$page = sanitize_text_field($_POST['page']);
	$mainSearch = sanitize_text_field($_POST['mainSearch']);
	$municipality = sanitize_text_field($_POST['LF_municipalities']);
	$sale = sanitize_text_field($_POST['sale']);
	$bedroom = sanitize_text_field($_POST['bedroom']);
	$bathroom = sanitize_text_field($_POST['bathroom']);
	$property_Type = sanitize_text_field($_POST['property_Type']);
	$priceFrom = sanitize_text_field($_POST['priceFrom']);
	$priceTo = sanitize_text_field($_POST['priceTo']);
	$waterFront = sanitize_text_field($_POST['waterFront']);
	$sort = sanitize_text_field($_POST['sort']);
	$agents = sanitize_text_field($_POST['agents']);
	$offices = sanitize_text_field($_POST['offices']);
	$openhouse = sanitize_text_field($_POST['openhouse']);
	$slug = sanitize_text_field($_POST['slug']);
	$search = sanitize_text_field($_POST['search']);
	$style = sanitize_text_field($_POST['style']);
	$ids = sanitize_text_field($_POST['ids']);
	$pagination = sanitize_text_field($_POST['pagination']);
	$priceorder = sanitize_text_field($_POST['priceorder']);
	$per_row = sanitize_text_field($_POST['per_row']);
	$index = sanitize_text_field($_POST['index']);
	$list_per_page = sanitize_text_field($_POST['list_per_page']);

	if(isset($list_per_page)){
		$list_per_page = $list_per_page;
	}
	else{
		$list_per_page = '';
	}
	if(isset($index)){
		$index = $index;
	}
	else{
		$index='';
	}
	if(isset($per_row)){
		$per_row = $per_row;
	}
	else{
		$per_row = '';
	}

	if(isset($pagination)){
		$pagination = $pagination;
	}
	else{
		$pagination = '';
	}

	if(isset($priceorder)){
		$priceorder = $priceorder;
	}
	else{
		$priceorder = '';
	}

	if(isset($style)){
		$style = $style;
	}
	else{
		$style = '';
	}

	if(isset($search)){
		$search = $search;
	}
	else{
		$search = '';
	}

	if(isset($ids)){
		$ids = $ids;
	}
	else{
		$ids='';
	}

	if(isset($openhouse)){
		$openhouse = $openhouse;
	}
	else{
		$openhouse = '';
	}

	if(isset($agents)){
		$agents = $agents;
	}
	else{
		$agents = '';
	}
	if(isset($offices)){
		$offices = $offices;
	}
	else{
		$offices = '';
	}
	if(isset($mainSearch))
	{
		$mainSearch = $mainSearch;
	}
	else{
		$mainSearch = '';
	}

	if(isset($municipality)){
		$municipality = $municipality;
	}
	else{
		$municipality = '';
	}
	if(isset($sale)){
		$sale=$sale;
	}
	else{
		$sale='';
	}

	if(isset($bedroom)){
		$bedroom = $bedroom;
	}
	else{
		$bedroom='';
	}

	if(isset($bathroom)){
		$bathroom= $bathroom;
	}
	else{
		$bathroom='';
	}

	if(isset($property_Type)){
		$property_Type=$property_Type;
	}
	else{
		$property_Type='';
	}

	if(isset($priceFrom)){
		$priceFrom = $priceFrom;
	}
	else{
		$priceFrom='';
	}

	if(isset($priceTo)){
		$priceTo=$priceTo;
	}
	else{
		$priceTo='';
	}

	if(isset($waterFront)){
		$waterFront = $waterFront;
	}
	else{
		$waterFront='';
	}

	getLFListings($page, $mainSearch, $municipality, $sale, $bedroom, $bathroom, $property_Type, $priceFrom, $priceTo, $waterFront, $sort, $offices, $agents, $openhouse, $slug, $search, $style, $ids, $pagination, $priceorder, $per_row,$index, $list_per_page);

	wp_die();
}

add_action( 'wp_ajax_LF_search', 'LF_search' );
add_action( 'wp_ajax_nopriv_LF_search', 'LF_search' );
function LF_search(){
	check_ajax_referer( 'my-special-string', 'token' );

	$mainSearch = sanitize_text_field($_POST['mainSearch']);
	$municipality = sanitize_text_field($_POST['LF_municipalities']);
	$sale = sanitize_text_field($_POST['sale']);
	$bedroom = sanitize_text_field($_POST['bedroom']);
	$bathroom = sanitize_text_field($_POST['bathroom']);
	$property_Type = sanitize_text_field($_POST['property_Type']);
	$priceFrom = sanitize_text_field($_POST['priceFrom']);
	$priceTo = sanitize_text_field($_POST['priceTo']);
	$waterFront = sanitize_text_field($_POST['waterFront']);
	$sort = sanitize_text_field($_POST['sort']);
	$agents = sanitize_text_field($_POST['agents']);
	$offices = sanitize_text_field($_POST['offices']);
	$openhouse = sanitize_text_field($_POST['openhouse']);
	$slug = sanitize_text_field($_POST['slug']);
	$search = sanitize_text_field($_POST['search']);
	$style = sanitize_text_field($_POST['style']);
	$ids = sanitize_text_field($_POST['ids']);
	$pagination = sanitize_text_field($_POST['pagination']);
	$priceorder = sanitize_text_field($_POST['priceorder']);
	$per_row = sanitize_text_field($_POST['per_row']);
	$index = sanitize_text_field($_POST['index']);
	$list_per_page = sanitize_text_field($_POST['list_per_page']);

	if(isset($list_per_page)){
		$list_per_page = $list_per_page;
	}
	else{
		$list_per_page = '';
	}

	if(isset($index)){
		$index = $index;
	}
	else{
		$index='';
	}

	if(isset($per_row)){
		$per_row = $per_row;
	}
	else{
		$per_row = '';
	}

	if(isset($pagination)){
		$pagination = $pagination;
	}
	else{
		$pagination = '';
	}

	if(isset($priceorder)){
		$priceorder = $priceorder;
	}
	else{
		$priceorder = '';
	}

	if(isset($style)){
		$style = $style;
	}
	else{
		$style = '';
	}
	if(isset($search)){
		$search = $search;
	}
	else{
		$search = '';
	}
	if(isset($ids)){
		$ids = $ids;
	}
	else{
		$ids='';
	}
	if(isset($openhouse)){
		$openhouse = $openhouse;
	}
	else{
		$openhouse = '';
	}
	if(isset($agents)){
		$agents = $agents;
	}
	else{
		$agents = '';
	}
	if(isset($offices)){
		$offices = $offices;
	}
	else{
		$offices = '';
	}
	if(isset($mainSearch))
	{
		$mainSearch = $mainSearch;
	}
	else{
		$mainSearch = '';
	}

	if(isset($municipality)){
		$municipality = $municipality;
	}
	else{
		$municipality = '';
	}

	if(isset($sale)){
		$sale=$sale;
	}
	else{
		$sale='';
	}

	if(isset($bedroom)){
		$bedroom = $bedroom;
	}
	else{
		$bedroom='';
	}

	if(isset($bathroom)){
		$bathroom= $bathroom;
	}
	else{
		$bathroom='';
	}

	if(isset($property_Type)){
		$property_Type=$property_Type;
	}
	else{
		$property_Type='';
	}

	if(isset($priceFrom)){
		$priceFrom = $priceFrom;
	}
	else{
		$priceFrom='';
	}

	if(isset($priceTo)){
		$priceTo=$priceTo;
	}
	else{
		$priceTo='';
	}

	if(isset($waterFront)){
		$waterFront = $waterFront;
	}
	else{
		$waterFront='';
	}

	getLFListings($page, $mainSearch, $municipality, $sale, $bedroom, $bathroom, $property_Type, $priceFrom, $priceTo, $waterFront, $sort, $offices, $agents, $openhouse, $slug, $search, $style, $ids, $pagination, $priceorder, $per_row,$index,$list_per_page);
	wp_die();
}


add_action( 'wp_ajax_LF_send_inquiryMail', 'LF_send_inquiryMail' );
add_action( 'wp_ajax_nopriv_LF_send_inquiryMail', 'LF_send_inquiryMail' );
/**
* this function sends inquiry emails.
*/
function LF_send_inquiryMail()
{
	check_ajax_referer( 'my-special-string', 'token' );
	$property = sanitize_text_field($_POST['txtSubject']);
	$name = sanitize_text_field($_POST['txtName']);
	$fromemail = LF_get_settings('fromEmail');
	$toemail = LF_get_settings('email');
	$email = sanitize_text_field($_POST['txtemail']);
	$subject = "Inquiry for ".$property;
	$txtMessage = sanitize_text_field($_POST['txtMessage']);
	$listingURL = sanitize_text_field($_POST['listingURL']);

	$msg = [];
	$flag = 0;

	if(empty(trim($name))){
		$msg['name'] = 'Name field is required.';
		$flag++;
	}
	else if(strlen($name)<2 || strlen($name)>20){
		$msg['name'] = 'Name should be 2 to 20 characters long.';
		$flag++;
	}
	else{
		$msg['name'] = '';
	}

	if(empty(trim($email))){
		$msg['email'] = 'Email field is required.';
		$flag++;
	}
	else if(!is_email($email)){
		$msg['email'] = 'This email is invalid.';
		$flag++;	
	}
	else{
		$msg['email'] = '';
	}

	if(empty(trim($txtMessage))){
		$msg['message'] = 'Message field is required.';
		$flag++;
	}
	else if(strlen($txtMessage)<2 || strlen($txtMessage)>140){
		$msg['message'] = 'Message should be 2 to 140 characters long.';
		$flag++;	
	}
	else{
		$msg['message'] = '';
	}

	if($flag==0){
		$message = '
		<div>'.LF_get_settings('LF_MailText').'</div>
		<table border="0">
		<tr>
			<td>Property: </td>
			<td>'.$property.'</td>
		</tr>
		<tr>
                        <td>Property URL: </td>
                        <td>'.$listingURL.'</td>
                </tr>
		<tr>
			<td>Name: </td>
			<td>'.stripslashes_deep($name).'</td>
		</tr>
		<tr>
			<td>Email: </td>
			<td>'.$email.'</td>
		</tr>
		<tr>
			<td>Message: </td>
			<td>'.stripslashes_deep($txtMessage).'</td>
		</tr>
		</table>
		';
		$headers[] = "From: $name <$fromemail>";
		$headers[] = "Content-type: text/html" ;
		
		$sent = wp_mail( $toemail, $subject, $message, $headers );
		if($sent)
		{
			echo json_encode(array('response'=>'1'));
		}
		else{
			echo json_encode(array('response'=>'0'));
		}
	}
	else{
		echo json_encode(array('response'=>'2','message'=>$msg));
	}
	die();
}

function LF_SessionStart(){
	check_ajax_referer( 'my-special-string', 'token' );
	$_SESSION['acceptTerms'] = $_SERVER['REMOTE_ADDR'];
	die();
}

add_action( 'wp_ajax_LF_SessionStart', 'LF_SessionStart' );
add_action( 'wp_ajax_nopriv_LF_SessionStart', 'LF_SessionStart' );
?>
