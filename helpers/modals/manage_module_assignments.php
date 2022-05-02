<!-- Udpate Modal -->
<div class="modal fade" id="update_<?php echo $asn->asn_id; ?>">
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
                            <label>Topic / Title</label>
                            <input type="text" name="asn_title" value="<?php echo $asn->asn_title; ?>" required class="form-control">
                            <input type="hidden" name="asn_id" value="<?php echo $asn->asn_id; ?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Available From</label>
                            <input type="date" name="asn_available_from" value="<?php echo $asn->asn_available_from; ?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Submission Deadline</label>
                            <input type="date" name="asn_submission_deadline" value="<?php echo $asn->asn_submission_deadline; ?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputFile">Attachment</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="asn_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Instructions</label>
                            <textarea type="text" name="asn_details" rows="10" class="summernote form-control"><?php echo $asn->asn_details; ?></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button name="update_asn" class="btn btn-primary" type="submit">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="delete_<?php echo $asn->asn_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h4>Delete <?php echo $asn->asn_title; ?> ? </h4>
                    <br>
                    <!-- Hide This -->
                    <input type="hidden" name="asn_id" value="<?php echo $asn->asn_id; ?>">
                    <input type="hidden" name="asn_attachments" value="<?php echo $asn->asn_attachments; ?>">
                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                    <input type="submit" name="delete_asn" value="Delete" class="text-center btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->