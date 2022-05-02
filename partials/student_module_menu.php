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
$view = $_GET['view'];
$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($system_settings = $res->fetch_object()) {
    /* System Logo */
    $system_logo_url = "../public/images/$system_settings->system_logo"
?>
    <div class="leftbar-tab-menu">
        <div class="main-icon-menu slimscroll-menu">
            <a href="my_dashboard" class="logo logo-metrica d-block text-center">
                <span>
                    <img src="<?php echo $system_logo_url; ?>" alt="logo-small" class="logo-sm">
                </span>
            </a>
            <nav class="nav">
                <a href="#Dashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Dashboard">
                    <i data-feather="home" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaDashboards-->

                <a href="#calendar" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="School Calendar">
                    <i data-feather="calendar" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaApps-->

                <a href="#notices" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Notices">
                    <i data-feather="airplay" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaUikit-->

                <a href="#Modules" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Enrolled Modules">
                    <i data-feather="book" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaPages-->

                <a href="#requisitions" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Requisitions">
                    <i data-feather="user-check" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaAuthentication-->
                <a href="#perfomances" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Perfomances">
                    <i data-feather="" class="align-self-center menu-icon icon-dual"></i>
                </a>
            </nav>
            <!--end nav-->

        </div>
        <!--end main-icon-menu-->

        <div class="main-menu-inner">
            <div class="topbar-left">
                <br><br>
            </div>
            <div class="menu-body slimscroll">
                <div id="Dashboard" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Dashboard</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="my_dashboard">Home</a></li>
                    </ul>
                </div>
                <div id="calendar" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">School Calendar</h6>
                    </div>
                    <ul class="nav metismenu">
                        <!--end nav-item-->
                        <li class="nav-item"><a class="nav-link" href="my_important_days">Important Days</a></li>
                    </ul>
                </div><!-- end Crypto -->

                <div id="notices" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Notice Board</h6>
                    </div>
                    <ul class="nav metismenu">
                        <!--end nav-item-->
                        <li class="nav-item"><a class="nav-link" href="my_dept_memos">Dept Memos</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_dept_notices">Dept Notices</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_course_memos">Course Memos</a></li>
                    </ul>
                    <!--end nav-->
                </div><!-- end Others -->
               
                <div id="requisitions" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Academic Requisitions</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="my_add_requisition">Add Requisition</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_manage_requisitions">Manage Requisitions</a></li>

                    </ul>
                </div>
                <div id="perfomances" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Perfomances</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="my_grades">My Grades</a></li>
                    </ul>
                </div>
                <div id="Modules" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Module Menu</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="my_module_notices?view=<?php echo $view; ?>">Notices</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_module_materials?view=<?php echo $view; ?>">Reading Materials</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_module_class_recordings?view=<?php echo $view; ?>">Class Recordings</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_module_assignments?view=<?php echo $view; ?>">Assignments</a></li>
                        <li class="nav-item"><a class="nav-link" href="my_module_pastpapers?view=<?php echo $view; ?>">Past Papers</a></li>
                    </ul>
                </div>

            </div>
            <!--end menu-body-->
        </div><!-- end main-menu-inner-->
    </div>
<?php
} ?>