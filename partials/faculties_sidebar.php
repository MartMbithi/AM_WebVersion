<?php
/*
 * Created on Fri Jan 28 2022
 *
 *  Devlan - devlan.co.ke 
 *
 * hello@devlan.info
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan
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
$faculty_id = $_GET['view'];
$ret = "SELECT * FROM `system_settings`";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($system_settings = $res->fetch_object()) {
    /* System Logo */
    $system_logo_url = "../public/images/$system_settings->system_logo"
?>
    <div class="leftbar-tab-menu">
        <div class="main-icon-menu slimscroll-menu">
            <a href="dashboard" class="logo logo-metrica d-block text-center">
                <span>
                    <img src="<?php echo $system_logo_url; ?>" alt="logo-small" class="logo-sm">
                </span>
            </a>
            <nav class="nav">
                <a href="#Dashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Faculty Dashboard">
                    <i data-feather="home" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaDashboards-->
                <a href="#Departments" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Faculty Departments">
                    <i data-feather="airplay" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <!--end MetricaUikit-->
                <a href="#Courses" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Faculty Courses">
                    <i data-feather="archive" class="align-self-center menu-icon icon-dual"></i>
                </a>
                <a href="#Reports" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Faculty Reports">
                    <i data-feather="file" class="align-self-center menu-icon icon-dual"></i>
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
                        <h6 class="menu-title">Dashboards</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="faculty_dashboard?view=<?php echo $faculty_id; ?>">Faculty Dashboard </a></li>
                    </ul>
                </div>

                <div id="Departments" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Departments</h6>
                    </div>
                    <ul class="nav metismenu">
                        <!--end nav-item-->
                        <li class="nav-item"><a class="nav-link" href="faculty_dept_add?view=<?php echo $faculty_id; ?>">Add Department</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_dept_import?view=<?php echo $faculty_id; ?>">Bulk Import</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_dept_manage?view=<?php echo $faculty_id; ?>">Manage Depts.</a></li>
                    </ul>
                    <!--end nav-->
                </div><!-- end Others -->

                <div id="Courses" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Courses</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="faculty_course_add?view=<?php echo $faculty_id; ?>">Add Course</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_course_import?view=<?php echo $faculty_id; ?>">Bulk Import</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_course_modules?view=<?php echo $faculty_id; ?>">Modules</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_course_module_allocations?view=<?php echo $faculty_id; ?>">Module Allocations</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_course_manage?view=<?php echo $faculty_id; ?>">Manage Courses</a></li>
                    </ul>
                </div><!-- end Pages -->
                <div id="Modules" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Modules</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="faculty_module_add?view=<?php echo $faculty_id; ?>">Add Module</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_import?view=<?php echo $faculty_id; ?>">Bulk Import</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_reading_materials?view=<?php echo $faculty_id; ?>">Reading Materials</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_class_recording?view=<?php echo $faculty_id; ?>">Class Recordings</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_assignments?view=<?php echo $faculty_id; ?>">Assignments</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_pastpapers?view=<?php echo $faculty_id; ?>">Past Papers</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_enrollments?view=<?php echo $faculty_id; ?>">Enrollments</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_grades?view=<?php echo $faculty_id; ?>">Grades</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_module_manage?view=<?php echo $faculty_id; ?>">Manage Modules</a></li>

                    </ul>
                </div>
                <div id="NonTeachingStaff" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Administrators</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="faculty_admins_add?view=<?php echo $faculty_id; ?>">Add</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_admins_import?view=<?php echo $faculty_id; ?>">Bulk Import</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_admins_manage?view=<?php echo $faculty_id; ?>">Manage </a></li>
                </div>
                <div id="Reports" class="main-icon-menu-pane">
                    <div class="title-box">
                        <h6 class="menu-title">Reports</h6>
                    </div>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="faculty_report_departments?view=<?php echo $faculty_id; ?>">Departments </a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_report_courses?view=<?php echo $faculty_id; ?>">Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_report_modules?view=<?php echo $faculty_id; ?>">Modules</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_report_teaching_allocations?view=<?php echo $faculty_id; ?>">Teaching Allocations</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_report_course_enrollments?view=<?php echo $faculty_id; ?>">Enrollments</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_report_timetable?view=<?php echo $faculty_id; ?>">Time Table</a></li>
                    </ul>
                </div>
            </div>
            <!--end menu-body-->
        </div><!-- end main-menu-inner-->
    </div>
<?php
} ?>