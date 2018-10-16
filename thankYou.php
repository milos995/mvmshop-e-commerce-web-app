<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	$full_name = sanitize($_POST['full_name']);
	$email = sanitize($_POST['email']);
	$phone = sanitize($_POST['phone']);
	$street = sanitize($_POST['street']);
	$city = sanitize($_POST['city']);
	$zip_code = sanitize($_POST['zip_code']);
	$sub_total = sanitize($_POST['sub_total']);
	$cart_id = sanitize($_POST['cart_id']);
	$description = sanitize($_POST['description']);

	// sredi proizvode
	$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$iresults = mysqli_fetch_assoc($itemQ);
	$items = json_decode($iresults['items'],true);
	foreach ($items as $item) {
		$newSizes = array();
		$item_id = $item['id'];
		$productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
		$product = mysqli_fetch_assoc($productQ);
		$sizes = sizesToArray($product['sizes']);
		foreach ($sizes as $size) {
			if($size['size'] == $item['size']){
				$q = $size['quantity'] - $item['quantity'];
				$newSizes[] = array('size' => $size['size'], 'quantity' => $q);
			}else{
				$newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity']);
			}
		}
		$sizeString = sizesToString($newSizes);
		$db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
	}

	// dodaj narudzbinu
	$db->query("UPDATE cart SET ordered = 1 WHERE id = '{$cart_id}'");
	$db->query("INSERT INTO orders (cart_id,full_name,email,phone,street,city,zip_code,sub_total,description) VALUES ('$cart_id', '$full_name','$email','$phone','$street','$city','$zip_code','$sub_total','$description')");
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
	setcookie(CART_COOKIE,'',1,'/',$domain,false);
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';
?>
<div class="text-center">
	<h1 class="text-success">Hvala vam!</h1>
	<p>Vaša narudzbina je uspešno poslata i iznosi <?=money($sub_total);?>.</p>
	<p>Broj vaše narudzbine je: <strong><?=$cart_id;?></strong></p>
	<p>Vaša narudzbina će biti isporučena na sledeću adresu:</p>
	<address>
		<p>Ime i prezime: <?=$full_name?></p>
		<p>Broj telefona: <?=$phone?></p>
		<p>Ulica i broj: <?=$street?></p>
		<p>Grad: <?=$zip_code.' '.$city?></p>
	</address>
</div>
<?php	include 'includes/footer.php'; ?>