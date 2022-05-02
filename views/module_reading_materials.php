<?php
/*
 * Created on Fri Jan 07 2022
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
/* Add Reading Materials */
if (isset($_POST['add_reading_materials'])) {
    $material_module_id  = $_POST['material_module_id'];
    $material_title  = $_POST['material_title'];
    $material_details = $_POST['material_details'];
    $material_available_from = $_POST['material_available_from'];
    $module = $a . $b;
    $material_attachments = $_FILES['material_attachments']['name'];
    /* Check if material attachments is empty if it is skip this */
    if (!empty($material_attachments)) {
        $new_name  = $module . ' ' . $material_attachments;
        $upload_directory = "../public/uploads/sys_data/reading_materials/" . $new_name;
        $temp_name = $_FILES["material_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);
    }


    /* Persist  */
    $sql = "INSERT INTO module_reading_materials (material_module_id, material_title, material_details, material_available_from,  material_attachments)
    VALUES(?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $material_module_id,
        $material_title,
        $material_details,
        $material_available_from,
        $new_name
    );
    $prepare->execute();
    if ($prepare) {
        $success = $material_title . " Uploaded";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Reading Materials */
if (isset($_POST['update_reading_materials'])) {
    $material_id  = $_POST['material_id'];
    $material_title  = $_POST['material_title'];
    $material_details = $_POST['material_details'];
    $material_available_from = $_POST['material_available_from'];
    $material_attachments = $_FILES['material_attachments']['name'];
    $module = $a . $b;
    /* Check if material attachments is empty if it is skip this */
    if (!empty($material_attachments)) {
        $new_name  = $module . ' ' . $material_attachments;
        $upload_directory = "../public/uploads/sys_data/reading_materials/" . $new_name;
        $temp_name = $_FILES["material_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);
        /* Persist If Attachment Is Detected */
        $sql  = "UPDATE  module_reading_materials SET material_title =?, material_details =?, material_attachments =?, material_available_from =? WHERE material_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sssss',
            $material_title,
            $material_details,
            $new_name,
            $material_available_from,
            $material_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = $material_title . " Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    } else {
        /* Persist  If No Attachment Detected*/
        $sql  = "UPDATE  module_reading_materials SET material_title =?, material_details =?, material_available_from =? WHERE material_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssss',
            $material_title,
            $material_details,
            $material_available_from,
            $material_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = $material_title . " Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Delete Reading Materials */
if (isset($_POST['delete'])) {
    $material_id = $_POST['material_id'];
    if (!empty($_POST['material_attachments'])) {
        $purge  = unlink('../public/uploads/sys_data/reading_materials/' . $_POST['material_attachments']);
        /* Delete */
        $sql = "DELETE FROM  module_reading_materials WHERE material_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $material_id);
        $prepare->execute();

        if ($prepare && $purge) {
            $success = "Reading Materials Deleted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        $sql = "DELETE FROM  module_reading_materials WHERE material_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $material_id);
        $prepare->execute();

        if ($prepare) {
            $success = "Reading Materials Deleted";
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
                                    <li class="breadcrumb-item active">Module Reading Materials</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Module Reading Materials</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Upload Module Reading Materials</button>
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
                                            <select name="material_module_id" style="width: 100%;" required class="basic form-control">
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
                                            <label>Reading Materials Topic / Title</label>
                                            <input type="text" name="material_title" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Reading Materials Available From</label>
                                            <input type="date" name="material_available_from" required class="form-control">
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
                                            <textarea type="text" name="material_details" rows="10" required class="summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_reading_materials" class="btn btn-primary" type="submit">
                                            Upload Materials
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
                                <legend class="w-auto text-primary font-weight-light">Select Module Code & Name To View Posted Reading Materials</legend>
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
                                    <legend class="w-auto text-primary font-weight-light">Uploaded Reading Materials</legend>
                                    <?php
                                    $module_id = $_POST['module_id'];
                                    $ret = "SELECT * FROM module_reading_materials mrm
                                    WHERE material_module_id = '$module_id'
                                    ORDER BY material_created_at DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($materials = $res->fetch_object()) {
                                    ?>
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="../public/images/icons/books.png" width="90%" class="img-fluid img-thumbnail rounded-start" alt="...">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $materials->material_title; ?></h5>
                                                        <p class="card-text">
                                                            <?php echo $materials->material_details; ?>
                                                        </p>
                                                        <p class="card-text">
                                                            <figcaption class="blockquote-footer">
                                                                Uploaded On :
                                                                <cite class="text-success" title="Source Title">
                                                                    <?php echo date('d M Y g:ia', strtotime($materials->material_created_at)); ?>
                                                                </cite>
                                                            </figcaption>
                                                            <?php
                                                            if (!empty($materials->material_available_from)) {
                                                            ?>
                                                                <figcaption class="blockquote-footer">
                                                                    Available From :
                                                                    <cite class="text-success" title="Source Title">
                                                                        <?php echo date('d M Y g:ia', strtotime($materials->material_available_from)); ?>
                                                                    </cite>
                                                                </figcaption>
                                                            <?php }
                                                            ?>
                                                            <div class="text-right">
                                                                <a data-toggle="modal" href="#update_<?php echo $materials->material_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                <a data-toggle="modal" href="#delete_<?php echo $materials->material_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                            </div>
                                                            <hr>
                                                            <?php
                                                            if (!empty($materials->material_attachments)) {
                                                                /* Show Download Button */
                                                            ?>
                                                                <div class="text-center">
                                                                    <a href="../public/uploads/sys_data/reading_materials/<?php echo $materials->material_attachments; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i> Download</a>
                                                                </div>
                                                            <?php } ?>
                                                        </p>
                                                        <!-- Load Modals -->
                                                        <?php include('../helpers/modals/manage_reading_materials.php'); ?>
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