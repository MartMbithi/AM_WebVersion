<?php
/*
 * Created on Thu May 05 2022
 *
 * Devlan Solutions LTD - www.devlan.co.ke 
 *
 * hello@devlan.co.ke
 *
 *
 * The Devlan Solutions LTD End User License Agreement
 *
 * Copyright (c) 2022 Devlan Solutions LTD
 *
 * 1. GRANT OF LICENSE
 * Devlan Solutions LTD hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan Solutions LTD. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan Solutions LTD.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan Solutions LTD and protected by copyright law and international copyright treaties. 
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
 * DEVLAN SOLUTIONS LTD DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * DEVLAN SOLUTIONS LTD SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
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
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN SOLUTIONS LTD  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
 * CONSEQUENTIAL, SPECIAL, INCIDENTAL OR INDIRECT DAMAGES OF ANY KIND ARISING OUT OF THE DELIVERY, PERFORMANCE OR 
 * USE OF THE SOFTWARE, EVEN IF DEVLAN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES
 * IN NO EVENT WILL DEVLAN  LIABILITY FOR ANY CLAIM, WHETHER IN CONTRACT 
 * TORT OR ANY OTHER THEORY OF LIABILITY, EXCEED THE LICENSE FEE PAID BY YOU, IF ANY.
 */

session_start();
require_once '../config/config.php';
require_once '../config/app_config.php';
/* Login */
if (isset($_POST['Login'])) {
    $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($mysqli, $_POST['user_password']);
    /* Check If Null Values Has Been Posted */
    if (!empty($user_email) && !empty($user_password)) {
        $sql = mysqli_query($mysqli, "SELECT * FROM users WHERE user_email = '{$user_email}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $user_pass = sha1(md5($user_password));
            $enc_pass = $row['user_password'];
            $acc_status = $row['user_account_status'];
            /* Check If This Account Is Verified */
            if ($acc_status == 'Verified') {
                /* Check If Auth Details Match */
                if ($user_pass === $enc_pass) {
                    $status = "Active now";
                    $sql2 = mysqli_query($mysqli, "UPDATE users SET user_status = '{$status}' WHERE user_id = {$row['user_id']}");
                    if ($sql2) {
                        /* Success Login */
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_gender'] = $row['user_gender'];
                        $_SESSION['user_address'] = $row['user_address'];
                        $_SESSION['success'] = 'Authentication Successful';
                        header('Location: index');
                        exit;
                    } else {
                        $err =  "Something went wrong. Please try again!";
                    }
                } else {
                    $err =  "Email or Password is Incorrect!";
                }
            } else {
                $info = "Please Verify Your Email Address To Proceed";
            }
        } else {
            $err =  "No Account With This $user_email Email";
        }
    } else {
        $err =  "All input fields are required!";
    }
}
require_once('../partials/head.php');

?>

<body>

    <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here -->




    <!-- ==========Header Section Starts Here========== -->
    <?php require_once('../partials/header.php'); ?>
    <!-- ==========Header Section Ends Here========== -->

    <!-- ==========Page Header Section Start Here========== -->
    <section class="page-header-section style-1" style="background:url(../public/images/page-header.jpg)">
        <div class="container">
            <div class="page-header-content">
                <div class="page-header-inner">
                    <div class="page-title">
                        <h2 class="bite-chocolate">Asian Melodies</h2>
                    </div>
                    <ol class="breadcrumb quick-kiss">
                        <li><a href="index ">Home</a></li>
                        <li class="active">Login</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page Header Section Ends Here========== -->

    <!-- ==========login Section start Here========== -->
    <div class="login-section padding-tb">
        <div class=" container">
            <div class="account-wrapper">
                <h3 class="title bite-chocolate">Login</h3>
                <form method="POST" class="account-form">
                    <div class="form-group">
                        <input type="text" required name="user_email" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <input type="password" required name="user_password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between flex-wrap pt-sm-2">
                            <div class="checkgroup">
                                <input type="checkbox" checked name="remember" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                            <a href="forget_password">Forget Password?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="Login" class="d-block lab-btn"><span>Sign In </span></button>
                    </div>
                </form>
                <div class="account-bottom">
                    <span class="d-block cate pt-10">Don't Have any Account?
                        <a href="signup">
                            Sign Up
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Login Section ends Here========== -->

    <!-- ================ footer Section start Here =============== -->
    <?php require_once('../partials/footer.php'); ?>
    <!-- ================ footer Section end Here =============== -->

    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->

    <?php require_once('../partials/scripts.php'); ?>
</body>



</html>