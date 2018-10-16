<h3 class="text-center">Moja korpa</h3>
<div>
	<?php if(empty($cart_id)): ?>
		<p class="text-center">Vaša korpa je prazna.</p>
	<?php else: 
		$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
		$results = mysqli_fetch_assoc($cartQ);
		$items = json_decode($results['items'],true);
		$sub_total = 0;
	?>

	<table class="table table-condensed" id="cart_widget">
		<tbody>
			<?php foreach ($items as $item):
				$productQ = $db->query("SELECT * FROM products WHERE id = '{$item['id']}'");
				$product = mysqli_fetch_assoc($productQ);	
			?>
			<tr>
				<td><?=$item['quantity'];?></td>
				<td><?=substr($product['title'],0,15);?></td>
				<td><?=money($item['quantity']*$product['price']);?></td>
			</tr>
			<?php
				$sub_total += ($item['quantity'] * $product['price']);
				endforeach; ?>

				<tr>
					<td></td>
					<td>Ukupno:</td>
					<td><?=money($sub_total);?></td>
				</tr>
		</tbody>
	</table>
		<a href="cart.php" class="btn btn-xs btn-primary pull-right">Pogledajte korpu</a>
		<div class="clearfix"></div>
	<?php endif; ?>
</div>