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
/* Update Faculty */
if (isset($_POST['update_faculty'])) {
    $faculty_id = $_POST['faculty_id'];
    $faculty_code = $_POST['faculty_code'];
    $faculty_name = $_POST['faculty_name'];
    $faculty_details = $_POST['faculty_details'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Updated Faculty  : ' . $faculty_code . ' ' . $faculty_name;
    $log_user_id = $_SESSION['user_id'];

    /* Persist */
    $sql = "UPDATE faculties SET faculty_code = ?, faculty_name =?, faculty_details =? WHERE faculty_id = ?";
    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";


    $prepare = $mysqli->prepare($sql);
    $log_prepare = $mysqli->prepare($log);


    $bind = $prepare->bind_param(
        'ssss',
        $faculty_code,
        $faculty_name,
        $faculty_details,
        $faculty_id
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
        $success = "$faculty_code, $faculty_name Details Updated";
    } else {
        $err = "Update Failed!, Please Try Again Later";
    }
}

/* Delete Faculty */
if (isset($_POST['delete'])) {
    $faculty_id = $_POST['faculty_id'];
    $faculty_code = $_POST['faculty_code'];
    $faculty_name = $_POST['faculty_name'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Deleted Faculty  : ' . $faculty_code . ' ' . $faculty_name;
    $log_user_id = $_SESSION['user_id'];

    /* Persist */
    $sql = "DELETE FROM faculties WHERE faculty_id =?";
    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

    $prepare = $mysqli->prepare($sql);
    $log_prepare = $mysqli->prepare($log);

    $bind = $prepare->bind_param('s', $faculty_id);
    $log_bind = $log_prepare->bind_param(
        'sss',
        $log_ip,
        $log_user_id,
        $log_type
    );

    $prepare->execute();
    $log_prepare->execute();


    if ($prepare && $log_prepare) {
        $success = "Faculty Details Deleted";
    } else {
        $err = "Delete Failed!, Please Try Again Later";
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
                                    <li class="breadcrumb-item active">Manage Faculties</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Manage Faculties</h4>
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
                                        <legend class="w-auto text-primary font-weight-light">Registered Faculties</legend>
                                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Faculty Code</th>
                                                    <th>Faculty Name</th>
                                                    <th>Faculty Head</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM faculties f
                                                INNER JOIN users u 
                                                ON u.user_id = f.faculty_user_id ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($faculties = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $faculties->faculty_code; ?></td>
                                                        <td><?php echo $faculties->faculty_name; ?></td>
                                                        <td><?php echo $faculties->user_number . ' ' . $faculties->user_name; ?></td>
                                                        <td>
                                                            <a data-toggle="modal" href="#update_<?php echo $faculties->faculty_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $faculties->faculty_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                        </td>
                                                        <!-- Udpate Modal -->
                                                        <div class="modal fade" id="update_<?php echo $faculties->faculty_id; ?>">
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
                                                                            <fieldset class="border border-primary p-2">
                                                                                <legend class="w-auto text-primary">Update <?php echo $faculties->faculty_name; ?></legend>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label for="">Faculty Code</label>
                                                                                            <input type="hidden" value="<?php echo $faculties->faculty_id; ?>" required name="faculty_id" class="form-control">
                                                                                            <input type="text" value="<?php echo $faculties->faculty_code; ?>" required name="faculty_code" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label for="">Faculty Name</label>
                                                                                            <input type="text" value="<?php echo $faculties->faculty_name; ?>" required name="faculty_name" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-md-12">
                                                                                            <label for="">Faculty Details / Description</label>
                                                                                            <textarea type="text" rows="5" required name="faculty_details" class="summernote form-control"><?php echo $faculties->faculty_details; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <button type="submit" name="update_faculty" class="btn btn-primary">Submit</button>
                                                                                </div>
                                                                            </fieldset>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->

                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete_<?php echo $faculties->faculty_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                            <h4>Delete <?php echo $faculties->faculty_code . ' ' . $faculties->faculty_name; ?></h4>
                                                                            <br>
                                                                            <!-- Hide This -->
                                                                            <input type="hidden" name="faculty_id" value="<?php echo $faculties->faculty_id; ?>">
                                                                            <input type="hidden" name="faculty_code" value="<?php echo $faculties->faculty_code; ?>">
                                                                            <input type="hidden" name="faculty_name" value="<?php echo $faculties->faculty_name; ?>">
                                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                            <input type="submit" name="delete" value="Delete" class="text-center btn btn-danger">
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