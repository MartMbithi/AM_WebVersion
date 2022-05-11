<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="header-top-area">
                <ul class="left quick-kiss">
                    <li>
                        <i class="icofont-ui-call"></i> <span>+254 737 229776 </span>
                    </li>
                    <li>
                        <i class="icofont-location-pin"></i> 127.0.0.1 Localhost
                    </li>
                </ul>
                <ul class="social-icons d-flex align-items-center">
                    <li>
                        <p class="quick-kiss">
                            Find us on :
                        </p>
                    </li>
                    <li>
                        <a href="#" class="fb"><i class="icofont-facebook-messenger"></i></a>
                    </li>
                    <li>
                        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
                    </li>
                    <li>
                        <a href="#" class="vimeo"><i class="icofont-vimeo"></i></a>
                    </li>
                    <li>
                        <a href="#" class="skype"><i class="icofont-skype"></i></a>
                    </li>
                    <li>
                        <a href="#" class="rss"><i class="icofont-rss-feed"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php
    if (!empty($_SESSION['user_id'])) {
    ?>
        <!-- Show this if user is not logged in -->
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="index">
                            <img src="../public/images/logo/logo.png" alt="logo">
                        </a>
                    </div>
                    <div class="menu-area">
                        <ul class="menu">
                            <li>
                                <a href="index">Home</a>
                            </li>
                            <li>
                                <a href="my_members">Members</a>
                            </li>
                            <li>
                                <a href="my_matches">Matches</a>
                            </li>
                            <li>
                                <a href="my_favourites">Favourites</a>
                            </li>
                            <li>
                                <a href="my_chat">Chat</a>
                            </li>
                            <li>
                                <a href="#0">Profile</a>
                                <ul class="submenu">
                                    <li><a href="my_profile">My Profile</a></li>
                                    <li><a href="logout?account=<?php echo $_SESSION['user_id']; ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- toggle icons -->
                        <div class="header-bar d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="ellepsis-bar d-lg-none">
                            <i class="icofont-info-square"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="index">
                            <img src="../public/images/logo/logo.png" alt="logo">
                        </a>
                    </div>
                    <div class="menu-area">
                        <ul class="menu">
                            <li>
                                <a href="index">Home</a>
                            </li>
                            <li>
                                <a href="#about">About Us</a>
                            </li>
                            <li>
                                <a href="#how_it_works">How It Works</a>
                            </li>
                        </ul>
                        <a href="login" class="login"><i class="icofont-user"></i> <span>LOG IN</span> </a>
                        <a href="signup" class="signup"><i class="icofont-users"></i> <span>SIGN UP</span> </a>

                        <!-- toggle icons -->
                        <div class="header-bar d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="ellepsis-bar d-lg-none">
                            <i class="icofont-info-square"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</header>