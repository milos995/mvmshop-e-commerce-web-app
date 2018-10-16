	</div><br><br>
	<div class="col-md-12 text-center" id="footer">&copy; Copyright 2017 MVM Team</div>
	<script>
		function updateSizes(){
			var sizeString = '';
			for(var i=1;i<=12;i++){
				if($('#size'+i).val() != ''){
					sizeString += $('#size'+i).val()+':'+$('#qty'+i).val()+',';
				}
			}
			$('#sizes').val(sizeString);
		}

		function get_child_options(selected){
			if(typeof selected === 'undefined'){
				var selected = '';
			}
			var parentID = $('#parent').val();
			$.ajax({
				url: '/mvmshop/admin/child_categories.php',
				type: 'POST',
				data: {parentID : parentID, selected : selected},
				success: function(data){
					$('#child').html(data);
				},
				error: function(){alert('Error')},
			});
		}
		$('select[name="parent"]').change(function(){
			get_child_options();
		});
	</script>
</body>
</html>