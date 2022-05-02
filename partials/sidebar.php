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

$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($system_settings = $res->fetch_object()) {
    /* System Logo */
    $system_logo_url = "../public/images/$system_settings->system_logo";
    $access_level = $_SESSION['user_access_level'];
    if ($access_level == 'sys_admin') {
        /* Load Admin Side Menu */
?>
        <div class="leftbar-tab-menu">
            <div class="main-icon-menu slimscroll-menu">
                <a href="dashboard" class="logo logo-metrica d-block text-center">
                    <span>
                        <img src="<?php echo $system_logo_url; ?>" alt="logo-small" class="logo-sm">
                    </span>
                </a>
                <nav class="nav">
                    <a href="#Dashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Dashboard">
                        <i data-feather="home" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaDashboards-->

                    <a href="#Faculties" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Faculties">
                        <i data-feather="briefcase" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaApps-->

                    <a href="#Departments" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Departments">
                        <i data-feather="airplay" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaUikit-->

                    <a href="#Courses" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Courses">
                        <i data-feather="archive" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaPages-->

                    <a href="#Modules" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Modules">
                        <i data-feather="book" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaAuthentication-->
                    <a href="#NonTeachingStaff" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Non Teaching Staffs">
                        <i data-feather="user" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaAuthentication-->
                    <a href="#TeachingStaff" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Lecturers">
                        <i data-feather="user-check" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaAuthentication-->
                    <a href="#Students" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Students">
                        <i data-feather="users" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <a href="#Reports" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Reports">
                        <i data-feather="file" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <a href="#SystemSettings" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="System Settings">
                        <i data-feather="sliders" class="align-self-center menu-icon icon-dual"></i>
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
                            <li class="nav-item"><a class="nav-link" href="dashboard">Admin Dashboard </a></li>
                        </ul>
                    </div>
                    <div id="Faculties" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Faculties</h6>
                        </div>
                        <ul class="nav metismenu">
                            <!--end nav-item-->
                            <li class="nav-item"><a class="nav-link" href="faculty_academic_calendar">Academic Calendar</a></li>
                            <li class="nav-item"><a class="nav-link" href="faculty_add">Add Faculty</a></li>
                            <li class="nav-item"><a class="nav-link" href="faculty_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="facuty_allocate_admin">Allocate Head</a></li>
                            <li class="nav-item"><a class="nav-link" href="faculty_school_calendar">School Calendar</a></li>
                            <li class="nav-item"><a class="nav-link" href="faculty_manage">Manage Faculties</a></li>
                            <li class="nav-item"><a class="nav-link" href="faculty_search">Advanced Search</a></li>
                        </ul>
                    </div><!-- end Crypto -->

                    <div id="Departments" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Departments</h6>
                        </div>
                        <ul class="nav metismenu">
                            <!--end nav-item-->
                            <li class="nav-item"><a class="nav-link" href="dept_add">Add Department</a></li>
                            <li class="nav-item"><a class="nav-link" href="dept_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="dept_memos">Dept. Memos </a></li>
                            <li class="nav-item"><a class="nav-link" href="dept_notices">Dept. Notices </a></li>
                            <li class="nav-item"><a class="nav-link" href="dept_documents">Dept. Documents </a></li>
                            <li class="nav-item"><a class="nav-link" href="dept_manage">Manage Depts.</a></li>
                            <li class="nav-item"><a class="nav-link" href="dept_search">Search</a></li>
                        </ul>
                        <!--end nav-->
                    </div><!-- end Others -->

                    <div id="Courses" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Courses</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="course_add">Add Course</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_memos">Course Memos</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_modules">Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_module_allocations">Module Allocations</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_time_table">Time Table</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_enrolled_students">Enrolled Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_manage">Manage Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_search">Advanced Search</a></li>
                        </ul>
                    </div><!-- end Pages -->
                    <div id="Modules" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Modules</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="module_add">Add Module</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_notices">Notices</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_reading_materials">Reading Materials</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_class_recording">Class Recordings</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_assignments">Assignments</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_pastpapers">Past Papers</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_enrollments">Enrollments</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_grades">Grades</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_manage">Manage Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="module_search">Advanced Search</a></li>

                        </ul>
                    </div>
                    <div id="NonTeachingStaff" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Administrators</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="admins_add">Add</a></li>
                            <li class="nav-item"><a class="nav-link" href="admins_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="admins_manage">Manage </a></li>
                            <li class="nav-item"><a class="nav-link" href="admins_search">Advanced Search</a></li>
                    </div>
                    <div id="TeachingStaff" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Teaching Staff</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="staff_add">Add</a></li>
                            <li class="nav-item"><a class="nav-link" href="staff_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="staff_allocate_module">Allocate Module</a></li>
                            <li class="nav-item"><a class="nav-link" href="staff_manage">Manage</a></li>
                            <li class="nav-item"><a class="nav-link" href="staff_search">Advanced Search</a></li>
                        </ul>
                    </div>
                    <div id="Students" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Students</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="student_add">Add Student</a></li>
                            <li class="nav-item"><a class="nav-link" href="student_import">Bulk Import</a></li>
                            <li class="nav-item"><a class="nav-link" href="student_enroll">Enroll </a></li>
                            <li class="nav-item"><a class="nav-link" href="student_grades">Grades</a></li>
                            <li class="nav-item"><a class="nav-link" href="student_manage">Manage Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="student_search">Advanced Search</a></li>
                        </ul>
                    </div>
                    <div id="Reports" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Reports</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="report_faculties">Faculties</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_departments">Departments </a></li>
                            <li class="nav-item"><a class="nav-link" href="report_courses">Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_modules">Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_admins">Administrators</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_lecs">Lecturers</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_students">Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_teaching_allocations">Teaching Allocations</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_course_enrollments">Enrollments</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_timetable">Time Table</a></li>
                            <li class="nav-item"><a class="nav-link" href="report_student_grades">Student Grades</a></li>
                        </ul>
                    </div>
                    <div id="SystemSettings" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">System Settings</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="settings_academic">Academic Settings</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings_plugins">System Plugins</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings_customization">Customization</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings_mailing">Mail Settings</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings_database_backup">Backup Engine</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings_system_logs">Logs</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings_api">API's</a></li>
                        </ul>
                    </div>
                </div>
                <!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>
    <?php } else if ($access_level == 'educational_admin') { ?>
        <div class="leftbar-tab-menu">
            <div class="main-icon-menu slimscroll-menu">
                <a href="edu_dashboard" class="logo logo-metrica d-block text-center">
                    <span>
                        <img src="<?php echo $system_logo_url; ?>" alt="logo-small" class="logo-sm">
                    </span>
                </a>
                <nav class="nav">
                    <a href="#Dashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Dashboard">
                        <i data-feather="home" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaDashboards-->

                    <a href="#Faculties" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Faculties">
                        <i data-feather="briefcase" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaApps-->

                    <a href="#Departments" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Departments">
                        <i data-feather="airplay" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaUikit-->

                    <a href="#Courses" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Courses">
                        <i data-feather="archive" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaPages-->

                    <a href="#Modules" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Modules">
                        <i data-feather="book" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaAuthentication-->
                    <a href="#TeachingStaff" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Lecturers">
                        <i data-feather="user-check" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaAuthentication-->
                    <a href="#Students" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Students">
                        <i data-feather="users" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <a href="#Reports" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Reports">
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
                            <li class="nav-item"><a class="nav-link" href="edu_dashboard">Dashboard </a></li>
                        </ul>
                    </div>
                    <div id="Faculties" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Faculties</h6>
                        </div>
                        <ul class="nav metismenu">
                            <!--end nav-item-->
                            <li class="nav-item"><a class="nav-link" href="edu_faculty_academic_calendar">Academic Calendar</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_faculty_add">Add Faculty</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_facuty_allocate_admin">Allocate Head</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_faculty_school_calendar">School Calendar</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_faculty_manage">Manage Faculties</a></li>
                        </ul>
                    </div><!-- end Crypto -->

                    <div id="Departments" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Departments</h6>
                        </div>
                        <ul class="nav metismenu">
                            <!--end nav-item-->
                            <li class="nav-item"><a class="nav-link" href="edu_dept_add">Add Department</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_dept_memos">Dept. Memos </a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_dept_notices">Dept. Notices </a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_dept_documents">Dept. Documents </a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_dept_manage">Manage Depts.</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_dept_search">Search</a></li>
                        </ul>
                        <!--end nav-->
                    </div><!-- end Others -->

                    <div id="Courses" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Courses</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="edu_course_add">Add Course</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_memos">Course Memos</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_modules">Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_module_allocations">Module Allocations</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_time_table">Time Table</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_enrolled_students">Enrolled Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_manage">Manage Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_course_search">Advanced Search</a></li>
                        </ul>
                    </div><!-- end Pages -->
                    <div id="Modules" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Modules</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="edu_module_add">Add Module</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_module_enrollments">Enrollments</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_module_grades">Grades</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_module_manage">Manage Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_module_search">Advanced Search</a></li>

                        </ul>
                    </div>
                    <div id="TeachingStaff" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Teaching Staff</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="edu_staff_add">Add</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_staff_allocate_module">Allocate Module</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_staff_manage">Manage</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_staff_search">Advanced Search</a></li>
                        </ul>
                    </div>
                    <div id="Students" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Students</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="edu_student_add">Add Student</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_student_enroll">Enroll </a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_student_grades">Grades</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_student_manage">Manage Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_student_search">Advanced Search</a></li>
                        </ul>
                    </div>
                    <div id="Reports" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Reports</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="edu_report_faculties">Faculties</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_departments">Departments </a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_courses">Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_modules">Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_lecs">Lecturers</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_students">Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_teaching_allocations">Teaching Allocations</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_course_enrollments">Enrollments</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_timetable">Time Table</a></li>
                            <li class="nav-item"><a class="nav-link" href="edu_report_student_grades">Student Grades</a></li>
                        </ul>
                    </div>
                </div>
                <!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>
    <?php } else if ($access_level == 'lecturer') { ?>
        <div class="leftbar-tab-menu">
            <div class="main-icon-menu slimscroll-menu">
                <a href="lec_dashboard" class="logo logo-metrica d-block text-center">
                    <span>
                        <img src="<?php echo $system_logo_url; ?>" alt="logo-small" class="logo-sm">
                    </span>
                </a>
                <nav class="nav">
                    <a href="#Dashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Dashboard">
                        <i data-feather="home" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <a href="#Calendar" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Academic Calendar">
                        <i data-feather="calendar" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaDashboards-->
                    <a href="#Modules" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Modules">
                        <i data-feather="book" class="align-self-center menu-icon icon-dual"></i>
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
                            <li class="nav-item"><a class="nav-link" href="lec_dashboard">Home</a></li>
                        </ul>
                    </div>
                    <div id="Calendar" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Academic Calendar</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="lec_academic_calendar">Important Dates</a></li>
                        </ul>
                    </div>
                    <div id="Modules" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Allocated Modules</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="lec_allocated_modules">Modules List</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_notices">Notices</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_reading_materials">Reading Materials</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_class_recording">Class Recordings</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_assignments">Assignments</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_pastpapers">Past Papers</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_enrollments">Enrollments</a></li>
                            <li class="nav-item"><a class="nav-link" href="lec_module_grades">Grades</a></li>
                        </ul>
                    </div>
                </div>
                <!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>
    <?php } else { ?>
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

                    <a href="#modules" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Enrolled Modules">
                        <i data-feather="book" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaPages-->

                    <a href="#requisitions" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Requisitions">
                        <i data-feather="user-check" class="align-self-center menu-icon icon-dual"></i>
                    </a>
                    <!--end MetricaAuthentication-->
                    <a href="#perfomances" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="Perfomances">
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

                    <div id="modules" class="main-icon-menu-pane">
                        <div class="title-box">
                            <h6 class="menu-title">Enrolled Modules</h6>
                        </div>
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="my_previous_enrollments">Previous Enrl Modules</a></li>
                            <li class="nav-item"><a class="nav-link" href="my_current_enrollments">Currently Enrl Modules</a></li>
                        </ul>
                    </div><!-- end Pages -->
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
                </div>
                <!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>
<?php }
} ?>