<?php
/*
 * Created on Fri Jan 21 2022
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


/* Bulk Import Courses */
require_once('../config/DataSource.php');
/* Load Composer Autoload */
require_once('../vendor/autoload.php');

use Devlan\DataSource;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["upload"])) {

    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    /* Where Magic Happens */
    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        $targetPath = '../public/uploads/sys_data/' . 'Admin_Bulk Upload_' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);


        for ($i = 1; $i <= $sheetCount; $i++) {

            $user_number  = "";
            if (isset($spreadSheetAry[$i][0])) {
                $user_number  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
            }

            $user_name  = "";
            if (isset($spreadSheetAry[$i][1])) {
                $user_name  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
            }

            $user_email   = "";
            if (isset($spreadSheetAry[$i][2])) {
                $user_email   = mysqli_real_escape_string($conn, $spreadSheetAry[$i][2]);
            }

            $user_phone   = "";
            if (isset($spreadSheetAry[$i][3])) {
                $user_phone   = mysqli_real_escape_string($conn, $spreadSheetAry[$i][3]);
            }

            $user_adr   = "";
            if (isset($spreadSheetAry[$i][4])) {
                $user_adr   = mysqli_real_escape_string($conn, $spreadSheetAry[$i][4]);
            }

            /* User Access Level To Educational Admin */
            $user_access_level  = 'educational_admin';

            include('../config/codeGen.php');
            /* User Password Reset Token */
            $password_reset_token = $tk;
            $activate_url = $account_password_set . $password_reset_token;

            /* Log Attributes */
            $log_ip = $_SERVER['REMOTE_ADDR'];
            $log_type = 'Bulk Imported ' . $user_name . ' ' . $user_name . ' Details';
            $log_user_id = $_SESSION['user_id'];

            /* Prevent Double Entries */
            $sql = "SELECT * FROM users  WHERE user_email ='$user_email'  ";
            $res = mysqli_query($mysqli, $sql);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                if (
                    $user_email == $row['user_email']  ||
                    $user_number == $row['user_number']
                ) {
                    $err = 'User With This Email : ' . $user_email . ' Or This  ' . $user_number . 'Already Exists';
                }
            } else {
                /* Persist Bulk Imports If No Duplicates */
                if (!empty($user_number) || !empty($user_name)) {
                    $query = "INSERT INTO  users (user_number, user_name, user_email, user_phone, user_access_level, user_adr, password_reset_token)
                    VALUES(?,?,?,?,?,?,?)";
                    $log = "INSERT INTO logs (log_ip, log_user_id,  log_type) VALUES(?,?,?)";
                    $log_prepare = $mysqli->prepare($log);
                    $log_bind = $log_prepare->bind_param(
                        'sss',
                        $log_ip,
                        $log_user_id,
                        $log_type
                    );
                    $log_prepare->execute();
                    $paramType = "sssssss";
                    $paramArray = array(
                        $user_number,
                        $user_name,
                        $user_email,
                        $user_phone,
                        $user_access_level,
                        $user_adr,
                        $password_reset_token
                    );
                    $insertId = $db->insert($query, $paramType, $paramArray);
                    /* Load Mailer */
                    include('../mailers/new_user_account_mailer.php');
                    if (!empty($insertId) && $log_prepare && $mail->send() && unlink($targetPath)) {
                        $success = "Admins Data Is Imported ";
                    } else {
                        $err = "Error Occured While Importing Data $mail->ErrorInfo";
                    }
                }
            }
        }
    } else {
        $info = "Invalid File Type. Upload Excel File.";
    }
}
