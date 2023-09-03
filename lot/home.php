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
.event-list{
cursor: pointer;
}
span.hightlight{
    background: yellow;
}
.banner{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 26vh;
        width: calc(30%);
    }
    .banner img{
        width: calc(100%);
        height: calc(100%);
        cursor :pointer;
    }
.event-list{
cursor: pointer;
border: unset;
flex-direction: inherit;
}

.event-list .banner {
    width: calc(40%)
}
.event-list .card-body {
    width: calc(60%)
}
.event-list .banner img {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    min-height: 50vh;
}
span.hightlight{
    background: yellow;
}
.banner{
   min-height: calc(100%)
}
</style>
        <header class="masthead">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-4 page-title">
                    	<h3 class="text-white">Welcome to <?php echo $_SESSION['system']['name']; ?></h3>
                        <hr class="divider my-4" />

                    <div class="col-md-12 mb-2 justify-content-center">
                    </div>                        
                    </div>
                    
                </div>
            </div>
        </header>
            <div class="container mt-3 pt-2">
                <h4 class="text-center text-white">Find Lot/House</h4>
                <hr class="divider">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="find_lot" method="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="control-label">Price Range</label>
                                    <select name="range" id="" class="custom-select">
                                    <?php 
                                    $start = 0;
                                    for($i = 0;$i < 10 ;$i++):    
                                    ?>
                                        <option class="text-right" <?php echo isset($_GET['range']) && $_GET['range'] == (number_format($start,0,'.','') .'-'.number_format($start > 0 ? $start+99999:$start+100000,0,'.',''))? " selected" : '' ?>><?php echo number_format($start) .'-'.number_format($start > 0 ? $start+99999:$start+100000) ?></option>
                                    <?php 
                                    if($start == 0)
                                    $start = $start + 100001;
                                    else
                                    $start = $start + 100000;
                                    endfor;
                                    ?>
                                    <option class="text-right"<?php echo isset($_GET['range']) && $_GET['range'] == '1,000,000-Above' ? " selected" : '' ?>>1,000,000-Above</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="control-label">Type</label>
                                    <select name="type" id="" class="custom-select">
                                        <option value="1" <?php echo isset($_GET['range']) && $_GET['range'] == 1? " selected" : '' ?>>Lot only</option>
                                        <option value="2" <?php echo isset($_GET['range']) && $_GET['range'] == 2? " selected" : '' ?>>House and Lot</option>
                                        <option value="0" <?php echo isset($_GET['range']) && $_GET['range'] == 0? " selected" : '' ?>>Both</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="float-right btn btn-primary">Find</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <?php 
                if(isset($_GET['find'])):
                ?>
                <div class="col-lg-12 mb-4">
                    <div class="row">
                        <?php 
                            $type = array('',"Lot Only","House and Lot"); 
                            $where ='';
                            if(isset($_GET['range'])){
                                $ex = explode('-',str_replace(',','',$_GET['range']));
                                if(is_numeric($ex[1]))
                                    $where .= " and l.price between '{$ex[0]}' and '{$ex[1]}' ";
                                else
                                    $where .= " and l.price >= '{$ex[0]}' ";
                            }
                            if(isset($_GET['type']) && $_GET['type'] > 0){
                                    $where .= " and l.type = '{$_GET['type']}' ";
                            }

                            $lots = $conn->query("SELECT l.*,d.name as dname FROM lots l inner join division d on d.id = l.division_id where l.status = 1 $where order by l.lot asc ");
                            if($lots->num_rows > 0):
                            while($row=$lots->fetch_assoc()):
                                $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                                unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                                $desc = strtr(html_entity_decode($row['details']),$trans);
                                $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
                        ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p>Lot: <b><?php echo ucwords($row['lot'].', '.$row['dname']) ?></b></p>
                                    <p>Type: <b><?php echo $type[$row['type']] ?></b></p>
                                    <p>Price: <b><?php echo number_format($row['price'],2) ?></b></p>
                                    <div class="truncate"><small><?php echo strip_tags($desc) ?></small></div>
                                    <button class="btn  btn-sm btn-primary float-right view" type="button" data-id="<?php echo $row['id'] ?>">View</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <center>Sorry, there is no Area/Lot found with the given data.</center>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                    
                <?php endif; ?>

            </div>


<script>
     $('.view').click(function(){
        uni_modal("Area/Lot Details","lot_details.php?view=1&id="+$(this).attr('data-id'),'mid-large')
     })
    $('#find_lot').submit(function(e){
        e.preventDefault()
        start_load()
        var r = $('[name="range"]').val()
        var t = $('[name="type"]').val()
            r = r.replace(/,/g,'');
        location.href = "index.php?page=home&find=1&range="+r+"&type="+t;
    })
</script>