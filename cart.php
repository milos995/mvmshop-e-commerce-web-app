<?php 
	require_once 'includes/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';

	if($cart_id != ''){
		$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
		$result = mysqli_fetch_assoc($cartQ);
		$items = json_decode($result['items'],true);
		$i = 1;
		$sub_total = 0;
		$item_count = 0;
	}
?>
<div class="col-md-12">
	<div class="row">
		<h2 class="text-center">Moja korpa</h2>
		<?php if($cart_id=='') : ?>
			<div class="bg-danger">
				<p class="text-center text-danger">Vaša korpa je prazna!</p>
			</div>
		<?php else: ?>
			<table class="table table-bordered table-condensed table-striped">
				<thead><th>#</th><th>Proizvod</th><th>Cena</th><th>Količina</th><th>Veličina</th><th>Ukupno</th></thead>
				<tbody>
					<?php 
						foreach ($items as $item) {
							$product_id = $item['id'];
							$productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
							$product = mysqli_fetch_assoc($productQ);
							$sArray = explode(',',$product['sizes']);
							foreach ($sArray as $sizeString) {
								$s = explode(':',$sizeString);
								if($s[0] == $item['size']){
									$available = $s[1];
								}
							}
							?>
								<tr>
									<td><?=$i;?></td>
									<td><?=$product['title'];?></td>
									<td><?=money($product['price']);?></td>
									<td>
										<button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>');">-</button>
										<?=$item['quantity'];?>
										<?php if($item['quantity'] < $available): ?>				
											<button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>');">+</button>
										<?php else: ?>
											<span class="text-danger">Max</span>
										<?php endif; ?>	
									</td>
									<td><?=$item['size'];?></td>
									<td><?=money($item['quantity'] * $product['price']);?></td>
								</tr>		
							<?php 
								$i++;
								$item_count += $item['quantity'];
								$sub_total += ($item['quantity'] * $product['price']);
						}												
					?>
					<tr>
						<td colspan="4"></td>
						<th>Sve ukupno:</th>
						<td class="bg-success"><?=money($sub_total);?></td>
					</tr>
				</tbody>
			</table>
			<!-- Check out dugme -->
			<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
			  <span class="glyphicon glyphicon-shopping-cart"></span> Naruči >>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="checkoutModalLabel">Naručivanje</h4>
			      </div>
			      <div class="modal-body">
			      	<div class="row">
				      	<form action="thankYou.php" method="post" id="payment-form" name="payment-form">
				      		<input type="hidden" name="sub_total" value="<?=$sub_total;?>">
				      		<input type="hidden" name="cart_id" value="<?=$cart_id;?>">
				      		<input type="hidden" name="description" value="<?=$item_count.' proizvod'.(($item_count>1)?'a':'').' od MVM shop-a.';?>">
				      		<span class="bg-danger" id="payment-errors"></span>
				      		<div class="form-group col-md-6">
				      			<label for="full_name">Ime i prezime:</label>
								<input type="text" name="full_name" class="form-control" id="full_name">
				      		</div>
				      		<div class="form-group col-md-6">
				      			<label for="email">E-mail:</label>
								<input type="text" name="email" class="form-control" id="email">
				      		</div>
				      		<div class="form-group col-md-6">
				      			<label for="phone">Broj telefona:</label>
								<input type="text" name="phone" class="form-control" id="phone">
				      		</div>
				      		<div class="form-group col-md-6">
				      			<label for="street">Ulica i broj:</label>
								<input type="text" name="street" class="form-control" id="street">
				      		</div>
				      		<div class="form-group col-md-6">
				      			<label for="city">Grad:</label>
								<input type="text" name="city" class="form-control" id="city">
				      		</div>
				      		<div class="form-group col-md-6">
				      			<label for="zip_code">Poštanski broj:</label>
								<input type="text" name="zip_code" class="form-control" id="zip_code">
				      		</div>			      	
			      	</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Izadji</button>
			        <button type="button" class="btn btn-primary" onclick="check_address();">Naruči</button>
			      </form>
			      </div>
			    </div>
			  </div>
			</div>
		<?php endif; ?>
	</div>
</div>
<script>
	function check_address(){
		var data = {
			'full_name' : $('#full_name').val(),
			'email' : $('#email').val(),
			'phone' : $('#phone').val(),
			'street' : $('#street').val(),
			'city' : $('#city').val(),
			'zip_code' : $('#zip_code').val()
		};

		$.ajax({
			url: '/mvmshop/includes/check_address.php',
			method: 'post',
			data : data,
			success: function(data){
				if(data != 'passed'){
					$('#payment-errors').html(data);
				}
				if(data == 'passed'){
					$('#payment-errors').html("");
					document.forms['payment-form'].submit();
				}
			},
			error : function(){
				alert("Greška!");
			}
		});
	}
</script>
<?php include 'includes/footer.php'; ?>