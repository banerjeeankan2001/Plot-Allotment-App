<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM lots where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
$pos = json_decode($marker_position);
$top = $pos->top;
$left = $pos->left;
}
?>
<style>
	.marker{
		position: absolute;
		cursor: move;
	}
</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form action="" id="manage-lot">
					<div class="row">
					<div class="col-md-6">
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">

						<div class="form-group ">
								<label for="" class="control-label">Division</label>
								<select name="division_id" class="custim-select select2" id="division_id">
									<option value=""></option>
										<?php 
										$query = $conn->query("SELECT * FROM division order by name asc");
										while($row= $query->fetch_assoc()):

										?>
										<option value="<?php echo $row['id'] ?>" <?php echo isset($division_id) && $division_id == $row['id'] ? 'selected' : ''  ?>><?php echo $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
						</div>
						<div class="form-group ">
								<label for="" class="control-label">Lot</label>
								<input type="text" class="form-control" name="lot"  value="<?php echo isset($lot) ? $lot :'' ?>" required>
						</div>
						<div class="form-group ">
								<label for="" class="control-label">Price</label>
								<input type="number" class="form-control text-right" step="any" name="price"  value="<?php echo isset($price) ? $price :'' ?>" required>
						</div>
						<div class="form-group ">
								<label for="" class="control-label">Type</label>
								<select name="type" class="custim-select select2" id="type">
									<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : ''  ?>>Lot</option>
									<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : ''  ?>>House & Lot</option>
									</select>
						</div>
						<div class="form-group " style="display: none" id='mdl-field'>
								<label for="" class="control-label">Model House</label>
								<select name="model_id" class="custim-select select2" id="model_id">
									<option value=""></option>
										<?php 
										$query = $conn->query("SELECT * FROM model_houses order by title asc");
										while($row= $query->fetch_assoc()):

										?>
										<option value="<?php echo $row['id'] ?>" <?php echo isset($model_id) && $model_id == $row['id'] ? 'selected' : ''  ?>><?php echo $row['title'] ?></option>
									<?php endwhile; ?>
								</select>
						</div>
						<div class="form-group">
								<label for="" class="control-label">Details</label>
								<textarea name="details" id="details" class="form-control jqte" cols="30" rows="5" required><?php echo isset($details) ? html_entity_decode($details) : '' ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<p>Mark the area in the map below.</p>
						<div id="msg"></div>
						<div id="map-field" style="position: relative;max-width:calc(100%);overflow:auto">
							<center>Select division first</center>
						</div>
						<input type="hidden" name="top" value="">
						<input type="hidden" name="left" value="">
						<div id="marker_clone" style="display: none">
							<div class='marker'>
								<i class="fa fa-map-marker" style="color:red;font-size: 2rem"></i>
							</div>
						</div>
					</div>
					</div>
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-block btn-primary col-sm-2"> Save</button>
							</div>
						</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
<div class="imgF" style="display: none " id="img-clone">
			<span class="rem badge badge-primary" onclick="rem_func($(this))"><i class="fa fa-times"></i></span>
	</div>
<script>
	$('#payment_status').on('change keypress keyup',function(){
		if($(this).prop('checked') == true){
			$('#amount').closest('.form-group').hide()
		}else{
			$('#amount').closest('.form-group').show()
		}
	})
	$('.jqte').jqte();
	$(document).ready(function(){

	if('<?php echo isset($division_id) ? 1 : 0 ?>' == 1){
			$('#division_id').trigger('change')
			$('#type').trigger('change')

	}
	})
	$('#type').change(function(){
		if($(this).val() == 2){
			$('#mdl-field').show()
			$('#model_id').val('<?php echo isset($model_id) ? $model_id : '' ?>')
			$('#model_id').trigger('change')
		}else{
			$('#mdl-field').hide()
			$('#model_id').val('')
			$('#model_id').trigger('change')
		}
	})
	$('#division_id').change(function(){
		start_load()
		$.ajax({
			url:'ajax.php?action=get_map',
			method:'POST',
			data:{id:$(this).val()},
			success:function(resp){
				if(resp){
					$('#map-field').html('<img src="assets/uploads/maps/'+resp+'" alt="">')
					var marker = $('#marker_clone .marker').clone()
					marker.attr('id','marker')
					marker.css({top:"calc(50%)",left:"calc(50%)"})
					$('#map-field').append(marker)
					dragElement(document.getElementById('marker'))
				}
			},complete:function(){
				end_load()
			if('<?php echo isset($division_id) ? 1 :0 ?>' == 1){
				$('#marker').css({'top':'<?php echo isset($top) ? $top : '' ?>','left':'<?php echo isset($left) ? $left : '' ?>'})
			}
			}
		})
	})
	$('#manage-lot').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		if($('[name="top"]').val() == '' || $('[name="top"]').val() == ''){
		$('#msg').html('<div class="alert alert-danger">Move the map maker to the lot location.</div>')
		end_load()
		return false;
		}
		$.ajax({
			url:'ajax.php?action=save_lot',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.href = "index.php?page=lots"
					},1500)

				}
				
			}
		})
	})
	function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id)) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id).onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.lot;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.lot;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    $('[name="top"]').val((elmnt.offsetTop - pos2) + "px")
    $('[name="left"]').val((elmnt.offsetLeft - pos1) + "px")
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
</script>