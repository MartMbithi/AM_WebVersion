<?php
/*
 * Created on Sat Dec 18 2021
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

/* Allocate Faculty HOD */
if (isset($_POST['add_allocation'])) {
    $faculty_id = $_POST['faculty_id'];
    $faculty_user_id  = $_POST['faculty_user_id'];
    $faculty_code = $_POST['faculty_code'];
    $faculty_name  = $_POST['faculty_name'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Allocated : ' . $faculty_code . ' ' . $faculty_name . ' New HOD';
    $log_user_id = $_SESSION['user_id'];

    /* Persist */
    $sql  = "UPDATE faculties SET faculty_user_id = ? WHERE faculty_id =?";
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
        $success = "Faculty HOD Allocation Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
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
                                    <li class="breadcrumb-item"><a href="">Faculties</a></li>
                                    <li class="breadcrumb-item active">Allocate Faculty Head</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Manage Allocated Faculty Heads</h4>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                /* Fetch All Faculties In Ascending Order */
                                $ret = "SELECT * FROM faculties f
                                INNER JOIN users u
                                WHERE u.user_id = f.faculty_user_id
                                ORDER BY faculty_code ASC  ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($faculties = $res->fetch_object()) {
                                ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <!-- To Do : Link This Pag To User Profile -->
                                            <div class="card-body">
                                                <!--end ribbon-->
                                                <img src="../public/images/icons/university.png" alt="" class="d-block mx-auto my-4" height="170">
                                                <div class="text-center my-4">
                                                    <div>
                                                        <p class="header-title"><?php echo $faculties->faculty_code . ' ' . $faculties->faculty_name; ?></p>
                                                        <p class="header-title">Current Head: <span class="text-success"><?php echo $faculties->user_number . ' ' . $faculties->user_name; ?></span></p><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-right">
                                                <button data-target="#update_<?php echo $faculties->faculty_id; ?>" data-toggle="modal" class="btn btn-primary">Update Allocated Head</button>
                                            </div>
                                            <!--end card-body-->
                                        </div>
                                        <!--end card-->
                                        <!-- Update Modal -->
                                        <div class="modal fade" id="update_<?php echo $faculties->faculty_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Update <?php echo $faculties->faculty_code . ' ' . $faculties->faculty_name; ?> Head</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" enctype="multipart/form-data" role="form">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="">Faculty Head</label>
                                                                        <!-- Hide This -->
                                                                        <input type="hidden" name="faculty_id" value="<?php echo $faculties->faculty_id; ?>">
                                                                        <input type="hidden" name="faculty_code" value="<?php echo $faculties->faculty_code; ?>">
                                                                        <input type="hidden" name="faculty_name" value="<?php echo $faculties->faculty_name; ?>">
                                                                        <select class="form-control basic" style="width: 100%;" name="faculty_user_id">
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
                                                                <button type="submit" name="add_allocation" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } ?>
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