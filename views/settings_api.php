<?php
/*
 * Created on Thu Jan 27 2022
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

/* Add Api  */
if (isset($_POST['add_api'])) {
    $key_app_name = $_POST['key_app_name'];
    $key_details = $_POST['key_details'];
    $key_oauth_details = $_POST['key_oauth_details'];

    /* Persist */
    $sql = "INSERT INTO api_keys (key_app_name, key_details, key_oauth_details) VALUES(?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sss',
        $key_app_name,
        $key_details,
        $key_oauth_details
    );
    $prepare->execute();
    if ($prepare) {
        $success  = "$key_app_name Registered";
    } else {
        $err = 'Failed!, Please Try Again';
    }
}

/* Update API */
if (isset($_POST['update_api'])) {
    $key_id = $_POST['key_id'];
    $key_app_name = $_POST['key_app_name'];
    $key_details = $_POST['key_details'];
    $key_oauth_details = $_POST['key_oauth_details'];

    /* Persist */
    $sql = "UPDATE api_keys SET key_app_name =?, key_details =?, key_oauth_details =? WHERE key_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $key_app_name,
        $key_details,
        $key_oauth_details,
        $key_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "$key_app_name Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete Api */
if (isset($_POST['delete_api'])) {
    $key_id = $_POST['key_id'];

    /* Delete */
    $sql = "DELETE FROM api_keys WHERE key_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $key_id);
    $prepare->execute();
    if ($prepare) {
        $success = "API Deleted";
    } else {
        $err  = "Failed!, Please Try Again";
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
                                    <li class="breadcrumb-item"><a href="">System Settings</a></li>
                                    <li class="breadcrumb-item active">API's</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Third Party API's Manager</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Add New API</button>
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
                                        <div class="form-group col-md-12">
                                            <label>API Name</label>
                                            <input type="text" name="key_app_name" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>API Key</label>
                                            <input type="text" name="key_details" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>API OAuth Key</label>
                                            <input type="text" name="key_oauth_details" class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_api" class="btn btn-primary" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
                <div class="row">
                    <?php
                    $ret = "SELECT * FROM api_keys 
                        ORDER BY key_app_name ASC ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($app = $res->fetch_object()) {
                    ?>
                        <div class="col-lg-4">
                            <div class="card client-card">
                                <div class="card-body text-center">
                                    <img src="../public/images/icons/api.png" alt="user" class="rounded-circle thumb-xl">
                                    <h5 class="client-name"><?php echo $app->key_app_name; ?></h5>
                                    <p class="text-muted text-center mt-3">Registered On : <?php echo date('d M Y g:ia', strtotime($app->key_created_on)); ?></p>
                                    <div class="text-center">
                                        <a data-toggle="modal" href="#view_<?php echo $app->key_id; ?>" class="badge badge-primary"><i class="fas fa-eye"></i> View</a>
                                        <a data-toggle="modal" href="#update_<?php echo $app->key_id; ?>" class="badge badge-warning"><i class="fas fa-edit"></i> Edit</a>
                                        <a data-toggle="modal" href="#delete_<?php echo $app->key_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                        </div>
                        <!-- Manage API Modals Helper -->
                    <?php include('../helpers/modals/manager_apis.php');
                    } ?>
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