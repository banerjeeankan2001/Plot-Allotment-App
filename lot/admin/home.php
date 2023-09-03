<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
    #map-items .card-body{
        width:calc(100%) ;
        height:calc(40vh) ;
        overflow: auto;
    }
    .map-items .maps{
        width:calc(100%) ;
        height:calc(100%) ;
        overflow: auto;

    }

</style>

<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-map-marked"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM lots ")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Total Lots</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-list"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM lots where status = 0")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Total Taken Lots</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-warning">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-th-list"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM lots where status = 2")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Total Reserved Lots</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="fa fa-home"></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM model_houses")->num_rows; ?>
                                        </b></h4>
                                        <p><b>Model Houses Types</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	
                    <div class="row">
                        <div class="col-md-12">
                        <p>
                            <b>
                                <large>Taken Lots</large>
                            </b>
                        </p>
                        </div>
                        <?php
                        $qry = $conn->query("SELECT * FROM division ");
                        while($row=$qry->fetch_array()):
                        $taken = $conn->query("SELECT * FROM lots where status = 0 and division_id = {$row['id']} ");
                        ?>
                        <div class="col-md-6">
                            <div class="card map-items">
                                <div class="card-header"><?php echo $row['name'] ?></div>
                                <div class="card-body">
                                     <div id="map<?php echo $row['id'] ?>" class="maps" style="position: relative">
                                        <img src="assets/uploads/maps/<?php echo $row['map_img'] ?>" alt="">
                                        <?php 
                                        while($l = $taken->fetch_array()): 
                                        $pos = json_decode($l['marker_position']);
                                        $l['top'] = $pos->top;
                                        $l['left'] = $pos->left;
                                        ?>  
                                            <div class="text-danger" style="position:absolute;top:<?php echo $l['top'] ?>;left:<?php echo $l['left'] ?>"><i class="fa fa-map-marker-alt"></i></div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>