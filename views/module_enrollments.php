<?php
/*
 * Created on Wed Jan 19 2022
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

/* Add Enrollment */
if (isset($_POST['add_enrollment'])) {
    $enrollment_user_id = $_POST['enrollment_user_id'];
    $enrollment_module_id = $_POST['enrollment_module_id'];
    $enrollment_academic_calendar_id = $_POST['enrollment_academic_calendar_id'];

    /* Mailer Details */
    $user_details = $_POST['user_number'] . ' ' . $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $module_details = $_POST['module_details'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM enrollments WHERE enrollment_user_id ='$enrollment_user_id'
    AND  enrollment_module_id = '$enrollment_module_id'
    AND enrollment_academic_calendar_id = '$enrollment_academic_calendar_id'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (
            $enrollment_user_id == $row['enrollment_user_id'] &&
            $enrollment_module_id == $row['enrollment_module_id'] &&
            $enrollment_academic_calendar_id == $row['enrollment_academic_calendar_id']
        ) {
            $err = "Student Enrollment Record Already Exists";
        }
    } else {
        /* Persist */
        $sql = "INSERT INTO enrollments (enrollment_user_id, enrollment_module_id, enrollment_academic_calendar_id)
        VALUES(?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('sss', $enrollment_user_id, $enrollment_module_id, $enrollment_academic_calendar_id);
        $prepare->execute();
        /* Load Mailer Here */
        include('../mailers/enrollment_mailer.php');
        if ($prepare && $mail->send()) {
            $success = "Module Enrollement Record Added";
        } else {
            $err = "Failed!, Please Try Again Later $mail->ErrorInfo";
        }
    }
}

/* Update Enrollment */
if (isset($_POST['update_enrollment'])) {
    $enrollment_id  = $_POST['enrollment_id'];
    $enrollment_module_id = $_POST['enrollment_module_id'];
    $enrollment_academic_calendar_id = $_POST['enrollment_academic_calendar_id'];

    /* Persist Update */
    $sql  = "UPDATE enrollments SET enrollment_module_id = ?, enrollment_academic_calendar_id =? WHERE enrollment_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sss',
        $enrollment_module_id,
        $enrollment_academic_calendar_id,
        $enrollment_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Module Enrollment Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}


/* Delete Enrollments */
if (isset($_POST['delete_enrollment'])) {
    $enrollment_id = $_POST['enrollment_id'];

    /* Persist */
    $sql = "DELETE FROM enrollments WHERE enrollment_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $enrollment_id);
    $prepare->execute();

    if ($prepare) {
        $success = "Enrollment Record Deleted";
    } else {
        $err = "Failed!, Please Try Again";
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
                                    <li class="breadcrumb-item active">Module Enrollments</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Student Enrollments</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Add Enrollment</button>
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
                                        <div class="form-group col-md-4">
                                            <label>Module Code & Name </label>
                                            <select name="enrollment_module_id" style="width: 100%;" onChange="GetModuleDetails(this.value);" required class="basic form-control">
                                                <option>Select Module Details</option>
                                                <?php
                                                /* Pop Module Details */
                                                $ret = "SELECT * FROM module_allocations ma 
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($allocation = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $allocation->module_id; ?>"><?php echo $allocation->module_code . ' ' . $allocation->module_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <!-- Hide This  -->
                                            <input type="hidden" name="module_details" id="ModuleDetails" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Student Details</label>
                                            <select name="enrollment_user_id" style="width: 100%;" onChange="GetInstructorDetails(this.value);" required class="basic form-control">
                                                <option>Select Student Details</option>
                                                <?php
                                                /* Pop Student Details */
                                                $ret = "SELECT * FROM users 
                                                WHERE user_access_level = 'student'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($students = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $students->user_id; ?>"><?php echo $students->user_number . ' ' . $students->user_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <!-- Hide This For Mailing Purposes -->
                                            <input type="hidden" name="user_number" id="UserNumber" required class="form-control">
                                            <input type="hidden" name="user_email" id="UserEmail" required class="form-control">
                                            <input type="hidden" name="user_name" id="UserName" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Academic Calendar</label>
                                            <select name="enrollment_academic_calendar_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop Academic Calendar Details */
                                                $ret = "SELECT * FROM academic_calendar";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($cal = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $cal->calendar_id; ?>"><?php echo $cal->calendar_year . ' ' . $cal->calendar_semester . ' : ' . $cal->calendar_status; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_enrollment" class="btn btn-primary" type="submit">
                                            Add Enrollment
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
                                <legend class="w-auto text-primary font-weight-light">Select Any Academic Year & Semester To View Enrolled Students</legend>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select name="calendar_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Academic Year & Semester</option>
                                                <?php
                                                /* Pop All Courses In Asc Order */
                                                $ret = "SELECT * FROM academic_calendar";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($cal = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $cal->calendar_id; ?>"><?php echo $cal->calendar_year . ' - ' . $cal->calendar_semester . ' - ' . $cal->calendar_status; ?></option>
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

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Module Details</th>
                                                        <th>Student</th>
                                                        <th>Academic Calendar</th>
                                                        <th>Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $calendar_id = $_POST['calendar_id'];
                                                    $ret = "SELECT * FROM enrollments e 
                                                    INNER JOIN modules m ON m.module_id = e.enrollment_module_id
                                                    INNER JOIN users s ON s.user_id = e.enrollment_user_id
                                                    INNER JOIN academic_calendar ac ON ac.calendar_id = e.enrollment_academic_calendar_id
                                                    WHERE e.enrollment_academic_calendar_id  = '$calendar_id'";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($enrollment = $res->fetch_object()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $enrollment->module_code . ' ' . $enrollment->module_name; ?></td>
                                                            <td><?php echo $enrollment->user_number . ' ' . $enrollment->user_name; ?></td>
                                                            <td><?php echo $enrollment->calendar_year . ' ' . $enrollment->calendar_semester . ' : ' . $enrollment->calendar_status; ?></td>
                                                            <td>
                                                                <a data-toggle="modal" href="#update_<?php echo $enrollment->enrollment_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                <a data-toggle="modal" href="#delete_<?php echo $enrollment->enrollment_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                            </td>

                                                            <!-- Udpate Modal -->
                                                            <div class="modal fade" id="update_<?php echo $enrollment->enrollment_id; ?>">
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
                                                                                        <label>Module Code & Name </label>
                                                                                        <input type="hidden" name="enrollment_id" value="<?php echo $enrollment->enrollment_id; ?>">
                                                                                        <select name="enrollment_module_id" style="width: 100%;" required class="basic form-control">
                                                                                            <?php
                                                                                            /* Pop Module Details */
                                                                                            $mod_sql = "SELECT * FROM module_allocations ma 
                                                                                            INNER JOIN modules m ON m.module_id = ma.allocation_module_id";
                                                                                            $mod_stmt = $mysqli->prepare($mod_sql);
                                                                                            $mod_stmt->execute(); //ok
                                                                                            $mod_res = $mod_stmt->get_result();
                                                                                            while ($allocation = $mod_res->fetch_object()) {
                                                                                            ?>
                                                                                                <option value="<?php echo $allocation->module_id; ?>"><?php echo $allocation->module_code . ' ' . $allocation->module_name; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label>Academic Calendar</label>
                                                                                        <select name="enrollment_academic_calendar_id" style="width: 100%;" required class="basic form-control">
                                                                                            <option value="<?php echo $enrollment->calendar_id; ?>"><?php echo $enrollment->calendar_year . ' ' . $enrollment->calendar_semester . ' : ' . $enrollment->calendar_status; ?></option>
                                                                                            <?php
                                                                                            /* Pop Academic Calendar Details */
                                                                                            $cal_sql = "SELECT * FROM academic_calendar";
                                                                                            $cal_stmt = $mysqli->prepare($cal_sql);
                                                                                            $cal_stmt->execute(); //ok
                                                                                            $cal_res = $cal_stmt->get_result();
                                                                                            while ($cal = $cal_res->fetch_object()) {
                                                                                            ?>
                                                                                                <option value="<?php echo $cal->calendar_id; ?>"><?php echo $cal->calendar_year . ' ' . $cal->calendar_semester . ' : ' . $cal->calendar_status; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <button name="update_enrollment" class="btn btn-primary" type="submit">
                                                                                        Update Enrollment
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Modal -->

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_<?php echo $enrollment->enrollment_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <h4>
                                                                                    Delete <?php echo $enrollment->user_number . ' ' . $enrollment->user_name; ?> Enrollment <br>
                                                                                    <?php echo $enrollment->module_code . '' . $enrollment->module_name; ?>
                                                                                </h4>
                                                                                <br>
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" name="enrollment_id" value="<?php echo $enrollment->enrollment_id; ?>">
                                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                                <input type="submit" name="delete_enrollment" value="Delete" class="text-center btn btn-danger">
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