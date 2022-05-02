<?php
/*
 * Created on Mon Jan 17 2022
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
/* Add Marks Entry */
if (isset($_POST['add_submission'])) {
    $att_user_id = $_SESSION['user_id'];
    $att_asn_id = $_GET['asn_id'];
    $attn_attachments   = $_FILES['attn_attachments']['name'];
    /* Assing Random Codes On This */
    $new_file_name = $a . $b . ' ' . $attn_attachments;
    $upload_directory = "../public/uploads/sys_data/module_assignment_attempts/" . $new_file_name;
    $temp_name = $_FILES["attn_attachments"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory);

    /* Pesist */
    $sql = "INSERT INTO module_assingments_attempts (att_user_id, att_asn_id , attn_attachments) VALUES(?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sss',
        $att_user_id,
        $att_asn_id,
        $new_file_name
    );
    $prepare->execute();
    /* To Do Mail Student Tell Them Assignment Has Been Submitted */
    if ($prepare) {
        $success = "Assignment Attempt Uploaded";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update */
if (isset($_POST['update_attempt'])) {
    $att_id = $_POST['att_id'];
    $attn_attachments   = $_FILES['attn_attachments']['name'];
    if (!empty($attn_attachments)) {
        $new_file_name = $a . $b . ' ' . $attn_attachments;
        $upload_directory = "../public/uploads/sys_data/module_assignment_attempts/" . $new_file_name;
        $temp_name = $_FILES["attn_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Pesist */
        $sql = "UPDATE module_assingments_attempts SET  attn_attachments =? WHERE att_id =? ";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ss',
            $new_file_name,
            $att_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Assignment Attempt Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    } else {
        $err = "Please Upload An Attempt Attachment";
    }
}

/* Delete */
if (isset($_POST['delete_attempt'])) {
    $att_id = $_POST['att_id'];
    $attn_attachments = $_POST['attn_attachments'];
    if (!empty($attn_attachments)) {
        /* Purge */
        $purge = unlink("../public/uploads/sys_data/module_assignment_attempts/" . $attn_attachments);
        $sql = "DELETE FROM module_assingments_attempts WHERE att_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            's',
            $att_id
        );
        $prepare->execute();
        if ($prepare && $purge) {
            $success = "Assignment Attempt Deleted";
        } else {
            $err = "Failed! Try Again Later";
        }
    } else {
        /* Catch The Worst Case Scenario */
        $sql = "DELETE FROM module_assingments_attempts WHERE att_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            's',
            $att_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Assignment Attempt Deleted";
        } else {
            $err = "Failed! Try Again Later";
        }
    }
}
require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/student_module_menu.php'); ?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php require_once('../partials/topbar.php');
    $asn_id = $_GET['asn_id'];
    $ret = "SELECT * FROM module_assaignments 
    WHERE asn_id = '$asn_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($asn = $res->fetch_object()) {
    ?>
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
                                        <li class="breadcrumb-item"><a href="my_dashboard">Home</a></li>
                                        <li class="breadcrumb-item"><a href="">Modules</a></li>
                                        <li class="breadcrumb-item"><a href="my_module_assignments">Module Assignments</a></li>
                                        <li class="breadcrumb-item active"><?php echo $asn->asn_title; ?></li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Module Assignment Attempt</h4>
                            </div>
                            <!--end page-title-box-->
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Upload Attempt</button>
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
                                                <label for="exampleInputFile">Attachment</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input name="attn_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button name="add_submission" class="btn btn-primary" type="submit">
                                                Add Submission
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
                            <div class="card card-body">
                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Admn No</th>
                                            <th>Name</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $user_id = $_SESSION['user_id'];
                                        $asn_id = $_GET['asn_id'];
                                        $ret = "SELECT * FROM module_assingments_attempts ma
                                        INNER JOIN users u ON u.user_id = ma.att_user_id 
                                        WHERE u.user_id = '$user_id' AND ma.att_asn_id = '$asn_id'
                                        ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        while ($attempts = $res->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $attempts->user_number; ?></td>
                                                <td><?php echo $attempts->user_name; ?></td>
                                                <td>
                                                    <a href="../public/uploads/sys_data/module_assignment_attempts/<?php echo $attempts->attn_attachments; ?>" class="badge badge-success"><i class="fas fa-download"></i> Download</a>
                                                    <a data-toggle="modal" href="#update_<?php echo $attempts->att_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a data-toggle="modal" href="#delete_<?php echo $attempts->att_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </td>
                                                <!-- Udpate Modal -->
                                                <div class="modal fade" id="update_<?php echo $attempts->att_id; ?>">
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
                                                                            <label for="exampleInputFile">Attachment</label>
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input name="attn_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                                    <input type="hidden" name="att_id" value="<?php echo $attempts->att_id; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button name="update_attempt" class="btn btn-primary" type="submit">
                                                                            Update Submission
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete_<?php echo $attempts->att_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <h4>Delete <?php echo $attempts->user_number . ' ' . $attempts->user_name; ?> Assignment Attempt ?</h4>
                                                                    <br>
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="att_id" value="<?php echo $attempts->att_id; ?>">
                                                                    <input type="hidden" name="attn_attachments" value="<?php echo $attempts->attn_attachments; ?>">
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <input type="submit" name="delete_attempt" value="Delete" class="text-center btn btn-danger">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Delete Modal -->
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
    <?php } ?>
    <!-- end page-wrapper -->
    <!-- Scripts -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>