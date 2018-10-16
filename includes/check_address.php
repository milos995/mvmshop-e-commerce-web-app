<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	$name = sanitize($_POST['full_name']);
	$email = sanitize($_POST['email']);
	$phone = sanitize($_POST['phone']);
	$street = sanitize($_POST['street']);
	$city = sanitize($_POST['city']);
	$zip_code = sanitize($_POST['zip_code']);
	$errors = array();
	$required = array(
		'full_name',
		'email',
		'phone',
		'street',
		'city',
		'zip_code',
	);

	foreach ($required as $f) {
		if(empty($_POST[$f]) || $_POST[$f] == ''){
			$errors[] = 'Sva polja su obavezna.';
			break;
		}
	}

	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$errors[] = 'E-mail nije validan.';
	}

	if(!empty($errors)){
		echo display_errors($errors);
	}else{
		echo "passed";
	}
?>