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
                                    <li class="breadcrumb-item"><a href="">Reports</a></li>
                                    <li class="breadcrumb-item active">Student Grades</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Student Grades</h4>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->

                <!-- End Modal -->
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset class="border border-primary p-2">
                            <legend class="w-auto text-primary font-weight-light">Select Student Admission Number & Name</legend>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <select name="user_id" style="width: 100%;" required class="basic form-control">
                                            <option>Select Student Details</option>
                                            <?php
                                            $cal_sql = "SELECT * FROM users
                                            WHERE user_access_level = 'student' 
                                            ORDER BY user_number ASC ";
                                            $cal_prepare = $mysqli->prepare($cal_sql);
                                            $cal_prepare->execute(); //ok
                                            $cal_return = $cal_prepare->get_result();
                                            while ($std = $cal_return->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $std->user_id; ?>"><?php echo $std->user_number . ' - ' . $std->user_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button name="search" class="btn btn-primary" type="submit">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </fieldset>
                        <br><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                if (isset($_POST['search'])) {
                                ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-right">
                                                <a href="report_grades_export_xls?user=<?php echo $_POST['user_id']; ?>" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export To Excel</a>
                                                <a href="report_grades_export_pdf?user=<?php echo $_POST['user_id']; ?>" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Export To PDF</a>
                                            </div>
                                            <br>
                                            <div class="">
                                                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Module Details</th>
                                                            <th>Marks Attained</th>
                                                            <th>Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $user_id = $_POST['user_id'];
                                                        $ret = "SELECT * FROM student_grades sg
                                                        INNER JOIN modules m ON m.module_id = sg.grade_marks_module_id
                                                        INNER JOIN users u ON u.user_id = sg.grade_marks_user_id
                                                        WHERE sg.grade_marks_user_id = '$user_id'
                                                       ";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($grades = $res->fetch_object()) {
                                                            /* Compute Grade */
                                                            $workScore = $grades->grade_marks_attained;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $grades->module_code . ' ' . $grades->module_name; ?></td>
                                                                <td><?php echo $grades->grade_marks_attained; ?></td>
                                                                <td>
                                                                    <?php
                                                                    switch ($workScore) {
                                                                        case $workScore >= 70 and $workScore <= 100:
                                                                            echo 'A';
                                                                            break;
                                                                        case $workScore >= 60 and $workScore <= 69:
                                                                            echo 'B';
                                                                            break;
                                                                        case $workScore >= 50 and $workScore <= 59:
                                                                            echo 'C';
                                                                            break;
                                                                        case $workScore >= 40 and $workScore <= 49:
                                                                            echo 'D';
                                                                            break;
                                                                        case $workScore >= 30 and $workScore <= 39:
                                                                            echo 'E';
                                                                            break;
                                                                        default:
                                                                            echo 'Null';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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