<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['model_id'])){
	$qry = $conn->query("SELECT d.* FROM division d inner join lots l on l.division_id = d.id where l.status = 1 and l.model_id=".$_GET['model_id']);
	
}

?>
<div class="container-fluid">
	<?php if(isset($qry) && $qry->num_rows > 0): ?>
	<div class="row">
	<?php 
		while($row=$qry->fetch_assoc()):
	?>
		<div class="col-md-6">
			<div class="card phase-field" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>">
				<div class="card-header " >
				<b><?php echo $row['name'] ?></b>
				</div>
				<div class="card-body">
					<img src="admin/assets/uploads/maps/<?php echo $row['map_img'] ?>" alt="">
					<hr>
					<p><small><i><?php echo $row['description'] ?></i></small></p>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
	</div>
	<?php else: ?>
	<center>Sorry, there's no available area in your selected house model.</center>
	<?php endif; ?>
</div>
<div class="modal-footer display">
	<div class="row">
		<div class="col-md-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
<style>
	p{
		margin:unset;
	}
	#uni_modal .modal-footer{
		display: none;
	}
	#uni_modal .modal-footer.display {
		display: block;
	}
	.phase-field{
		cursor:pointer
	}
	.phase-field:hover .card-body{
		background:#0066ff4a
	}
	.phase-field img{
		max-width:calc(100%);
		max-height:40vh;
	}
</style>
<script>
	$('.text-jqte').jqte();
	$('#manage-career').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=save_career',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
	$('.phase-field').click(function(){
		uni_modal($(this).attr('data-name'),"available_houses.php?model_id=<?php echo $_GET['model_id'] ?>&division_id="+$(this).attr('data-id'),'large')
	})
</script>