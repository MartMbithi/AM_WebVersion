<?php
/*
 * Created on Tue Jan 25 2022
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
                                    <li class="breadcrumb-item"><a href="">Students</a></li>
                                    <li class="breadcrumb-item active">Students Search Results</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Student Advanced Search Results</h4>
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
                                        <legend class="w-auto text-primary font-weight-light">Enter Student Admission Number Or Name</legend>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <input type="text" name="search_querry" required class="form-control">
                                                </div>

                                            </div>
                                            <div class="text-right">
                                                <button name="search" class="btn btn-primary" type="submit">
                                                    Search
                                                </button>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <?php
                if (isset($_POST['search'])) {
                ?>
                    <div class="col-lg-12">
                        <div class="">
                            <div class="">
                                <fieldset class="border border-primary p-2">
                                    <legend class="w-auto text-primary font-weight-light">Search Results For <?php echo $_POST['search_querry']; ?></legend>
                                    <div class="row">

                                        <?php
                                        /* Handle Search Results Call Backs */
                                        $query = htmlspecialchars($_POST['search_querry']);
                                        $min_length = 1;
                                        if (strlen($query) >= $min_length) {
                                            $query = mysqli_real_escape_string($mysqli, $query);
                                            $raw_results = mysqli_query(
                                                $mysqli,
                                                "SELECT *  FROM users 
                                                WHERE  user_access_level = 'student' AND
                                                (`user_number` LIKE '%" . $query . "%') || (`user_name` LIKE '%" . $query . "%')"
                                            );
                                            if (mysqli_num_rows($raw_results) > 0) {
                                                while ($results = mysqli_fetch_array($raw_results)) {
                                                    /* Set User Profile */
                                                    if (!empty($results['user_dpic'])) {
                                                        $url = "../public/uploads/user_data/admins/" . $results['user_dpic'];
                                                    } else {
                                                        $url = "../public/images/no-profile.png";
                                                    }
                                        ?>

                                                    <div class="col-lg-4">
                                                        <a href="student_profile?view=<?php echo $results['user_id']; ?>">
                                                            <div class="card client-card">
                                                                <div class="card-body text-center">
                                                                    <img src="<?php echo $url; ?>" alt="user" class="rounded-circle thumb-xl">
                                                                    <h5 class="client-name"><?php echo $results['user_name']; ?></h5>
                                                                    <p class="text-muted text-center mt-3"><?php echo $results['user_email']; ?></p>
                                                                    <span class="text-muted mr-3"><i class="dripicons-tags  mr-2 text-info"></i><?php echo $results['user_number']; ?></span>
                                                                    <span class="text-muted mr-3"><i class="dripicons-location mr-2 text-info"></i><?php echo $results['user_adr']; ?></span>
                                                                    <span class="text-muted"><i class="dripicons-phone mr-2 text-info"></i><?php echo $results['user_phone']; ?></span>
                                                                </div>
                                                                <!--end card-body-->
                                                            </div>
                                                            <!--end card-->
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                                    <div class=" overflow-hidden">
                                                        <div class="card-body">
                                                            <div class="text-center">
                                                                <h4 class="text-danger">No Search Results For : <?php echo $_POST['search_querry']; ?></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="col-xl-12 col-lg-12 col-sm-12">
                                                <div class=" overflow-hidden">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <h4 class="text-danger">Minimum Search Querry Length Is <?php echo $min_length; ?> Characters</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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