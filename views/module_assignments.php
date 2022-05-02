<?php

/*
 * Created on Sun Jan 16 2022
 *
 *  Devlan - devlan.co.ke 
 *
 * hello@devlan.info
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan
 *
 * 1. GRANT OF LICENSE
 * Devlan hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan and protected by copyright law and international copyright treaties. 
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
 * Devlan  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * Devlan SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
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
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
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

/* Add Module Assnment */
if (isset($_POST['add_asn'])) {
    $asn_module_id = $_POST['asn_module_id'];
    $asn_title = $_POST['asn_title'];
    $asn_details = $_POST['asn_details'];
    $asn_available_from = $_POST['asn_available_from'];
    $asn_submission_deadline = $_POST['asn_submission_deadline'];
    $asn_attachments = $_FILES['asn_attachments']['name'];
    /* Check If The Assignment Has An Attachment */
    if (!empty($asn_attachments)) {
        /* Upload The Attachments */
        $new_file_name = $asn_title . ' ' . $asn_attachments;/* Add Assnment Title On The Document Name */
        $upload_directory = "../public/uploads/sys_data/module_assignments/" . $new_file_name;
        $temp_name = $_FILES["asn_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);
        /* Persist  */
        $sql = "INSERT INTO module_assaignments (asn_module_id, asn_title, asn_details, asn_available_from, asn_submission_deadline,
        asn_attachments) VALUES(?,?,?,?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssssss',
            $asn_module_id,
            $asn_title,
            $asn_details,
            $asn_available_from,
            $asn_submission_deadline,
            $new_file_name
        );
        $prepare->execute();
        /* To Do Mail All Enrolled Students That An Assignment Has Been Uploaded */
        if ($prepare) {
            $success = "$asn_title Uploaded";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        /* Persist Asn With No Attachments */
        $sql = "INSERT INTO module_assaignments (asn_module_id, asn_title, asn_details, asn_available_from, asn_submission_deadline) VALUES(?,?,?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sssss',
            $asn_module_id,
            $asn_title,
            $asn_details,
            $asn_available_from,
            $asn_submission_deadline,
        );
        $prepare->execute();
        /* To Do Mail All Enrolled Students That An Assignment Has Been Uploaded */
        if ($prepare) {
            $success = "$asn_title Uploaded";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Update Assnment */
if (isset($_POST['update_asn'])) {
    $asn_id = $_POST['asn_id'];
    $asn_title = $_POST['asn_title'];
    $asn_details = $_POST['asn_details'];
    $asn_available_from = $_POST['asn_available_from'];
    $asn_submission_deadline = $_POST['asn_submission_deadline'];
    $asn_attachments = $_FILES['asn_attachments']['name'];
    /* Check If The Assignment Has An Attachment */
    if (!empty($asn_attachments)) {
        /* Upload The Attachments */
        $new_file_name = $asn_title . ' ' . $asn_attachments;/* Add Assnment Title On The Document Name */
        $upload_directory = "../public/uploads/sys_data/module_assignments/" . $new_file_name;
        $temp_name = $_FILES["asn_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);
        /* Persist  */
        $sql = "UPDATE module_assaignments SET asn_title =?, asn_details =?, asn_available_from =?, asn_submission_deadline =?, asn_attachments =?
        WHERE asn_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssssss',
            $asn_title,
            $asn_details,
            $asn_available_from,
            $asn_submission_deadline,
            $new_file_name,
            $asn_id

        );
        $prepare->execute();
        if ($prepare) {
            $success = "$asn_title Updated";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        /* Persist Asn With No Attachments */
        $sql = "UPDATE module_assaignments SET asn_title =?, asn_details =?, asn_available_from =?, asn_submission_deadline =? WHERE asn_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sssss',
            $asn_title,
            $asn_details,
            $asn_available_from,
            $asn_submission_deadline,
            $asn_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$asn_title Updated";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Delete Assnmant */
if (isset($_POST['delete_asn'])) {
    $asn_id = $_POST['asn_id'];
    /* If Has Attachment - Purge It */
    if (!empty($_POST['asn_attachments'])) {
        $purge = unlink("../public/uploads/sys_data/module_assignments/" . $_POST['asn_attachments']);
        /* Load Delete Logic */
        $sql = "DELETE FROM module_assaignments WHERE asn_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $asn_id);
        $prepare->execute();
        if ($prepare && $purge) {
            $success = "Assingment Deleted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        /* Purge If They Has No Attachment */
        $sql = "DELETE FROM module_assaignments WHERE asn_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $asn_id);
        $prepare->execute();
        if ($prepare) {
            $success = "Assingment Deleted";
        } else {
            $err = "Failed!, Please Try Again Later";
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
                                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Modules</a></li>
                                    <li class="breadcrumb-item active">Module Assignments</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Module Assignments</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Upload Module Assignments</button>
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
                                        <div class="form-group col-md-6">
                                            <label>Module Name</label>
                                            <select name="asn_module_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop All Courses In Asc Order */
                                                $ret = "SELECT * FROM module_allocations ma
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
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
                                            <label>Topic / Title</label>
                                            <input type="text" name="asn_title" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Available From</label>
                                            <input type="date" name="asn_available_from" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Submission Deadline</label>
                                            <input type="date" name="asn_submission_deadline" required class="form-control">
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
                                            <textarea type="text" name="asn_details" rows="10" class="summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_asn" class="btn btn-primary" type="submit">
                                            Upload
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
                                <legend class="w-auto text-primary font-weight-light">Select Module Code & Name To Manage Uploaded Assignments</legend>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select name="module_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Module</option>
                                                <?php
                                                /* Pop All Modules */
                                                $ret = "SELECT * FROM modules                                 
                                                ORDER BY module_code ASC  ";
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
                                    <legend class="w-auto text-primary font-weight-light">Uploaded Module Assignments</legend>
                                    <?php
                                    $module_id = $_POST['module_id'];
                                    $ret = "SELECT * FROM module_assaignments ma 
                                    INNER JOIN modules m ON m.module_id = ma.asn_module_id
                                    WHERE m.module_id = '$module_id'
                                    ORDER BY ma.asn_created_at  DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($asn = $res->fetch_object()) {
                                    ?>
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row g-0">
                                                <div class="col-md-12">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $asn->asn_title; ?></h5>
                                                        <p class="card-text">
                                                            <?php echo $asn->asn_details; ?>
                                                        </p>
                                                        <?php
                                                        if (!empty($asn->asn_attachments)) {
                                                            /* Show Download Atachment */
                                                        ?>
                                                            <div class="text-center">
                                                                <a href="../public/uploads/sys_data/module_assignments/<?php echo $asn->asn_attachments; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i> Download Assingment Attachment</a>
                                                            </div>
                                                            <hr>
                                                        <?php } ?>
                                                        <p class="card-text">
                                                            <figcaption class="blockquote-footer">
                                                                Submission Deadline :
                                                                <cite class="text-danger" title="Source Title">
                                                                    <?php echo date('d M Y g:ia', strtotime($asn->asn_submission_deadline)); ?>,
                                                                </cite>
                                                            </figcaption>
                                                            <figcaption class="blockquote-footer">
                                                                Available From :
                                                                <cite class="text-primary" title="Source Title">
                                                                    <?php echo date('d M Y g:ia', strtotime($asn->asn_available_from)); ?>,
                                                                </cite>
                                                            </figcaption>
                                                            <figcaption class="blockquote-footer">
                                                                Uploaded On :
                                                                <cite class="text-primary" title="Source Title">
                                                                    <?php echo date('d M Y g:ia', strtotime($asn->asn_created_at)); ?>
                                                                </cite>
                                                            </figcaption>
                                                            <div class="text-right">
                                                                <a href="module_assignment?view=<?php echo $asn->asn_id; ?>" class="badge badge-primary"><i class="fas fa-eye"></i> View Attempts</a>
                                                                <a data-toggle="modal" href="#update_<?php echo $asn->asn_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                <a data-toggle="modal" href="#delete_<?php echo $asn->asn_id ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                            </div>
                                                        </p>
                                                        <!-- Load Modals -->
                                                        <?php include('../helpers/modals/manage_module_assignments.php'); ?>
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