<?php
/*
 * Created on Mon May 02 2022
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
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();
/* Unsubscribe This Fella */
if (isset($_POST['unsubscribe'])) {
    $email = mysqli_escape_string($mysqli, $_GET['email']);
    /* Validate Email */
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /* Check If Email Already Exists On Mailing Lists */
        $sql = mysqli_query($mysqli, "SELECT * FROM newsletter WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            $sql = "DELETE FROM  newsletter WHERE email = '{$email}' ";
            $prepare = $mysqli->prepare($sql);
            $prepare->execute();
            /* Load Mailer */
            require_once('../mailers/unsubscribe_mailer.php');
            if ($prepare && $mail->send()) {
                $success = "You Have Unsubscribed From Our Newsletter";
            } else {
                $err = "Failed!, Please Try Again";
            }
        } else {
            $err = "Email Account Does Not Exist In Our Mailing List";
        }
    } else {
        $err = "Enter Correct Email Address";
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
                        <h2>Unsubscribe From Our Mailing List</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page Header Section Ends Here========== -->
    <section class="member-page-section">
        <div class="container">
            <div class="member-filter">

            </div>
            <div class="member-wrapper">
                <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="../public/images/404.png" alt="member-img">
                        </div>
                        <div class="lab-content text-center">
                            <h6>To Unsubscribe from our mailing list click the button below to confirm.</h6>
                            <form method="post" class="account-form">
                                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                                <button type="submit" class="btn btn-danger" name="unsubscribe"><span>Confirm</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ footer Section start Here =============== -->
    <?php require_once('../partials/footer.php'); ?>
    <!-- ================ footer Section end Here =============== -->

    <!-- scrollToTop start here -->
    <a href=" #" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->

    <!-- All Scripts -->
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>