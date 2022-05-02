<?php
/*
 * Created on Thu Feb 03 2022
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

/* Update Course Details */
if (isset($_POST['update_course'])) {
    $course_id = $_GET['view'];
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $course_details = $_POST['course_details'];

    /* Persist */
    $sql = "UPDATE courses SET course_code =?, course_name =?, course_details =? WHERE course_code = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $course_code,
        $course_name,
        $course_details,
        $course_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Course Details Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/courses_sidebar.php'); ?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php require_once('../partials/topbar.php');
    /* Pop Faculty Details */
    $view = $_GET['view'];
    $ret = "SELECT * FROM courses c
    INNER JOIN departments d ON d.department_id = c.course_department_id
    INNER JOIN faculties f ON f.faculty_id = d.department_faculty_id
    WHERE c.course_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($course = $res->fetch_object()) {
        require_once('../partials/courses_analytics.php');

    ?>
        <!-- Top Bar End -->

        <div class="page-wrapper">

            <!-- Page Content-->
            <div class="page-content-tab">

                <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="course_manage">Courses</a></li>
                                    <li class="breadcrumb-item active"><?php echo $course->course_name; ?></li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo $course->course_name . ' ' . $course->course_code; ?> Dashboard</h4>
                            <!--end page-title-box-->
                        </div>
                        <!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <br><br>

                                <div class="card-body  met-pro-bg">
                                    <div class="met-profile">
                                        <div class="row">
                                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                                <div class="met-profile-main">
                                                    <div class="met-profile-main-pic">
                                                        <img src="../public/images/icons/departments.png" height="120" width="120" alt="" class="rounded-circle">
                                                    </div>

                                                    <div class="met-profile_user-detail">
                                                        <h5 class="met-user-name"><?php echo $course->course_code . ' ' . $course->course_name; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4 ml-auto">
                                                <ul class="list-unstyled personal-detail">
                                                    <li class="mt-2">
                                                        <i class="dripicons-tags mr-2 text-info font-18"></i> <b> Faculty </b> : <?php echo $course->faculty_code . ' ' . $course->faculty_name; ?>
                                                    </li>
                                                    <li class="mt-2">
                                                        <i class="dripicons-tags mr-2 text-info font-18"></i> <b> Department </b> : <?php echo $course->department_code . ' ' . $course->department_name; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--end row-->
                                        <hr>
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php echo $course->course_details; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end f_profile-->
                                </div>
                                <!--end card-body-->
                                <div class="card-body">
                                    <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="settings_detail_tab" data-toggle="pill" href="#settings_detail">Course Analytics</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#email_password">Manage Course Details</a>
                                        </li>
                                    </ul>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content detail-list" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="settings_detail">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <a href="course_dashboard_module_manage?view=<?php echo $view; ?>">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4 align-self-center">
                                                                        <div class="icon-info">
                                                                            <i class=" fas fa-chalkboard-teacher align-self-center icon-lg icon-dual-success"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 align-self-center text-right">
                                                                        <div class="ml-2">
                                                                            <p class="mb-0 text-muted">Modules</p>
                                                                            <h3 class="mt-0 mb-1 font-weight-semibold d-inline-block"><?php echo $modules; ?></h3>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!--end card-body-->
                                                        </div>
                                                        <!--end card-->
                                                    </a>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <a href="course_dashboard_memos?view=<?php echo $view; ?>">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-4 col-4 align-self-center">
                                                                        <div class="icon-info">
                                                                            <i class="fas fa-chalkboard align-self-center icon-lg icon-dual-pink"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-8 col-8 align-self-center text-right">
                                                                        <div class="ml-2">
                                                                            <p class="mb-1 text-muted">Posted Memos</p>
                                                                            <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $memos; ?></h3>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!--end card-body-->
                                                        </div>
                                                        <!--end card-->
                                                    </a>
                                                </div>
                                                <!--end col-->
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>

                                <div class="tab-pane fade" id="email_password">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Course Code</label>
                                                                    <input type="text" value="<?php echo $course->course_code; ?>" required name="course_id" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Course Name</label>
                                                                    <input type="text" value="<?php echo $course->course_name; ?>" required name="course_name" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Course Details / Description</label>
                                                                    <textarea type="text" rows="5" required name="course_details" class="form-control summernote"><?php echo $course->course_details; ?></textarea>
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
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                            <!--end tab-content-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div><!-- container -->

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