<?php

function fbLoggedIn() {
	global $facebook;
	return ($facebook->getSession()) ? true : false;
}

function fbIsFan() {
	global $facebook;
	$signed_request = $facebook->getSignedRequest();
	return ($signed_request['page']['liked']) ? true : false;
}

function fbTabData() {
	global $facebook;
	$signed_request = $facebook->getSignedRequest();
	return $signed_request['app_data'];
}

function fbIsDevPage() {
	global $facebook;
	$signed_request = $facebook->getSignedRequest();
	return ($signed_request['page']['id'] == FB_DEV_PAGE_ID) ? true : false;
}