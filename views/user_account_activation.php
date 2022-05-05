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
/* Proceed To Activation */
if (isset($_POST['SignUp'])) {
    /* Prevent SQL Injection */
    $user_gender = mysqli_real_escape_string($mysqli, $_POST['user_gender']);
    $user_age = mysqli_real_escape_string($mysqli, $_POST['user_age']);
    $user_address = mysqli_real_escape_string($mysqli, $_POST['user_address']);
    $user_id = mysqli_real_escape_string($mysqli, $_GET['account']);
    $user_account_status = 'Verified';
    /* Persist User Profile Image */
    if (isset($_FILES['image'])) {
        $img_name = $_FILES['image']['name'];
        $img_type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);

        $extensions = ["jpeg", "png", "jpg"];
        if (in_array($img_ext, $extensions) === true) {
            $types = ["image/jpeg", "image/jpg", "image/png"];
            if (in_array($img_type, $types) === true) {
                $time = time();
                $new_img_name = $time . $img_name;
                if (move_uploaded_file($tmp_name, "../public/uploads/user_data/" . $new_img_name)) {
                    /* Persist User Data */
                    $sql = "UPDATE users SET user_gender ='$user_gender', user_age ='$user_age', user_address ='$user_address',
                    user_account_status = '$user_account_status', user_profile_picture = '$new_img_name' WHERE user_id = '$user_id'";
                    $prepare = $mysqli->prepare($sql);
                    $prepare->execute();
                    if ($prepare) {
                        $_SESSION['success'] = 'Your Account Has Been Set Up, Proceed To Login';
                        header('Location: login');
                        exit;
                    } else {
                        $err = "Failed!, Please Try Again";
                    }
                }
            } else {
                echo "Please upload an image file - jpeg, png, jpg";
            }
        } else {
            echo "Please upload an image file - jpeg, png, jpg";
        }
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
                        <li class="active">Account Activation</li>
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
                <h3 class="title bite-chocolate">Finalize Your Account Set Up</h3>
                <p class="text-center">You have verified your email, kindly fill all required fields to set up your account</p>
                <form enctype="multipart/form-data" autocomplete="off" method="POST" class="account-form">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">
                            Gender
                        </label>
                        <div class="col-6">
                            <select class="form-control" name="user_gender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="val-username">Age
                        </label>
                        <div class="col-6">
                            <input type="text" required name="user_age">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="val-username">Current City
                        </label>
                        <div class="col-6">
                            <input type="text" required name="user_address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="val-username">Profile Picture
                        </label>
                        <div class="col-6">
                            <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required name="user_address">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="SignUp" class="d-block lab-btn"><span>Proceed</span></button>
                    </div>
                </form>
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