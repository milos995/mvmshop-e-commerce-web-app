<?php
	require_once 'includes/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';
	include 'includes/leftbar.php';

	
	$sql = "SELECT * FROM products";
	$cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
	if($cat_id == ''){
		$sql .= " WHERE 1";
	}else{
		$sql .= " WHERE categories = '{$cat_id}'";
	}
	$price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
	$min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
	$max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
	$brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
	if($min_price != ''){
		$sql .= " AND price >= '{$min_price}'";
	}
	if($max_price != ''){
		$sql .= " AND price <= '{$max_price}'";
	}
	if($brand != ''){
		$sql .= " AND brand = '{$brand}'";
	}
	if($price_sort == 'low'){
		$sql .= " ORDER BY price";
	}
	if($price_sort == 'high'){
		$sql .= " ORDER BY price DESC";
	}
	$productQ = $db->query($sql);
	$category = get_category($cat_id);
?>

<div class="col-lg-8">
	<div class="row">
		<?php if($cat_id != ''): ?>
			<h2 class="text-center"><?=$category['parent'].' - '.$category['child'];?></h2>
		<?php else: ?>
			<h2 class="text-center">MVM Shop</h2>
		<?php endif; ?>
		<?php while($product = mysqli_fetch_assoc($productQ)) : ?>
			<div class="col-lg-3 text-center products">
				<h4><?php echo $product['title']; ?></h4>
				<img src="<?php echo $product['image']; ?>" class="img-thumb">
				<p class="list-price text-danger">Stara Cena: <s><?php echo $product['list_price']; ?> RSD</s></p>
				<p class="price">Cena: <?php echo $product['price']; ?> RSD</p>
				<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id']; ?>)">Detalji</button>
			</div>
		<?php endwhile; ?>		
	</div>
</div>

<?php
	include 'includes/rightbar.php';
	include 'includes/footer.php';
?>