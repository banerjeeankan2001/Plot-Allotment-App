<?php 
include 'admin/db_connect.php'; 
?>
<style>
#portfolio .img-fluid{
    width: calc(100%);
    height: 30vh;
    z-index: -1;
    position: relative;
    padding: 1em;
}
.models-list{
cursor: pointer;
border: unset;
flex-direction: inherit;
}
.models-img {
    width: calc(30%);
    max-height: 30vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.models-list .card-body{
    width: calc(70%);
}
.models-img img {
    max-height: calc(100%);
    max-width: calc(100%);
    padding:5px
}
span.hightlight{
    background: yellow;
}
.carousel,.carousel-inner,.carousel-item{
   min-height: calc(100%)
}
header.masthead,header.masthead:before {
        min-height: 50vh !important;
        height: 50vh !important
    }
.row-items{
    position: relative;
}
.card-left{
    left:0;
}
.card-right{
    right:0;
}
.rtl{
    direction: rtl ;
}
.models-text{
    justify-content: center;
    align-items: center ;
}
.masthead{
        min-height: 23vh !important;
        height: 23vh !important;
    }
     .masthead:before{
        min-height: 23vh !important;
        height: 23vh !important;
    }
.models-list p {
	margin:unset;
}
</style>
        <header class="masthead">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-4 page-title">
                        <h3 class="text-white">List of House Models</h3>
                        <hr class="divider my-4" />

                    <div class="col-md-12 mb-2 justify-content-center">
                    </div>                        
                    </div>
                    
                </div>
            </div>
        </header>
        	<div class="container">
        		<div class="card mb-4 mt-4">
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-8">
		                    <div class="input-group mb-3">
		                      <div class="input-group-prepend">
		                        <span class="input-group-text" id="filter-field"><i class="fa fa-search"></i></span>
		                      </div>
		                      <input type="text" class="form-control" id="filter" placeholder="Filter name,course, etc." aria-label="Filter" aria-describedby="filter-field">
		                    </div>
		                </div>
		                <div class="col-md-4">
		                    <button class="btn btn-primary btn-block btn-sm" id="search">Search</button>
		                </div>
		            </div>
		            
		        </div>
		    </div>
        	</div>	
            <div class="container-fluid mt-3 pt-2">
               
                <div class="row-items">
                <div class="col-lg-12">
                    <div class="row">
                <?php
                $fpath = 'admin/assets/uploads/models/';
                $models = $conn->query("SELECT * FROM model_houses order by title asc");
                while($row = $models->fetch_assoc()):
                    $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                    unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                    $desc = strtr(html_entity_decode($row['description']),$trans);
                    $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
                ?>
                <div class="col-md-6 item">
                <div class="card models-list" data-id="<?php echo $row['id'] ?>">
                        <div class="models-img" card-img-top>

                            <img src="<?php echo $fpath.'/'.$row['cover'] ?>" alt="">
                        </div>
                    <div class="card-body">
                        <div class="row align-items-center justify-contents-center h-100">
                            <div class="w-100">
                                <div>
                                <p class="filter-txt"><b><?php echo $row['title'] ?></b></p>
                                <hr class="divider w-100" style="max-width: calc(100%)">
                                <p class="filter-txt truncate  w-100"><b><?php echo $desc ?></b></p>
                                <div class="row">
                                    <div class="col-md-12">
                                    <button class="btn float-right mr-4 btn-primary btn-sm view_model" type="button" data-id=<?php echo $row['id'] ?>>View</button>

                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
                <br>
                </div>
                <?php endwhile; ?>
                </div>
                </div>
                </div>
            </div>


<script>
    // $('.card.models-list').click(function(){
    //     location.href = "index.php?page=view_models&id="+$(this).attr('data-id')
    // })
    $('.view_model').click(function(){
       location.href= "index.php?page=view_model&id="+$(this).attr('data-id');
    })
    $('.models-img img').click(function(){
        viewer_modal($(this).attr('src'))
    })
     $('#filter').keypress(function(e){
    if(e.which == 13)
        $('#search').trigger('click')
   })
    $('#search').click(function(){
        var txt = $('#filter').val()
        start_load()
        if(txt == ''){
        $('.item').show()
        end_load()
        return false;
        }
        $('.item').each(function(){
            var content = "";
            $(this).find(".filter-txt").each(function(){
                content += ' '+$(this).text()
            })
            if((content.toLowerCase()).includes(txt.toLowerCase()) == true){
                $(this).toggle(true)
            }else{
                $(this).toggle(false)
            }
        })
        end_load()
    })

</script>