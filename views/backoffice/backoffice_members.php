<?php
/*
 * Created on Wed May 11 2022
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
require_once('../../config/config.php');
require_once('../../config/checklogin.php');
admin_check_login();
/* Update User Account */
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_gender = $_POST['user_gender'];
    $user_address = $_POST['user_address'];
    $user_age = $_POST['user_age'];

    /* Update */
    $sql = "UPDATE users SET user_name  = '{$user_name}', user_email = '{$user_email}', user_gender = '{$user_gender}',
    user_address = '{$user_address}', user_age = '{$user_age}' WHERE user_id = '{$user_id}'";
    $prepare = $mysqli->prepare($sql);
    $prepare->execute();
    if ($prepare) {
        $success = "Member Account Details Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}


/* Delete Account */
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    /* Persist */
    $sql = "DELETE FROM users WHERE user_id = '{$user_id}'";
    $prepare = $mysqli->prepare($sql);
    $prepare->execute();
    if ($prepare) {
        $success = "Member Account Deleted";
    } else {
        $err = "Failed! Please Try Again";
    }
}
require_once('../../partials/backoffice_head.php');
?>

<body class="nk-body npc-invest bg-lighter ">
    <div class="nk-app-root">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php require_once('../../partials/backoffice_header.php'); ?>
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content nk-content-lg nk-content-fluid">
                <div class="container-xl wide-lg">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h2 class="nk-block-title fw-normal">Asian Melodies Members</h2>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <table class="datatable-init table">
                                            <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Gender</th>
                                                    <th>Age</th>
                                                    <th>Address</th>
                                                    <th>Account Status</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM users";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($users = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $users->user_name; ?></td>
                                                        <td><?php echo $users->user_email; ?></td>
                                                        <td><?php echo $users->user_gender; ?></td>
                                                        <td><?php echo $users->user_age; ?> Years</td>
                                                        <td><?php echo $users->user_address; ?></td>
                                                        <td><?php echo $users->user_account_status; ?></td>
                                                        <td>
                                                            <a data-toggle="modal" href="#update_<?php echo $users->user_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $users->user_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                        </td>
                                                        <!-- Update Modal -->
                                                        <div class="modal fade fixed-right" id="update_<?php echo $users->user_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog  modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header align-items-center">
                                                                        <div class="modal-title">
                                                                            <h6 class="mb-0">Update <?php echo $users->user_name; ?></h6>
                                                                        </div>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" enctype="multipart/form-data" role="form">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="">Name</label>
                                                                                    <input type="text" required name="user_name" value="<?php echo $users->user_name; ?>" class="form-control" id="exampleInputEmail1">
                                                                                    <input type="hidden" required name="user_id" value="<?php echo $users->user_id; ?>" class="form-control" id="exampleInputEmail1">
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="">Email</label>
                                                                                    <input type="email" value="<?php echo $users->user_email; ?>" required name="user_email" class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="">Gender</label>
                                                                                    <select type="text" value="<?php echo $users->user_gender; ?>" required name="user_gender" class="form-control">
                                                                                        <option><?php echo $users->user_gender; ?></option>
                                                                                        <option>Male</option>
                                                                                        <option>Female</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="">Age</label>
                                                                                    <input type="text" value="<?php echo $users->user_age; ?>" required name="user_age" class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="">Address</label>
                                                                                    <input type="text" value="<?php echo $users->user_address; ?>" required name="user_address" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-right">
                                                                                <button type="submit" name="update_user" class="btn btn-primary">Update Personal Details</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->

                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete_<?php echo $users->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM DELETE</h5>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form method="POST">
                                                                        <div class="modal-body text-center text-danger">
                                                                            <h4>Delete : <?php echo $users->user_name; ?> Account </h4>
                                                                            <br>
                                                                            <!-- Hide This -->
                                                                            <input type="hidden" name="user_id" value="<?php echo $users->user_id; ?>">
                                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                            <input type="submit" name="delete_user" value="Delete" class="text-center btn btn-danger">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        </table>

                                    </div><!-- .nk-block -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                    <!-- footer @s -->
                    <?php require_once('../../partials/backoffice_footer.php'); ?>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- app-root @e -->
            <!-- JavaScript -->
            <?php require_once('../../partials/backoffice_scripts.php'); ?>
</body>

</html>