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

    ?>
        <!-- ==========Page Header Section Start Here========== -->
        <section class="page-header-section style-1" style="background:url(../public/images/page-header.jpg)">
            <div class="container">
                <div class="page-header-content">
                    <div class="page-header-inner">
                        <div class="page-title">
                            <h2>Member Single Profile</h2>
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
                                <ul class="profile-contact">
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="icofont-user"></i></div>
                                            <div class="text">
                                                <p>Mark As Favorite</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="profile-item d-none">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <a href="#"><img src="../public/uploads/user_data/<?php echo $users->user_profile_picture; ?>" alt="profile"></a>
                                </div>
                                <div class="lab-content">
                                    <div class="profile-name">
                                        <div class="p-name-content">
                                            <h4><?php echo $users->user_name; ?></h4>
                                            <p><?php echo $users->user_status; ?></p>
                                        </div>

                                        <div class="contact-button">
                                            <button class="contact-btn">
                                                <i class="icofont-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <ul class="profile-contact">
                                        <li>
                                            <a href="#">
                                                <div class="icon"><i class="icofont-user"></i></div>
                                                <div class="text">
                                                    <p>Mark As Favorite</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="icon"><i class="icofont-envelope"></i></div>
                                                <div class="text">
                                                    <p>Mark As Match</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="profile-details">
                            <nav class="profile-nav">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                                    <button class="nav-link" id="nav-friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false">Friends <span class="item-number">16</span></button>
                                    <button class="nav-link" id="nav-media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false">Private Chat <span class="item-number">35</span></button>
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item" href="#">Activity</a></li>
                                            <li><a class="dropdown-item" href="#">Privacy</a></li>
                                            <li><a class="dropdown-item" href="#">Block user</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <!-- Profile tab -->
                                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div>
                                        <div class="row">
                                            <div class="col-xl-8">
                                                <article>
                                                    <div class="info-card mb-20">
                                                        <div class="info-card-title">
                                                            <h6>Base Info</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <p class="info-name">Name</p>
                                                                    <p class="info-details">William Smith</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">I'm a</p>
                                                                    <p class="info-details">Woman</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Loking for a</p>
                                                                    <p class="info-details">Men</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Marital Status</p>
                                                                    <p class="info-details">Single</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Age</p>
                                                                    <p class="info-details">36</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Date of Birth</p>
                                                                    <p class="info-details">27-02-1996</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Address</p>
                                                                    <p class="info-details">Streop Rd, Peosur, Inphodux,
                                                                        USA.</p>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                    <div class="info-card mb-20">
                                                        <div class="info-card-title">
                                                            <h6>Myself Summary</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <p>Collaboratively innovate compelling mindshare after
                                                                prospective partnerships Competently sereiz long-term
                                                                high-impact internal or "organic" sources via user friendly
                                                                strategic themesr areas creat Dramatically coordinate
                                                                premium partnerships rather than standards compliant
                                                                technologies ernd Dramatically matrix ethical collaboration
                                                                and idea-sharing through opensource methodologies and
                                                                Intrinsicly grow collaborative platforms vis-a-vis effective
                                                                scenarios. Energistically strategize cost effective ideas
                                                                before the worke unde.</p>
                                                        </div>
                                                    </div>
                                                    <div class="info-card mb-20">
                                                        <div class="info-card-title">
                                                            <h6>Looking For</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <p class="info-name">Things I'm looking for</p>
                                                                    <p class="info-details">I want a funny person</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Whatever I like</p>
                                                                    <p class="info-details">I like to travel a lot</p>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                    <div class="info-card mb-20">
                                                        <div class="info-card-title">
                                                            <h6>Lifestyle</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <p class="info-name">Interest</p>
                                                                    <p class="info-details">Dogs,Cats</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Favorite vocations spot</p>
                                                                    <p class="info-details">Maldives, Bangladesh</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Looking for</p>
                                                                    <p class="info-details">Serious Relationshiop,Affair</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Smoking</p>
                                                                    <p class="info-details">Casual Smoker</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Language</p>
                                                                    <p class="info-details">English, French, Italian</p>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                    <div class="info-card">
                                                        <div class="info-card-title">
                                                            <h6>Physical info</h6>
                                                        </div>
                                                        <div class="info-card-content">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <p class="info-name">Height</p>
                                                                    <p class="info-details">5'8 ft</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Weight</p>
                                                                    <p class="info-details">72 kg</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Hair Color</p>
                                                                    <p class="info-details">Black</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Eye Color</p>
                                                                    <p class="info-details">Brown</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Body Type</p>
                                                                    <p class="info-details">Tall</p>
                                                                </li>
                                                                <li>
                                                                    <p class="info-name">Ethnicity</p>
                                                                    <p class="info-details">Middle Eastern</p>
                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </article>
                                            </div>

                                            <!-- Aside Part -->
                                            <div class="col-xl-4">
                                                <aside class="mt-5 mt-xl-0">
                                                    <div class="widget search-widget">
                                                        <div class="widget-inner">
                                                            <div class="widget-title">
                                                                <h5>Filter Search Member</h5>
                                                            </div>
                                                            <div class="widget-content">
                                                                <p>Serious Dating With TuruLav Your Perfect
                                                                    Match is Just a Click Away.</p>
                                                                <form action="https://labartisan.net/" class="banner-form">
                                                                    <div class="gender">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">I am a </option>
                                                                                <option value="1">Male</option>
                                                                                <option value="2">Female</option>
                                                                                <option value="3">Others</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="person">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">Looking for</option>
                                                                                <option value="1">Male</option>
                                                                                <option value="2">Female</option>
                                                                                <option value="3">Others</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="age">
                                                                        <div class="right d-flex justify-content-between w-100">
                                                                            <div class="custom-select">
                                                                                <select>
                                                                                    <option value="1">18</option>
                                                                                    <option value="2">19</option>
                                                                                    <option value="3">20</option>
                                                                                    <option value="4">21</option>
                                                                                    <option value="5">22</option>
                                                                                    <option value="6">23</option>
                                                                                    <option value="7">24</option>
                                                                                    <option value="8">25</option>
                                                                                    <option value="9">26</option>
                                                                                    <option value="10">27</option>
                                                                                    <option value="11">28</option>
                                                                                    <option value="13">29</option>
                                                                                    <option value="14">30</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="custom-select">
                                                                                <select>
                                                                                    <option value="1">36</option>
                                                                                    <option value="2">19</option>
                                                                                    <option value="3">20</option>
                                                                                    <option value="4">21</option>
                                                                                    <option value="5">22</option>
                                                                                    <option value="6">23</option>
                                                                                    <option value="7">24</option>
                                                                                    <option value="8">25</option>
                                                                                    <option value="9">26</option>
                                                                                    <option value="10">27</option>
                                                                                    <option value="11">28</option>
                                                                                    <option value="13">29</option>
                                                                                    <option value="14">30</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="city">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">Choose Your Country
                                                                                </option>
                                                                                <option value="1">USA</option>
                                                                                <option value="2">UK</option>
                                                                                <option value="3">Spain</option>
                                                                                <option value="4">Brazil</option>
                                                                                <option value="5">France</option>
                                                                                <option value="6">Newzeland</option>
                                                                                <option value="7">Australia</option>
                                                                                <option value="8">Bangladesh</option>
                                                                                <option value="9">Turki</option>
                                                                                <option value="10">Chine</option>
                                                                                <option value="11">India</option>
                                                                                <option value="12">Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="interest">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">Your Interests
                                                                                </option>
                                                                                <option value="1">Gaming</option>
                                                                                <option value="2">Fishing</option>
                                                                                <option value="3">Skydriving</option>
                                                                                <option value="4">Swimming</option>
                                                                                <option value="5">Racing</option>
                                                                                <option value="6">Hangout</option>
                                                                                <option value="7">Tranvelling</option>
                                                                                <option value="8">Camping</option>
                                                                                <option value="9">Touring</option>
                                                                                <option value="10">Acting</option>
                                                                                <option value="11">Dancing</option>
                                                                                <option value="12">Singing</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <button class="">Find Your Partner</button>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget like-member">
                                                        <div class="widget-inner">
                                                            <div class="widget-title">
                                                                <h5>you may like</h5>
                                                            </div>
                                                            <div class="widget-content">
                                                                <div class="row row-cols-3 row-cols-sm-auto g-3">
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/01.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/02.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/03.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/04.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/05.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/06.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/07.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/08.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/09.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget active-group">
                                                        <div class="widget-inner">
                                                            <div class="widget-title">
                                                                <h5>join the group</h5>
                                                            </div>
                                                            <div class="widget-content">
                                                                <div class="group-item lab-item">
                                                                    <div class="lab-inner d-flex flex-wrap align-items-center">
                                                                        <div class="lab-content w-100">
                                                                            <h6>Active Group A1</h6>
                                                                            <p>Colabors atively fabcate best breed and
                                                                                apcations through visionary</p>
                                                                            <ul class="img-stack d-flex">
                                                                                <li><img src="assets/images/group/group-mem/01.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/02.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/03.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/04.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/05.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/06.png" alt="member-img"></li>
                                                                                <li class="bg-theme">12+</li>
                                                                            </ul>
                                                                            <div class="test"> <a href="profile.html" class="lab-btn">
                                                                                    <i class="icofont-users-alt-5"></i>
                                                                                    View Group</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="group-item lab-item">
                                                                    <div class="lab-inner d-flex flex-wrap align-items-center">
                                                                        <div class="lab-content w-100">
                                                                            <h6>Active Group A2</h6>
                                                                            <p>Colabors atively fabcate best breed and
                                                                                apcations through visionary</p>
                                                                            <ul class="img-stack d-flex">
                                                                                <li><img src="assets/images/group/group-mem/01.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/02.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/03.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/04.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/05.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/06.png" alt="member-img"></li>
                                                                                <li class="bg-theme">16+</li>
                                                                            </ul>
                                                                            <div class="test"> <a href="profile.html" class="lab-btn">
                                                                                    <i class="icofont-users-alt-5"></i>
                                                                                    View Group</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </aside>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Frinds Tab -->
                                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="nav-friends-tab">
                                    <div>
                                        <div class="row">
                                            <div class="col-xl-8">
                                                <article>
                                                    <div class="row gy-4 gx-3 justify-content-center">
                                                        <div class=" col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/01.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">jenifer Guido</a> </h6>
                                                                        <p>Active 1 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/02.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Andrea Guido</a> </h6>
                                                                        <p>Active 2 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/03.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Anna hawk</a> </h6>
                                                                        <p>Active 5 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/04.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Andreas Adam</a> </h6>
                                                                        <p>Active 4 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/05.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Alaina T</a> </h6>
                                                                        <p>Active 1 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/06.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Aron Smith</a> </h6>
                                                                        <p>Active 3 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/07.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Helen Gomz</a> </h6>
                                                                        <p>Active 3 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/08.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Andrez jr</a> </h6>
                                                                        <p>Active 5 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/09.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Ladiga Guido</a> </h6>
                                                                        <p>Active 5 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/10.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Andrea Guido</a> </h6>
                                                                        <p>Active 1 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/11.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Jene Aiko</a> </h6>
                                                                        <p>Active 4 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/12.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Jhon Cena</a> </h6>
                                                                        <p>Active 2 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/13.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Irfan Patel </a> </h6>
                                                                        <p>Active 5 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/14.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Hames Radregez</a> </h6>
                                                                        <p>Active 1 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/15.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Johan ben</a> </h6>
                                                                        <p>Active 2 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/16.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Johannes</a> </h6>
                                                                        <p>Active 6 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/17.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Helena Mind</a> </h6>
                                                                        <p>Active 4 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/18.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Virat Alba</a> </h6>
                                                                        <p>Active 3 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/19.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Afrin Nawr</a> </h6>
                                                                        <p>Active 5 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-6">
                                                            <div class="lab-item member-item style-1">
                                                                <div class="lab-inner">
                                                                    <div class="lab-thumb">
                                                                        <img src="assets/images/member/20.jpg" alt="member-img">
                                                                    </div>
                                                                    <div class="lab-content">
                                                                        <h6><a href="#">Jason Roy</a> </h6>
                                                                        <p>Active 2 Day</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>

                                            <!-- Aside Part -->
                                            <div class="col-xl-4">
                                                <aside class="mt-5 mt-xl-0">
                                                    <div class="widget search-widget">
                                                        <div class="widget-inner">
                                                            <div class="widget-title">
                                                                <h5>Filter Search Member</h5>
                                                            </div>
                                                            <div class="widget-content">
                                                                <p>Serious Dating With TuruLav Your Perfect
                                                                    Match is Just a Click Away.</p>
                                                                <form action="https://labartisan.net/" class="banner-form">
                                                                    <div class="gender">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">I am a </option>
                                                                                <option value="1">Male</option>
                                                                                <option value="2">Female</option>
                                                                                <option value="3">Others</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="person">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">Looking for</option>
                                                                                <option value="1">Male</option>
                                                                                <option value="2">Female</option>
                                                                                <option value="3">Others</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="age">
                                                                        <div class="right d-flex justify-content-between w-100">
                                                                            <div class="custom-select">
                                                                                <select>
                                                                                    <option value="1">18</option>
                                                                                    <option value="2">19</option>
                                                                                    <option value="3">20</option>
                                                                                    <option value="4">21</option>
                                                                                    <option value="5">22</option>
                                                                                    <option value="6">23</option>
                                                                                    <option value="7">24</option>
                                                                                    <option value="8">25</option>
                                                                                    <option value="9">26</option>
                                                                                    <option value="10">27</option>
                                                                                    <option value="11">28</option>
                                                                                    <option value="13">29</option>
                                                                                    <option value="14">30</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="custom-select">
                                                                                <select>
                                                                                    <option value="1">36</option>
                                                                                    <option value="2">19</option>
                                                                                    <option value="3">20</option>
                                                                                    <option value="4">21</option>
                                                                                    <option value="5">22</option>
                                                                                    <option value="6">23</option>
                                                                                    <option value="7">24</option>
                                                                                    <option value="8">25</option>
                                                                                    <option value="9">26</option>
                                                                                    <option value="10">27</option>
                                                                                    <option value="11">28</option>
                                                                                    <option value="13">29</option>
                                                                                    <option value="14">30</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="city">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">Choose Your Country
                                                                                </option>
                                                                                <option value="1">USA</option>
                                                                                <option value="2">UK</option>
                                                                                <option value="3">Spain</option>
                                                                                <option value="4">Brazil</option>
                                                                                <option value="5">France</option>
                                                                                <option value="6">Newzeland</option>
                                                                                <option value="7">Australia</option>
                                                                                <option value="8">Bangladesh</option>
                                                                                <option value="9">Turki</option>
                                                                                <option value="10">Chine</option>
                                                                                <option value="11">India</option>
                                                                                <option value="12">Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="interest">
                                                                        <div class="custom-select right w-100">
                                                                            <select class="">
                                                                                <option value="0">Your Interests
                                                                                </option>
                                                                                <option value="1">Gaming</option>
                                                                                <option value="2">Fishing</option>
                                                                                <option value="3">Skydriving</option>
                                                                                <option value="4">Swimming</option>
                                                                                <option value="5">Racing</option>
                                                                                <option value="6">Hangout</option>
                                                                                <option value="7">Tranvelling</option>
                                                                                <option value="8">Camping</option>
                                                                                <option value="9">Touring</option>
                                                                                <option value="10">Acting</option>
                                                                                <option value="11">Dancing</option>
                                                                                <option value="12">Singing</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <button class="">Find Your Partner</button>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget like-member">
                                                        <div class="widget-inner">
                                                            <div class="widget-title">
                                                                <h5>you may like</h5>
                                                            </div>
                                                            <div class="widget-content">
                                                                <div class="row row-cols-3 row-cols-sm-auto g-3">
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/01.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/02.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/03.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/04.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/05.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/06.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/07.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/08.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="image-thumb">
                                                                            <a href="#">
                                                                                <img src="assets/images/widget/09.jpg" alt="img">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget active-group">
                                                        <div class="widget-inner">
                                                            <div class="widget-title">
                                                                <h5>join the group</h5>
                                                            </div>
                                                            <div class="widget-content">
                                                                <div class="group-item lab-item">
                                                                    <div class="lab-inner d-flex flex-wrap align-items-center">
                                                                        <div class="lab-content w-100">
                                                                            <h6>Active Group A1</h6>
                                                                            <p>Colabors atively fabcate best breed and
                                                                                apcations through visionary</p>
                                                                            <ul class="img-stack d-flex">
                                                                                <li><img src="assets/images/group/group-mem/01.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/02.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/03.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/04.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/05.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/06.png" alt="member-img"></li>
                                                                                <li class="bg-theme">12+</li>
                                                                            </ul>
                                                                            <div class="test"> <a href="profile.html" class="lab-btn">
                                                                                    <i class="icofont-users-alt-5"></i>
                                                                                    View Group</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="group-item lab-item">
                                                                    <div class="lab-inner d-flex flex-wrap align-items-center">
                                                                        <div class="lab-content w-100">
                                                                            <h6>Active Group A2</h6>
                                                                            <p>Colabors atively fabcate best breed and
                                                                                apcations through visionary</p>
                                                                            <ul class="img-stack d-flex">
                                                                                <li><img src="assets/images/group/group-mem/01.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/02.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/03.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/04.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/05.png" alt="member-img"></li>
                                                                                <li><img src="assets/images/group/group-mem/06.png" alt="member-img"></li>
                                                                                <li class="bg-theme">16+</li>
                                                                            </ul>
                                                                            <div class="test"> <a href="profile.html" class="lab-btn">
                                                                                    <i class="icofont-users-alt-5"></i>
                                                                                    View Group</a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </aside>
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