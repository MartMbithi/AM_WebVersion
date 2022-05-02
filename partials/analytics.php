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

$user_id = $_SESSION['user_id'];
$user_access_level = $_SESSION['user_access_level'];
$current_academic_year  = $_SESSION['current_calendar'];

if ($user_access_level == 'lecturer') {
    /* Load Lec Analytics */

    /*Currently Allocated This Semester */
    $query = "SELECT COUNT(*)  FROM module_allocations ma
    INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
    WHERE ma.allocation_user_id = '$user_id' AND ac.calendar_status = 'Current' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($current_allocations);
    $stmt->fetch();
    $stmt->close();

    /*Enrolled Students To My Modules  */
    $query = "SELECT COUNT(*)  FROM enrollments e 
    INNER JOIN  academic_calendar ac ON ac.calendar_id  = e.enrollment_academic_calendar_id
    INNER JOIN modules m ON m.module_id = e.enrollment_module_id 
    INNER JOIN module_allocations ma ON ma.allocation_module_id = m.module_id
    WHERE ac.calendar_status = 'Current' AND ma.allocation_user_id = '$user_id' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($enrolled_students);
    $stmt->fetch();
    $stmt->close();
} else if ($user_access_level == 'student') {
    /* Load Student Analytics` */

    /* 1. Currently Enrolled Modules */
    $query = "SELECT COUNT(*)  FROM enrollments e 
    INNER JOIN academic_calendar ac ON ac.calendar_id = e.enrollment_academic_calendar_id
    WHERE calendar_status = 'Current' AND enrollment_user_id  = '$user_id'";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($currently_enrolled_modules);
    $stmt->fetch();
    $stmt->close();

    /* 2. Overall Attempted Modules */
    $query = "SELECT COUNT(*)  FROM enrollments e 
    INNER JOIN academic_calendar ac ON ac.calendar_id = e.enrollment_academic_calendar_id
    WHERE calendar_status != 'Current' AND enrollment_user_id  = '$user_id'";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($past_enrolled_modules);
    $stmt->fetch();
    $stmt->close();
} else {
    /* Load Everyone Analytics */

    /* Faculties */
    $query = "SELECT COUNT(*)  FROM `faculties` ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($faculties);
    $stmt->fetch();
    $stmt->close();

    /* Departments  */
    $query = "SELECT COUNT(*)  FROM `departments` ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($departments);
    $stmt->fetch();
    $stmt->close();

    /* Courses */
    $query = "SELECT COUNT(*)  FROM `courses` ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($courses);
    $stmt->fetch();
    $stmt->close();


    /* Modules */
    $query = "SELECT COUNT(*)  FROM `modules` ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($modules);
    $stmt->fetch();
    $stmt->close();

    /* System Admins */
    $query = "SELECT COUNT(*)  FROM `users` WHERE user_access_level = 'educational_admin'  || user_access_level ='sys_admin' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($admins);
    $stmt->fetch();
    $stmt->close();

    /* Lecs  */
    $query = "SELECT COUNT(*)  FROM `users` WHERE user_access_level = 'lecturer' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($lecs);
    $stmt->fetch();
    $stmt->close();

    /*  Students */
    $query = "SELECT COUNT(*)  FROM `users` WHERE user_access_level = 'student' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($students);
    $stmt->fetch();
    $stmt->close();
}
