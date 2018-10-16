<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	if(!is_logged_in()){
		header('Location: login.php');
	}
	include 'includes/head.php';
	include 'includes/navigation.php';

	$orderQ = "SELECT o.id, o.cart_id, o.full_name, o.description, o.order_date, o.sub_total, c.items, c.ordered, c.shipped
	FROM orders o
	LEFT JOIN cart c ON o.cart_id = c.id
	WHERE c.ordered = 1 AND c.shipped = 0
	ORDER BY o.order_date";
	$orderResults = $db->query($orderQ);
?>
<div class="col-md-12">
	<h2 class="text-center">Narudzbine za slanje</h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<th></th>
			<th>Ime i prezime</th>
			<th>Opis</th>
			<th>Ukupno</th>
			<th>Datum</th>
		</thead>
		<tbody>
			<?php while($order = mysqli_fetch_assoc($orderResults)): ?>
				<tr>
					<td><a href="orders.php?order_id=<?=$order['id'];?>" class="btn btn-xs btn-info">Detalji</a></td>
					<td><?=$order['full_name'];?></td>
					<td><?=$order['description'];?></td>
					<td><?=money($order['sub_total']);?></td>
					<td><?=pretty_date($order['order_date']);?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php include 'includes/footer.php'; ?>