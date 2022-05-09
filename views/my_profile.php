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
/* Update Personal Details */
if (isset($_POST['update_profile'])) {
    $user_id = mysqli_real_escape_string($mysqli, $_SESSION['user_id']);
    $user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);
    $user_age = mysqli_real_escape_string($mysqli, $_POST['user_age']);
    $user_gender = mysqli_real_escape_string($mysqli, $_POST['user_gender']);
    $user_address = mysqli_real_escape_string($mysqli, $_POST['user_address']);

    /* Persist */
    $sql = "UPDATE users SET user_name = '{$user_name}', user_email = '{$user_email}', user_age = '{$user_age}', user_gender = '{$user_gender}',
    user_address = '{$user_address}' WHERE user_id = '{$user_id}'";
    $prepare = $mysqli->prepare($sql);
    $prepare->execute();
    if ($prepare) {
        $success  = "Personal Details Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Profile Image */
if (isset($_POST['update_image'])) {
    $user_id = mysqli_real_escape_string($mysqli, $_SESSION['user_id']);
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
                    $sql = "UPDATE users SET  user_profile_picture = '{$new_img_name}' WHERE user_id = '{$user_id}'";
                    $prepare = $mysqli->prepare($sql);
                    $prepare->execute();
                    if ($prepare) {
                        $success =  "Profile Photo Updated";
                    } else {
                        $err = "Failed!, Please Try Again";
                    }
                }
            } else {
                $err =  "Please upload an image file - jpeg, png, jpg";
            }
        } else {
            $err =  "Please upload an image file - jpeg, png, jpg";
        }
    }
}

/* Update Biography/ About */
if (isset($_POST['update_bio'])) {
    $user_id = mysqli_real_escape_string($mysqli, $_SESSION['user_id']);
    $user_biography = mysqli_real_escape_string($mysqli, $_POST['user_biography']);
    /* Persist */
    $sql = "UPDATE users SET user_biography = '{$user_biography}' WHERE user_id = '{$user_id}'";
    $prepare  = $mysqli->prepare($sql);
    $prepare->execute();
    if ($prepare) {
        $success = "Your Biography Has Been Updated";
    } else {
        $err = "Failed!, Please Try Again";
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

    <!-- Load This With Specific User Profile -->
    <?php
    $user_id = $_SESSION['user_id'];
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
                                    <button class="nav-link" id="nav-friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false">Personal Info</button>
                                    <button class="nav-link" id="nav-friends-tab" data-bs-toggle="tab" data-bs-target="#dpic" type="button" role="tab" aria-controls="friends" aria-selected="false">Profile Image</button>
                                    <button class="nav-link" id="nav-friends-tab" data-bs-toggle="tab" data-bs-target="#bio" type="button" role="tab" aria-controls="friends" aria-selected="false">Bio & About</button>
                                    <button class="nav-link" id="nav-friends-tab" data-bs-toggle="tab" data-bs-target="#auth" type="button" role="tab" aria-controls="friends" aria-selected="false">Authentication</button>
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
                                <!-- Personal Info Tab -->
                                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="nav-friends-tab">
                                    <div class="info-card mb-20">

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row gy-4 gx-3 justify-content-center">
                                                    <div class="info-card-content">
                                                        <form method="post" class="account-form" enctype="multipart/form-data" role="form">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Full Name</label>
                                                                    <input type="text" value="<?php echo $users->user_name; ?>" required name="user_name">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Email</label>
                                                                    <input type="text" value="<?php echo $users->user_email; ?>" required name="user_email">
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="">Gender</label>
                                                                    <select type="text" style="width: 100%;" required name="user_gender" class="basic form-control">
                                                                        <option><?php echo $users->user_gender; ?></option>
                                                                        <option>Male</option>
                                                                        <option>Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Age</label>
                                                                    <input type="text" value="<?php echo $users->user_age; ?>" required name="user_age">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Address</label>
                                                                    <input type="text" required name="user_address" value="<?php echo $users->user_address; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="pull-right">
                                                                <button type="submit" name="update_profile" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Image -->
                                <div class="tab-pane fade" id="dpic" role="tabpanel" aria-labelledby="nav-friends-tab">
                                    <div class="info-card mb-20">

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row gy-4 gx-3 justify-content-center">
                                                    <div class="info-card-content">
                                                        <form method="post" class="account-form" enctype="multipart/form-data" role="form">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Profile Image</label><br>
                                                                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required name="user_address">
                                                                </div>
                                                            </div>
                                                            <div class="pull-right">
                                                                <button type="submit" name="update_image" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Biography -->
                                <div class="tab-pane fade" id="bio" role="tabpanel" aria-labelledby="nav-friends-tab">
                                    <div class="info-card mb-20">

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row gy-4 gx-3 justify-content-center">
                                                    <div class="info-card-content">
                                                        <form method="post" class="account-form" enctype="multipart/form-data" role="form">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Biography/ Intrests / Who Are You</label><br>
                                                                    <textarea rows="10" type="text" class="form-control" required name="user_biography"><?php echo $users->user_biography; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="pull-right">
                                                                <button type="submit" name="update_bio" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Auth -->
                                <div class="tab-pane fade" id="auth" role="tabpanel" aria-labelledby="nav-friends-tab">
                                    <div class="info-card mb-20">

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row gy-4 gx-3 justify-content-center">
                                                    <div class="info-card-content">
                                                        <form method="post" class="account-form" enctype="multipart/form-data" role="form">
                                                            <div class="row">

                                                                <div class="form-group col-md-4">
                                                                    <label for="">Old Password</label>
                                                                    <input type="password" required name="old_password">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">New Password</label>
                                                                    <input type="password" required name="new_password">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Confirm Password</label>
                                                                    <input type="password" required name="confirm_password">
                                                                </div>
                                                                <div class="pull-right">
                                                                    <button type="submit" name="update_password" class="btn btn-primary">Save</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
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