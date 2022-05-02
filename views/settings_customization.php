<?php
/*
 * Created on Wed Jan 26 2022
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

/* Udpate System Name, Tagline & Version */
if (isset($_POST['update_system_core'])) {
    $system_name = $_POST['system_name'];
    $system_tagline = $_POST['system_tagline'];
    $system_version = $_POST['system_version'];

    /* Persist */
    $sql = "UPDATE system_settings SET system_name =?, system_tagline =?, system_version =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sss',
        $system_name,
        $system_tagline,
        $system_version
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Core System Details Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update System Logo */
if (isset($_POST['update_system_logo'])) {
    $system_logo = $_FILES['system_logo']['name'];
    /* Perform Some ABRACADABRA On System Logo */
    $time = date("d-M-Y_g:ia") . "-";
    $timestamped_logo = $time . $system_logo;
    $upload_directory = "../public/images/" . $timestamped_logo;
    $temp_name = $_FILES["system_logo"]["tmp_name"];
    /* Move Uploaded File */
    move_uploaded_file($temp_name, $upload_directory);

    /* Persist */
    $sql = "UPDATE system_settings SET system_logo = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        's',
        $timestamped_logo
    );
    $prepare->execute();
    if ($prepare) {
        $success = "System Logo Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Allowed Plugins - Calendar Plugin Embed Url */
if (isset($_POST['update_link'])) {
    $system_calendar_embed_code = $_POST['system_calendar_embed_code'];

    /* Persist */
    $sql = "UPDATE system_settings SET system_calendar_embed_code =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $system_calendar_embed_code);
    $prepare->execute();
    if ($prepare) {
        $success = "Calendar Embed Link Updated";
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
    <?php require_once('../partials/topbar.php');
    /* Pop System Settings Here */
    $ret = "SELECT * FROM system_settings";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($sys = $res->fetch_object()) {

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
                                        <li class="breadcrumb-item"><a href="">Settings</a></li>
                                        <li class="breadcrumb-item active">System Configurations</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Manage Core System Settings</h4>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link waves-effect waves-light active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Core System Settings</a>
                                                <a class="nav-link waves-effect waves-light" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">System Logo</a>
                                                <a class="nav-link waves-effect waves-light" id="v-pills-profile-tab-settings" data-toggle="pill" href="#v-pills-profile-settings" role="tab" aria-controls="v-pills-profile-settings" aria-selected="false">Calendar Embed Url</a>

                                            </div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="tab-content mo-mt-2" id="v-pills-tabContent">
                                                <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Company Name</label>
                                                                    <input type="text" value="<?php echo $sys->system_name; ?>" required name="system_name" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="">System Version</label>
                                                                    <input type="text" value="<?php echo $sys->system_version; ?>" required name="system_version" readonly class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Company Tagline</label>
                                                                    <textarea type="text" required name="system_tagline" class="summernote form-control"><?php echo $sys->system_tagline; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="update_system_core" class="btn btn-primary">Save Company Settings</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="exampleInputFile">Select File</label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input required name="system_logo" accept=".png, .jpeg, .jpg" type="file" class="custom-file-input">
                                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" name="update_system_logo" class="btn btn-primary">Update Company Logo</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-profile-settings" role="tabpanel" aria-labelledby="v-pills-profile-tab-settings">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label>Public Calendar URL</label>
                                                                <textarea rows="2" name="system_calendar_embed_code" required class="form-control"><?php echo $sys->system_calendar_embed_code; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button name="update_link" class="btn btn-primary" type="submit">
                                                                Save Embed Link
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                        </div>
                    </div>
                    <!--end card-->
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