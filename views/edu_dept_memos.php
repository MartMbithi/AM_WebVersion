<?php
/*
 * Created on Sat Jan 01 2022
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


/* Add Memo */
if (isset($_POST['add_memo'])) {
    $memo_department_id = $_POST['memo_department_id'];
    $memo_posted_by_id = $_SESSION['user_id']; /* Log This Memo To Logged In User */
    $memo_target_audience  = $_POST['memo_target_audience'];
    $memo_title = $_POST['memo_title'];
    $memo_details = $_POST['memo_details'];
    $memo_type  = "Memo";
    /* Post A Notification On This */
    $notification_user_id  = $_SESSION['user_id'];
    $notification_target_audience = $memo_target_audience;
    $notification_status = 'Unread';
    $notification_details = "New Departmental Memo Has Been Posted";

    $memo_attachments  = $_FILES['memo_attachments']['name'];
    if (!empty($memo_attachments)) {
        $upload_directory = "../public/uploads/sys_data/memos/" . $memo_attachments;
        $temp_name = $_FILES["memo_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Pesist This */
        $sql = "INSERT INTO dep_memos (memo_department_id, memo_posted_by_id, memo_target_audience, memo_title,  memo_details, memo_attachments, memo_type)
        VALUES(?,?,?,?,?,?,?)";
        $notification = "INSERT INTO notifications (notification_user_id, notification_target_audience, notification_status, notification_details)
        VALUES(?,?,?,?)";

        $prepare = $mysqli->prepare($sql);
        $notification_prepare = $mysqli->prepare($notification);

        $bind = $prepare->bind_param(
            'sssssss',
            $memo_department_id,
            $memo_posted_by_id,
            $memo_target_audience,
            $memo_title,
            $memo_details,
            $memo_attachments,
            $memo_type
        );
        $notification_bind  = $notification_prepare->bind_param(
            'ssss',
            $notification_user_id,
            $notification_target_audience,
            $notification_status,
            $notification_details
        );
        $prepare->execute();
        $notification_prepare->execute();

        if ($prepare && $notification_prepare) {
            $success = "Departmental Memo Posted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        /* Pesist This */
        $sql = "INSERT INTO dep_memos (memo_department_id, memo_posted_by_id, memo_target_audience, memo_title,  memo_details, memo_type)
        VALUES(?,?,?,?,?,?)";
        $notification = "INSERT INTO notifications (notification_user_id, notification_target_audience, notification_status, notification_details)
        VALUES(?,?,?,?)";

        $prepare = $mysqli->prepare($sql);
        $notification_prepare = $mysqli->prepare($notification);

        $bind = $prepare->bind_param(
            'ssssss',
            $memo_department_id,
            $memo_posted_by_id,
            $memo_target_audience,
            $memo_title,
            $memo_details,
            $memo_type
        );
        $notification_bind  = $notification_prepare->bind_param(
            'ssss',
            $notification_user_id,
            $notification_target_audience,
            $notification_status,
            $notification_details
        );
        $prepare->execute();
        $notification_prepare->execute();

        if ($prepare && $notification_prepare) {
            $success = "Departmental Memo Posted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Update Departmental Memo */
if (isset($_POST['update_memo'])) {
    $memo_id = $_POST['memo_id'];
    $memo_posted_by_id = $_SESSION['user_id']; /* Log This Memo To Logged In User */
    $memo_target_audience  = $_POST['memo_target_audience'];
    $memo_title = $_POST['memo_title'];
    $memo_details = $_POST['memo_details'];
    $memo_attachments  = $_FILES['memo_attachments']['name'];
    if (!empty($memo_attachments)) {
        $upload_directory = "../public/uploads/sys_data/memos/" . $memo_attachments;
        $temp_name = $_FILES["memo_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Pesist This */
        $sql = "UPDATE  dep_memos SET memo_posted_by_id =?, memo_target_audience =?, memo_title =?,  memo_details =?, memo_attachments =? WHERE memo_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssssss',
            $memo_posted_by_id,
            $memo_target_audience,
            $memo_title,
            $memo_details,
            $memo_attachments,
            $memo_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Departmental Memo Updated";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        /* Pesist This */
        $sql = "UPDATE  dep_memos SET memo_posted_by_id =?, memo_target_audience =?, memo_title =?,  memo_details =? WHERE memo_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sssss',
            $memo_posted_by_id,
            $memo_target_audience,
            $memo_title,
            $memo_details,
            $memo_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Departmental Memo Updated";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Delete Memo */
if (isset($_POST['delete'])) {
    $memo_id = $_POST['memo_id'];
    $memo_attachments = $_POST['memo_attachments'];
    if (!empty($memo_attachments)) {
        $sql = "DELETE FROM  dep_memos WHERE memo_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $memo_id);
        $prepare->execute();

        if ($prepare && unlink('../public/uploads/sys_data/memos/' . $memo_attachments)) {
            $success = "Departmental Memo Deleted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    } else {
        $sql = "DELETE FROM  dep_memos WHERE memo_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $memo_id);
        $prepare->execute();

        if ($prepare) {
            $success = "Departmental Memo Deleted";
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
                                    <li class="breadcrumb-item"><a href="edu_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Departments</a></li>
                                    <li class="breadcrumb-item active">Departmental Memos</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Departmental Memos</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Post New Memo</button>
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
                                            <label>Department Code & Name</label>
                                            <select name="memo_department_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop All Departments In Asc Order */
                                                $ret = "SELECT * FROM departments                                 
                                                ORDER BY department_code ASC  ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($departments = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $departments->department_id; ?>"><?php echo $departments->department_code . ' ' . $departments->department_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Memo Target Audience </label>
                                            <select name="memo_target_audience" style="width: 100%;" required class="basic form-control">
                                                <option>Lecturers</option>
                                                <option>Students</option>
                                                <option>All Personnel</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Memo Title</label>
                                            <input type="text" name="memo_title" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputFile">Memo Attachments</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="memo_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Memo Details</label>
                                            <textarea type="text" name="memo_details" rows="10" required class="summernote form-control"></textarea>
                                        </div>

                                    </div>
                                    <div class="text-right">
                                        <button name="add_memo" class="btn btn-primary" type="submit">
                                            Post Memo
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
                                <legend class="w-auto text-primary font-weight-light">Select Any Department To View Its Posted Memos </legend>
                                <div class="row">
                                    <?php
                                    /* Pop All Departments In Asc Order */
                                    $ret = "SELECT * FROM departments d 
                                    INNER JOIN faculties f ON f.faculty_id = d.department_faculty_id
                                    INNER JOIN users u ON u.user_id = d.department_user_id                                    
                                    ORDER BY department_code ASC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($departments = $res->fetch_object()) {
                                        /* Give A Count On Posted Memos */
                                        $department_id = $departments->department_id;
                                        include('../helpers/department_memos_count.php');
                                    ?>
                                        <div class="col-md-3">
                                            <div class="card">
                                                <!-- To Do : Link This Pag To User Profile -->
                                                <div class="card-body">
                                                    <!--end ribbon-->
                                                    <img src="../public/images/icons/departments.png" alt="" class="d-block mx-auto my-4" height="100">
                                                    <div class="text-center my-4">
                                                        <div>
                                                            <p class="header-title"><?php echo $departments->department_code . ' ' . $departments->department_name; ?></p>
                                                            <p class="header-title">Faculty : <?php echo $departments->faculty_code . ' ' . $departments->faculty_name; ?></p>
                                                            <p class="header-title">Dep Head: <span class="text-success"><?php echo $departments->user_number . ' ' . $departments->user_name; ?></span></p><br>
                                                            <p class="header-title">Posted Memos : <span class="text-primary"><?php echo $no_of_posted_memos; ?></span></p><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <form method="POST">
                                                        <input type="hidden" name="DepartmentId" value="<?php echo $departments->department_id; ?>">
                                                        <input type="hidden" name="DepartmentCode" value="<?php echo $departments->department_code; ?>">
                                                        <input type="hidden" name="DepartmentName" value="<?php echo $departments->department_name; ?>">
                                                        <div class="text-right">
                                                            <button name="search" class="btn btn-primary" type="submit">
                                                                Manage Posted Memos
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!--end card-body-->
                                            </div>
                                            <!--end card-->
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                            </fieldset>

                            <!-- Get All Departmental Memos Posted On Selected Department -->
                            <hr>
                            <?php
                            if (isset($_POST['search'])) {
                            ?>
                                <fieldset class="border border-primary p-2">
                                    <legend class="w-auto text-primary font-weight-light">All Posted Memos Under : <?php echo $_POST['DepartmentCode'] . ' ' . $_POST['DepartmentName']; ?></legend>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Memo Taget Audience</th>
                                                            <th>Posted By</th>
                                                            <th>Date Posted</th>
                                                            <th>Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $department_id = $_POST['DepartmentId'];
                                                        $ret = "SELECT * FROM dep_memos  dm
                                                        INNER JOIN users u ON u.user_id = dm.memo_posted_by_id
                                                        WHERE dm.memo_department_id = '$department_id' AND memo_type  != 'Notice' ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($memos = $res->fetch_object()) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $memos->memo_target_audience; ?></td>
                                                                <td><?php echo $memos->user_number . ' ' . $memos->user_name; ?></td>
                                                                <td><?php echo date('d M Y g:ia', strtotime($memos->memo_created_at)); ?></td>
                                                                <td>
                                                                    <a data-toggle="modal" href="#view_<?php echo $memos->memo_id; ?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                                    <a data-toggle="modal" href="#update_<?php echo $memos->memo_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                    <a data-toggle="modal" href="#delete_<?php echo $memos->memo_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                                </td>
                                                                <!-- View Modal -->
                                                                <div class="modal fade" id="view_<?php echo $memos->memo_id; ?>">
                                                                    <div class="modal-dialog  modal-xl">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title"><?php echo $memos->memo_title; ?></h4>
                                                                                <button type="button" class="close" data-dismiss="modal">
                                                                                    <span>&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="lead">
                                                                                    <?php echo $memos->memo_details; ?>
                                                                                </p>
                                                                                <?php
                                                                                /* Show This If Attachment Is Available */
                                                                                if (!empty($memos->memo_attachments)) {
                                                                                ?>
                                                                                    <div class="text-center">
                                                                                        <a href="../public/uploads/sys_data/memos/<?php echo $memos->memo_attachments; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i> Download Memo Attachment</a>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <hr>
                                                                                <figcaption class="blockquote-footer">
                                                                                    Posted By <cite class="text-success" title="Source Title">
                                                                                        <?php echo $memos->user_number . ' ' . $memos->user_name; ?> On
                                                                                        <?php echo  date('d M Y g:ia', strtotime($memos->memo_created_at)); ?>
                                                                                    </cite>
                                                                                </figcaption>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End View Modal -->

                                                                <!-- Udpate Modal -->
                                                                <div class="modal fade" id="update_<?php echo $memos->memo_id; ?>">
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
                                                                                            <label>Memo Target Audience </label>
                                                                                            <select name="memo_target_audience" style="width: 100%;" required class="basic form-control">
                                                                                                <option><?php echo $memos->memo_target_audience; ?></option>
                                                                                                <option>Lecturers</option>
                                                                                                <option>Students</option>
                                                                                                <option>All Personnel</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label>Memo Title</label>
                                                                                            <input type="text" value="<?php echo $memos->memo_title; ?>" name="memo_title" required class="form-control">
                                                                                            <input type="hidden" value="<?php echo $memos->memo_id; ?>" name="memo_id" required class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-md-12">
                                                                                            <label for="exampleInputFile">Memo Attachments</label>
                                                                                            <div class="input-group">
                                                                                                <div class="custom-file">
                                                                                                    <input name="memo_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-12">
                                                                                            <label>Memo Details</label>
                                                                                            <textarea type="text" name="memo_details" rows="10" required class="summernote form-control"><?php echo $memos->memo_details; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <button name="update_memo" class="btn btn-primary" type="submit">
                                                                                            Update Posted Memo
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End Modal -->

                                                                <!-- Delete Modal -->
                                                                <div class="modal fade" id="delete_<?php echo $memos->memo_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                    <h4>Delete This Memo </h4>
                                                                                    <br>
                                                                                    <!-- Hide This -->
                                                                                    <input type="hidden" name="memo_id" value="<?php echo $memos->memo_id; ?>">
                                                                                    <input type="hidden" name="memo_attachments" value="<?php echo $memos->memo_attachments; ?>">
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