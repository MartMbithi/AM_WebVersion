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
                                    <p>Your Perfect Match is Just a Click Away.</p>

                                    <form method="GET" action="search_result?gender_2=<?php echo $_POST['gender_2']; ?>&age=<?php echo $_POST['age']; ?>&city=<?php echo $_POST['city']; ?>" class="banner-form">
                                        <?php if (!empty($_SESSION['user_id'])) { ?>
                                            <div class="gender">
                                                <label for="gender" class="left">I am a </label>
                                                <div class="custom-select right">
                                                    <select name="gender" id="gender" class="">
                                                        <option><?php echo $_SESSION['user_gender']; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="gender">
                                                <label for="gender" class="left">I am a </label>
                                                <div class="custom-select right">
                                                    <select name="gender" id="gender" class="">
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="person">
                                            <label for="gender-two" class="left">Looking for</label>
                                            <div class="custom-select right">
                                                <select name="gender_2" id="gender-two" class="">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="age">
                                            <label for="age" class="left">Age</label>
                                            <div class="right d-flex justify-content-between">
                                                <div class="custom-select">
                                                    <select name="age" id="age-two">
                                                        <option>18</option>
                                                        <option>19</option>
                                                        <option>20</option>
                                                        <option>21</option>
                                                        <option>22</option>
                                                        <option>23</option>
                                                        <option>24</option>
                                                        <option>25</option>
                                                        <option>26</option>
                                                        <option>27</option>
                                                        <option>28</option>
                                                        <option>29</option>
                                                        <option>30</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="city">
                                            <label for="city" class="left">City</label>
                                            <input class="right" name="city" type="text" value="<?php echo $_SESSION['user_address']; ?>">
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

    <?php if (empty($_SESSION['user_id'])) { ?>

        <!-- ================ Member Section Start Here =============== -->
        <section class="member-section padding-tb">
            <div class="container">
                <div class="section-header">
                    <h4 class="theme-color">Meet New People Today!</h4>
                    <h2>Members Near You</h2>
                </div>
                <div class="section-wrapper">
                    <div class="row justify-content-center g-3 g-md-4">
                        <?php
                        $ret = "SELECT * FROM  users 
                        WHERE user_account_status = 'Verified'
                        ORDER BY RAND() LIMIT 5";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        while ($users = $res->fetch_object()) {
                        ?>
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="lab-item member-item style-1">
                                    <div class="lab-inner">
                                        <div class="lab-thumb">
                                            <img src="../public/uploads/user_data/<?php echo $users->user_profile_picture; ?>" alt="member-img">
                                        </div>
                                        <div class="lab-content">
                                            <h6><a href="login"><?php echo $users->user_name; ?></a> </h6>
                                            <p><?php echo $users->user_status; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="member-button-group d-flex flex-wrap justify-content-center">
                        <a href="signup" class="lab-btn"><i class="icofont-users"></i>
                            <span>
                                Join Us for Free
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ Member Section end Here =============== -->


        <!-- ================ About Section start Here =============== -->
        <section class="about-section padding-tb bg-img">
            <div class="container">
                <div class="section-header">
                    <h4>About Our Asian Melodies</h4>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ Work Section end Here =============== -->

        <!-- ================ footer Section start Here =============== -->
    <?php }
    require_once('../partials/footer.php'); ?>
    <!-- ================ footer Section end Here =============== -->
    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->
    <!-- All Scripts -->
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>