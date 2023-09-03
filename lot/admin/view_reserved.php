<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT r.*,d.name as dname,l.lot,Concat(r.lastname,', ',r.firstname,' ',r.middlename) as cname FROM reserved r inner join lots l on l.id = r.lot_id inner join division d on d.id = l.division_id where r.id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<p>Name: <b><large><?php echo ucwords($cname) ?></large></b></p>
	<p>Lot: <b><?php echo ucwords($lot.', '.$dname) ?></b></p>
	<p>Contact #: <b><?php echo $contact ?></b></p>
	<p>Email: <b><?php echo $email ?></b></p>
	<p>Address: <b><?php echo $address ?></b></p>
	<p>Messsage: <b><?php echo $message ?></b></p>
	<hr class="divider">
	<form id="manage-reserved">
		<input type="hidden" name="id" value='<?php echo isset($id) ? $id : '' ?>'>
		<input type="hidden" name="lot_id" value='<?php echo isset($lot_id) ? $lot_id : '' ?>'>
		<div class="form-group">
			<label for="" class="control-label">Status</label>
			<select name="status" id="status" class="custom-select">
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Cancelled</option>
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Reserved</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>Confirmed</option>
			</select>
		</div>
	</form>
</div>
<div class="modal-footer display">
	<div class="row">
		<div class="col-md-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
			<button class="btn float-right btn-primary mr-2" onclick="$('#uni_modal form').submit()">Update</button>
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
</style>
<script>
	$('.text-jqte').jqte();
	$('#manage-reserved').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=update_reserved',
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
</script>