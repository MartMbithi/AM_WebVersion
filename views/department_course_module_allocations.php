<?php
/*
 * Created on Tue Feb 01 2022
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

/* Add Module Allocation */
if (isset($_POST['add_allocation'])) {
    $allocation_module_id = $_POST['allocation_module_id'];
    $allocation_user_id = $_POST['allocation_user_id'];
    $allocation_calendar_id = $_POST['allocation_calendar_id'];

    /* Mailing Details */
    $user_details = $_POST['user_number'] . ' ' . $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $module_details = $_POST['module_details'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM module_allocations  WHERE allocation_module_id ='$allocation_module_id' 
    AND allocation_user_id = '$allocation_user_id' AND
    allocation_calendar_id = $allocation_calendar_id ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (
            $allocation_user_id == $row['allocation_user_id'] &&
            $allocation_module_id == $row['allocation_module_id'] &&
            $allocation_calendar_id == $row['allocation_calendar_id']
        ) {
            $err = "This Module Has Been Allocated An Instructor";
        }
    } else {
        /* Persist */
        $sql = "INSERT INTO module_allocations (allocation_calendar_id, allocation_module_id, allocation_user_id) VALUES(?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('sss', $allocation_calendar_id, $allocation_module_id, $allocation_user_id);
        $prepare->execute();
        /* Load Mailer Here */
        include('../mailers/allocation_mailer.php');

        if ($prepare && $mail->send()) {
            $success = "Module Has Been Allocated Instructor";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Update Module Allocation */
if (isset($_POST['update_allocation'])) {
    $allocation_module_id = $_POST['allocation_module_id'];
    $allocation_user_id = $_POST['allocation_user_id'];
    $allocation_id = $_POST['allocation_id'];
    $allocation_calendar_id = $_POST['allocation_calendar_id'];
    /* Mailer */
    //$user_details = $_POST['user_details'];


    /* Persist Update */
    $sql = "UPDATE module_allocations SET allocation_calendar_id=?, allocation_user_id =?, allocation_module_id =? WHERE allocation_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $allocation_calendar_id,
        $allocation_user_id,
        $allocation_module_id,
        $allocation_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Module Allocation Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}


/* Delete Module Allocation */
if (isset($_POST['delete_allocation'])) {
    $allocation_id = $_POST['allocation_id'];

    /* Persist Delete Operation */
    $sql = "DELETE FROM module_allocations WHERE allocation_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $allocation_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Module Allocation Deleted";
    } else {
        $err = "Failed!, Please Try Again Later";
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
                                        <li class="breadcrumb-item active"><?php echo $department->department_name; ?></li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Teaching Module Allocations</h4>
                            </div>
                            <!--end page-title-box-->
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Add Allocation</button>
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
                                            <label>Academic Year & Academic Semester</label>
                                            <select name="allocation_calendar_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                $cal_sql = "SELECT * FROM academic_calendar";
                                                $cal_prepare = $mysqli->prepare($cal_sql);
                                                $cal_prepare->execute(); //ok
                                                $cal_return = $cal_prepare->get_result();
                                                while ($calendar = $cal_return->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $calendar->calendar_id; ?>"><?php echo $calendar->calendar_year . ' - ' . $calendar->calendar_semester . ' : ' . $calendar->calendar_status ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="form-group col-md-6">
                                                <label>Module Name & Module Code</label>
                                                <select name="allocation_module_id" onChange="GetModuleDetails(this.value);" style="width: 100%;" required class="basic form-control">
                                                    <option> Select Module </option>
                                                    <?php
                                                    /* Pop All Courses In Asc Order */
                                                    $ret = "SELECT * FROM modules m
                                                    INNER JOIN courses c ON m.module_course_id = c.course_id   
                                                    WHERE c.course_department_id = '$view'                             
                                                    ORDER BY module_code ASC  ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($modules = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $modules->module_id; ?>"><?php echo $modules->module_code . ' - ' . $modules->module_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!-- Hide This  -->
                                                <input type="hidden" name="module_details" id="ModuleDetails" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Instructor Number & Name</label>
                                                <select name="allocation_user_id" style="width: 100%;" onChange="GetInstructorDetails(this.value);" required class="basic form-control">
                                                    <option>Select Instructor</option>
                                                    <?php
                                                    /* Pop All Courses In Asc Order */
                                                    $ret = "SELECT * FROM users  
                                                    WHERE user_access_level !='student'                               
                                                    ORDER BY user_number ASC  ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($users = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $users->user_id; ?>"><?php echo $users->user_number . ' - ' . $users->user_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!-- Hide This For Mailing Purposes -->
                                                <input type="hidden" name="user_number" id="UserNumber" required class="form-control">
                                                <input type="hidden" name="user_email" id="UserEmail" required class="form-control">
                                                <input type="hidden" name="user_name" id="UserName" required class="form-control">

                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button name="add_allocation" class="btn btn-primary" type="submit">
                                                Register Module Teaching Allocation
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
                                    <legend class="w-auto text-primary font-weight-light">Select Course Name & Code To Manage Registered Modules</legend>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <select name="course_id" style="width: 100%;" required class="basic form-control">
                                                    <option>Select Course</option>
                                                    <?php
                                                    /* Pop All Courses In Asc Order */
                                                    $ret = "SELECT * FROM courses 
                                                    WHERE course_department_id = '$view'                                
                                                    ORDER BY course_code ASC  ";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($courses = $res->fetch_object()) {
                                                    ?>
                                                        <option value="<?php echo $courses->course_id; ?>"><?php echo $courses->course_code . ' - ' . $courses->course_name; ?></option>
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
                                        <legend class="w-auto text-primary font-weight-light">Module Teaching Allocations</legend>
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Module Details</th>
                                                                <th>Allocated Instructor</th>
                                                                <th>Academic Year</th>
                                                                <th>Manage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $course_id = $_POST['course_id'];
                                                            $ret = "SELECT * FROM module_allocations ma
                                                            INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                            INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                            INNER JOIN users u ON u.user_id = ma.allocation_user_id
                                                            WHERE m.module_course_id = '$course_id'";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($allocations = $res->fetch_object()) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $allocations->module_code . ' ' . $allocations->module_name; ?></td>
                                                                    <td><?php echo $allocations->user_number . ' ' . $allocations->user_name; ?></td>
                                                                    <td><?php echo $allocations->calendar_year . ' - ' . $allocations->calendar_semester; ?></td>
                                                                    <td>
                                                                        <a data-toggle="modal" href="#update_<?php echo $allocations->allocation_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                        <a data-toggle="modal" href="#delete_<?php echo $allocations->allocation_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                                    </td>


                                                                    <!-- Udpate Modal -->
                                                                    <div class="modal fade" id="update_<?php echo $allocations->allocation_id; ?>">
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
                                                                                                <label>Academic Year & Semester</label>
                                                                                                <select name="allocation_calendar_id" style="width: 100%;" required class="basic form-control">
                                                                                                    <option value="<?php echo $allocations->allocation_calendar_id; ?>"><?php echo $allocations->calendar_year . ' - ' . $allocations->calendar_semester . ' : ' . $allocations->calendar_status; ?></option>
                                                                                                    <?php
                                                                                                    $cal_sql = "SELECT * FROM academic_calendar";
                                                                                                    $cal_prepare = $mysqli->prepare($cal_sql);
                                                                                                    $cal_prepare->execute(); //ok
                                                                                                    $cal_return = $cal_prepare->get_result();
                                                                                                    while ($calendar = $cal_return->fetch_object()) {
                                                                                                    ?>
                                                                                                        <option value="<?php echo $calendar->calendar_id; ?>"><?php echo $calendar->calendar_year . ' - ' . $calendar->calendar_semester . ' : ' . $calendar->calendar_status ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group col-md-6">
                                                                                                <label>Module Name & Module Code</label>
                                                                                                <input type="hidden" name="allocation_id" value="<?php echo $allocations->allocation_id; ?>">
                                                                                                <select name="allocation_module_id" style="width: 100%;" required class="basic form-control">
                                                                                                    <option value="<?php echo $allocations->module_id; ?>"><?php echo $allocations->module_code . ' - ' . $allocations->module_name; ?></option>
                                                                                                    <?php
                                                                                                    /* Pop All Courses In Asc Order */
                                                                                                    $module_sql = "SELECT * FROM modules m
                                                                                                    INNER JOIN courses c ON c.course_id = m.module_course_id
                                                                                                    WHERE c.course_department_id = '$view'                                 
                                                                                                    ORDER BY module_code ASC  ";
                                                                                                    $mod_prepare = $mysqli->prepare($module_sql);
                                                                                                    $mod_prepare->execute(); //ok
                                                                                                    $mod_return = $mod_prepare->get_result();
                                                                                                    while ($modules = $mod_return->fetch_object()) {
                                                                                                    ?>
                                                                                                        <option value="<?php echo $modules->module_id; ?>"><?php echo $modules->module_code . ' - ' . $modules->module_name; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group col-md-12">
                                                                                                <label>Instructor Number & Name</label>
                                                                                                <select name="allocation_user_id" style="width: 100%;" required class="basic form-control">
                                                                                                    <option value="<?php echo $allocations->user_id; ?>"><?php echo $allocations->user_number . ' - ' . $allocations->user_name; ?></option>
                                                                                                    <?php
                                                                                                    /* Pop All Courses In Asc Order */
                                                                                                    $user_sql = "SELECT * FROM users  
                                                                                                    WHERE user_access_level !='student'                               
                                                                                                    ORDER BY user_number ASC  ";
                                                                                                    $prepare = $mysqli->prepare($user_sql);
                                                                                                    $prepare->execute(); //ok
                                                                                                    $return = $prepare->get_result();
                                                                                                    while ($users = $return->fetch_object()) {
                                                                                                    ?>
                                                                                                        <option value="<?php echo $users->user_id; ?>"><?php echo $users->user_number . ' - ' . $users->user_name; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="text-right">
                                                                                            <button name="update_allocation" class="btn btn-primary" type="submit">
                                                                                                Update Module Teaching Allocation
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End Modal -->

                                                                    <!-- Delete Modal -->
                                                                    <div class="modal fade" id="delete_<?php echo $allocations->allocation_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                        <h4>Delete <?php echo $allocations->module_code . ' - ' . $allocations->module_name; ?> Teaching Allocation </h4>
                                                                                        <br>
                                                                                        <!-- Hide This -->
                                                                                        <input type="hidden" name="allocation_id" value="<?php echo $allocations->allocation_id; ?>">
                                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                                        <input type="submit" name="delete_allocation" value="Delete" class="text-center btn btn-danger">
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
    <?php } ?>
    <!-- end page-wrapper -->
    <!-- Scripts -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>