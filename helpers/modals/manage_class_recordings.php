<!-- Udpate Modal -->
<div class="modal fade" id="update_<?php echo $rec->recording_id; ?>">
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
                        <div class="form-group col-md-6">
                            <label>Recording Topic / Title</label>
                            <input type="hidden" value="<?php echo $rec->recording_id; ?>" name="recording_id" required class="form-control">
                            <input type="text" value="<?php echo $rec->recording_title; ?>" name="recording_title" required class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputFile">Recording Clip</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="recording_clip" accept=".MP4, .MOV, .WMV, .FLV" type="file" class="custom-file-input">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Recording Details <small> Brief Description Of What This Recordings Cover</small></label>
                            <textarea type="text" name="recording_desc" rows="10" required class="summernote form-control"><?php echo $rec->recording_desc; ?></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button name="update_recording" class="btn btn-primary" type="submit">
                            Update Class Recordings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Udpate Modal -->
<div class="modal fade" id="update_clip_<?php echo $rec->recording_id; ?>">
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
                            <label>Recording Topic / Title</label>
                            <input type="text" value="<?php echo $rec->recording_title; ?>" name="recording_title" required class="form-control">
                            <input type="hidden" value="<?php echo $rec->recording_id; ?>" name="recording_id" required class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Recording Link | Stream Link</label>
                            <textarea type="text" rows="2" name="recording_stream_link" required class="form-control"><?php echo $rec->recording_stream_link; ?></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Recording Details <small> Brief Description Of What This Recordings Cover</small></label>
                            <textarea type="text" name="recording_desc" rows="10" required class="summernote form-control"><?php echo $rec->recording_desc; ?></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <button name="update_recording" class="btn btn-primary" type="submit">
                            Update Class Recordings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="delete_<?php echo $rec->recording_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h4>Delete <?php echo $rec->recording_title; ?> Class Recording ? </h4>
                    <br>
                    <!-- Hide This -->
                    <input type="hidden" name="recording_id" value="<?php echo $rec->recording_id; ?>">
                    <input type="hidden" name="recording_clip" value="<?php echo $rec->recording_clip; ?>">
                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                    <input type="submit" name="delete_recording" value="Delete" class="text-center btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->