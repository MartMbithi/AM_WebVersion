<!-- Udpate Modal -->
<div class="modal fade" id="update_<?php echo $materials->material_id; ?>">
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
                            <label>Reading Materials Topic / Title</label>
                            <input type="hidden" name="material_id" value="<?php echo $materials->material_id; ?>" required class="form-control">
                            <input type="text" value="<?php echo $materials->material_title; ?>" name="material_title" required class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Reading Materials Available From</label>
                            <input type="date" value="<?php echo $materials->material_available_from; ?>" name="material_available_from" required class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputFile">Reading Materials Attachments</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="material_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Reading Materials Details <small> Brief Description Of What This Notes Cover</small></label>
                            <textarea type="text" name="material_details" rows="10" required class="summernote form-control"><?php echo $materials->material_details ; ?></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button name="update_reading_materials" class="btn btn-primary" type="submit">
                            Upload Materials
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="delete_<?php echo $materials->material_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h4>Delete : <?php echo $materials->material_title; ?> Reading Materials ? </h4>
                    <br>
                    <!-- Hide This -->
                    <input type="hidden" name="material_id" value="<?php echo $materials->material_id; ?>">
                    <input type="hidden" name="material_attachments" value="<?php echo $materials->material_attachments; ?>">
                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                    <input type="submit" name="delete" value="Delete" class="text-center btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->