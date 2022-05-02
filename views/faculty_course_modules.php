<?php
/*
 * Created on Sun Jan 30 2022
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
/* Add Module */
if (isset($_POST['add_module'])) {
    $module_course_id = $_POST['module_course_id'];
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $module_details = $_POST['module_details'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Registered New Module : ' . $module_code . ' ' . $module_name;
    $log_user_id = $_SESSION['user_id'];


    /* Avoid Duplicate Values */
    $sql = "SELECT * FROM modules  WHERE module_course_id ='$module_course_id' AND module_code = '$module_code' ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (
            $module_course_id == $row['module_course_id'] &&
            $module_code == $row['module_code']
        ) {
            $err = "A Module With This Code " . $module_code . " Already Exixts ";
        }
    } else {
        /* Persist New Module */
        $sql = "INSERT INTO modules (module_course_id, module_code, module_name, module_details) VALUES(?,?,?,?)";
        $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

        $prepare  = $mysqli->prepare($sql);
        $log_prepare = $mysqli->prepare($log);

        $bind = $prepare->bind_param(
            'ssss',
            $module_course_id,
            $module_code,
            $module_name,
            $module_details
        );
        $log_bind = $log_prepare->bind_param(
            'sss',
            $log_ip,
            $log_user_id,
            $log_type
        );


        $prepare->execute();
        $log_prepare->execute();

        if ($prepare && $log_prepare) {
            $success = "$module_code - $module_name Added";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Update Module */
if (isset($_POST['update_module'])) {
    $module_id = $_POST['module_id'];
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $module_details = $_POST['module_details'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Updated : ' . $module_code . ' ' . $module_name;
    $log_user_id = $_SESSION['user_id'];


    /*Perist Update  */
    $sql = "UPDATE modules SET  module_code =?, module_name =?, module_details =? WHERE module_id =?";
    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

    $prepare  = $mysqli->prepare($sql);
    $log_prepare = $mysqli->prepare($log);

    $bind = $prepare->bind_param(
        'ssss',
        $module_code,
        $module_name,
        $module_details,
        $module_id
    );
    $log_bind = $log_prepare->bind_param(
        'sss',
        $log_ip,
        $log_user_id,
        $log_type
    );

    $prepare->execute();
    $log_prepare->execute();

    if ($prepare && $log_prepare) {
        $success = "$module_code - $module_name Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}

/* Delete Module */
if (isset($_POST['delete_module'])) {
    $module_id = $_POST['module_id'];
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Deleted Module : ' . $module_code . ' ' . $module_name;
    $log_user_id = $_SESSION['user_id'];

    /* Persist Delete */
    $sql = "DELETE FROM modules WHERE module_id =?";
    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

    $prepare = $mysqli->prepare($sql);
    $log_prepare = $mysqli->prepare($log);

    $bind = $prepare->bind_param('s', $module_id);
    $log_bind = $log_prepare->bind_param(
        'sss',
        $log_ip,
        $log_user_id,
        $log_type
    );

    $prepare->execute();
    $log_prepare->execute();

    if ($prepare && $log_prepare) {
        $success = "Module Deleted";
    } else {
        $err = "Failed!, Please Try Again";
    }
}
require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/faculties_sidebar.php'); ?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php require_once('../partials/topbar.php');
    /* Pop Faculty Details */
    $view = $_GET['view'];
    $ret = "SELECT * FROM faculties f
    INNER JOIN users u ON u.user_id = f.faculty_user_id
    WHERE faculty_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($faculty = $res->fetch_object()) {
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
                                        <li class="breadcrumb-item"><a href="faculty_manage">Faculties</a></li>
                                        <li class="breadcrumb-item"><a href="faculty_dashboard?view=<?php echo $_GET['view']; ?>"><?php echo $faculty->faculty_name; ?></a></li>
                                        <li class="breadcrumb-item active">Course Modules</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Modules</h4>
                            </div>
                            <!--end page-title-box-->
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Register New Module</button>
                            </div>
                            <hr>
                        </div>
                        <!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
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
                                                <label>Course Code & Name</label>
                                                <select name="module_course_id" style="width: 100%;" required class="basic form-control">
                                                    <?php
                                                    /* Pop All Courses In Asc Order */
                                                    $ret = "SELECT * FROM courses c
                                                    INNER JOIN departments d ON d.department_id = c.course_department_id
                                                    WHERE d.department_faculty_id = '$view'                                                                                   
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
                                            <div class="form-group col-md-6">
                                                <label>Module Code </label>
                                                <input type="text" placeholder="<?php echo $a . $b; ?>" name="module_code" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Module Name</label>
                                                <input type="text" name="module_name" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Module Details</label>
                                                <textarea type="text" name="module_details" rows="10" required class="summernote form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button name="add_module" class="btn btn-primary" type="submit">
                                                Register Module
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
                                                    $ret = "SELECT * FROM courses c
                                                    INNER JOIN departments d ON d.department_id = c.course_department_id
                                                    WHERE d.department_faculty_id = '$view'                                 
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
                                        <legend class="w-auto text-primary font-weight-light">Registered Course Modules</legend>
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Module Code</th>
                                                                <th>Module Name</th>
                                                                <th>Course</th>
                                                                <th>Manage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $course_id = $_POST['course_id'];
                                                            $ret = "SELECT * FROM modules m 
                                                            INNER JOIN courses c 
                                                            ON c.course_id = m.module_course_id 
                                                            WHERE m.module_course_id = '$course_id'";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($modules = $res->fetch_object()) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $modules->module_code; ?></td>
                                                                    <td><?php echo $modules->module_name; ?></td>
                                                                    <td><?php echo $modules->course_code . ' ' . $modules->course_name; ?></td>
                                                                    <td>
                                                                        <a href="module_dashboard?view=<?php echo $modules->module_id; ?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                                        <a data-toggle="modal" href="#update_<?php echo $modules->module_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                        <a data-toggle="modal" href="#delete_<?php echo $modules->module_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                                    </td>

                                                                    <!-- Udpate Modal -->
                                                                    <div class="modal fade" id="update_<?php echo $modules->module_id; ?>">
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
                                                                                                <label>Module Code </label>
                                                                                                <input type="text" value="<?php echo $modules->module_code; ?>" name="module_code" required class="form-control">
                                                                                            </div>
                                                                                            <div class="form-group col-md-6">
                                                                                                <label>Module Name</label>
                                                                                                <input type="text" name="module_name" value="<?php echo $modules->module_name; ?>" required class="form-control">
                                                                                                <input type="hidden" name="module_id" value="<?php echo $modules->module_id; ?>" required class="form-control">
                                                                                            </div>
                                                                                            <div class="form-group col-md-12">
                                                                                                <label>Module Details</label>
                                                                                                <textarea type="text" name="module_details" rows="10" class="summernote form-control"><?php echo $modules->module_details; ?></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="text-right">
                                                                                            <button name="update_module" class="btn btn-primary" type="submit">
                                                                                                Update Module
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End Modal -->

                                                                    <!-- Delete Modal -->
                                                                    <div class="modal fade" id="delete_<?php echo $modules->module_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                        <h4>Delete <?php echo $modules->module_code . ' - ' . $modules->module_name; ?> </h4>
                                                                                        <br>
                                                                                        <!-- Hide This -->
                                                                                        <input type="hidden" name="module_id" value="<?php echo $modules->module_id; ?>">
                                                                                        <input type="hidden" name="module_code" value="<?php echo $modules->module_code; ?>">
                                                                                        <input type="hidden" name="module_name" value="<?php echo $modules->module_name; ?>">
                                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                                        <input type="submit" name="delete_module" value="Delete" class="text-center btn btn-danger">
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