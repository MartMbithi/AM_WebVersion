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


    <!-- ================ Banner Section start Here =============== -->
    <section class="banner-section">
        <div class="container">
            <div class="section-wrapper">
                <div class="row align-items-end">
                    <div class="col-lg-6">
                        <div class="banner-content">
                            <div class="intro-form">
                                <div class="intro-form-inner">
                                    <h3>Introducing Asian Melodies</h3>
                                    <p>Serious Dating With <strong>Asian Meloddies </strong> Your Perfect
                                        Match is Just a Click Away.</p>
                                    <form class="banner-form">
                                        <div class="gender">
                                            <label for="gender" class="left">I am a </label>
                                            <div class="custom-select right">
                                                <select name="gender" id="gender" class="">
                                                    <option value="0">Select Gender</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="3">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="person">
                                            <label for="gender-two" class="left">Looking for</label>
                                            <div class="custom-select right">
                                                <select name="gender" id="gender-two" class="">
                                                    <option value="0">Select Gender</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="3">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="age">
                                            <label for="age" class="left">Age</label>
                                            <div class="right d-flex justify-content-between">
                                                <div class="custom-select">
                                                    <select name="age-start" id="age">
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
                                                    <select name="age-end" id="age-two">
                                                        <option value="1">18+</option>
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
                                            <label for="city" class="left">City</label>
                                            <input class="right" type="text" id="city" placeholder="Your City Name..">
                                        </div>
                                        <button class="">Find Your Partner</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-thumb">
                            <img src="../public/images/banner/01.png" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="all-shapes">
            <img src="../public/images/banner/banner-shapes/01.png" alt="shape" class="banner-shape shape-1">
            <img src="../public/images/banner/banner-shapes/02.png" alt="shape" class="banner-shape shape-2">
            <img src="../public/images/banner/banner-shapes/03.png" alt="shape" class="banner-shape shape-3">
            <img src="../public/images/banner/banner-shapes/04.png" alt="shape" class="banner-shape shape-4">
            <img src="../public/images/banner/banner-shapes/05.png" alt="shape" class="banner-shape shape-5">
            <img src="../public/images/banner/banner-shapes/06.png" alt="shape" class="banner-shape shape-6">
            <img src="../public/images/banner/banner-shapes/07.png" alt="shape" class="banner-shape shape-7">
            <img src="../public/images/banner/banner-shapes/08.png" alt="shape" class="banner-shape shape-8">
        </div>
    </section>
    <!-- ================ Banner Section end Here =============== -->


    <!-- ================ Member Section Start Here =============== -->
    <section class="member-section padding-tb">
        <div class="container">
            <div class="section-header">
                <h4 class="theme-color">Meet New People Today!</h4>
                <h2>New Members in London</h2>
            </div>
            <div class="section-wrapper">
                <div class="row justify-content-center g-3 g-md-4">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="lab-item member-item style-1">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public/images/member/01.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Andrea Guido</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="lab-item member-item style-1">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public/images/member/02.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Gihan-Fernando</a></h6>
                                    <p>Active 2 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="lab-item member-item style-1">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public/images/member/03.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Sweet Admin</a></h6>
                                    <p>Active 3 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="lab-item member-item style-1">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public/images/member/04.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Gyan-Baffour</a></h6>
                                    <p>Active 5 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="lab-item member-item style-1">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public/images/member/05.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Teszt Eleking</a></h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="lab-item member-item style-1">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/06.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Zeahra Guido</a>
                                    </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="member-button-group d-flex flex-wrap justify-content-center">
                    <a href="signup.html" class="lab-btn"><i class="icofont-users"></i> <span>Join Us for
                            Free</span></a>
                    <a href="login.html" class="lab-btn"><i class="icofont-play-alt-1"></i> <span>Our tv
                            commercial</span></a>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Member Section end Here =============== -->


    <!-- ================ About Section start Here =============== -->
    <section class="about-section padding-tb bg-img">
        <div class="container">
            <div class="section-header">
                <h4>About Our Turulav</h4>
                <h2>It All Starts With A Date</h2>
            </div>
            <div class="section-wrapper">
                <div class="row justify-content-center g-4">
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="lab-item about-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <img src="../public//images/about/01.png" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h2 class="counter">29,991</h2>
                                    <p>Members in Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="lab-item about-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <img src="../public//images/about/02.png" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h2 class="counter">29,960</h2>
                                    <p>Members Online</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="lab-item about-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <img src="../public//images/about/03.png" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h2 class="counter">29,960</h2>
                                    <p>Men Online</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="lab-item about-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <img src="../public//images/about/04.png" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h2 class="counter">28,960</h2>
                                    <p>Women Online</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ About Section end Here =============== -->


    <!-- ================ Work Section start Here =============== -->
    <section class="work-section padding-tb">
        <div class="container">
            <div class="section-header">
                <h4 class="theme-color">How Does It Work?</h4>
                <h2>You’re Just 3 Steps Away From A Great Date</h2>
            </div>
            <div class="section-wrapper">
                <div class="row justify-content-center g-5">
                    <div class="col-lg-4 col-sm-6 col-12 px-4">
                        <div class="lab-item work-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <div class="thumb-inner">
                                        <img src="../public//images/work/01.png" alt="work-img">
                                        <div class="step">
                                            <span>step</span>
                                            <p>01</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="lab-content">
                                    <h4>Create A Profile</h4>
                                    <p>Continua actualize ailers through robu
                                        and sertively concepze standards compliant
                                        commerce after technica sound.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12 px-4">
                        <div class="lab-item work-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <div class="thumb-inner">
                                        <img src="../public//images/work/02.png" alt="work-img">
                                        <div class="step">
                                            <span>step</span>
                                            <p>02</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="lab-content">
                                    <h4>Find Matches</h4>
                                    <p>Continua actualize ailers through robu
                                        and sertively concepze standards compliant
                                        commerce after technica sound.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12 px-4">
                        <div class="lab-item work-item">
                            <div class="lab-inner text-center">
                                <div class="lab-thumb">
                                    <div class="thumb-inner">
                                        <img src="../public//images/work/03.png" alt="work-img">
                                        <div class="step">
                                            <span>step</span>
                                            <p>03</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="lab-content">
                                    <h4>Start Dating</h4>
                                    <p>Continua actualize ailers through robu
                                        and sertively concepze standards compliant
                                        commerce after technica sound.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Work Section end Here =============== -->



    <!-- ================ Success Story Section start Here =============== -->
    <section class="story-section padding-tb bg-img">
        <div class=" container">
            <div class="section-header">
                <h4>Love in Faith Success Stories</h4>
                <h2>Sweet Stories From Our Lovers</h2>
            </div>
            <div class="section-wrapper">
                <div class="row justify-content-center g-4">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="story-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/story/01.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4><a href="blog-single.html">Image Post Formate</a></h4>
                                    <p>Seamlesly evolve unique web-readiness with
                                        Collabors atively fabricate best of breed and
                                        apcations through </p>
                                    <a href="blog-single.html" class="lab-btn"><i class="icofont-circled-right"></i>
                                        Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="story-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/story/02.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4><a href="blog-single.html">Couple Of Month</a></h4>
                                    <p>Seamlesly evolve unique web-readiness with
                                        Collabors atively fabricate best of breed and
                                        apcations through </p>
                                    <a href="blog-single.html" class="lab-btn"><i class="icofont-circled-right"></i>
                                        Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="story-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/story/03.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4><a href="blog-single.html">Media For Blog Article</a></h4>
                                    <p>Seamlesly evolve unique web-readiness with
                                        Collabors atively fabricate best of breed and
                                        apcations through </p>
                                    <a href="blog-single.html" class="lab-btn"><i class="icofont-circled-right"></i>
                                        Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Success Story Section end Here =============== -->


    <!-- ================ Top Member Section start Here =============== -->
    <section class="top-member-section padding-tb">
        <div class="container">
            <div class="section-header">
                <h4 class="theme-color">Top Members</h4>
                <h2>Turulav Members Online Now</h2>
            </div>
            <div class="section-wrapper">
                <ul class="button-group filters-button-group w-100 d-flex flex-wrap justify-content-center">
                    <li class="button is-checked filter-btn" data-filter="*"><i class="icofont-heart-alt"></i> Show all
                    </li>
                    <li class="button filter-btn" data-filter=".girl"><i class="icofont-girl"></i> new girl
                        member</li>
                    <li class="button filter-btn" data-filter=".boy"><i class="icofont-hotel-boy"></i> New
                        Boy Member</li>
                </ul>

                <div class="grid-memberlist">
                    <div class="grid-member filter-item girl">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/01.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Johanna</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item girl">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/03.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Selinae</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item boy">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/02.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Andrea Guido</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item boy">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/04.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Rocky deo</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item girl">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/05.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Jhon doe</a> </h6>
                                    <p>Active 5 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item boy">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/06.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Angelina</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item girl">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/07.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Andrea Guido</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item boy">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/08.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Jene Aiko</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item girl">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/09.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Anna haek</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-member filter-item boy">
                        <div class="lab-item member-item style-1 style-2">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="../public//images/member/10.jpg" alt="member-img">
                                </div>
                                <div class="lab-content">
                                    <h6><a href="profile.html">Andrean Puido</a> </h6>
                                    <p>Active 1 Day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Top Member Section end Here =============== -->


    <!-- ================ Active Group Section Start Here =============== -->
    <section class="group-section padding-tb bg-img">
        <div class="container">
            <div class="section-header">
                <h4>Recently Active Groups</h4>
                <h2>Turulav 4 Best Active Group</h2>
            </div>
            <div class="section-wrapper">
                <div class="row g-4">
                    <div class="col-xl-6 col-12">
                        <div class="group-item lab-item">
                            <div class="lab-inner d-flex flex-wrap align-items-center p-4">
                                <div class="lab-thumb me-sm-4 mb-4 mb-sm-0">
                                    <img src="../public//images/group/01.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4>Active Group A1</h4>
                                    <p>Colabors atively fabcate best breed and
                                        apcations through visionary value </p>
                                    <ul class="img-stack d-flex">
                                        <li><img src="../public//images/group/group-mem/01.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/02.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/03.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/04.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/05.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/06.png" alt="member-img"></li>
                                        <li class="bg-theme">12+</li>
                                    </ul>
                                    <div class="test"> <a href="active-group.html" class="lab-btn"> <i class="icofont-users-alt-5"></i>View Group</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="group-item lab-item">
                            <div class="lab-inner d-flex flex-wrap align-items-center p-4">
                                <div class="lab-thumb me-sm-4 mb-4 mb-sm-0">
                                    <img src="../public//images/group/02.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4>Active Group A2</h4>
                                    <p>Colabors atively fabcate best breed and
                                        apcations through visionary value </p>
                                    <ul class="img-stack d-flex">
                                        <li><img src="../public//images/group/group-mem/01.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/02.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/03.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/04.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/05.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/06.png" alt="member-img"></li>
                                        <li class="bg-theme">12+</li>
                                    </ul>
                                    <div class="test"> <a href="active-group.html" class="lab-btn"> <i class="icofont-users-alt-5"></i>View Group</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="group-item lab-item">
                            <div class="lab-inner d-flex flex-wrap align-items-center p-4">
                                <div class="lab-thumb me-sm-4 mb-4 mb-sm-0">
                                    <img src="assets/images/group/03.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4>Active Group A3</h4>
                                    <p>Colabors atively fabcate best breed and
                                        apcations through visionary value </p>
                                    <ul class="img-stack d-flex">
                                        <li><img src="../public//images/group/group-mem/01.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/02.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/03.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/04.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/05.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/06.png" alt="member-img"></li>
                                        <li class="bg-theme">12+</li>
                                    </ul>
                                    <div class="test"> <a href="active-group.html" class="lab-btn"> <i class="icofont-users-alt-5"></i>View Group</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="group-item lab-item">
                            <div class="lab-inner d-flex flex-wrap align-items-center p-4">
                                <div class="lab-thumb me-sm-4 mb-4 mb-sm-0">
                                    <img src="assets/images/group/04.jpg" alt="img">
                                </div>
                                <div class="lab-content">
                                    <h4>Active Group A4</h4>
                                    <p>Colabors atively fabcate best breed and
                                        apcations through visionary value </p>
                                    <ul class="img-stack d-flex">
                                        <li><img src="../public//images/group/group-mem/01.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/02.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/03.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/04.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/05.png" alt="member-img"></li>
                                        <li><img src="../public//images/group/group-mem/06.png" alt="member-img"></li>
                                        <li class="bg-theme">12+</li>
                                    </ul>
                                    <div class="test"> <a href="active-group.html" class="lab-btn"> <i class="icofont-users-alt-5"></i>View Group</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Active Group Section end Here =============== -->


    <!-- ================ Review Section start Here =============== -->
    <section class="clints-section padding-tb">
        <div class="container">
            <div class="section-header">
                <h4 class="theme-color">What our Customers Say</h4>
                <h2>Client’s Feed back Latest Reviews
                    From My Clients</h2>
            </div>
            <div class="section-wrapper">
                <div class="clients">
                    <div class="client-list">
                        <div class="client-content">
                            <p>Drama enable wordwide action team whereProcedu Aran Manu Produc Raher ConveneMotin Was
                                Procedur Arramin</p>
                            <div class="client-info">
                                <div class="name-desi">
                                    <h6>Marin Chapla</h6>
                                    <span>UI Designer</span>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="client-thumb">
                            <img src="../public//images/group/group-mem/02.png" alt="lab-clients">
                        </div>
                    </div>
                    <div class="client-list">
                        <div class="client-content">
                            <p>Drama enable wordwide action team whereProcedu Aran Manu Produc Raher ConveneMotin Was
                                Procedur Arramin</p>
                            <div class="client-info">
                                <div class="name-desi">
                                    <h6>Nandita Rani</h6>
                                    <span>Digital Marketor</span>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="client-thumb">
                            <img src="../public//images/group/group-mem/01.png" alt="lab-clients">
                        </div>
                    </div>
                    <div class="client-list">
                        <div class="client-content">
                            <p>Drama enable wordwide action team whereProcedu Aran Manu Produc Raher ConveneMotin Was
                                Procedur Arramin</p>
                            <div class="client-info">
                                <div class="name-desi">
                                    <h6>Sunil Borua</h6>
                                    <span>UX Designer</span>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="client-thumb">
                            <img src="../public//images/group/group-mem/03.png" alt="lab-clients">
                        </div>
                    </div>
                    <div class="client-list">
                        <div class="client-content">
                            <p>Drama enable wordwide action team whereProcedu Aran Manu Produc Raher ConveneMotin Was
                                Procedur Arramin</p>
                            <div class="client-info">
                                <div class="name-desi">
                                    <h6>Zinat Zaara</h6>
                                    <span>Web Designer</span>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="client-thumb">
                            <img src="../public//images/group/group-mem/04.png" alt="lab-clients">
                        </div>
                    </div>
                    <div class="client-list">
                        <div class="client-content">
                            <p>Drama enable wordwide action team whereProcedu Aran Manu Produc Raher ConveneMotin Was
                                Procedur Arramin</p>
                            <div class="client-info">
                                <div class="name-desi">
                                    <h6><a href="profile.html">Somrat Islam </a></h6>
                                    <span>UI Designer</span>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="client-thumb">
                            <img src="../public//images/group/group-mem/05.png" alt="lab-clients">
                        </div>
                    </div>
                    <div class="client-list">
                        <div class="client-content">
                            <p>Drama enable wordwide action team whereProcedu Aran Manu Produc Raher ConveneMotin Was
                                Procedur Arramin</p>
                            <div class="client-info">
                                <div class="name-desi">
                                    <h6>Junaid Khan</h6>
                                    <span>Font-End-Devoloper</span>
                                </div>
                                <div class="rating">
                                    <ul>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                        <li><i class="icofont-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="client-thumb">
                            <img src="../public//images/group/group-mem/06.png" alt="lab-clients">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Review Section end Here =============== -->


    <!-- ================ App Section start Here =============== -->
    <section class="app-section bg-theme">
        <div class="container">
            <div class="section-wrapper padding-tb">
                <div class="app-content">
                    <h4>Download App Our Turulav</h4>
                    <h2>Easy Connect to Everyone</h2>
                    <p>You find us, finally, and you are already in love. More than 5.000.000 around
                        the world already shared the same experience andng ares uses our system
                        Joining us today just got easier!</p>
                    <ul class="app-download d-flex flex-wrap">
                        <li><a href="#" class="d-flex flex-wrap align-items-center">
                                <div class="app-thumb">
                                    <img src="../public//images/app/apple.png" alt="apple">
                                </div>
                                <div class="app-content">
                                    <p>Available on the</p>
                                    <h4>App Store</h4>
                                </div>
                            </a></li>
                        <li class="d-inline-block"><a href="#" class="d-flex flex-wrap align-items-center">
                                <div class="app-thumb">
                                    <img src="../public//images/app/playstore.png" alt="playstore">
                                </div>
                                <div class="app-content">
                                    <p>Available on the</p>
                                    <h4>Google Play</h4>
                                </div>
                            </a></li>
                    </ul>

                </div>
                <div class="mobile-app">
                    <img src="../public//images/app/mobile-view.png" alt="mbl-view">
                </div>
            </div>
        </div>
    </section>
    <!-- ================ App Section end Here =============== -->


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