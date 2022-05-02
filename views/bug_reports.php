<?php
/*
 * Created on Fri Jan 28 2022
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

/* Marked All As Fixed */
if (isset($_POST['mark_as_read'])) {
    $bug_fixing_status = "Fixed";

    /* Update  Status */
    $sql = "UPDATE bug_reports SET bug_fixing_status = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        's',
        $bug_fixing_status,
    );
    $prepare->execute();
    if ($prepare) {
        $success = "All Bugs Marked Fixed";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete All Bug Reports */
if (isset($_POST['delete_all'])) {
    /* Delete */
    $sql = "DELETE FROM bug_reports";
    $prepare = $mysqli->prepare($sql);
    $prepare->execute();
    if ($prepare) {
        $success = "Bug Reports Cleared";
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
                                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                    <li class="breadcrumb-item active">Bug Reports</li>
                                </ol>
                            </div>
                            <h4 class="page-title">System Halts And Bug Reports</h4>
                        </div>
                        <!--end page-title-box-->
                        <!--end page-title-box-->
                        <div class="text-right">
                            <form method="POST">
                                <button type="submit" name="delete_all" class="btn btn-primary">Clear All</button>
                                <button type="submit" name="mark_as_read" class="btn btn-primary">Mark All As Fixed</button>
                            </form>
                        </div>
                        <hr>
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->


                <div class="row">
                    <div class="col-lg-12">
                        <div class="carousel-inner">
                            <?php
                            $ret = "SELECT * FROM bug_reports br 
                            INNER JOIN users u ON u.user_id = br.bug_user_id
                            ORDER BY bug_reported_on DESC  ";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->execute(); //ok
                            $res = $stmt->get_result();
                            while ($bugs = $res->fetch_object()) {
                                /* Set Borders As Unread And Read */
                                if ($bugs->bug_fixing_status == 'Pending Fix') {
                                    $border = "border border-danger";
                                } else {
                                    $border = "border border-success";
                                }
                            ?>
                                <div class="card <?php echo $border; ?>">
                                    <div class="card-body">
                                        <div class="media-body align-self-center">
                                            <h4 class="mt-0 mb-1 title-text text-primary">Reported By : <?php echo $bugs->user_number . ' ' . $bugs->user_name; ?></h4>
                                            <hr>
                                            <h4 class="mt-0 mb-1 title-text text-danger"><?php echo $bugs->bug_title; ?></h4>
                                            <p class="text-muted mb-1"><?php echo  $bugs->bug_details; ?></p>
                                        </div>
                                        <div class="text-right">
                                            <small class="mt-0 mb-1">Reported On <?php echo date('d M Y g:ia', strtotime($bugs->bug_reported_on)); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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