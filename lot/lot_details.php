<?php include 'admin/db_connect.php' ?>
<?php
    $type_arr=array('',"Lot Only","House and Lot");
    $qry = $conn->query("SELECT * FROM lots where id =".$_GET['id']);
    foreach($qry->fetch_array() as $k=>$v){
        $$k = $v;
    }
?>
<div class="container-fluid">
    <p>Lot: <b><?php echo ucwords($lot) ?></b></p>
    <p>Type: <b><?php echo ucwords($type_arr[$type]) ?></b></p>
    <p>Price: <b><?php echo number_format($price,2) ?></b></p>
    <div>
        <?php echo html_entity_decode($details) ?>
    </div>
    <button class="btn btn-primary" id="reserve" type="button">Reserve</button>
</div>
<script>
$('#reserve').click(function(){
    uni_modal('Reserve Area',"reserve.php?lot_id=<?php echo $id ?>",'mid-large')
})
</script>