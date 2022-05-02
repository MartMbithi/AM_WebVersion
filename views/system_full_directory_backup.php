<?php
/*
 * Created on Thu Jan 27 2022
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

/* Base Directory */
$pathBase = '../public/uploads/';  // Relate Path

// ZIP FILE NAMING ... This currently is equal to = sitename_www_YYYY_MM_DD_backup.zip 
$zipPREFIX = "Full_System_Backup";
$zipDATING = '_' . date('Y_m_d') . '_';
$zipPOSTFIX = "backup";
$zipEXTENSION = ".zip";

// SHOW PHP ERRORS... REMOVE/CHANGE FOR LIVE USE
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);




// ############################################################################################################################
//                                  NO CHANGES NEEDED FROM THIS POINT
// ############################################################################################################################

// SOME BASE VARIABLES WE MIGHT NEED
$iBaseLen = strlen($pathBase);
$iPreLen = strlen($zipPREFIX);
$iPostLen = strlen($zipPOSTFIX);
$sFileZip = $pathBase . $zipPREFIX . $zipDATING . $zipPOSTFIX . $zipEXTENSION;
$oFiles = array();
$oFiles_Error = array();
$oFiles_Previous = array();


/* Check If Theres An Existing Backup */
if (file_exists($sFileZip)) {
    // IF BACKUP EXISTS... SHOW MESSAGE AND THATS IT
    echo "<h3 style='margin-bottom:0px;'>Backup Already Exists</h3><div style='width:800px; border:1px solid #000;'>";
    echo '<b>File Name: </b>', $sFileZip, '<br />';
    echo '<b>File Size: </b>', $sFileZip, '<br />';
    echo "</div>";
    exit; // No point loading our function below ;)
} else {

    // NO BACKUP FOR TODAY.. SO START IT AND SHOW SCRIPT SETTINGS
    echo "<h3 style='margin-bottom:0px;'>Script Settings</h3><div style='width:800px; border:1px solid #000;'>";
    echo '<b>Backup Directory: </b>', $pathBase, '<br /> ';
    echo '<b>Backup Save File: </b>', $sFileZip, '<br />';
    echo "</div>";

    // CREATE ZIPPER AND LOOP DIRECTORY FOR SUB STUFF
    $oZip = new ZipArchive;
    $oZip->open($sFileZip,  ZipArchive::CREATE | ZipArchive::OVERWRITE);
    $oFilesWrk = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($pathBase), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($oFilesWrk as $oKey => $eFileWrk) {
        // VARIOUS NAMING FORMATS OF THE CURRENT FILE / DIRECTORY.. RELATE & ABSOLUTE
        $sFilePath = substr($eFileWrk->getPathname(), $iBaseLen, strlen($eFileWrk->getPathname()) - $iBaseLen);
        $sFileReal = $eFileWrk->getRealPath();
        $sFile = $eFileWrk->getBasename();

        // WINDOWS CORRECT SLASHES
        $sMyFP = str_replace('\\', '/', $sFileReal);

        if (file_exists($sMyFP)) {  // CHECK IF THE FILE WE ARE LOOPING EXISTS
            if ($sFile != "."  && $sFile != "..") { // MAKE SURE NOT DIRECTORY / . || ..
                // CHECK IF FILE HAS BACKUP NAME PREFIX/POSTFIX... If So, Dont Add It,, List It
                if (substr($sFile, 0, $iPreLen) != $zipPREFIX && substr($sFile, -1, $iPostLen + 4) != $zipPOSTFIX . $zipEXTENSION) {
                    $oFiles[] = $sMyFP;                     // LIST FILE AS DONE
                    $oZip->addFile($sMyFP, $sFilePath);     // APPEND TO THE ZIP FILE
                } else {
                    $oFiles_Previous[] = $sMyFP;            // LIST PREVIOUS BACKUP
                }
            }
        } else {
            $oFiles_Error[] = $sMyFP;                       // LIST FILE THAT DOES NOT EXIST
        }
    }
    $sZipStatus = $oZip->getStatusString();                 // GET ZIP STATUS
    $oZip->close(); // WARNING: Close Required to append files, dont delete any files before this.

    // SHOW BACKUP STATUS / FILE INFO
    echo "<h3 style='margin-bottom:0px;'>Backup Status </h3><div style='width:800px; height:120px; border:1px solid #000;'>";
    echo "<b>Zipper Status: </b>" . $sZipStatus . "<br />";
    echo "<b>Finished Zip Script: </b>", $sFileZip, "<br />";
    echo "<b>Zip Size: </b>", human_filesize($sFileZip), "<br />";
    echo "</div>";


    // SHOW ANY PREVIOUS BACKUP FILES
    echo "<h3 style='margin-bottom:0px;'>Previous Backups Count(" . count($oFiles_Previous) . ")</h3><div style='overflow:auto; width:800px; height:120px; border:1px solid #000;'>";
    foreach ($oFiles_Previous as $eFile) {
        echo basename($eFile) . ", Size: " . human_filesize($eFile) . "<br />";
    }
    echo "</div>";

    // SHOW ANY FILES THAT DID NOT EXIST??
    if (count($oFiles_Error) > 0) {
        echo "<h3 style='margin-bottom:0px;'>Error Files, Count(" . count($oFiles_Error) . ")</h3><div style='overflow:auto; width:800px; height:120px; border:1px solid #000;'>";
        foreach ($oFiles_Error as $eFile) {
            echo $eFile . "<br />";
        }
        echo "</div>";
    }

    // SHOW ANY FILES THAT HAVE BEEN ADDED TO THE ZIP
    echo "<h3 style='margin-bottom:0px;'>Added Files, Count(" . count($oFiles) . ")</h3><div style='overflow:auto; width:800px; height:120px; border:1px solid #000;'>";
    foreach ($oFiles as $eFile) {
        echo $eFile . "<br />";
    }
    echo "</div>";
}


// CONVERT FILENAME INTO A FILESIZE AS Bytes/Kilobytes/Megabytes,Giga,Tera,Peta
function human_filesize($sFile, $decimals = 2)
{
    $bytes = filesize($sFile);
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
