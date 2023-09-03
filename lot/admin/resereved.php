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
						<b>List of Reserved</b>
						
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
									<th class="">Date</th>
									<th class="">Lot</th>
									<th class="">Reservation Info</th>
									<th class="">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$type = array('',"Lot Only","House and Lot"); 
								$reserved = $conn->query("SELECT r.*,d.name as dname,l.lot,Concat(r.lastname,', ',r.firstname,' ',r.middlename) as cname FROM reserved r inner join lots l on l.id = r.lot_id inner join division d on d.id = l.division_id order by r.id desc ");
								while($row=$reserved->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class=""><?php echo date("M d,Y",strtotime($row['date_created'])) ?></td>
									<td class="">
										 <p> <b><?php echo ucwords($row['lot'].', '.$row['dname']) ?></b></p>
									</td>
									<td class="">
										 <p>Reserved by: <b><?php echo ucwords($row['cname']) ?></b></p>
										 <p><small>Contact #: <b><?php echo $row['contact'] ?></b></small></p>
										 <p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
									</td>
									<td class="text-center">
										<?php if($row['status'] == 0): ?>
											<span class="badge badge-danger text-white">Cancelled</span>
										<?php elseif($row['status'] == 1): ?>
											<span class="badge badge-primary text-white">Reserved</span>
										<?php elseif($row['status'] == 2): ?>
											<span class="badge badge-success text-white">Confirmed</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary view_reserved" type="button" data-id="<?php echo $row['id'] ?>" >View</button>
										<button class="btn btn-sm btn-outline-danger delete_reserved" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	
	$('.view_reserved').click(function(){
		uni_modal("Reserved Details","view_reserved.php?id="+$(this).attr('data-id'))
		
	})
	
	$('.delete_reserved').click(function(){
		_conf("Are you sure to delete this reserved?","delete_reserved",[$(this).attr('data-id')])
	})
	
	function delete_reserved($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_reserved',
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