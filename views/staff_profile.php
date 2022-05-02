<?php
/*
 * Created on Mon Jan 24 2022
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
require_once('../config/app_config.php');
require_once('../config/codeGen.php');

check_login();

/* Update Profile  Picture*/
if (isset($_POST['update_picture'])) {
    $id = $_GET['view'];
    /* Timestamp Every File Upload */
    $time = date("d-M-Y") . "-" . time();
    $profile_pic = $time . $_FILES['profile_pic']['name'];
    $upload_directory = "../public/uploads/user_data/admins/" . $profile_pic;
    $temp_name = $_FILES["profile_pic"]["tmp_name"];
    /* Move Uploaded File */
    move_uploaded_file($temp_name, $upload_directory);

    $query = "UPDATE users  SET  user_dpic =? WHERE user_id =?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ss', $profile_pic, $id);
    $stmt->execute();
    if ($stmt) {
        $success = "Profile Picture Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Update Profile */
if (isset($_POST['update_profile'])) {
    $user_id = $_GET['view'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_phone = $_POST['user_phone'];
    $user_adr  = $_POST['user_adr'];
    $user_access_level  = $_POST['user_access_level'];

    /* Persist */
    $sql = "UPDATE users SET user_name =?, user_email =?, user_phone =?, user_adr = ?, user_access_level =? WHERE user_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('ssssss', $user_name, $user_email, $user_phone, $user_adr, $user_access_level, $user_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Profile Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

/* Trigger Reset Password Mailer */
if (isset($_POST['reset_password'])) {
    //prevent posting blank value for email
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Enter Email Address";
    }
    $query = mysqli_query($mysqli, "SELECT * FROM users WHERE user_email='" . $email . "'");
    $num_rows = mysqli_num_rows($query);

    /* Password Reset URL */
    $reset_url = $url . $tk;

    if ($num_rows > 0) {
        /* Hash Password  */
        $query = "UPDATE users SET  password_reset_token =? WHERE  user_email =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss', $tk, $email);
        $stmt->execute();

        /* Load Mailer */
        require_once('../mailers/reset_password_mailer.php');
        if ($stmt && $mail->send()) {
            $success = "Password Reset Instructions Sent To Your Mail";
        } else {
            $err = "Password Reset Failed!, Try again $mail->ErrorInfo";
        }
    } else {
        /* User Does Not Exist */
        $err = "Sorry, User Account With That Email Does Not Exist";
    }
}
/* Reset Password Manually Without No Mailer Triggering */
if (isset($_POST['reset_password_manually'])) {
    $id = $_GET['view'];
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password =  sha1(md5($_POST['confirm_password']));
    /* Check If They Match */
    if ($new_password != $confirm_password) {
        $err = "Passwords Does Not Match";
    } else {
        /* Update Passwords */
        $sql = "UPDATE users SET user_password =? WHERE user_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ss',
            $confirm_password,
            $id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Password Updated";
        } else {
            $err = "Failed!, Please Try Again";
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
    <?php require_once('../partials/topbar.php');
    /* Load Logged In User Session */
    $id  = $_GET['view'];
    $ret = "SELECT * FROM users WHERE user_id ='$id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($logged_in_user = $res->fetch_object()) {
        /* Has Profile Picture */
        if ($logged_in_user->user_dpic == '') {
            $url = "../public/images/no-profile.png";
        } else {
            $url = "../public/uploads/user_data/admins/$logged_in_user->user_dpic";
        }
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
                                        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Teaching Staffs</a></li>
                                        <li class="breadcrumb-item active"><?php echo $logged_in_user->user_name; ?></li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $logged_in_user->user_name; ?> Profile</h4>
                            </div>
                            <!--end page-title-box-->
                        </div>
                        <!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body  met-pro-bg">
                                    <div class="met-profile">
                                        <div class="row">
                                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                                <div class="met-profile-main">
                                                    <div class="met-profile-main-pic">
                                                        <img src="<?php echo $url; ?>" height="120" width="120" alt="" class="rounded-circle">
                                                        <a href="#edit-profile-pic" data-toggle="modal" class="fro-profile_main-pic-change">
                                                            <i class="fas fa-camera"></i>
                                                        </a>
                                                    </div>
                                                    <!-- Update Profile Pic Modal -->
                                                    <div class="modal fade" id="edit-profile-pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title " id="exampleModalLabel">Upload Profile Picture</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method='post' enctype="multipart/form-data" class="form-horizontal">
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12">
                                                                                <div class="input-group">
                                                                                    <div class="custom-file">
                                                                                        <input type="file" required name="profile_pic" class="custom-file-input" id="exampleInputFile">
                                                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group text-right row">
                                                                            <div class="offset-sm-2 col-sm-10">
                                                                                <button type="submit" name="update_picture" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                    <div class="met-profile_user-detail">
                                                        <h5 class="met-user-name"><?php echo $logged_in_user->user_name; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4 ml-auto">
                                                <ul class="list-unstyled personal-detail">
                                                    <li class="mt-2"><i class="dripicons-tags text-info font-18 mt-2 mr-2"></i> <b>Employee ID</b> : <?php echo $logged_in_user->user_number; ?></li>
                                                    <li class="mt-2"><i class="dripicons-phone mr-2 text-info font-18"></i> <b> Phone </b> : <?php echo $logged_in_user->user_phone; ?></li>
                                                    <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b> Email </b> : <?php echo $logged_in_user->user_email; ?></li>
                                                    <li class="mt-2"><i class="dripicons-location text-info font-18 mt-2 mr-2"></i> <b>Address</b> : <?php echo $logged_in_user->user_adr; ?></li>
                                                    <li class="mt-2"><i class="dripicons-anchor text-info font-18 mt-2 mr-2"></i> <b>Access Level</b> :
                                                        <?php if ($logged_in_user->user_access_level == 'lecturer') { ?>
                                                            Lecturer
                                                        <?php } ?>
                                                    </li>
                                                </ul>

                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end f_profile-->
                                </div>
                                <!--end card-body-->
                                <div class="card-body">
                                    <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link active" id="settings_detail_tab" data-toggle="pill" href="#settings_detail">Profile Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#change_password">Change Password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#email_password">Trigger Reset Password Email</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#allocation_history">Module Allocations History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#logs">Access Logs</a>
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
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="">Name</label>
                                                                <input type="text" required value="<?php echo $logged_in_user->user_name; ?>" name="user_name" class="form-control" id="exampleInputEmail1">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Work Email</label>
                                                                <input type="text" value="<?php echo $logged_in_user->user_email; ?>" required name="user_email" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Phone Number</label>
                                                                <input type="text" value="<?php echo $logged_in_user->user_phone; ?>" required name="user_phone" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Employee ID</label>
                                                                <input type="text" readonly value="<?php echo $logged_in_user->user_number; ?>" required name="user_number" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Access Level</label>
                                                                <select type="text" style="width: 100%;" required name="user_access_level" class="basic form-control">
                                                                    <?php if ($logged_in_user->user_access_level == 'lecturer') { ?>
                                                                        <option value="lecturer">Lecturer - Instructor</option>
                                                                        <option value="educational_admin">Educational Administrator</option>
                                                                    <?php }  ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputPassword1">Address</label>
                                                                <textarea required name="user_adr" rows="2" class="form-control Summernote"><?php echo $logged_in_user->user_adr; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="update_profile" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
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
                                                    <form method='post' class="form-horizontal">
                                                        <div class="form-group row">
                                                            <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" name="new_password" required class="form-control" id="inputEmail">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputName2" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" name="confirm_password" required class="form-control" id="inputName2">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row text-right">
                                                            <div class="offset-sm-2 col-sm-10">
                                                                <button type="submit" name="reset_password_manually" class="btn btn-primary">Submit</button>
                                                            </div>

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
                                                    <form method='post' class="form-horizontal">
                                                        <p class="text-muted text-center mb-3"> Password Reset Instructions Will Be Sent To This Email </p>
                                                        <div class="form-group row">
                                                            <label for="inputName2" class="col-sm-2 col-form-label">Staff Work Email</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" readonly name="email" value="<?php echo $logged_in_user->user_email; ?>" required class="form-control" id="inputName2">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row text-right">
                                                            <div class="offset-sm-2 col-sm-10">
                                                                <button type="submit" name="reset_password" class="btn btn-primary">Send Password Reset Email</button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <div class="tab-pane fade" id="allocation_history">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Module Details</th>
                                                                <th>Allocated Instructor</th>
                                                                <th>Academic Year</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $ret = "SELECT * FROM module_allocations ma
                                                            INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                            INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                            INNER JOIN users u ON u.user_id = ma.allocation_user_id
                                                            WHERE u.user_id = '$id' ";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($allocations = $res->fetch_object()) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $allocations->module_code . ' ' . $allocations->module_name; ?></td>
                                                                    <td><?php echo $allocations->user_number . ' ' . $allocations->user_name; ?></td>
                                                                    <td><?php echo $allocations->calendar_year . ' - ' . $allocations->calendar_semester; ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>

                                <div class="tab-pane fade" id="logs">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="header-title mt-0 mb-3">Most Recent <?php echo $logged_in_user->user_name; ?> System Access Logs & Timeline</h4>
                                                    <div class="main-timeline mt-3">
                                                        <?php
                                                        /* Pop Most Recent Access Logs For This User */
                                                        $user_id = $logged_in_user->user_id;
                                                        $ret = "SELECT * FROM logs 
                                                        WHERE log_user_id = '$user_id'
                                                        ORDER BY  log_created_on DESC
                                                        LIMIT 10 ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($logs = $res->fetch_object()) {
                                                        ?>
                                                            <div class="timeline">
                                                                <span class="timeline-icon"></span>
                                                                <span class="year"><?php echo date('d M Y', strtotime($logs->log_created_on)); ?></span>
                                                                <div class="timeline-content">
                                                                    <h5 class="title"> Log IP Address : <a class="text-primary" data-toggle="modal" href="#ip_details<?php echo $logs->log_id; ?>"><?php echo $logs->log_ip; ?></a></h5>
                                                                    <span class="post"><?php echo date('d M Y g:ia', strtotime($logs->log_created_on)); ?></span>
                                                                    <p class="description">
                                                                        <?php echo $logs->log_type; ?>
                                                                    </p>
                                                                </div>
                                                                <!-- Pop Log IP Details -->
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
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <br>
                                                    <!-- Allow An Export To This User Logs -->
                                                    <div class="text-center">
                                                        <a href="profile_export_logs_xls?user=<?php echo $logged_in_user->user_id ?>" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export To Excel</a>
                                                        <a href="profile_export_logs_pdf?user=<?php echo $logged_in_user->user_id ?>" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Export To PDF</a>
                                                    </div>
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
        <!-- end page-wrapper -->

        <!-- Scripts -->
    <?php
    }
    require_once('../partials/scripts.php'); ?>
</body>

</html>