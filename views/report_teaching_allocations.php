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
                                    <li class="breadcrumb-item active">Teaching Allocations</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Teaching Allocations Reports</h4>
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
                            <legend class="w-auto text-primary font-weight-light">Select Academic Year & Semester To View Teaching Allocations</legend>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <select name="allocation_calendar_id" style="width: 100%;" required class="basic form-control">
                                            <option>Select Academic Calendar & Semester</option>
                                            <?php
                                            $cal_sql = "SELECT * FROM academic_calendar 
                                            ORDER BY calendar_status ASC ";
                                            $cal_prepare = $mysqli->prepare($cal_sql);
                                            $cal_prepare->execute(); //ok
                                            $cal_return = $cal_prepare->get_result();
                                            while ($calendar = $cal_return->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $calendar->calendar_id; ?>"><?php echo $calendar->calendar_year . ' - ' . $calendar->calendar_semester . ' : ' . $calendar->calendar_status ?></option>
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
                                                <a href="report_allocations_export_xls?session=<?php echo $_POST['allocation_calendar_id']; ?>" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export To Excel</a>
                                                <a href="report_allocations_export_pdf?session=<?php echo $_POST['allocation_calendar_id']; ?>" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Export To PDF</a>
                                            </div>
                                            <br>
                                            <div class="">
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
                                                        $allocation_calendar_id = $_POST['allocation_calendar_id'];
                                                        $ret = "SELECT * FROM module_allocations ma
                                                        INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                        INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                        INNER JOIN users u ON u.user_id = ma.allocation_user_id
                                                        WHERE ac.calendar_id = '$allocation_calendar_id'";
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