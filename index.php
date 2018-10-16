<?php
	require_once 'includes/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';
	include 'includes/leftbar.php';

	$json_url = 'http://'.$_SERVER['HTTP_HOST'].'/mvmshop/includes/featured_product.php';
	$crl = curl_init();
	curl_setopt($crl, CURLOPT_URL, $json_url);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE); 
	$json = curl_exec($crl);
	curl_close($crl);
	$products = json_decode($json, TRUE);
	$cProducts = count($products['results']);
?>

<div class="col-lg-8">
	<div class="row">
		<h2 class="text-center">Izdvajamo iz ponude</h2>
		<?php for($i = 0; $i < $cProducts; $i++) : ?>
			<div class="col-lg-3 text-center products">
				<h4><?php echo $products['results'][$i]['title'];?></h4>
				<img src="<?php echo $products['results'][$i]['image']; ?>" class="img-thumb">
				<p class="list-price text-danger">Stara Cena: <s><?php echo $products['results'][$i]['list_price']; ?> RSD</s></p>
				<p class="price">Cena: <?php echo $products['results'][$i]['price']; ?> RSD</p>
				<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $products['results'][$i]['id']; ?>)">Detalji</button>
			</div>
		<?php endfor; ?>		
	</div>
</div>

<?php
	include 'includes/rightbar.php';
	include 'includes/footer.php';
?>