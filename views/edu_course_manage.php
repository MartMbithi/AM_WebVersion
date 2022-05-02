<?php
/*
 * Created on Sun Feb 27 2022
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

/* Update Course */
if (isset($_POST['update_course'])) {
    $course_id = $_POST['course_id'];
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $course_details = $_POST['course_details'];
    $course_department_id = $_POST['course_department_id'];

    /* Persist Update */
    $sql = "UPDATE courses SET course_code = ?, course_name =?, course_details =?, course_department_id =? WHERE course_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $course_code,
        $course_name,
        $course_details,
        $course_department_id,
        $course_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "$course_code - $course_name Updated";
    } else {
        $err = "Failed, Please Try Again";
    }
}
/* Delete Course */
if (isset($_POST['delete_course'])) {
    $course_id = $_POST['course_id'];
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Deleted Course   : ' . $course_code . ' ' . $course_name;
    $log_user_id = $_SESSION['user_id'];

    /* Pesist Delete */
    $sql = "DELETE FROM courses WHERE course_id = ?";
    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

    $prepare = $mysqli->prepare($sql);
    $log_prepare = $mysqli->prepare($log);

    $bind = $prepare->bind_param('s', $course_id);
    $log_bind  = $log_prepare->bind_param(
        'sss',
        $log_ip,
        $log_user_id,
        $log_type
    );

    $prepare->execute();
    $log_prepare->execute();

    if ($prepare && $log_prepare) {
        $success = "Deleted $course_code - $course_name";
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
                                    <li class="breadcrumb-item"><a href="edu_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Courses</a></li>
                                    <li class="breadcrumb-item active">Manage Courses</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Manage Courses</h4>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->

                <!-- End Modal -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">

                                    <fieldset class="border border-primary p-2">
                                        <legend class="w-auto text-primary font-weight-light">Registered Courses</legend>
                                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Department Details</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM courses c 
                                                INNER JOIN departments d ON c.course_department_id = d.department_id ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($courses = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $courses->course_code; ?></td>
                                                        <td><?php echo $courses->course_name; ?></td>
                                                        <td><?php echo $courses->department_code . ' ' . $courses->department_name; ?></td>
                                                        <td>
                                                            <a href="course_dashboard?view=<?php echo $courses->course_id; ?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                            <a data-toggle="modal" href="#update_<?php echo $courses->course_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $courses->course_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                        </td>
                                                        <!-- Udpate Modal -->
                                                        <div class="modal fade" id="update_<?php echo $courses->course_id; ?>">
                                                            <div class="modal-dialog  modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Fill All Required Fields</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" enctype="multipart/form-data" role="form">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="form-group col-md-6">
                                                                                        <label for="">Course Code</label>
                                                                                        <input type="hidden" value="<?php echo $courses->course_id; ?>" required name="course_id" class="form-control">
                                                                                        <input type="text" value="<?php echo $courses->course_code; ?>" required name="course_code" class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label for="">Course Name</label>
                                                                                        <input type="text" value="<?php echo $courses->course_name; ?>" required name="course_name" class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group col-md-12">
                                                                                        <label for="">Course Department Name</label>
                                                                                        <select class="form-control basic" style="width: 100%;" name="course_department_id">
                                                                                            <option value="<?php echo $courses->course_department_id; ?>"><?php echo $courses->department_code . ' ' . $courses->department_name; ?></option>
                                                                                            <?php
                                                                                            $dep_ret = "SELECT * FROM departments 
                                                                                            ORDER BY  department_code ASC";
                                                                                            $dep_stmt = $mysqli->prepare($dep_ret);
                                                                                            $dep_stmt->execute(); //ok
                                                                                            $dep_res = $dep_stmt->get_result();
                                                                                            while ($departments = $dep_res->fetch_object()) {
                                                                                            ?>
                                                                                                <option value="<?php echo $departments->department_id; ?>"><?php echo $departments->department_code . ' ' . $departments->department_name; ?></option>
                                                                                            <?php } ?>

                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group col-md-12">
                                                                                        <label for="">Course Details / Description</label>
                                                                                        <textarea type="text" rows="5" required name="course_details" class="form-control summernote"><?php echo $courses->course_details; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-right">
                                                                                <button type="submit" name="update_course" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->

                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete_<?php echo $courses->course_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                            <h4>Delete <?php echo $courses->course_code . ' ' . $courses->course_name; ?></h4>
                                                                            <br>
                                                                            <!-- Hide This -->
                                                                            <input type="hidden" name="course_id" value="<?php echo $courses->course_id; ?>">
                                                                            <input type="hidden" name="course_code" value="<?php echo $courses->course_code; ?>">
                                                                            <input type="hidden" name="course_name" value="<?php echo $courses->course_name; ?>">
                                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                            <input type="submit" name="delete_course" value="Delete" class="text-center btn btn-danger">
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
                                    </fieldset>
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
    <!-- end page-wrapper -->
    <!-- Scripts -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>