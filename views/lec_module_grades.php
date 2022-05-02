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

/* Add Marks Entry*/
if (isset($_POST['add_marks'])) {
    $grade_marks_user_id = $_POST['grade_marks_user_id'];
    $grade_marks_module_id = $_POST['grade_marks_module_id'];
    $grade_marks_calendar_id = $_POST['grade_marks_calendar_id'];
    $grade_marks_attained = $_POST['grade_marks_attained'];

    $sql = "INSERT INTO student_grades (grade_marks_module_id, grade_marks_calendar_id, grade_marks_user_id, grade_marks_attained) VALUES(?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $grade_marks_module_id,
        $grade_marks_calendar_id,
        $grade_marks_user_id,
        $grade_marks_attained
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Marks Submitted";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Marks Entry */
if (isset($_POST['update_marks'])) {
    $grade_marks_attained = $_POST['grade_marks_attained'];
    $grade_id = $_POST['grade_id'];

    /* Update Marks */
    $sql  = "UPDATE student_grades SET grade_marks_attained =? WHERE grade_id  =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ss',
        $grade_marks_attained,
        $grade_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Marks Entry Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete Marks Entry */
if (isset($_POST['delete_marks'])) {
    $grade_id = $_POST['grade_id'];

    /* Persist Delete */
    $sql = "DELETE FROM student_grades WHERE grade_id =? ";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $grade_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Grades Deleted";
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
                                    <li class="breadcrumb-item"><a href="lec_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Modules</a></li>
                                    <li class="breadcrumb-item active">Module Marks Entry</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Student Marks Entry</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Add Marks Entry</button>
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
                                            <select name="grade_marks_module_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Module</option>
                                                <?php
                                                /* Pop Module Details */
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM module_allocations ma 
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ac.calendar_status = 'Current' AND ma.allocation_user_id = '$user_id'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($module = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $module->module_id; ?>">
                                                        <?php echo $module->module_code . ' ' . $module->module_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <!-- Hide This  -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Student Details </label>
                                            <select name="grade_marks_user_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Student Details</option>
                                                <?php
                                                $ret = "SELECT * FROM users
                                                WHERE user_access_level = 'student' ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($std = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $std->user_id; ?>">
                                                        <?php echo $std->user_number . ' ' . $std->user_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <!-- Hide This  -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Academic Year & Semester </label>
                                            <select name="grade_marks_calendar_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                $ret = "SELECT * FROM academic_calendar WHERE calendar_status = 'Current' ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($cal = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $cal->calendar_id; ?>">
                                                        <?php echo $cal->calendar_year . ' :  ' . $cal->calendar_semester . ' : ' . $cal->calendar_status; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <!-- Hide This  -->
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Cumulative Marks Attained <small>This Includes All Assignments & CATs Accumulated</small></label>
                                            <input type="number" name="grade_marks_attained" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_marks" class="btn btn-primary" type="submit">
                                            Add Marks
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
                                <legend class="w-auto text-primary font-weight-light">Select Any Module To Manage Their Perfomances</legend>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select name="module_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Module</option>
                                                <?php
                                                /* Pop Module Details */
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM module_allocations ma 
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ac.calendar_status = 'Current' AND ma.allocation_user_id = '$user_id'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($module = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $module->module_id; ?>">
                                                        <?php echo $module->module_code . ' ' . $module->module_name; ?>
                                                    </option>
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
                                                        <th>Student Details</th>
                                                        <th>Marks Attained</th>
                                                        <th>Grade</th>
                                                        <th>Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $module_id = $_POST['module_id'];
                                                    $user_id = $_SESSION['user_id'];
                                                    $ret = "SELECT * FROM student_grades sg
                                                    INNER JOIN modules m ON m.module_id = sg.grade_marks_module_id
                                                    INNER JOIN academic_calendar ac ON ac.calendar_id = sg.grade_marks_calendar_id
                                                    INNER JOIN module_allocations ma ON ma.allocation_calendar_id = sg.grade_marks_calendar_id
                                                    INNER JOIN users u ON u.user_id = sg.grade_marks_user_id
                                                    WHERE  sg.grade_marks_module_id = '$module_id' 
                                                    AND ac.calendar_status = 'Current' AND ma.allocation_user_id = '$user_id' ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($grades = $res->fetch_object()) {
                                                        /* Compute Grade */
                                                        $workScore = $grades->grade_marks_attained;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $grades->user_number . ' ' . $grades->user_name; ?></td>
                                                            <td><?php echo $grades->module_code . ' ' . $grades->module_name; ?></td>
                                                            <td><?php echo $grades->grade_marks_attained; ?></td>
                                                            <td>
                                                                <?php
                                                                switch ($workScore) {
                                                                    case $workScore >= 70 and $workScore <= 100:
                                                                        echo 'A';
                                                                        break;
                                                                    case $workScore >= 60 and $workScore <= 69:
                                                                        echo 'B';
                                                                        break;
                                                                    case $workScore >= 50 and $workScore <= 59:
                                                                        echo 'C';
                                                                        break;
                                                                    case $workScore >= 40 and $workScore <= 49:
                                                                        echo 'D';
                                                                        break;
                                                                    case $workScore >= 30 and $workScore <= 39:
                                                                        echo 'E';
                                                                        break;
                                                                    default:
                                                                        echo 'Null';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a data-toggle="modal" href="#update_<?php echo $grades->grade_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                <a data-toggle="modal" href="#delete_<?php echo $grades->grade_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                            </td>

                                                            <!-- Udpate Modal -->
                                                            <div class="modal fade" id="update_<?php echo $grades->grade_id; ?>">
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
                                                                                        <label>Cumulative Marks Attained <small>This Includes All Assignments & CATs Accumulated</small></label>
                                                                                        <input type="hidden" value="<?php echo $grades->grade_id; ?>" name="grade_id" required class="form-control">
                                                                                        <input type="number" value="<?php echo $grades->grade_marks_attained; ?>" name="grade_marks_attained" required class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <button name="update_marks" class="btn btn-primary" type="submit">
                                                                                        Update Marks
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Modal -->

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_<?php echo $grades->grade_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                    Delete <?php echo $grades->user_number . ' ' . $grades->user_name; ?> Marks For <br>
                                                                                    <?php echo $grades->module_code . '' . $grades->module_name; ?>
                                                                                </h4>
                                                                                <br>
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" name="grade_id" value="<?php echo $grades->grade_id; ?>">
                                                                                <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                                <input type="submit" name="delete_marks" value="Delete" class="text-center btn btn-danger">
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