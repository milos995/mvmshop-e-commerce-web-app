<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<a href="/mvmshop/admin/index.php" class="navbar-brand">MVM Shop Admin</a>
		<ul class="nav navbar-nav">
			<li><a href="brands.php">Brendovi</a></li>
			<li><a href="products.php">Proizvodi</a></li>
			<?php if(has_permission('admin')): ?>
				<li><a href="users.php">Korisnici</a></li>
			<?php endif; ?>			
			<!--<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#"><?php echo $child['category'] ?></a></li>
				</ul>
			</li>-->
		</ul>
		<div class="pull-right user">
			<p class="navbar-nav nav">Dobro došli, <strong><?= $user_data['first']; ?></strong></p>
            <p class="navbar-nav nav logout"><a href="logout.php">Odjavite se</a></p>
		</div>
	</div>
</nav>
<div class="container-fluid">