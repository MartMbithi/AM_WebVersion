<!-- Udpate Modal -->
<div class="modal fade" id="update_<?php echo $paper->paper_id; ?>">
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
                            <label for="exampleInputFile">Past Papers Attachments</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="paper_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Past Paper Topic / Title</label>
                            <input type="hidden" name="paper_id" value="<?php echo $paper->paper_id; ?>" required class="form-control">
                            <input type="text" name="paper_topic" value="<?php echo $paper->paper_topic; ?>" required class="form-control">
                        </div>
                    </div>
                    <div class="text-right">
                        <button name="update_paper" class="btn btn-primary" type="submit">
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
<div class="modal fade" id="delete_<?php echo $paper->paper_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h4>Delete <?php echo $paper->paper_topic; ?> ? </h4>
                    <br>
                    <!-- Hide This -->
                    <input type="hidden" name="paper_id" value="<?php echo $paper->paper_id; ?>">
                    <input type="hidden" name="paper_attachments" value="<?php echo $paper->paper_attachments; ?>">
                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                    <input type="submit" name="delete" value="Delete" class="text-center btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->

<!-- Update Status -->
<div class="modal fade" id="status_<?php echo $paper->paper_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONFIRM VISIBILITY STATUS UPDATE</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body text-center text-danger">
                    <h4>
                        Update Visibility Status
                    </h4>
                    <br>
                    <!-- Hide This -->
                    <input type="hidden" name="paper_id" value="<?php echo $paper->paper_id; ?>">
                    <?php
                    if ($paper->paper_status == 'hidden') {
                    ?>
                        <input type="hidden" name="paper_status" value="available">
                    <?php } else { ?>
                        <input type="hidden" name="paper_status" value="hidden">
                    <?php } ?>
                    <input type="hidden" name="paper_id" value="<?php echo $paper->paper_id; ?>">
                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                    <input type="submit" name="update_visibility" value="Update" class="text-center btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->