<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	if(!is_logged_in()){
		header('Location: login.php');
	}
	include 'includes/head.php';
	include 'includes/navigation.php';

	// zavrsi narudzbinu
	if(isset($_GET['complete']) && $_GET['complete'] == 1){
		$cart_id = sanitize((int)$_GET['cart_id']);
		$db->query("UPDATE cart SET shipped = 1 WHERE id ='{$cart_id}'");
		$_SESSION['success_flash'] = 'Narudzbina je završena!';
		header('Location: index.php');
	}

	$order_id = sanitize((int)$_GET['order_id']);
	$orderQ = $db->query("SELECT * FROM orders WHERE id = '{$order_id}'");
	$order = mysqli_fetch_assoc($orderQ);
	$cart_id = $order['cart_id'];
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$cart = mysqli_fetch_assoc($cartQ);
	$items = json_decode($cart['items'],true);
	$idArray = array();
	$products = array();
	foreach ($items as $item) {
		$idArray[] = $item['id'];
	}
	$ids = implode(',',$idArray);
	$productQ = $db->query("SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent'
		FROM products i
		LEFT JOIN categories c ON i.categories = c.id
		LEFT JOIN categories p ON c.parent = p.id
		WHERE i.id IN ({$ids})");
	while($p = mysqli_fetch_assoc($productQ)){
		foreach ($items as $item) {
			if($item['id'] == $p['id']){
				$x = $item;
				continue;
			}
		}
		$products[] = array_merge($x, $p);
	}
?>
<h2 class="text-center">Naručeni proizvodi</h2>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<th>Količina</th>
		<th>Naziv proizvoda</th>
		<th>Kategorija</th>
		<th>Veličina</th>
	</thead>
	<tbody>
		<?php foreach($products as $product): ?>
			<tr>
				<td><?=$product['quantity'];?></td>
				<td><?=$product['title'];?></td>
				<td><?=$product['parent'].' - '.$product['child'];?></td>
				<td><?=$product['size'];?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="row">
	<div class="col-md-6">
		<h3 class="text-center">Detalji narudzbine</h3>
		<table class="tabe table-bordered table-condensed table-striped table-auto">
			<tbody>
				<tr>
					<td>Ukupno</td>
					<td><?=money($order['sub_total']);?></td>
				</tr>
				<tr>
					<td>Datum narudzbine</td>
					<td><?=pretty_date($order['order_date']);?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<h3 class="text-center">Adresa za slanje</h3>
		<address class="text-center">
			<?=$order['full_name'];?><br>
			<?=$order['phone'];?><br>
			<?=$order['street'];?><br>
			<?=$order['zip_code'].' '.$order['city'];?><br>
		</address>
	</div>
</div>
<div class="pull-right">
	<a href="index.php" class="btn btn-default">Otkaži</a>
	<a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-primary">Završi narudzbinu</a>
</div>
<?php include 'includes/footer.php'; ?>