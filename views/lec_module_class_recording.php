<?php
/*
 * Created on Wed Mar 02 2022
 *
 *  Devlan Agency - devlan.co.ke 
 *
 * hello@devlan.co.ke
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan Agency
 *
 * 1. GRANT OF LICENSE
 * Devlan Agency hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan Agency. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan Agency.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan Agency and protected by copyright law and international copyright treaties. 
 * You may not remove or conceal any proprietary notices, labels or marks from the Software.
 *
 * 3. RESTRICTIONS ON USE
 * You may not, and you may not permit others to
 * (a) reverse engineer, decompile, decode, decrypt, disassemble, or in any way derive source code from, the Software;
 * (b) modify, distribute, or create derivative works of the Software;
 * (c) copy (other than one back-up copy), distribute, publicly display, transmit, sell, rent, lease or 
 * otherwise exploit the Software.  
 *
 * 4. TERM
 * This License is effective until terminated. 
 * You may terminate it at any time by destroying the Software, together with all copies thereof.
 * This License will also terminate if you fail to comply with any term or condition of this Agreement.
 * Upon such termination, you agree to destroy the Software, together with all copies thereof.
 *
 * 5. NO OTHER WARRANTIES. 
 * DEVLAN AGENCY  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * DEVLAN AGENCY SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
 * EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT OF THIRD PARTY RIGHTS. 
 * SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES OR LIMITATIONS
 * ON HOW LONG AN IMPLIED WARRANTY MAY LAST, OR THE EXCLUSION OR LIMITATION OF 
 * INCIDENTAL OR CONSEQUENTIAL DAMAGES,
 * SO THE ABOVE LIMITATIONS OR EXCLUSIONS MAY NOT APPLY TO YOU. 
 * THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS AND YOU MAY ALSO 
 * HAVE OTHER RIGHTS WHICH VARY FROM JURISDICTION TO JURISDICTION.
 *
 * 6. SEVERABILITY
 * In the event of invalidity of any provision of this license, the parties agree that such invalidity shall not
 * affect the validity of the remaining portions of this license.
 *
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN AGENCY  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
 * CONSEQUENTIAL, SPECIAL, INCIDENTAL OR INDIRECT DAMAGES OF ANY KIND ARISING OUT OF THE DELIVERY, PERFORMANCE OR 
 * USE OF THE SOFTWARE, EVEN IF DEVLAN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES
 * IN NO EVENT WILL DEVLAN  LIABILITY FOR ANY CLAIM, WHETHER IN CONTRACT 
 * TORT OR ANY OTHER THEORY OF LIABILITY, EXCEED THE LICENSE FEE PAID BY YOU, IF ANY.
 */

session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();
require_once('../config/codeGen.php');


/* Module Class Recordings */
if (isset($_POST['upload_recording'])) {
    $recording_module_id = $_POST['recording_module_id'];
    $recording_uploaded_by = $_SESSION['user_id'];
    $recording_title = $_POST['recording_title'];
    $recording_desc = $_POST['recording_desc'];
    $recording_clip = time() . $_FILES['recording_clip']['name'];
    $upload_directory = "../public/uploads/sys_data/class_recordings/" . $recording_clip;
    $temp_name = $_FILES["recording_clip"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory);

    /* Persist Upload */
    $sql  = "INSERT INTO class_recordings (recording_module_id, recording_uploaded_by, recording_title, recording_desc, recording_clip)
    VALUES(?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $recording_module_id,
        $recording_uploaded_by,
        $recording_title,
        $recording_desc,
        $recording_clip
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Module Class Recording Uploaded";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Share Class Recording */
if (isset($_POST['share_recording'])) {
    $recording_module_id = $_POST['recording_module_id'];
    $recording_uploaded_by = $_SESSION['user_id'];
    $recording_title = $_POST['recording_title'];
    $recording_desc = $_POST['recording_desc'];
    $recording_stream_link  = $_POST['recording_stream_link'];

    /* Pesist Link */
    $sql  = "INSERT INTO class_recordings (recording_module_id, recording_uploaded_by, recording_title, recording_desc, recording_stream_link)
    VALUES(?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $recording_module_id,
        $recording_uploaded_by,
        $recording_title,
        $recording_desc,
        $recording_stream_link
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Module Class Stream Link Shared";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Module Recordings */
if (isset($_POST['update_recording'])) {
    $recording_id = $_POST['recording_id'];
    $recording_title = $_POST['recording_title'];
    $recording_desc = $_POST['recording_desc'];
    $recording_clip = $_FILES['recording_clip']['name'];
    $recording_stream_link = $_POST['recording_stream_link'];

    /* Check If Blank*/
    if (!empty($recording_clip)) {
        $upload_directory = "../public/uploads/sys_data/class_recordings/" . $recording_clip;
        $temp_name = $_FILES["recording_clip"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Update */
        $sql  = "UPDATE  class_recordings SET  recording_title =?, recording_desc =?, recording_clip =? WHERE recording_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssss',
            $recording_title,
            $recording_desc,
            $recording_clip,
            $recording_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Module Class Recording Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    } else {
        $sql  = "UPDATE  class_recordings SET  recording_title =?, recording_desc =?, recording_stream_link =? WHERE recording_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssss',
            $recording_title,
            $recording_desc,
            $recording_stream_link,
            $recording_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Module Class Recording Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Delete Class Recordings */
if (isset($_POST['delete_recording'])) {
    $recording_id = $_POST['recording_id'];
    if (!empty($_POST['recording_clip'])) {
        /* Purge */
        $purge = unlink("../public/uploads/sys_data/class_recordings/" . $_POST['recording_clip']);
        $sql = "DELETE FROM class_recordings WHERE recording_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            's',
            $recording_id
        );
        $prepare->execute();
        if ($prepare && $purge) {
            $success = "Module Class Recording Deleted";
        } else {
            $err = "Failed!, Please Try Again";
        }
    } else {
        $sql = "DELETE FROM class_recordings WHERE recording_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            's',
            $recording_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Module Class Recording Deleted";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/sidebar.php'); ?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php require_once('../partials/topbar.php'); ?>
    <!-- Top Bar End -->

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content-tab">

            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="float-right">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="lec_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Modules</a></li>
                                    <li class="breadcrumb-item active">Module Class Recording</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Module Class Recordings</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                        </div>
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_embed" class="btn btn-primary">Stream Class Recording Link</button>
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Directly Upload Class Recordings</button>
                        </div>
                        <hr>
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->
                <!-- Add Departmental Memo Modal -->
                <div class="modal fade" id="add_modal">
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
                                            <label>Module Name</label>
                                            <select name="recording_module_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop All Courses In Asc Order */
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM module_allocations ma
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ma.allocation_user_id = '$user_id' AND ac.calendar_status = 'Current'
                                                ORDER BY m.module_code ASC ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($modules = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $modules->module_id; ?>"><?php echo $modules->module_code . ' - ' . $modules->module_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Recording Topic / Title</label>
                                            <input type="text" name="recording_title" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">Recording Clip</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="recording_clip" required accept=".MP4, .MOV, .WMV, .FLV" type="file" class="custom-file-input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Recording Details <small> Brief Description Of What This Recordings Cover</small></label>
                                            <textarea type="text" name="recording_desc" rows="10" required class="summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="upload_recording" class="btn btn-primary" type="submit">
                                            Upload Class Recordings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="add_embed">
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
                                            <label>Module Name</label>
                                            <select name="recording_module_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop All Courses In Asc Order */
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM module_allocations ma
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ma.allocation_user_id = '$user_id' AND ac.calendar_status = 'Current'
                                                ORDER BY m.module_code ASC ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($modules = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $modules->module_id; ?>"><?php echo $modules->module_code . ' - ' . $modules->module_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Recording Topic / Title</label>
                                            <input type="text" name="recording_title" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Recording Link | Stream Link</label>
                                            <input type="text" name="recording_stream_link" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Recording Details <small> Brief Description Of What This Recordings Cover</small></label>
                                            <textarea type="text" name="recording_desc" rows="10" required class="summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="share_recording" class="btn btn-primary" type="submit">
                                            Upload Class Recordings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <fieldset class="border border-primary p-2">
                                <legend class="w-auto text-primary font-weight-light">Select Module Code & Name To View Uploaded Class Recording</legend>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select name="module_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Module</option>
                                                <?php
                                                /* Pop All Modules */
                                                $ret = "SELECT * FROM module_allocations ma
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ma.allocation_user_id = '$user_id' AND ac.calendar_status = 'Current'
                                                ORDER BY m.module_code ASC ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($module = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $module->module_id; ?>"><?php echo $module->module_code . ' - ' . $module->module_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="search" class="btn btn-primary" type="submit">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </fieldset>
                            <!-- Get All Departmental Memos Posted On Selected Department -->
                            <hr>
                            <?php
                            if (isset($_POST['search'])) {
                            ?>
                                <fieldset class="border border-primary p-2">
                                    <legend class="w-auto text-primary font-weight-light">Uploaded Module Class Recordings</legend>
                                    <?php
                                    $module_id = $_POST['module_id'];
                                    $user_id  = $_SESSION['user_id'];
                                    $ret = "SELECT * FROM class_recordings cr
                                    INNER JOIN modules m ON m.module_id = cr.recording_module_id
                                    INNER JOIN module_allocations ma ON ma.allocation_module_id = m.module_id
                                    INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                    WHERE cr.recording_module_id = '$module_id' AND ma.allocation_user_id = '$user_id'
                                    AND ac.calendar_status = 'Current' ORDER BY cr.recording_date_uploaded DESC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($rec = $res->fetch_object()) {
                                    ?>
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row g-0">
                                                <div class="col-md-8">
                                                    <!-- Load Clip Here  If There Is An Atachent-->
                                                    <?php
                                                    if (!empty($rec->recording_clip)) { ?>
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <video controls class="embed-responsive-item" src="../public/uploads/sys_data/class_recordings/<?php echo $rec->recording_clip; ?>" allowfullscreen>
                                                        </div>
                                                    <?php } else { ?>
                                                        <!-- Load Embed Here -->
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <?php echo $rec->recording_stream_link; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $rec->recording_title; ?></h5>
                                                        <p class="card-text">
                                                            <?php echo $rec->recording_desc; ?>
                                                        </p>
                                                        <p class="card-text">
                                                        <figcaption class="blockquote-footer">
                                                            Uploaded On :
                                                            <cite class="text-success" title="Source Title">
                                                                <?php echo date('d M Y g:ia', strtotime($rec->recording_date_uploaded)); ?>
                                                            </cite>
                                                        </figcaption>
                                                        <div class="text-right">
                                                            <?php if (!empty($rec->recording_clip)) { ?>
                                                                <a data-toggle="modal" href="#update_<?php echo $rec->recording_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <?php } else { ?>
                                                                <a data-toggle="modal" href="#update_clip_<?php echo $rec->recording_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <?php } ?>
                                                            <a data-toggle="modal" href="#delete_<?php echo $rec->recording_id ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                        <hr>
                                                        </p>
                                                        <!-- Load Modals -->
                                                        <?php include('../helpers/modals/manage_class_recordings.php'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </fieldset>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div><!-- container -->
            <!-- Footer -->
            <?php require_once('../partials/footer.php'); ?>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->
    <!-- Scripts -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>