<?php
/*
 * Created on Wed Feb 23 2022
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
/* Add Past Paper */
if (isset($_POST['add_paper'])) {
    $paper_module_id = $_GET['view'];
    $paper_topic  = $_POST['paper_topic'];
    $paper_attachments = $_FILES['paper_attachments']['name'];
    $paper_user_id  = $_SESSION['user_id'];
    if (!empty($paper_attachments)) {
        $new_file_name = $paper_topic . ' ' . $paper_attachments;
        /* Upload Papers */
        $upload_directory = "../public/uploads/sys_data/pastpapers/" . $new_file_name;
        $temp_name = $_FILES["paper_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Persist */
        $sql = "INSERT INTO module_past_papers (paper_module_id, paper_user_id, paper_topic, paper_attachments) VALUES(?,?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssss',
            $paper_module_id,
            $paper_user_id,
            $paper_topic,
            $new_file_name
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$paper_topic, Uploaded";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Update Past Papers */
if (isset($_POST['update_paper'])) {
    $paper_id = $_POST['paper_id'];
    $paper_topic = $_POST['paper_topic'];
    $paper_attachments = $_FILES['paper_attachments']['name'];
    if (!empty($paper_attachments)) {
        $new_file_name = $paper_topic . ' ' . $paper_attachments;
        /* Upload Papers */
        $upload_directory = "../public/uploads/sys_data/pastpapers/" . $new_file_name;
        $temp_name = $_FILES["paper_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Persist */
        $sql = "UPDATE module_past_papers SET paper_topic =?, paper_attachments =? WHERE paper_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sss',
            $paper_topic,
            $new_file_name,
            $paper_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$paper_topic Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    } else {
        $sql = "UPDATE module_past_papers SET paper_topic =? WHERE paper_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ss',
            $paper_topic,
            $paper_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$paper_topic Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Delete Past Paper */
if (isset($_POST['delete'])) {
    $paper_id = $_POST['paper_id'];
    $paper_attachments = $_POST['paper_attachments'];
    if (!empty($paper_attachments)) {
        /* Purge From Main Directory */
        $purge = unlink("../public/uploads/sys_data/pastpapers/" . $paper_attachments);
        /* Load Delete */
        $sql = "DELETE FROM module_past_papers WHERE paper_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $paper_id);
        $prepare->execute();
        if ($prepare && $purge) {
            $success = "Past Paper Deleted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Update Visibility */
if (isset($_POST['update_visibility'])) {
    $paper_id = $_POST['paper_id'];
    $paper_status = $_POST['paper_status'];
    /* Pesist */
    $sql = "UPDATE module_past_papers SET paper_status =? WHERE paper_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('ss', $paper_status, $paper_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Paper Visibility Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}

require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/module_sidebar.php'); ?>
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
                                    <li class="breadcrumb-item active">Module Past Paper</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Module Past Papers</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Upload Past Papers</button>
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
                                            <input type="text" name="paper_topic" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_paper" class="btn btn-primary" type="submit">
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
                                <legend class="w-auto text-primary font-weight-light">Uploaded Past Papers</legend>
                                <?php
                                $module_id = $_GET['view'];
                                $ret = "SELECT * FROM module_past_papers mpp
                                INNER JOIN users u ON u.user_id = mpp.paper_user_id
                                WHERE paper_module_id = '$module_id'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($paper = $res->fetch_object()) {
                                ?>
                                    <div class="card mb-3" style="max-width: 100%;">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="../public/images/icons/exam.png" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $paper->paper_topic ?></h5>
                                                    <p class="card-text">
                                                    <figcaption class="blockquote-footer">
                                                        Uploaded By :
                                                        <cite class="text-success" title="Source Title">
                                                            <?php echo $paper->user_number . ' ' . $paper->user_name; ?>
                                                        </cite>
                                                    </figcaption>
                                                    <figcaption class="blockquote-footer">
                                                        Uploaded On :
                                                        <cite class="text-success" title="Source Title">
                                                            <?php echo date('d M Y g:ia', strtotime($paper->paper_uploaded_at)); ?>
                                                        </cite>
                                                    </figcaption>
                                                    <figcaption class="blockquote-footer">
                                                        Visibility Status :
                                                        <?php if ($paper->paper_status == 'hidden') { ?>
                                                            <cite class="text-danger" title="Source Title">
                                                                Not Available
                                                            </cite>
                                                        <?php } else { ?>
                                                            <cite class="text-success" title="Source Title">
                                                                Available
                                                            </cite>
                                                        <?php } ?>
                                                    </figcaption>
                                                    <br><br><br><br>
                                                    <div class="text-right">
                                                        <a data-toggle="modal" href="#status_<?php echo $paper->paper_id; ?>" class="badge badge-warning"><i class="fas fa-eye"></i> Update Visibility</a>
                                                        <a data-toggle="modal" href="#update_<?php echo $paper->paper_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a data-toggle="modal" href="#delete_<?php echo $paper->paper_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </div>
                                                    <hr>
                                                    <?php
                                                    if (!empty($paper->paper_attachments) && $paper->paper_status == 'available') {
                                                    ?>
                                                        <div class="text-center">
                                                            <a href="../public/uploads/sys_data/pastpapers/<?php echo $paper->paper_attachments; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i> Download</a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="text-center">
                                                            <button class="btn btn-outline-danger"><i class="fas fa-exclamation-circle"></i> Paper Not Available</button>
                                                        </div>
                                                    <?php } ?>
                                                    </p>
                                                    <!-- Load Modals -->
                                                    <?php require_once('../helpers/modals/manage_past_papers.php'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </fieldset>
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