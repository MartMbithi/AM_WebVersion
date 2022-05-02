<?php
/*
 * Created on Mon Jan 31 2022
 *
 *  Devlan - devlan.co.ke 
 *
 * hello@devlan.co.ke
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan - Martin Mbithi
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

/* Add Department Document */
if (isset($_POST['add_document'])) {
    $doc_dep_id = $_GET['view'];/* Department ID */
    $doc_user_id = $_SESSION['user_id'];
    $doc_title = $_POST['doc_title'];
    /* Add Attachment Title */
    $doc_attachments =  $doc_title . date('d-M-Y_g:ia') . '_' . $_FILES['doc_attachments']['name'];
    $upload_directory = "../public/uploads/sys_data/memos/" . $doc_attachments;
    $temp_name = $_FILES["doc_attachments"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory);

    /* Persist This */
    $sql = "INSERT INTO dep_documents (doc_dep_id, doc_user_id, doc_title, doc_attachments) VALUES(?,?,?,?)";
    $prepare  = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $doc_dep_id,
        $doc_user_id,
        $doc_title,
        $doc_attachments
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Department Document Posted";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Departent Document */
if (isset($_POST['update_document'])) {
    $doc_user_id = $_SESSION['user_id'];
    $doc_title = $_POST['doc_title'];
    /* Add Attachment Title */
    $doc_attachments =  $doc_title . date('d-M-Y_g:ia') . '_' . $_FILES['doc_attachments']['name'];
    $upload_directory = "../public/uploads/sys_data/memos/" . $doc_attachments;
    $temp_name = $_FILES["doc_attachments"]["tmp_name"];
    move_uploaded_file($temp_name, $upload_directory);
    $doc_id = $_POST['doc_id'];

    /* Persist This */
    $sql = "UPDATE dep_documents SET doc_user_id = ?, doc_attachments =?, doc_title =? WHERE doc_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $doc_user_id,
        $doc_attachments,
        $doc_title,
        $doc_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Departmental Document Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}

/* Delete Departent Document */
if (isset($_POST['delete'])) {
    $doc_id = $_POST['doc_id'];
    $doc_attachments = $_POST['doc_attachments'];

    /* Delete */
    $sql = "DELETE FROM dep_documents WHERE doc_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $doc_id);
    $prepare->execute();
    if ($prepare && unlink('../public/uploads/sys_data/memos/' . $doc_attachments)) {
        $success = "Departmenal Document Deleted";
    }
}
require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/departments_sidebar.php'); ?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php require_once('../partials/topbar.php');
    $view = $_GET['view'];
    $ret = "SELECT * FROM departments d
    INNER JOIN faculties f 
    ON f.faculty_id = d.department_faculty_id
    INNER JOIN users u ON u.user_id = d.department_user_id
    WHERE d.department_id ='$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($department = $res->fetch_object()) {
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
                                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                        <li class="breadcrumb-item"><a href="dept_manage">Departments</a></li>
                                        <li class="breadcrumb-item"><a href="department_dashboard?view=<?php echo $view; ?>"><?php echo $department->department_name; ?></a></li>
                                        <li class="breadcrumb-item active ">Documents</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Departmental Documents</h4>
                            </div>
                            <!--end page-title-box-->
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Post New Department Document</button>
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
                                                <label>Title</label>
                                                <input type="text" name="doc_title" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputFile">Departmental Documents Attachments</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input required name="doc_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button name="add_document" class="btn btn-primary" type="submit">
                                                Post Departmenal Notice
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
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Document Title</th>
                                                        <th>Document Posted By</th>
                                                        <th>Date Posted</th>
                                                        <th>Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ret = "SELECT * FROM dep_documents dd
                                                    INNER JOIN users u ON dd.doc_user_id = u.user_id
                                                    WHERE dd.doc_dep_id  = '$view'";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($docs = $res->fetch_object()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $docs->doc_title; ?></td>
                                                            <td><?php echo $docs->user_number . ' ' . $docs->user_name; ?></td>
                                                            <td><?php echo date('d M Y g:ia', strtotime($docs->doc_date_posted)); ?></td>
                                                            <td>
                                                                <a data-toggle="modal" href="#view_<?php echo $docs->doc_id; ?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                                <a data-toggle="modal" href="#update_<?php echo $docs->doc_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                <a data-toggle="modal" href="#delete_<?php echo $docs->doc_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                            </td>
                                                            <!-- View Modal -->
                                                            <div class="modal fade" id="view_<?php echo $docs->doc_id; ?>">
                                                                <div class="modal-dialog  modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Departmental Document Details</h4>
                                                                            <button type="button" class="close" data-dismiss="modal">
                                                                                <span>&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="text-center">
                                                                                <p class="lead">
                                                                                    <?php echo $docs->doc_title; ?>
                                                                                </p>
                                                                                <a href="../public/uploads/sys_data/memos/<?php echo $docs->doc_attachments; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i> Download Memo Attachment</a>
                                                                            </div>
                                                                            <hr>
                                                                            <figcaption class="blockquote-footer">
                                                                                Posted By <cite class="text-success" title="Source Title">
                                                                                    <?php echo $docs->user_number . ' ' . $docs->user_name; ?> On
                                                                                    <?php echo  date('d M Y g:ia', strtotime($docs->doc_date_posted)); ?>
                                                                                </cite>
                                                                            </figcaption>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End View Modal -->

                                                            <!-- Udpate Modal -->
                                                            <div class="modal fade" id="update_<?php echo $docs->doc_id; ?>">
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
                                                                                        <label>Title</label>
                                                                                        <input type="text" name="doc_title" value="<?php echo $docs->doc_title; ?>" required class="form-control">
                                                                                        <input type="hidden" name="doc_id" value="<?php echo $docs->doc_id; ?>" required class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label for="exampleInputFile">Departmental Documents Attachments</label>
                                                                                        <div class="input-group">
                                                                                            <div class="custom-file">
                                                                                                <input name="doc_attachments" required accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <button name="update_document" class="btn btn-primary" type="submit">
                                                                                        Update Departmenal Notice
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Modal -->

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_<?php echo $docs->doc_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <h4>Delete This Document </h4>
                                                                                <br>
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" name="doc_id" value="<?php echo $docs->doc_id; ?>">
                                                                                <input type="hidden" name="doc_attachments" value="<?php echo $docs->doc_attachments; ?>">
                                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                                <input type="submit" name="delete" value="Delete" class="text-center btn btn-danger">
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