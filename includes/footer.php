	</div><br><br>
	<footer class="text-center" id="footer">&copy; Copyright 2017 MVM Team</footer>

	<script>
		function detailsmodal(id){
			var data = {"id" : id};
			$.ajax({
				url : '/mvmshop/includes/detailsmodal.php',
				method : "post",
				data : data,
				success: function(data){
					$('body').append(data);
					$('#details-modal').modal('toggle');
				},
				error: function(){
					alert("Something went wrong!");
				}
			});
		}

		function update_cart(mode, edit_id, edit_size){
			var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
			$.ajax({
				url: '/mvmshop/includes/update_cart.php',
				method: 'post',
				data : data,
				success: function(){
					location.reload();
				},
				error : function(){
					alert("Greška!");
				}
			});
		}

		function add_to_cart(){
			$('#modal_errors').html("");
			var size = $('#size').val();
			var quantity = $('#quantity').val();
			var available = $('#available').val();
			var error = '';
			var data = $('#add_product_form').serialize();
			if(size == '' || quantity == '' || quantity == 0){
				error += '<p class="text-danger text-center">Morate izabrati veličinu i količinu.</p>';
				$('#modal_errors').html(error);
				return;
			}else if(quantity > available){
				error += '<p class="text-danger text-center">Preostala količina je '+available+'.</p>';
				$('#modal_errors').html(error);
				return;
			}else{
				$.ajax({
					url: '/mvmshop/includes/add_cart.php',
					method: 'post',
					data : data,
					success: function(){
						location.reload();
					},
					error : function(){
						alert("Greška!");
					}
				});
			}
		}
	</script>
</body>
</html>