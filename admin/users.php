<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	if(!is_logged_in()){
		login_error_redirect();
	}
	if(!has_permission('admin')){
		permission_error_redirect('index.php');
	}
	include 'includes/head.php';
	include 'includes/navigation.php';
	if(isset($_GET['delete'])){
		$delete_id = sanitize($_GET['delete']);
		$db->query("DELETE FROM users WHERE id = '$delete_id'");
		$_SESSION['success_flash'] = 'Korisnik je izbrisan!';
		header('Location: users.php');
	}
	if(isset($_GET['add'])){
		$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
		$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
		$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
		$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
		$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
		$errors = array();
		if($_POST){
			$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
			$emailCount = mysqli_fetch_assoc($emailQuery);
			if($emailCount != 0){
				$errors[] = 'E-mail već postoji.';
			}
			$required = array('name', 'email', 'password', 'confirm', 'permissions');
			foreach ($required as $f) {
				if(empty($_POST[$f])){
					$errors[] = 'Morate uneti sva polja!';
					break;
				}
			}
			if(strlen($password) < 6){
				$errors[] = 'Šifra mora imati barem 6 karaktera.';
			}

			if($password != $confirm){
				$errors[] = "Šifre se ne poklapaju.";
			}

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'E-mail nije validan.';
			}

			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				$hashed = password_hash($password,PASSWORD_DEFAULT);
				$db->query("INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
				$_SESSION['success_flash'] = 'Uspešno ste dodali korisnika!';
				header('Location: users.php');
			}
		}
		?>
		<h2 class="text-center">Dodaj novog korisnika</h2><hr>
		<form action="users.php?add=1" method="post">
			<div class="form-group col-md-6">
				<label for="name">Ime i prezime:</label>
				<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="email">E-mail:</label>
				<input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="password">Šifra:</label>
				<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="confirm">Potvrdite šifru:</label>
				<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="confirm">Dozvole:</label>
				<select class="form-control" name="permissions">
					<option value=""<?=(($permissions == '')?' selected':'');?>></option>
					<option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>Editor</option>
					<option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
				</select>
			</div>
			<div class="form-group col-md-6 text-right mar-top">
				<a href="users.php" class="btn btn-default">Otkaži</a>
				<input type="submit" name="Dodaj korisnika" class="btn btn-primary">
			</div>
		</form>		
		<?php 
	}else{
	$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");
?>
<h2>Korisnici</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Dodaj korisnika</a>
<hr>
<table class="table table-bordered table-striped table-condensed">
	<thead><th></th><th>Ime</th><th>E-mail</th><th>Registrovan</th><th>Zadnje prijavljivanje</th><th>Dozvole</th></thead>
	<tbody>
		<?php while($user = mysqli_fetch_assoc($userQuery)): ?>
			<tr>
				<td>
					<?php if($user['id'] != $user_data['id']): ?>
						<a href="users.php?delete=<?=$user['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					<?php endif; ?>
				</td>
				<td><?=$user['full_name'];?></td>
				<td><?=$user['email'];?></td>
				<td><?=pretty_date($user['join_date']);?></td>
				<td><?=(($user['last_login'] == '0000-00-00 00:00:00')?'Nikada':pretty_date($user['last_login']));?></td>
				<td><?=$user['permissions'];?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php }include 'includes/footer.php' ?>