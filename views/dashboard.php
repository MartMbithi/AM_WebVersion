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
require_once('../partials/analytics.php');

/* Delete Requisition */
if (isset($_POST['delete_requisition'])) {
    $requisition_id = $_POST['requisition_id'];
    /* Persist */
    $sql = "DELETE FROM requisitions WHERE requisition_id = '$requisition_id' ";
    $prepare = $mysqli->prepare($sql);
    $prepare->execute();
    if ($prepare) {
        $success =  "Requisition record deleted";
    } else {
        $err = "Failed!, Please try again";
    }
}

/* Update Requisitios*/
if (isset($_POST['update_requisitions'])) {
    $requisition_id = $_POST['requisition_id'];
    $requisition_progress  = $_POST['requisition_progress'];
    /* Persist */
    $sql = "UPDATE requisitions SET requisition_progress = ? WHERE requisition_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('ss', $requisition_progress, $requisition_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Requisition Updated";
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

    <?php
    /* Handle Fall Back Urls Incase Sessions Gets Messed Up */
    if ($_SESSION['user_access_level'] == 'sys_admin') {
    ?>
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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Admin Dashboard</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Administrator Dashboard</h4>
                            </div>
                            <!--end page-title-box-->
                        </div>
                        <!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="faculty_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-university align-self-center icon-lg icon-dual-warning"></i>
                                                </div>
                                            </div>
                                            <div class="col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Faculties</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $faculties; ?></h3>
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

                        <div class="col-lg-3">
                            <a href="dept_manage">
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

                        <div class="col-lg-3">
                            <a href="course_manage">
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

                        <div class="col-lg-3">
                            <a href="module_manage">
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


                        <!--end col-->

                        <div class="col-lg-4">
                            <a href="admins_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-user-secret align-self-center icon-lg icon-dual-purple"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Administrators</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $admins; ?></h3>
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
                            <a href="staff_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-user-tie align-self-center icon-lg icon-dual-success"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Lecturers</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $lecs; ?></h3>
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
                            <a href="student_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-user-graduate align-self-center icon-lg icon-dual-pink"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Students</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $students; ?></h3>
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
                    <!--end row-->

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0">Recent Users Login Activity</h4>
                                    <div class="">
                                        <table class="table">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th>User Details</th>
                                                    <th>Login IP Address</th>
                                                    <th>Time Logged In</th>
                                                </tr>
                                                <!--end tr-->
                                            </thead>
                                            <tbody>
                                                <?php
                                                /* Load User Login Logs */
                                                $ret = "SELECT * FROM logs l INNER JOIN users u 
                                                ON l.log_user_id = u.user_id  WHERE log_type = 'Authentication'
                                                ORDER BY l.log_created_on DESC LIMIT 4";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($logs = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            Reg No : <?php echo $logs->user_number; ?><br>
                                                            Name : <?php echo $logs->user_name; ?>
                                                        </td>
                                                        <td><a class="text-primary" data-toggle="modal" href="#ip_details<?php echo $logs->log_id; ?>"><?php echo $logs->log_ip; ?></a></td>
                                                        <td><span class="badge badge-md badge-soft-purple"><?php echo date('d, M Y - g:ia', strtotime($logs->log_created_on)); ?></span></td>
                                                        <!-- IP ADDRESS Details -->
                                                        <div class="modal fade" id="ip_details<?php echo $logs->log_id; ?>">
                                                            <div class="modal-dialog modal-dialog-centered  modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title"><?php echo $logs->log_ip; ?> Details</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php
                                                                        /* Parse This Log IP Address */
                                                                        $ip = $logs->log_ip;
                                                                        $ch = curl_init('http://ipwhois.app/json/' . $ip);
                                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                        $json = curl_exec($ch);
                                                                        curl_close($ch);
                                                                        // Decode JSON response
                                                                        $ipwhois_result = json_decode($json, true);
                                                                        ?>
                                                                        <ul class="list-group list-group-flush">
                                                                            <li class="list-group-item">IP Address Type : <span class="text-success"> <?php echo $ipwhois_result["type"]; ?></span> </li>
                                                                            <li class="list-group-item">Continent & Code : <span class="text-success"> <?php echo $ipwhois_result["continent_code"] . ', ' . $ipwhois_result["continent"]; ?></li>
                                                                            <li class="list-group-item">Country : <span class="text-success"> <?php echo $ipwhois_result["country_phone"] . ', ' . $ipwhois_result["country_code"] . ',  ' . $ipwhois_result['country']; ?> </li>
                                                                            <li class="list-group-item">City : <span class="text-success"> <?php echo $ipwhois_result["city"]; ?></span> </li>
                                                                            <li class="list-group-item">Latitude : <span class="text-success"> <?php echo $ipwhois_result["latitude"]; ?></span> </li>
                                                                            <li class="list-group-item">Longitude : <span class="text-success"> <?php echo $ipwhois_result["longitude"]; ?></span> </li>
                                                                            <li class="list-group-item">Organization : <span class="text-success"> <?php echo $ipwhois_result["org"]; ?></span> </li>
                                                                            <li class="list-group-item">ISP : <span class="text-success"> <?php echo $ipwhois_result["isp"]; ?></span> </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body dash-info-carousel">
                                    <h4 class="mt-0 header-title mb-4">System And Database Server Status</h4>
                                    <div class="bg-light p-3 d-flex justify-content-between">
                                        <?php
                                        $server_info = mysqli_get_server_info($mysqli);
                                        $array = explode("  ", mysqli_stat($mysqli));
                                        ?>
                                        <div>
                                            <p class="text-muted mb-0">Server Version</p>
                                            <h5 class="mb-1 font-weight-semibold"><?php echo $server_info; ?></h5>
                                        </div>
                                    </div>
                                    <div class="media mt-3">
                                        <div class="media-body align-self-center">
                                            <?php
                                            foreach ($array as $value) {
                                                echo "<p class='text-muted mb-0'> <i class='fas fa-check'></i> Server " . $value . "<br /></p>";
                                            }; ?>
                                        </div>
                                        <!--end media-body-->
                                    </div>
                                    <hr class="hr-dashed">
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->

                    </div>
                    <!--end row-->


                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">Recent Users Requisitions</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Requisition By</th>
                                                    <th>Created At</th>
                                                    <th>Progress</th>
                                                    <th>Action</th>
                                                </tr>
                                                <!--end tr-->
                                            </thead>

                                            <tbody>
                                                <?php
                                                /* Load User Requests */
                                                $ret = "SELECT * FROM requisitions r INNER JOIN users u 
                                                ON r.requisition_user_id = u.user_id
                                                ORDER BY r.requisition_created_at ASC
                                                LIMIT 20";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($req = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            Reg No : <?php echo $req->user_number; ?><br>
                                                            Name : <?php echo $req->user_name; ?>
                                                        </td>
                                                        <td><span class="badge badge-md badge-soft-purple"><?php echo date('d, M Y - g:ia', strtotime($req->requisition_created_at)); ?></span></td>
                                                        <td>
                                                            <small class="float-right text-muted ml-3 font-13"><?php echo $req->requisition_progress; ?>%</small>
                                                            <div class="progress mt-2" style="height:3px;">
                                                                <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $req->requisition_progress; ?>%; border-radius:5px;" aria-valuenow="<?php echo $req->requisition_progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" href="#view_<?php echo $req->requisition_id ?>" class="mr-2"><i class="fas fa-eye text-info font-16"></i></a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $req->requisition_id ?>" class="mr-2"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                                        </td>
                                                    </tr>
                                                    <!-- View & Update Modal -->
                                                    <div class="modal fade" id="view_<?php echo $req->requisition_id; ?>">
                                                        <div class="modal-dialog  modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"><?php echo $user_name; ?> Requisition Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $req->requisition_details; ?>
                                                                    <br>
                                                                    <div class="text-right text-success">
                                                                        Created On: <?php echo date('d M Y g:ia', strtotime($req->requisition_created_at)); ?>
                                                                    </div>
                                                                    <hr>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label>Requisition Status</label>
                                                                                <input type="hidden" value="<?php echo $req->requisition_id; ?>" name="requisition_id" required class="form-control">
                                                                                <select name="requisition_progress" style="width: 100%;" required class="basic form-control">
                                                                                    <option value="0">Pending</option>
                                                                                    <option value="50">On Progress</option>
                                                                                    <option value="100">Completed</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button name="update_requisitions" class="btn btn-primary" type="submit">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End View & Update Modal -->


                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $req->requisition_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete This Requisition </h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="requisition_id" value="<?php echo $req->requisition_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_requisition" value="Delete" class="text-center btn btn-danger">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">System Bugs / Halts Reports</h4>
                                    <div class="slimscroll crm-dash-activity">
                                        <div class="activity">
                                            <?php
                                            /* Load Crashlytics */
                                            $ret = "SELECT * FROM bug_reports WHERE bug_fixing_status  = 'Pending Fix'   ORDER BY bug_reported_on DESC LIMIT 10 ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($bugs = $res->fetch_object()) {
                                            ?>
                                                <a href="bug_reports">
                                                    <div class="activity-info">
                                                        <div class="icon-info-activity">
                                                            <i class="mdi mdi-alarm-light-outline  bg-soft-danger"></i>
                                                        </div>
                                                        <div class="activity-info-text">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="m-0 w-75 text-bold"><?php echo $bugs->bug_title; ?></h6>
                                                                <small class="text-muted d-block"><?php echo date('d M Y - g:ia', strtotime($bugs->bug_reported_on)); ?></small>
                                                            </div>
                                                            <p class="text-muted mt-3">
                                                                <?php echo substr($bugs->bug_details, 0, 50); ?>...
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <hr class="hr-dashed">
                                            <?php
                                            } ?>
                                        </div>
                                        <!--end activity-->
                                    </div>
                                    <!--end crm-dash-activity-->
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div><!-- container -->
                <!-- Footer -->
                <?php require_once('../partials/footer.php'); ?>
                <!--end footer-->
            </div>
            <!-- end page content -->
        </div>
    <?php } else if ($_SESSION['user_access_level'] == 'educational_admin') { ?>
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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Educational Admin Dashboard</h4>
                            </div>
                            <!--end page-title-box-->
                        </div>
                        <!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-4">
                            <a href="edu_faculty_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-university align-self-center icon-lg icon-dual-warning"></i>
                                                </div>
                                            </div>
                                            <div class="col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Faculties</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $faculties; ?></h3>
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
                            <a href="edu_dept_manage">
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
                            <a href="edu_course_manage">
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
                            <a href="edu_module_manage">
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



                        <div class="col-lg-4">
                            <a href="edu_staff_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-user-tie align-self-center icon-lg icon-dual-success"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Lecturers</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $lecs; ?></h3>
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
                            <a href="edu_student_manage">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-4 align-self-center">
                                                <div class="icon-info">
                                                    <i class="fas fa-user-graduate align-self-center icon-lg icon-dual-pink"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-8 align-self-center text-right">
                                                <div class="ml-2">
                                                    <p class="mb-1 text-muted">Students</p>
                                                    <h3 class="mt-0 mb-1 font-weight-semibold"><?php echo $students; ?></h3>
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
                    <!--end row-->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0">Recent Users Login Activity</h4>
                                    <div class="">
                                        <table class="table">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th>User Details</th>
                                                    <th>Login IP Address</th>
                                                    <th>Time Logged In</th>
                                                </tr>
                                                <!--end tr-->
                                            </thead>
                                            <tbody>
                                                <?php
                                                /* Load User Login Logs */
                                                $ret = "SELECT * FROM logs l INNER JOIN users u 
                                                ON l.log_user_id = u.user_id  WHERE log_type = 'Authentication'
                                                AND u.user_access_level !='sys_admin'
                                                ORDER BY l.log_created_on DESC LIMIT 4";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($logs = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            Reg No : <?php echo $logs->user_number; ?><br>
                                                            Name : <?php echo $logs->user_name; ?>
                                                        </td>
                                                        <td><a class="text-primary" data-toggle="modal" href="#ip_details<?php echo $logs->log_id; ?>"><?php echo $logs->log_ip; ?></a></td>
                                                        <td><span class="badge badge-md badge-soft-purple"><?php echo date('d, M Y - g:ia', strtotime($logs->log_created_on)); ?></span></td>
                                                        <!-- IP ADDRESS Details -->
                                                        <div class="modal fade" id="ip_details<?php echo $logs->log_id; ?>">
                                                            <div class="modal-dialog modal-dialog-centered  modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title"><?php echo $logs->log_ip; ?> Details</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php
                                                                        /* Parse This Log IP Address */
                                                                        $ip = $logs->log_ip;
                                                                        $ch = curl_init('http://ipwhois.app/json/' . $ip);
                                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                        $json = curl_exec($ch);
                                                                        curl_close($ch);
                                                                        // Decode JSON response
                                                                        $ipwhois_result = json_decode($json, true);
                                                                        ?>
                                                                        <ul class="list-group list-group-flush">
                                                                            <li class="list-group-item">IP Address Type : <span class="text-success"> <?php echo $ipwhois_result["type"]; ?></span> </li>
                                                                            <li class="list-group-item">Continent & Code : <span class="text-success"> <?php echo $ipwhois_result["continent_code"] . ', ' . $ipwhois_result["continent"]; ?></li>
                                                                            <li class="list-group-item">Country : <span class="text-success"> <?php echo $ipwhois_result["country_phone"] . ', ' . $ipwhois_result["country_code"] . ',  ' . $ipwhois_result['country']; ?> </li>
                                                                            <li class="list-group-item">City : <span class="text-success"> <?php echo $ipwhois_result["city"]; ?></span> </li>
                                                                            <li class="list-group-item">Latitude : <span class="text-success"> <?php echo $ipwhois_result["latitude"]; ?></span> </li>
                                                                            <li class="list-group-item">Longitude : <span class="text-success"> <?php echo $ipwhois_result["longitude"]; ?></span> </li>
                                                                            <li class="list-group-item">Organization : <span class="text-success"> <?php echo $ipwhois_result["org"]; ?></span> </li>
                                                                            <li class="list-group-item">ISP : <span class="text-success"> <?php echo $ipwhois_result["isp"]; ?></span> </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                        </div>
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">Recent Users Requisitions</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Requisition By</th>
                                                    <th>Created At</th>
                                                    <th>Progress</th>
                                                    <th>Action</th>
                                                </tr>
                                                <!--end tr-->
                                            </thead>

                                            <tbody>
                                                <?php
                                                /* Load User Requests */
                                                $ret = "SELECT * FROM requisitions r INNER JOIN users u 
                                                ON r.requisition_user_id = u.user_id
                                                ORDER BY r.requisition_created_at ASC
                                                LIMIT 20";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($req = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            Reg No : <?php echo $req->user_number; ?><br>
                                                            Name : <?php echo $req->user_name; ?>
                                                        </td>
                                                        <td><span class="badge badge-md badge-soft-purple"><?php echo date('d, M Y - g:ia', strtotime($req->requisition_created_at)); ?></span></td>
                                                        <td>
                                                            <small class="float-right text-muted ml-3 font-13"><?php echo $req->requisition_progress; ?>%</small>
                                                            <div class="progress mt-2" style="height:3px;">
                                                                <div class="progress-bar bg-pink" role="progressbar" style="width: <?php echo $req->requisition_progress; ?>%; border-radius:5px;" aria-valuenow="<?php echo $req->requisition_progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a data-toggle="modal" href="#view_<?php echo $req->requisition_id ?>" class="mr-2"><i class="fas fa-eye text-info font-16"></i></a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $req->requisition_id ?>" class="mr-2"><i class="fas fa-trash-alt text-danger font-16"></i></a>
                                                        </td>
                                                    </tr>
                                                    <!-- View & Update Modal -->
                                                    <div class="modal fade" id="view_<?php echo $req->requisition_id; ?>">
                                                        <div class="modal-dialog  modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"><?php echo $user_name; ?> Requisition Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $req->requisition_details; ?>
                                                                    <br>
                                                                    <div class="text-right text-success">
                                                                        Created On: <?php echo date('d M Y g:ia', strtotime($req->requisition_created_at)); ?>
                                                                    </div>
                                                                    <hr>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label>Requisition Status</label>
                                                                                <input type="hidden" value="<?php echo $req->requisition_id; ?>" name="requisition_id" required class="form-control">
                                                                                <select name="requisition_progress" style="width: 100%;" required class="basic form-control">
                                                                                    <option value="0">Pending</option>
                                                                                    <option value="50">On Progress</option>
                                                                                    <option value="100">Completed</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button name="update_requisitions" class="btn btn-primary" type="submit">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End View & Update Modal -->


                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete_<?php echo $req->requisition_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <h4>Delete This Requisition </h4>
                                                                        <br>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="requisition_id" value="<?php echo $req->requisition_id; ?>">
                                                                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                        <input type="submit" name="delete_requisition" value="Delete" class="text-center btn btn-danger">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                    </div>
                    <!--end row-->

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