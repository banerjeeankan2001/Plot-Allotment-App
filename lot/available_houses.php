<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['model_id'])){
	$map = $conn->query("SELECT * FROM division where id = ".$_GET['division_id'])->fetch_array()['map_img'];
	$qry = $conn->query("SELECT * FROM lots where status = 1 and model_id=".$_GET['model_id']." and division_id=".$_GET['division_id']);
	
}

?>
<div class="container-fluid">
	
	<div class="row">
		<div class="col-md-6">
		<p>Click the maker (<span class="fa fa-map-marker-alt text-danger"></span>) in your selected lot to view details.</p>
		<div id="map-wrapper" style="position:relative;width:calc(100%);overflow:auto">
		<img src="admin/assets/uploads/maps/<?php echo $map ?>" alt="">
			<?php 
				while($row=$qry->fetch_assoc()):
					$pos = json_decode($row['marker_position']);
					$top = $pos->top;
					$left = $pos->left;
			?>
			<a href="javascript:void(0)" class="marker text-danger" data-id='<?php echo $row['id'] ?>' style="top:<?php echo $top ?>;left:<?php echo $left ?>;font-size:2rem"><span class="fa fa-map-marker-alt"></span></a>
		<?php endwhile; ?>
		</div>
		</div>
		<div class="col-md-6">
			<div id="details"></div>
		</div>
	</div>
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
	.marker{
		position:absolute
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
	$('.marker').click(function(){
		start_load()
		$.ajax({
			url:'lot_details.php?id='+$(this).attr('data-id'),
			success:function(resp){
				if(resp){
					$('#details').html(resp)
					end_load()
				}
			}
		})
	})
</script>