<!-- View Modal -->
<div class="modal fade" id="view_<?php echo $app->key_id; ?>">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $app->key_app_name; ?> Details</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body col-md-12">
                <ul class="list-group list-group-flush">
                    <p class="list-group-item">
                        ID : <?php echo $app->key_details; ?>
                    </p>
                    <p class="list-group-item">
                        Key : <?php echo $app->key_oauth_details; ?>
                    </p>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Udpate Modal -->
<div class="modal fade" id="update_<?php echo $app->key_id; ?>">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Fill All Required Fields</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>API Name</label>
                            <input type="text" name="key_app_name" value="<?php echo $app->key_app_name; ?>" required class="form-control">
                            <input type="hidden" name="key_id" value="<?php echo $app->key_id; ?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>API Key</label>
                            <input type="text" name="key_details" value="<?php echo $app->key_details; ?>" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>API OAuth Key</label>
                            <input type="text" name="key_oauth_details" value="<?php echo $app->key_oauth_details; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="text-right">
                        <button name="update_api" class="btn btn-primary" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="delete_<?php echo $app->key_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONFIRM DELETE</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body text-center text-danger">
                    <h4>Delete <?php echo $app->key_app_name; ?> ? </h4>
                    <br>
                    <!-- Hide This -->
                    <input type="hidden" name="key_id" value="<?php echo $app->key_id; ?>">
                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                    <input type="submit" name="delete_api" value="Delete" class="text-center btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->