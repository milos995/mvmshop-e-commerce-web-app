<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	if(!is_logged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';
	include 'includes/navigation.php';

	// izbrisi proizvod
	if(isset($_GET['delete'])){
		$id = sanitize($_GET['delete']);
		$imageQ = $db->query("SELECT * FROM products WHERE id = '$id'");
		$imageP = mysqli_fetch_assoc($imageQ);
		$imagePath = $_SERVER['DOCUMENT_ROOT'].$imageP['image'];
		$db->query("DELETE FROM products WHERE id = '$id'");
		unlink($imagePath);
	}

	$dbpath = '';
	if (isset($_GET['add']) || isset($_GET['edit'])) {
		$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
		$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");		
		$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
		$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
		$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
		$category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
		$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
		$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
		$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
		$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
		$sizes = rtrim($sizes, ',');
		$saved_image = '';
		if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$productResults = $db->query("SELECT * FROM products WHERE id ='$edit_id'");
			$product = mysqli_fetch_assoc($productResults);
			if(isset($_GET['delete_image'])){
				$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
				unlink($image_url);
				$db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
				header('Location: products.php?edit='.$edit_id);
			}
			$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
			$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
			$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
			$parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
			$parentResult = mysqli_fetch_assoc($parentQ);
			$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
			$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
			$list_price = ((isset($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
			$description = ((isset($_POST['description']))?sanitize($_POST['description']):$product['description']);
			$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
			$sizes = rtrim($sizes, ',');
			$saved_image = (($product['image'] != '')?$product['image']:'');
			$dbpath = $saved_image;
		}
		if(!empty($sizes)){
			$sizeString = sanitize($sizes);
			$sizeString = rtrim($sizeString,',');
			$sizesArray = explode(',',$sizeString);
			$sArray = array();
			$qArray = array();
			foreach ($sizesArray as $ss) {
				$s = explode(':', $ss);
				$sArray[] = $s[0];
				$qArray[] = $s[1];
		}
		}else{
			$sizesArray = array();
		}
		if($_POST){	
			$errors = array();
			
			$required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
			foreach ($required as $field) {
				if ($_POST[$field] == '') {
					$errors[] = 'Sva polja sa znakom * su obavezna.';
					break;
				}					
			}
			if(isset($_FILES['photo']) && $_FILES['photo']['size'] > 0){
				var_dump($_FILES);
				$photo = $_FILES['photo'];
				$name = $photo['name'];
				$nameArray = explode('.',$name);
				$fileName = $nameArray[0];
				$fileExt = $nameArray[1];
				$tmpLoc = $photo['tmp_name'];
				$uploadName = md5(microtime()).'.'.$fileExt;
				$uploadPath = BASEURL.'img/products/'.$uploadName;
				$dbpath = '/mvmshop/img/products/'.$uploadName;
			}		
			if(!empty($errors)){
				echo display_errors($errors);
			}else {
				if(!empty($_FILES)){
					move_uploaded_file($tmpLoc,$uploadPath);
				}
				$insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`, `description`) 
				VALUES ('$title','$price', '$list_price', '$brand', '$category', '$sizes', '$dbpath', '$description')";
				if(isset($_GET['edit'])){
					$insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', sizes = '$sizes', image = '$dbpath', description = '$description' WHERE id = '$edit_id'";
				}
				$db->query($insertSql);
				header('Location: products.php');
			}
		}

?>
	<h2 class="text-center"><?=((isset($_GET['edit']))?'Izmeni':'Dodaj novi');?> proizvod</h2><hr>
	<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
		<div class="form-group col-md-3">
			<label for="title">Naziv proizvoda*:</label>
			<input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">			
		</div>
		<div class="form-group col-md-3">
			<label for="brand">Brend*:</label>
			<select class="form-control" id="brand" name="brand">
				<option value=""<?=(($brand == '')?' selected':'');?>></option>
				<?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
					<option value="<?=$b['id']?>"<?=(($brand == $b['id'])?' selected':'');?>><?=$b['brand']?></option>
				<?php endwhile ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="parent">Glavna kategorija*:</label>
			<select class="form-control" id="parent" name="parent">
				<option value=""<?=(($parent == '')?' selected':'');?>></option>
				<?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
					<option value="<?=$p['id']?>"<?=(($parent == $p['id'])?' selected':'');?>><?=$p['category']?></option>
				<?php endwhile ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="child">Potkategorija*:</label>
			<select id="child" name="child" class="form-control">				
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="price">Cena*:</label>
			<input type="text" name="price" id="price" class="form-control" value="<?=$price;?>">
		</div>
		<div class="form-group col-md-3">
			<label for="list_price">Stara cena:</label>
			<input type="text" name="list_price" id="list_price" class="form-control" value="<?=$list_price;?>">
		</div>
		<div class="form-group col-md-3">
			<label>Količine i veličine*:</label>
			<button class="btn btn-default form-control" onclick="$('#sizesModal').modal('toggle'); return false;">Količine i veličine</button>
		</div>
		<div class="form-group col-md-3">
			<label for="sizes">Količine i veličine pregled</label>
			<input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
		</div>
		<div class="form-group col-md-6">
			<?php if($saved_image != ''): ?>
				<div class="saved-image">
					<img src="<?=$saved_image;?>"><br>
					<a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Izbriši sliku</a>
				</div>
			<?php else: ?>
				<label for="photo">Slika proizvoda:</label>
				<input type="file" name="photo" id="photo" class="form-control">
			<?php endif; ?>
		</div>
		<div class="form-group col-md-6">			
			<label for="description">Detalji:</label>
			<textarea id="description" name="description" class="form-control"	rows="6"><?=$description;?></textarea>			
		</div>
		<div class="form-group pull-right">
			<a href="products.php" class="btn btn-default">Otkaži</a>
			<input type="submit" value="<?=((isset($_GET['edit']))?'Izmeni':'Dodaj');?> proizvod" class="btn btn-success">
		</div><div class="clearfix"></div>		
	</form>

	<!-- Modal -->
	<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModal">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="sizesModalLabel">Količine i veličine</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="container-fluid">
		      	<?php for($i=1; $i <= 12; $i++) : ?>
		      		<div class="form-group col-md-4">
		      			<label for="size<?=$i;?>">Veličina:</label>
						<input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
		      		</div>
		      		<div class="form-group col-md-2">
		      			<label for="qty<?=$i;?>">Količina:</label>
						<input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
		      		</div>				
		      	<?php endfor; ?>
	      	</div>	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Izadji</button>
	        <button type="button" class="btn btn-primary" onclick="updateSizes();$('#sizesModal').modal('toggle');return false;">Sačuvaj izmene</button>
	      </div>
	    </div>
	  </div>
	</div>		
<?php 		
	} else {
		$sql = "SELECT * FROM products";
		$presults = $db->query($sql);
		if(isset($_GET['featured'])){
			$id = (int)$_GET['id'];
			$featured = (int)$_GET['featured'];
			$featured_sql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
			$db->query($featured_sql);
			header('Location: products.php');
		}	
?>
<h2 class="text-center">Proizvodi</h2>
<a href="products.php?add=1" class="btn btn-success pull-right mar-right" id="add-product-btn">Dodaj proizvod</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
	<thead><th></th><th>Proizvodi</th><th>Cena</th><th>Kategorija</th><th>Izdvojiti</th></thead>
	<tbody>
		<?php while($product = mysqli_fetch_assoc($presults)) : 
			$childID = $product['categories'];
			$catSql = "SELECT * FROM categories WHERE id = '$childID'";
			$result = $db->query($catSql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM categories WHERE id = '$parentID'";
			$presult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].'~'.$child['category'];
		?>
			<tr>
				<td>
					<a href="products.php?edit=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="products.php?delete=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>
				<td><?=$product['title']?></td>
				<td><?=money($product['price'])?></td>
				<td><?=$category?></td>
				<td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
					<span class="glyphicon glyphicon-<?=(($product['featured'] == 1)?'minus':'plus');?>"></span>					
				</a>&nbsp <?=(($product['featured'] == 1)?'Izdvojen proizvod':'');?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<?php } include 'includes/footer.php'; ?>
<script>
	$('document').ready(function(){
		get_child_options('<?=$category;?>');
	});
</script>