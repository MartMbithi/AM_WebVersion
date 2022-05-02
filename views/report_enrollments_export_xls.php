<?php
/*
 * Created on Wed Jan 26 2022
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

session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();
require_once('../config/codeGen.php');

/* Wrap This Codebase Under System Settings And Academic Calendar Details */

$session = $_GET['session'];
$ret = "SELECT * FROM `system_settings` JOIN 
academic_calendar WHERE calendar_id = '$session' ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {


    /* Filter Excel Data */
    function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    /* Excel File Name */
    $fileName = $sys->system_name . "  " . $sys->calendar_year . ' ' . $sys->calendar_semester . " Student Module Enrollments Reports.xls";

    /* Excel Column Name */
    $header = array($sys->system_name . ' ' . $sys->calendar_year  . ' ' . $sys->calendar_semester . ' Student Module Enrollments');
    $fields = array('Module Details', 'Enrolled Student Details');


    /* Implode Excel Data */
    $excelDataHeader = implode("\t\t\t", array_values($header)) . "\n\n";
    $excelData = implode("\t", array_values($fields)) . "\n";

    /* Fetch All Records From The Database */
    $query = $mysqli->query("SELECT * FROM enrollments e 
    INNER JOIN modules m ON m.module_id = e.enrollment_module_id
    INNER JOIN users s ON s.user_id = e.enrollment_user_id
    INNER JOIN academic_calendar ac ON ac.calendar_id = e.enrollment_academic_calendar_id
    WHERE e.enrollment_academic_calendar_id  = '$session'");
    if ($query->num_rows > 0) {
        /* Load All Fetched Rows */
        while ($row = $query->fetch_assoc()) {
            $lineData = array($row['module_code'] . ' ' . $row['module_name'], $row['user_number'] . ' ' . $row['user_name']);
            array_walk($lineData, 'filterData');
            $excelData .= implode("\t", array_values($lineData)) . "\n";
        }
    } else {
        $excelData .= 'No Module Enrollments Records Available...' . "\n";
    }

    /* Generate Header File Encordings For Download */
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");

    /* Render  Excel Data For Download */
    echo $excelDataHeader;
    echo $excelData;

    exit;
}
