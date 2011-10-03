<?php

// Like Gate
//if( is_page('home') && !fbIsFan() ) changePage('like');

function changePage($page) {
	global $build, $meta;
	$build->page = $page;
	$meta['body_class'] = $page;
}

function meta_title(){
	global $meta;
	$meta['title'] = (isset($meta['title']) && !empty($meta['title'])) ? $meta['title'] . ' &raquo; ' : '';
	return $meta['title'] . SITE_TITLE;
}

function correctDateFormat($date, $format = 'MM/DD/YYYY') {
	switch($format) {
		
		case 'MM-DD-YYYY':
		case 'MM/DD/YYYY':
			list($m, $d, $y) = preg_split('/[-\.\/ ]/', $date);
			break;
		
	}
	return checkdate($m, $d, $y);
}

function alreadyEntered($email) {
	global $db;
	$email = $db->escape($email);
	$entered = $db->query_first("SELECT id FROM game_sweeps WHERE email = '$email'");
	if($entered) return true;
	else return false;
}

function submitForm() {
	global $db;
	header('Content-Type: text/plain');
	
	//form validation vars
	$formok = true;
	$errors = array();
	
	//form data
	$data['first_name'] = $_POST['first_name'];
	$data['last_name'] = $_POST['last_name'];
	$data['email'] = $_POST['email'];
	$data['phone'] = $_POST['phone'];
	$data['address_1'] = $_POST['address_1'];
	$data['address_2'] = $_POST['address_2'];
	$data['city'] = $_POST['city'];
	$data['state'] = $_POST['state'];
	$data['zip'] = $_POST['zip'];
	$data['dob'] = $_POST['dob'];
	if( isset($_POST['rules']) ){
		$data['rules'] = $_POST['rules'];
	} else {
		$data['rules'] = '';
	}
	
	//validate form data
	if( empty($data['first_name']) ){
		$formok = false;
		$errors['first_name'] = "You have not entered a first name";
	}
	if( empty($data['last_name']) ){
		$formok = false;
		$errors['last_name'] = "You have not entered a last name";
	}
	if( empty($data['email']) ){
		$formok = false;
		$errors['email'] = "You have not entered an email address";
	} elseif(empty($errors) && alreadyEntered($data['email'])) {
		$formok = false;
		$errors['email'] = 'You have already entered the promotion!';
	}
	if( empty($data['phone']) || !validatePhone($data['phone']) ){
		$formok = false;
		$errors['phone'] = "You must enter a valid phone number";
	}
	if( empty($data['address_1']) ){
		$formok = false;
		$errors['address_1'] = "You must enter an address";
	}
	if( empty($data['city']) ){
		$formok = false;
		$errors['city'] = "You must enter a city";
	}
	if( empty($data['state']) ){
		$formok = false;
		$errors['state'] = "Enter state";
	} elseif( !array_key_exists(strtoupper($data['state']), stateArray()) && !in_array(ucwords(strtolower($data['state'])), stateArray()) ){
		$formok = false;
		$errors['state'] = "Enter valid abbreviation";
	}
	if( empty($data['zip']) || !validate5DigitZip($data['zip']) ){
		$formok = false;
		$errors['zip'] = "You must enter a valid zip code";
	}
	if( empty($data['dob']) ){
		$formok = false;
		$errors['dob'] = "You must enter your date of birth";
	} elseif( getAge(date('Y-m-d', strtotime($data['dob']))) < 18 ){
		$formok = false;
		$errors['dob'] = "You must be 18 years or older to enter";
	}
	if( $data['rules'] == "" ){
		$formok = false;
		$errors['rules'] = "You must agree to the rules";
	}
	
	//format data for db
	$data['state'] = (strlen($data['state']) == 2) ? strtoupper($data['state']) : array_search(ucwords(strtolower($data['state'])), stateArray());
	$data['phone'] = removeNonAlphaNumerics($data['phone']);
	$data['dob'] = date('Y-m-d', strtotime($data['dob']));

	//what we need to return back to our ajax handler
	$returndata = array(
		'posted_form_data' => array(
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email' => $data['email'],
			'phone' => $data['phone'],
			'address_1' => $data['address_1'],
			'address_2' => $data['address_2'],
			'city' => $data['city'],
			'state' => $data['state'],
			'zip' => $data['zip'],
			'dob' => $data['dob']
		),
		'form_ok' => $formok,
		'errors' => $errors
	);

	//if no errors, submit to db
	if($formok == true) {
		$db->query_insert('game_sweeps', $returndata['posted_form_data']);
	}
	
	echo json_encode($returndata);
	exit();
}