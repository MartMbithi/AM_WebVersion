<?php
/*
 * Created on Mon Nov 29 2021
 *
 *  Devlan - devlan.co.ke 
 *
 * hello@devlan.info
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2021 Devlan
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

/* Update Allocated User */
if (isset($_POST['update_head'])) {
    $faculty_id = $_GET['view'];
    $faculty_user_id = $_POST['faculty_user_id'];
    $faculty = $_POST['faculty_code'] . ' ' . $_POST['faculty_name'];
    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Allocated : ' . $faculty .  ' New HOD';
    $log_user_id = $_SESSION['user_id'];

    /* Persist */
    $sql = "UPDATE faculties SET faculty_user_id =? WHERE faculty_id = ?";
    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

    $prepare = $mysqli->prepare($sql);
    $log_prepare = $mysqli->prepare($log);

    $bind = $prepare->bind_param('ss', $faculty_user_id, $faculty_id);
    $log_bind = $log_prepare->bind_param(
        'sss',
        $log_ip,
        $log_user_id,
        $log_type
    );

    $prepare->execute();
    $log_prepare->execute();

    if ($prepare && $log_bind) {
        $success = "Faculty Head Details Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}

/* Update Faculty Details */
if (isset($_POST['update_faculty'])) {
    $faculty_id = $_GET['view'];
    $faculty_code = $_POST['faculty_code'];
    $faculty_name = $_POST['faculty_name'];
    $faculty_details = $_POST['faculty_details'];

    /* Persist */
    $sql = "UPDATE faculties SET faculty_code =?, faculty_name =?, faculty_details =? WHERE faculty_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $faculty_code,
        $faculty_name,
        $faculty_details,
        $faculty_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Faculty Details Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
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
        require_once('../partials/faculty_analytics.php');

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
                                    <li class="breadcrumb-item"><a href="faculty_manage">Faculties</a></li>
                                    <li class="breadcrumb-item active"><?php echo $faculty->faculty_name; ?></li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo $faculty->faculty_code . ' ' . $faculty->faculty_name; ?> Dashboard</h4>
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
                                                        <img src="../public/images/icons/university.png" height="120" width="120" alt="" class="rounded-circle">
                                                    </div>

                                                    <div class="met-profile_user-detail">
                                                        <h5 class="met-user-name"><?php echo $faculty->faculty_code . ' ' . $faculty->faculty_name; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4 ml-auto">
                                                <ul class="list-unstyled personal-detail">
                                                    <li class="mt-2"><i class="dripicons-tags text-info font-18 mt-2 mr-2"></i> <b>Faculty Code </b> : <?php echo $faculty->user_number; ?></li>
                                                    <li class="mt-2"><i class="dripicons-user mr-2 text-info font-18"></i> <b> Faculty Head </b> : <?php echo $faculty->user_number . ' ' . $faculty->user_name; ?></li>
                                                    <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b> Faculty Head Email </b> : <?php echo $faculty->user_email; ?></li>
                                                    <li class="mt-2"><i class="dripicons-phone text-info font-18 mt-2 mr-2"></i> <b>Faculty Head Phone</b> : <?php echo $faculty->user_phone; ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--end row-->
                                        <hr>
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php echo $faculty->faculty_details; ?>
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
                                            <a class="nav-link active" id="settings_detail_tab" data-toggle="pill" href="#settings_detail">Faculty Analytics</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#change_password">Manage Faculty Head</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#email_password">Manage Faculty Details</a>
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
                                                <div class="col-lg-4">
                                                    <a href="faculty_dept_manage?view=<?php echo $view; ?>">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4 align-self-center">
                                                                        <div class="icon-info">
                                                                            <i class="fas fa-building align-self-center icon-lg icon-dual-purple"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 align-self-center text-right">
                                                                        <div class="ml-2">
                                                                            <p class="mb-1 text-muted">Departments</p>
                                                                            <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $departments; ?></h3>
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
                                                <div class="col-lg-4">
                                                    <a href="faculty_course_manage?view=<?php echo $view; ?>">
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
                                                                            <p class="mb-0 text-muted">Courses</p>
                                                                            <h3 class="mt-0 mb-1 font-weight-semibold d-inline-block"><?php echo $courses; ?></h3>

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
                                                <div class="col-lg-4">
                                                    <a href="faculty_course_modules?view=<?php echo $view; ?>">
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
                                                                            <p class="mb-1 text-muted">Modules</p>
                                                                            <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $modules; ?></h3>
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

                                <div class="tab-pane fade" id="change_password">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Current Faculty Head</label>
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="faculty_code" value="<?php echo $faculty->faculty_code; ?>">
                                                                    <input type="hidden" name="faculty_name" value="<?php echo $faculty->faculty_name; ?>">
                                                                    <select class="form-control basic" style="width: 100%;" name="faculty_user_id">
                                                                        <option value="<?php echo $faculty->faculty_user_id; ?>"><?php echo $faculty->user_number . ' ' . $faculty->user_name; ?></option>
                                                                        <?php
                                                                        $sql = "SELECT * FROM users 
                                                                        WHERE user_access_level !='student'
                                                                        ORDER BY  user_number ASC";
                                                                        $prepare = $mysqli->prepare($sql);
                                                                        $prepare->execute(); //ok
                                                                        $return = $prepare->get_result();
                                                                        while ($users = $return->fetch_object()) {
                                                                        ?>
                                                                            <option value="<?php echo $users->user_id; ?>"><?php echo $users->user_number . ' ' . $users->user_name; ?></option>
                                                                        <?php } ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="update_head" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
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
                                                                    <label for="">Faculty Code</label>
                                                                    <input type="text" value="<?php echo $faculty->faculty_code; ?>" required name="faculty_code" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Faculty Name</label>
                                                                    <input type="text" value="<?php echo $faculty->faculty_name; ?>" required name="faculty_name" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Faculty Details / Description</label>
                                                                    <textarea type="text" rows="5" required name="faculty_details" class="summernote form-control"><?php echo $faculty->faculty_details; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="update_faculty" class="btn btn-primary">Submit</button>
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