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
                                    <li class="breadcrumb-item"><a href="edu_dashboard">Search Results</a></li>
                                    <li class="breadcrumb-item active"><?php echo $_GET['querry']; ?></li>
                                </ol>
                            </div>
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->


                <div class="row">
                    <div class="col-lg-12">
                        <fieldset class="border border-primary p-2">
                            <legend class="w-auto text-primary font-weight-bold">Search Results For : <?php echo $_GET['querry']; ?></legend>
                            <div class="row">

                                <?php
                                /* Handle Search Results Call Backs */
                                $query = htmlspecialchars($_GET['querry']);
                                $min_length = 2;
                                if (strlen($query) >= $min_length) {
                                    $query = mysqli_real_escape_string($mysqli, $query);
                                    $raw_results = mysqli_query($mysqli, "SELECT * FROM users WHERE user_access_level ='student' AND (`user_name` LIKE '%" . $query . "%')  || (`user_number` LIKE '%" . $query . "%')  ");
                                    if (mysqli_num_rows($raw_results) > 0) {
                                        while ($results = mysqli_fetch_array($raw_results)) {
                                            /* Load Profile Picture */
                                            if ($results['user_dpic'] == '') {
                                                $dir = "../public/images/no-profile.png";
                                            } else {
                                                $dir = "../public/uploads/user_data/admins/" . $results['user_dpic'];
                                            }
                                ?>
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <!-- To Do : Link This Pag To User Profile -->
                                                    <a href="edu_student_profile?view=<?php echo $results['user_id']; ?>">
                                                        <div class="card-body">
                                                            <!--end ribbon-->
                                                            <img src="<?php echo $dir; ?>" alt="" class="d-block mx-auto my-4" height="170">
                                                            <div class="text-center my-4">
                                                                <div>
                                                                    <a href="" class="header-title"><?php echo $results['user_number']; ?></a><br>
                                                                    <a href="" class="header-title"><?php echo $results['user_name']; ?></a><br>
                                                                    <a href="mailto:<?php echo $results['user_email']; ?>" class="header-title"><?php echo $results['user_email']; ?></a><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end card-body-->
                                                    </a>
                                                </div>
                                                <!--end card-->
                                            </div>
                                            <!--end col-->
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-xl-12 col-lg-12 col-sm-12">
                                            <div class=" overflow-hidden">
                                                <div class="card-body">
                                                    <div class="text-center">
                                                        <h4 class="text-danger">No Search Results For : <?php echo $_GET['querry']; ?></h4>
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