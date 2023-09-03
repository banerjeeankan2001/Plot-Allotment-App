<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM model_houses where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<style type="text/css">
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
		height: 40vh !important;background: black;

	}
	#imagesCarousel{
		margin-left:unset !important ;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
		margin-top: unset;
		margin-bottom: unset;
	}
	#imagesCarousel img{
		width: calc(100%)!important;
		height: auto!important;
		/*max-height: calc(100%)!important;*/
		max-width: calc(100%)!important;
		cursor :pointer;
	}
	#banner{
		display: flex;
		justify-content: center;
	}
	#banner img{
		max-width: calc(100%);
		max-height: 50vh;
		cursor :pointer;
	}
	#img-field img{
		max-width:calc(100%);
		cursor:pointer
	}
	<?php if(!empty($cover)): ?>
	 header.masthead {
	    background: url(admin/assets/uploads/models/<?php echo $cover ?>);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	<?php endif; ?>
</style>
<header class="masthead">
	<div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-4 align-self-end mb-4 pt-2 page-title">
                    	<h4 class="text-center text-white"><b><?php echo ucwords($title) ?></b></h4>
                        <hr class="divider my-4" />
                     
                    </div>
                    
                </div>
            </div>
</header>
<section></section>
<div class="container-fluid">
<div class="row">
	<div class="col-lg-4">
		<div class="card mt-4 mb-4">
			<div class="card-body"id='img-field'>
				<h4><b>Images</b></h4>
				<hr class="divider">
				<?php 
					$images = array();
					if(isset($id)){
						$fpath = 'admin/assets/uploads/models/'.$id;
						if(is_dir($fpath))
						$images= scandir($fpath);
					}
					// var_dump($images);
					foreach($images as $k => $v):
						if(!in_array($v,array('.','..'))):
				?>
					<div class="row mb-3">
						<div class="col-md-12 justify-content-center">
							<center><img src="<?php echo $fpath.'/'.$v ?>" alt=""></center>
						</div>
					</div>
				<?php
						else:
							unset($images[$v]);
						endif;
					endforeach;
				?>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card mt-4 mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						
					</div>
					<div class="col-md-12" id="content">
					<p class="">
						<?php echo html_entity_decode($description); ?>
					</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<hr class="divider" style="max-width: calc(100%);"/>
						<div class="text-center">
								<button class="btn btn-primary" id="view_areas" type="button">View Areas</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	$('#img-field img').click(function(){
		viewer_modal($(this).attr('src'))
	})
	$('#view_areas').click(function(){
        uni_modal("Choose Phase","choose_phase.php?model_id=<?php echo $_GET['id']?>",'mid-large')
    })

   
</script>
