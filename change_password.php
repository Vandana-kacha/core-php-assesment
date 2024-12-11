<?php

// Start session
session_start();

// Retrieve session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Include and initialize JSON class
require_once 'json_class.php';
$db = new Json();

// Get status message from session 
if(!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-1">&nbsp;</div>
            <div class="col-lg-10 mb-5">
                <div class="card overflow-hidden pt-2 mt-5 mb-5 row">
                    
                    <!-- Display status message -->
                    <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>

                    <div class="col-md-12">
                        <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                    </div>

                    <?php } elseif(!empty($statusMsg) && ($statusMsgType == 'error')) { ?>

                    <div class="col-md-12">
                        <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                    </div>

                    <?php } ?>

                    <div class="row col-md-12">

                        <div class="col-lg-8 col-md-8 float-left">
                            <h2>Change Password</h2>
                        </div>

                        <div class="col-lg-4 col-md-4 float-right text-right">
                            <a href="index.php" class="btn btn-secondary">Back</a>
                        </div>

                    </div>

                    <div class="col-md-12 pt-2 pb-2">
                        <form method="post" action="task.php?changepassword=1">

                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" name="old_pass" value="" required="">
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_pass" value="" required="">
                            </div>
                            
                            <input type="submit" name="changepass" class="btn btn-success" value="Change">
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">&nbsp;</div>

        </div>
    </div>
</body>
</html>
