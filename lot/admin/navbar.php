
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=resereved" class="nav-item nav-resereved"><span class='icon-field'><i class="fa fa-th-list"></i></span> Reserved List</a>
				<a href="index.php?page=divisions" class="nav-item nav-divisions"><span class='icon-field'><i class="fa fa-map"></i></span> Division List</a>
				<a href="index.php?page=lots" class="nav-item nav-lots"><span class='icon-field'><i class="fa fa-map-marker-alt"></i></span> Lot List</a>
				<a href="index.php?page=models" class="nav-item nav-models"><span class='icon-field'><i class="fa fa-home"></i></span> Model Houses</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
