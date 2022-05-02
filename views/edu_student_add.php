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
require_once('../config/app_config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
check_login();

/* Register Student */
if (isset($_POST['add_student'])) {
    $user_number = $_POST['user_number'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_access_level = 'student';
    $user_phone = $_POST['user_phone'];
    $user_adr = $_POST['user_adr'];
    $password_reset_token = $tk; //Mail Users This To Reset Their Password

    /* Eliminate Duplicates */
    $sql = "SELECT * FROM users  WHERE user_email ='$user_email'   ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($user_email == $row['user_email'] && $user_number  == $row['user_number']) {
            $err = 'A User With This : ' . $user_email . ' Or This : ' . $user_number . ' Already Exists';
        }
    } else {
        /* Persist */
        $sql = "INSERT INTO users (user_number, user_name, user_email, user_access_level, user_phone, user_adr, password_reset_token)
        VALUES(?,?,?,?,?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sssssss',
            $user_number,
            $user_name,
            $user_email,
            $user_access_level,
            $user_phone,
            $user_adr,
            $password_reset_token
        );
        $prepare->execute();
        /* Activate URL */
        $activate_url = $account_password_set . $password_reset_token;
        /* Include Mailer */
        include('../mailers/new_user_account_mailer.php');
        if ($prepare && $mail->send()) {
            $success = "Student Account Created";
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
                                    <li class="breadcrumb-item"><a href="edu_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Students</a></li>
                                    <li class="breadcrumb-item active">Add</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Register New Student </h4>
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
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Admission Number</label>
                                                    <input type="text" value="<?php echo $a . '-' . $b; ?>" required name="user_number" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Full Name</label>
                                                    <input type="text" required name="user_name" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Email</label>
                                                    <input type="text" required name="user_email" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" required name="user_phone" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Access Level</label>
                                                    <select type="text" disabled="disabled" style="width: 100%;" required name="user_access_level" class="basic form-control">
                                                        <option value="student">Student</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Address</label>
                                                    <input type="text" required name="user_adr" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="add_student" class="btn btn-primary">Submit</button>
                                        </div>
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