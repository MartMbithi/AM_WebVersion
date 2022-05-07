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

    <!-- Load This With Specific User Profile -->
    <?php
    $user_id = $_GET['view'];
    $ret = "SELECT * FROM  users 
    WHERE user_id = '$user_id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($users = $res->fetch_object()) {
        /* Count Of How Many Favorites This Fella Has */
        $user_id  = $users->user_id;
        $query = "SELECT COUNT(*)   FROM favourites WHERE fav_logged_in_user_id  = '{$user_id}' ";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($favourites);
        $stmt->fetch();
        $stmt->close();

    ?>
        <!-- ==========Page Header Section Start Here========== -->
        <section class="page-header-section style-1" style="background:url(../public/images/page-header.jpg)">
            <div class="container">
                <div class="page-header-content">
                    <div class="page-header-inner">
                        <div class="page-title">
                            <h2><?php echo $users->user_name; ?> Profile</h2>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="index">Home</a></li>
                            <li class="active"><?php echo $users->user_name; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- ==========Page Header Section Ends Here========== -->


        <!-- ==========Profile Section Start Here========== -->
        <section class="profile-section padding-tb">
            <div class="container">
                <div class="section-wrapper">
                    <div class="member-profile">
                        <div class="profile-item">
                            <div class="profile-cover">
                                <img src="../public/images/profile/cover.jpg" alt="cover-pic">
                            </div>
                            <div class="profile-information">
                                <div class="profile-pic">
                                    <img src="../public/uploads/user_data/<?php echo $users->user_profile_picture; ?>" alt="DP">

                                </div>
                                <div class="profile-name">
                                    <h4><?php echo $users->user_name; ?></h4>
                                    <p><?php echo $users->user_status; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="profile-details">
                            <nav class="profile-nav">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                                    <button class="nav-link" id="nav-friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false">Favorites <span class="item-number"><?php echo $favourites; ?></span></button>
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item" href="#">Send Private Message</a></li>
                                            <li><a class="dropdown-item" href="#">Add As Match</a></li>
                                            <form method="POST">
                                                <!-- Hide This -->
                                                <input type="hidden" name="fav_logged_in_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                <input type="hidden" name="fav_user_id" value="<?php echo $user_id; ?>">
                                                <li><input type="submit" name="Add_Favourite" class="dropdown-item" value="Add To Favourites"></li>
                                            </form>
                                        </ul>
                                    </div>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <!-- Profile tab -->
                                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <article>
                                                    <div class="info-card mb-20">
                                                        <div class="info-card-title">
                                                            <h6>Basic Info</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <p class="info-name">Name</p>
                                                                    <p class="info-details"><?php echo $users->user_name; ?></p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">I'm a</p>
                                                                    <p class="info-details"><?php echo $users->user_gender; ?></p>
                                                                </li>
                                                                <?php if ($users->user_gender == 'Male') { ?>
                                                                    <li>
                                                                        <p class="info-name">Loking for a</p>
                                                                        <p class="info-details">Women</p>
                                                                    </li>
                                                                <?php } else { ?>
                                                                    <li>
                                                                        <p class="info-name">Loking for a</p>
                                                                        <p class="info-details">Men</p>
                                                                    </li>
                                                                <?php } ?>
                                                                <li>
                                                                    <p class="info-name">Age</p>
                                                                    <p class="info-details"><?php echo $users->user_age; ?> Years</p>
                                                                </li>

                                                                <li>
                                                                    <p class="info-name">Current City / Town</p>
                                                                    <p class="info-details"><?php echo $users->user_address; ?></p>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                    <div class="info-card mb-20">
                                                        <div class="info-card-title">
                                                            <h6>Who Im I</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <p><?php echo $users->user_biography; ?></p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Frinds Tab -->
                                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="nav-friends-tab">
                                    <div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <article>
                                                    <div class="row gy-4 gx-3 justify-content-center">
                                                        <?php
                                                        /* Fetch Some Of Favourite Users Which Belongs To This Fella */
                                                        $user_id = $users->user_id;
                                                        $raw_results = mysqli_query($mysqli, "SELECT * FROM favourites f
                                                        INNER JOIN users u ON f.fav_user_id = u.user_id 
                                                        WHERE  u.user_account_status = 'Verified' AND f.fav_logged_in_user_id = '{$user_id}'");
                                                        if (mysqli_num_rows($raw_results) > 0) {
                                                            while ($results = mysqli_fetch_array($raw_results)) {
                                                        ?>
                                                                <div class=" col-lg-3 col-md-4 col-6">
                                                                    <div class="lab-item member-item style-1">
                                                                        <div class="lab-inner">
                                                                            <div class="lab-thumb">
                                                                                <img src="../public/uploads/user_data/<?php echo $results['user_profile_picture']; ?>" alt="member-img">
                                                                            </div>
                                                                            <div class="lab-content">
                                                                                <h6><a href="member_profile?view=<?php echo $results['user_id']; ?>"><?php echo $results['user_name']; ?></a> </h6>
                                                                                <p><?php echo $results['user_status']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        } else { ?>
                                                            <div class="row">
                                                                <div class="col-12 text-center">
                                                                    <img src="../public/images/404.png" alt="member-img">
                                                                </div>
                                                                <div class="lab-content text-center">
                                                                    <h6>Woops, <?php echo $users->user_name; ?> Has No Favorite Members For Now.</h6>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ==========Profile Section Ends Here========== -->

    <?php } ?>


    <!-- ================ footer Section start Here =============== -->
    <?php require_once('../partials/footer.php'); ?>
    <!-- ================ footer Section end Here =============== -->


    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->

    <!-- All Scripts -->
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>