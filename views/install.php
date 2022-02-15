<?php 
    require_once __DIR__ . "/header.php";
    // echo $name;
?>   
<div class="container"> <div class=" text-center mt-5 ">
    <h1>Install Loyalty App </h1>
</div>
<div class="row ">
    <div class="col-lg-7 mx-auto">
        <div class="card mt-2 mx-auto p-4 bg-light">
            <div class="card-body bg-light">
                <div class="container">
                    <form id="contact-form" role="form" method="POST" action="<?php echo root_path . "/?r=install/do_install"; ?>">
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="store_url">Store Url *</label> <input id="store_url" type="text" name="store_url" class="form-control" placeholder="Please enter your store url *" required="required" data-error="Store Url is required."> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="api_key">Api Key *</label> <input id="api_key" type="text" name="api_key" class="form-control" placeholder="Please enter your Api Key *" required="required" data-error="Api Key is required."> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="shared_secret">Shared Secret *</label> <input id="shared_secret" type="text" name="shared_secret" class="form-control" placeholder="Please enter your Shared Secret *" required="required" data-error="Shared Secret is required."> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="pw_production">PW Production *</label> <input id="pw_production" type="text" name="pw_production" class="form-control" placeholder="Please enter your PW Production *" required="required" data-error="PW Production is required."> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="pw_product_name">PW Product Name *</label> <input id="pw_product_name" type="text" name="pw_product_name" class="form-control" placeholder="Please enter your PW Product Name *" required="required" data-error="PW Product Name is required."> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="pw_slug">PW Slug *</label> <input id="pw_slug" type="text" name="pw_slug" class="form-control" placeholder="Please enter your PW Slug *" required="required" data-error="PW Slug Name is required."> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="pw_client_authorization">PW Client Authorization *</label> <input id="pw_client_authorization" type="text" name="pw_client_authorization" class="form-control" placeholder="Please enter your PW Client Authorization *" required="required" data-error="PW Client Authorization is required."> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="Install"> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- /.8 -->
    </div> <!-- /.row-->
</div>
<?php 
    require_once __DIR__ . "/footer.php";
?>   
