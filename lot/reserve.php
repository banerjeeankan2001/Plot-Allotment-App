<div class="container-fluid">
    <div class="col-lg-12">
        <form action="" id="manage-reserve">
        <input type="hidden" name="lot_id" value=<?php echo $_GET['lot_id'] ?>>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="" class="control-label">Last Name</label>
                    <input type="text" name="lastname" required class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="" class="control-label">First Name</label>
                    <input type="text" name="firstname" required class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="" class="control-label">Middle Name</label>
                    <input type="text" name="middlename" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="" class="control-label">Email</label>
                    <input type="email" name="email" required class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="" class="control-label">Contact #</label>
                    <input type="text" name="contact" required class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="" class="control-label">Address</label>
                    <textarea cols="30" rows="5" name="address" required class="form-control"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="" class="control-label">Message</label>
                    <textarea cols="30" rows="5" name="message" required class="form-control"></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$('#manage-reserve').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
        url:'admin/ajax.php?action=save_reserve',
        method:'POST',
        data:$(this).serialize(),
        success:function(resp){
            if(resp == 1){
                alert_toast('Reservation for the selected Area/Lot successfully sent.','success')
                setTimeout(function(){
                    location.reload()
                },1000)
            }
        }
    })
})
</script>