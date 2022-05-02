<?php
/*
 * Created on Wed Dec 22 2021
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

/* Add Department */
if (isset($_POST['add_department'])) {
    $department_faculty_id = $_POST['department_faculty_id'];
    $department_user_id = $_POST['department_user_id'];
    $department_code = $_POST['department_code'];
    $department_name = $_POST['department_name'];
    $department_details = $_POST['department_details'];

    /* Log Attributes */
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_type = 'Registered New Department : ' . $department_code . ' ' . $department_name;
    $log_user_id = $_SESSION['user_id'];

    /* Eliminate Duplicates */
    $sql = "SELECT * FROM departments  WHERE department_code ='$department_code' ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($department_code == $row['department_code']) {
            $err = 'A Department With This Code: ' . $department_code . ' Alreaady Exists';
        }
    } else {
        /* Persist New Department */
        $sql = "INSERT INTO departments (department_faculty_id, department_user_id, department_code, department_name, department_details)
        VALUES(?,?,?,?,?)";
        $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";

        $prepare = $mysqli->prepare($sql);
        $log_prepare = $mysqli->prepare($log);

        $bind = $prepare->bind_param(
            'sssss',
            $department_faculty_id,
            $department_user_id,
            $department_code,
            $department_name,
            $department_details
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
            $success = "$department_code - $department_name, Details Added";
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
                                    <li class="breadcrumb-item"><a href="">Departments</a></li>
                                    <li class="breadcrumb-item active">Add Department</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Register New Department</h4>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <fieldset class="border border-primary p-2">
                                            <legend class="w-auto text-primary font-weight-bold">Fill All Required Values</legend>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="">Department Code</label>
                                                        <input type="text" placeholder="<?php echo $a . $b; ?>" required name="department_code" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Department Name</label>
                                                        <input type="text" required name="department_name" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Department Head</label>
                                                        <select class="form-control basic" style="width: 100%;" name="department_user_id">
                                                            <?php
                                                            $ret = "SELECT * FROM users 
                                                            WHERE user_access_level !='student'
                                                            ORDER BY  user_number ASC";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($users = $res->fetch_object()) {
                                                            ?>
                                                                <option value="<?php echo $users->user_id; ?>"><?php echo $users->user_number . ' ' . $users->user_name; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Faculty Name</label>
                                                        <select class="form-control basic" style="width: 100%;" name="department_faculty_id">
                                                            <?php
                                                            $ret = "SELECT * FROM faculties
                                                            ORDER BY  faculty_code ASC";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->execute(); //ok
                                                            $res = $stmt->get_result();
                                                            while ($faculty = $res->fetch_object()) {
                                                            ?>
                                                                <option value="<?php echo $faculty->faculty_id; ?>"><?php echo $faculty->faculty_code . ' ' . $faculty->faculty_name; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">Department Details / Description</label>
                                                        <textarea type="text" rows="5" required name="department_details" class="form-control summernote"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" name="add_department" class="btn btn-primary">Submit</button>
                                            </div>
                                        </fieldset>
                                    </form>
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