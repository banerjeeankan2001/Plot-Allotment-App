<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Lots</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=manage_lot" id="new_lot">
					<i class="fa fa-plus"></i> New Entry
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<colgroup>
								<col width="5%">
								<col width="20%">
								<col width="15%">
								<col width="30%">
								<col width="15%">
								<col width="15%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Division</th>
									<th class="">Lot</th>
									<th class="">Details</th>
									<th class="">Other Info</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$type = array('',"Lot Only","House and Lot"); 
								$lots = $conn->query("SELECT l.*,d.name as dname FROM lots l inner join division d on d.id = l.division_id order by l.lot asc ");
								while($row=$lots->fetch_assoc()):
									$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
									$desc = strtr(html_entity_decode($row['details']),$trans);
									$desc=str_replace(array("<li>","</li>"), array("",","), $desc);
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p> <b><?php echo ucwords($row['dname']) ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo ucwords($row['lot']) ?></b></p>
									</td>
									<td>
										 <p class="truncate"><?php echo strip_tags($desc) ?></p>
									</td>
									<td>
										 <p class=""><small>Type: <b><?php echo $type[$row['type']] ?></b></small></p>
										 <p class=""><small>Price: <b><?php echo number_format($row['price'])?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_lot" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_lot" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('.view_lot').click(function(){
		window.open("../index.php?page=view_lot&id="+$(this).attr('data-id'))
		
	})
	$('.edit_lot').click(function(){
		location.href ="index.php?page=manage_lot&id="+$(this).attr('data-id')
		
	})
	$('.delete_lot').click(function(){
		_conf("Are you sure to delete this lot?","delete_lot",[$(this).attr('data-id')])
	})
	
	function delete_lot($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_lot',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>