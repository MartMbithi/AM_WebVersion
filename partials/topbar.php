<?php
/*
 * Created on Mon Nov 29 2021
 *
 *  Devlan - devlan.co.ke 
 *
 * hello@devlan.info
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2021 Devlan
 *
 * 1. GRANT OF LICENSE
 * Devlan hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan and protected by copyright law and international copyright treaties. 
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
 * Devlan  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * Devlan SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
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
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
 * CONSEQUENTIAL, SPECIAL, INCIDENTAL OR INDIRECT DAMAGES OF ANY KIND ARISING OUT OF THE DELIVERY, PERFORMANCE OR 
 * USE OF THE SOFTWARE, EVEN IF DEVLAN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES
 * IN NO EVENT WILL DEVLAN  LIABILITY FOR ANY CLAIM, WHETHER IN CONTRACT 
 * TORT OR ANY OTHER THEORY OF LIABILITY, EXCEED THE LICENSE FEE PAID BY YOU, IF ANY.
 */

$user_id  = $_SESSION['user_id'];
$access_level = $_SESSION['user_access_level'];

if ($access_level == 'sys_admin') {
    /* Load System Admin Top Bar */
    $ret = "SELECT * FROM users  JOIN system_settings
    WHERE user_id ='$user_id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
        /* Count Unread Notifications For This User */
        $query = "SELECT COUNT(*)  FROM notifications 
        WHERE notification_status = 'Unread' 
        AND notification_user_id = '$user_id'
        AND notification_target_audience = 'All Personnel'  ";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($unread);
        $stmt->fetch();
        $stmt->close();
        /* Has Profile Picture */
        if ($admin->user_dpic == '') {
            $url = "../public/images/no-profile.png";
        } else {
            $url = "../public/uploads/user_data/admins/$admin->user_dpic";
        }
        /* System Logo */
        $sys_logo = "../public/images/$admin->system_logo"
?>
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti-bell noti-icon"></i>
                            <span class="badge badge-danger badge-pill noti-icon-badge"><?php echo $unread; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                            <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                Notifications <span class="badge badge-light badge-pill"><?php echo $unread; ?></span>
                            </h6>
                            <div class="slimscroll notification-list">
                                <!-- item-->
                                <?php
                                /* Load Notifications On Order Created */
                                $ret = "SELECT * FROM notifications
                                WHERE notification_status = 'Unread'
                                AND notification_user_id = '$user_id'
                                AND notification_target_audience = 'All Personnel'
                                ORDER BY notification_created_at DESC ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($notification = $res->fetch_object()) {
                                ?>
                                    <a href="notifications" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2"><?php echo date('d M Y g:ia', strtotime($notification->notification_created_at)); ?></small>
                                        <div class="media">
                                            <div class="avatar-md bg-primary">
                                                <i class="la la-angle-double-right text-white"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <small class="text-muted mb-0"><?php echo  substr($notification->notification_details, 0, 30) . "..."; ?></small>
                                            </div>
                                            <!--end media-body-->
                                        </div>
                                        <!--end media-->
                                    </a>
                                <?php
                                } ?>
                                <!--end-item-->

                            </div>
                            <!-- All-->
                            <a href="notifications" class="dropdown-item text-center text-primary">
                                View all <i class="fi-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/user-4.jpg" alt="Hello, <?php echo $admin->user_name; ?>" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="profile"><i class="dripicons-user text-muted mr-2"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" target="_blank" href="<?php echo $admin->system_calendar_embed_code; ?>"><i class="dripicons-calendar text-muted mr-2"></i> Calendar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                        </div>
                    </li>
                    <li class="mr-2">

                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <a href="dashboard">
                            <span class="responsive-logo">
                                <img src="<?php echo $sys_logo; ?>" alt="logo-small" class="logo-sm align-self-center" height="34">
                            </span>
                        </a>
                    </li>
                    <li>
                        <button class="button-menu-mobile nav-link">
                            <i data-feather="menu" class="align-self-center"></i>
                        </button>
                    </li>
                    <li class="hide-phone app-search">
                        <form role="search" method="get" action="search_result" class="">
                            <input type="text" name="querry" placeholder="Search Students" class="form-control">
                            <a href="#"><i class="fas fa-search"></i></a>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
    <?php
    }
} else if ($access_level == 'educational_admin') {
    /* Load Educational Admin Top Bar */
    $ret = "SELECT * FROM users  JOIN system_settings
    WHERE user_id ='$user_id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
        /* Count Unread Notifications For This User */
        $query = "SELECT COUNT(*)  FROM notifications 
        WHERE notification_status = 'Unread' 
        AND notification_user_id = '$user_id'
        AND notification_target_audience = 'All Personnel'  ";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($unread);
        $stmt->fetch();
        $stmt->close();
        /* Has Profile Picture */
        if ($admin->user_dpic == '') {
            $url = "../public/images/no-profile.png";
        } else {
            $url = "../public/uploads/user_data/admins/$admin->user_dpic";
        }
        /* System Logo */
        $sys_logo = "../public/images/$admin->system_logo"
    ?>
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti-bell noti-icon"></i>
                            <span class="badge badge-danger badge-pill noti-icon-badge"><?php echo $unread; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                            <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                Notifications <span class="badge badge-light badge-pill"><?php echo $unread; ?></span>
                            </h6>
                            <div class="slimscroll notification-list">
                                <!-- item-->
                                <?php
                                /* Load Notifications On Order Created */
                                $ret = "SELECT * FROM notifications
                               WHERE notification_status = 'Unread'
                               AND notification_user_id = '$user_id'
                               AND notification_target_audience = 'All Personnel'
                               ORDER BY notification_created_at DESC ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($notification = $res->fetch_object()) {
                                ?>
                                    <a href="edu_notifications" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2"><?php echo date('d M Y g:ia', strtotime($notification->notification_created_at)); ?></small>
                                        <div class="media">
                                            <div class="avatar-md bg-primary">
                                                <i class="la la-angle-double-right text-white"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <small class="text-muted mb-0"><?php echo  substr($notification->notification_details, 0, 30) . "..."; ?></small>
                                            </div>
                                            <!--end media-body-->
                                        </div>
                                        <!--end media-->
                                    </a>
                                <?php
                                } ?>
                                <!--end-item-->

                            </div>
                            <!-- All-->
                            <a href="edu_notifications" class="dropdown-item text-center text-primary">
                                View all <i class="fi-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/user-4.jpg" alt="Hello, <?php echo $admin->user_name; ?>" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edu_profile"><i class="dripicons-user text-muted mr-2"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="edu_report_bug"><i class="dripicons-message  text-muted mr-2"></i> Report Bug</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" target="_blank" href="<?php echo $admin->system_calendar_embed_code; ?>"><i class="dripicons-calendar text-muted mr-2"></i> Calendar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                        </div>
                    </li>
                    <li class="mr-2">

                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <a href="edu_dashboard">
                            <span class="responsive-logo">
                                <img src="<?php echo $sys_logo; ?>" alt="logo-small" class="logo-sm align-self-center" height="34">
                            </span>
                        </a>
                    </li>
                    <li>
                        <button class="button-menu-mobile nav-link">
                            <i data-feather="menu" class="align-self-center"></i>
                        </button>
                    </li>
                    <li class="hide-phone app-search">
                        <form role="search" method="get" action="edu_search_result" class="">
                            <input type="text" name="querry" placeholder="Search Students" class="form-control">
                            <a href="#"><i class="fas fa-search"></i></a>
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- end navbar-->
        </div>

    <?php }
} else if ($access_level == 'lecturer') {
    /* Load Lecturer Top Bar */
    $ret = "SELECT * FROM users  JOIN system_settings
    WHERE user_id ='$user_id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
        /* Count Unread Notifications For This User */
        $query = "SELECT COUNT(*)  FROM notifications 
        WHERE notification_status = 'Unread' 
        AND notification_user_id = '$user_id'
        AND notification_target_audience = 'All Personnel'  ";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($unread);
        $stmt->fetch();
        $stmt->close();
        /* Has Profile Picture */
        if ($admin->user_dpic == '') {
            $url = "../public/images/no-profile.png";
        } else {
            $url = "../public/uploads/user_data/admins/$admin->user_dpic";
        }
        /* System Logo */
        $sys_logo = "../public/images/$admin->system_logo"
    ?>
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti-bell noti-icon"></i>
                            <span class="badge badge-danger badge-pill noti-icon-badge"><?php echo $unread; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                            <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                Notifications <span class="badge badge-light badge-pill"><?php echo $unread; ?></span>
                            </h6>
                            <div class="slimscroll notification-list">
                                <!-- item-->
                                <?php
                                /* Load Notifications On Order Created */
                                $ret = "SELECT * FROM notifications
                                WHERE notification_status = 'Unread'
                                AND notification_user_id = '$user_id'
                                AND notification_target_audience = 'All Personnel'
                                ORDER BY notification_created_at DESC ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($notification = $res->fetch_object()) {
                                ?>
                                    <a href="lec_notifications" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2"><?php echo date('d M Y g:ia', strtotime($notification->notification_created_at)); ?></small>
                                        <div class="media">
                                            <div class="avatar-md bg-primary">
                                                <i class="la la-angle-double-right text-white"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <small class="text-muted mb-0"><?php echo  substr($notification->notification_details, 0, 30) . "..."; ?></small>
                                            </div>
                                            <!--end media-body-->
                                        </div>
                                        <!--end media-->
                                    </a>
                                <?php
                                } ?>
                                <!--end-item-->

                            </div>
                            <!-- All-->
                            <a href="lec_notifications" class="dropdown-item text-center text-primary">
                                View all <i class="fi-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/user-4.jpg" alt="Hello, <?php echo $admin->user_name; ?>" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="lec_profile"><i class="dripicons-user text-muted mr-2"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="lec_report_bug"><i class="dripicons-message  text-muted mr-2"></i> Report Bug</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" target="_blank" href="<?php echo $admin->system_calendar_embed_code; ?>"><i class="dripicons-calendar text-muted mr-2"></i> Calendar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                        </div>
                    </li>
                    <li class="mr-2">

                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <a href="lec_dashboard">
                            <span class="responsive-logo">
                                <img src="<?php echo $sys_logo; ?>" alt="logo-small" class="logo-sm align-self-center" height="34">
                            </span>
                        </a>
                    </li>
                    <li>
                        <button class="button-menu-mobile nav-link">
                            <i data-feather="menu" class="align-self-center"></i>
                        </button>
                    </li>
                    <li class="hide-phone app-search">
                        <!-- <form role="search" method="get" action="search_result" class="">
                            <input type="text" name="querry" placeholder="Search Students" class="form-control">
                            <a href="#"><i class="fas fa-search"></i></a>
                        </form> -->
                    </li>
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
    <?php }
} else {
    /* Load Student Top Bar */
    $ret = "SELECT * FROM users  JOIN system_settings
    WHERE user_id ='$user_id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
        /* Count Unread Notifications For This User */
        $query = "SELECT COUNT(*)  FROM notifications 
        WHERE notification_status = 'Unread' 
        AND notification_user_id = '$user_id'
        AND notification_target_audience = 'All Personnel'  ";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($unread);
        $stmt->fetch();
        $stmt->close();
        /* Has Profile Picture */
        if ($admin->user_dpic == '') {
            $url = "../public/images/no-profile.png";
        } else {
            $url = "../public/uploads/user_data/admins/$admin->user_dpic";
        }
        /* System Logo */
        $sys_logo = "../public/images/$admin->system_logo"
    ?>
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti-bell noti-icon"></i>
                            <span class="badge badge-danger badge-pill noti-icon-badge"><?php echo $unread; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                            <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                                Notifications <span class="badge badge-light badge-pill"><?php echo $unread; ?></span>
                            </h6>
                            <div class="slimscroll notification-list">
                                <!-- item-->
                                <?php
                                /* Load Notifications On Order Created */
                                $ret = "SELECT * FROM notifications
                                WHERE notification_status = 'Unread'
                                AND notification_user_id = '$user_id'
                                AND notification_target_audience = 'All Personnel'
                                ORDER BY notification_created_at DESC ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($notification = $res->fetch_object()) {
                                ?>
                                    <a href="my_notifications" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2"><?php echo date('d M Y g:ia', strtotime($notification->notification_created_at)); ?></small>
                                        <div class="media">
                                            <div class="avatar-md bg-primary">
                                                <i class="la la-angle-double-right text-white"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <small class="text-muted mb-0"><?php echo  substr($notification->notification_details, 0, 30) . "..."; ?></small>
                                            </div>
                                            <!--end media-body-->
                                        </div>
                                        <!--end media-->
                                    </a>
                                <?php
                                } ?>
                                <!--end-item-->

                            </div>
                            <!-- All-->
                            <a href="my_notifications" class="dropdown-item text-center text-primary">
                                View all <i class="fi-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/user-4.jpg" alt="Hello, <?php echo $admin->user_name; ?>" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="my_profile"><i class="dripicons-user text-muted mr-2"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="my_report_bug"><i class="dripicons-message  text-muted mr-2"></i> Report Bug</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" target="_blank" href="<?php echo $admin->system_calendar_embed_code; ?>"><i class="dripicons-calendar text-muted mr-2"></i> Calendar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                        </div>
                    </li>
                    <li class="mr-2">

                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <a href="my_dashboard">
                            <span class="responsive-logo">
                                <img src="<?php echo $sys_logo; ?>" alt="logo-small" class="logo-sm align-self-center" height="34">
                            </span>
                        </a>
                    </li>
                    <li>
                        <button class="button-menu-mobile nav-link">
                            <i data-feather="menu" class="align-self-center"></i>
                        </button>
                    </li>
                    <li class="hide-phone app-search">
                        <!-- <form role="search" method="get" action="search_result" class="">
                            <input type="text" name="querry" placeholder="Search Students" class="form-control">
                            <a href="#"><i class="fas fa-search"></i></a>
                        </form> -->
                    </li>
                </ul>
            </nav>
            <!-- end navbar-->
        </div>

<?php }
} ?>