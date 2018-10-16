<h3 class="text-center">Popularni proizvodi</h3>
<?php 
	$orderQ = $db->query("SELECT * FROM cart WHERE ordered = 1 ORDER BY id DESC LIMIT 5");
	$results = array();
	while ($row = mysqli_fetch_assoc($orderQ)) {
		$results[] = $row;
	}
	$row_count = $orderQ->num_rows;
	$used_ids = array();
	for ($i=0; $i < $row_count; $i++) { 
		$json_items = $results[$i]['items'];
		$items = json_decode($json_items,true);
		foreach ($items as $item) {
			if(!in_array($item['id'], $used_ids)){
				$used_ids[] = $item['id'];
			}
		}
	}
?>
<div id="recent-widget">
	<table class="table table-condensed">
		<?php foreach ($used_ids as $id): 
			$productQ = $db->query("SELECT * FROM products WHERE id = '{$id}'");
			$product = mysqli_fetch_assoc($productQ);	
		?>
		<tr>
			<td>
				<?=substr($product['title'],0,15);?>
			</td>
			<td>
				<a class="text-primary" onclick="detailsmodal('<?=$id;?>')">Pogledajte</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>