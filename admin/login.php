<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	include 'includes/head.php';

	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$email = trim($email);
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$password = trim($password);
	$errors = array();
?>
<style>
	body {
		background-image: url('../img/bg.jpg');
		background-size: 100vw 100vh;
		background-attachment: fixed;
	}
	#footer {
		color: white;
	}	
</style>
<div id="login-form">
	<div>
		<?php
			if($_POST){
				if(empty($_POST['email']) || empty($_POST['password'])){
					$errors[] = 'Morate uneti e-mail i šifru.';
				}

				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$errors[] = 'E-mail nije validan';
				}

				if(strlen($password) < 6){
					$errors[] = 'Šifra mora imati barem 6 karaktera';
				}

				$query = $db->query("SELECT * FROM users WHERE email = '$email'");
				$user = mysqli_fetch_assoc($query);
				$userCount = mysqli_num_rows($query);
				if($userCount < 1){
					$errors[] = 'E-mail ne postoji.';
				}

				if(!password_verify($password, $user['password'])){
					$errors[] = 'Uneli ste pogrešnu šifru.';
				}

				if(!empty($errors)){
					echo display_errors($errors);
				}else {
					$user_id = $user['id'];
					login($user_id);
				}
			}
		?>
	</div>
	<h2 class="text-center">Prijavite se</h2>
	<form action="login.php" method="post">
		<div class="form-group">
			<label for="email">E-mail:</label>
			<input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="password">Šifra</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Prijavite se" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/mvmshop/index.php">Posetite sajt</a></p>
</div>

<?php 
	include 'includes/footer.php';
?>