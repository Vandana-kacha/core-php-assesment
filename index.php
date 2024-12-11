<?php

// Start session 
session_start();

// Retrieve session data 
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Include and initialize JSON class
require_once 'json_class.php';
$db = new Json();

// Fetch the book's data
if(!empty($_SESSION['sessData']['userData'])) {
    $books = $db->getResult($_SESSION['sessData']['search']);
} else {
    $books = $db->getRows();
}

// Get status message from session
if(!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
} else {
    unset($_SESSION['sessData']['userData']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
    <style type="text/css">
        .error {
            color:red;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mt-3">

                <?php
                if (isset($sessData['isLogged']) && $sessData['isLogged'] == "1") {
                ?>
                <div class="card overflow-hidden">
                    <div class="row mt-3">

                        <div class="col-lg-1">&nbsp;</div>
                            <div class="col-lg-10 mb-5">

                                <!-- Display status message -->
                                <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>

                                <div class="col-xs-12">
                                    <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                                </div>

                                <?php } elseif(!empty($statusMsg) && ($statusMsgType == 'error')) { ?>

                                <div class="col-xs-12">
                                    <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                                </div>

                                <?php } ?>

                                <div class="head">
                                    <h3 class="text-left">Books</h3>

                                    <div class="float-right pt-1 text-right">
                                        <form method="post" name="search" action="task.php?search=1" class="text-right">
                                            <input type="text" name="search" id="search" title="Type word and enter" />
                                            <input type="hidden" name="submit" value="Search" />
                                        </form>
                                    </div>

                                    <div class="float-left mb-2 text-left mr-2">
                                        <a href="addedit.php" class="btn btn-success"> + Add Books </a>
                                    </div>

                                    <div class="float-left mb-2 text-left">
                                        <a href="change_password.php" class="btn btn-success"> Change Password </a>
                                    </div>

                                    <div class="float-left mb-2 text-left ml-2">
                                        <a href="index.php" class="btn btn-info text-white"> Refresh </a>
                                    </div>

                                    <div class="float-left mb-2 text-left ml-2">
                                        <a href="singout.php" class="btn btn-danger text-white" onclick="return confirm('You will be logged out. Are you sure to signout ?');"> Signout </a>
                                    </div>

                                </div>
                
                                <!-- List the users -->
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Book id</th>
                                            <th class="text-center">Book name</th>
                                            <th class="text-center">Author</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!empty($books))
                                        { 
                                            $count = 0;
                                            foreach($books as $row)
                                            {
                                                $count++;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td class="text-center"><?php echo $row['category']; ?></td>
                                                <td class="text-center"><?php echo $row['book_id']; ?></td>
                                                <td class="text-center"><?php echo $row['book_name']; ?></td>
                                                <td class="text-center"><?php echo $row['author']; ?></td>
                                                <td class="text-center"><?php echo $row['qty']; ?></td>
                                                <td class="text-center"><?php echo $row['price']; ?></td>
                                                <td class="text-center">
                                                    <a href="addedit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a> | 
                                                    <a href="task.php?action_type=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger text-white" onclick="return confirm('Are you sure to delete?');">Delete</a>
                                                </td>
                                            </tr>
                                            <?php 
                                            } 
                                        } else { 
                                        ?>
                                        <tr><td colspan="8" style="text-align:center;">No book(s) found...</td></tr>
                                        <?php 
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>          
                        <div class="col-lg-1">&nbsp;</div>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <div class="row mt-5">
                    <div class="col-lg-3">&nbsp;</div>
                        <div class="col-lg-6 card overflow-hidden">
                            <div class="col-lg-4 mb-5">
                                <div class="media align-items-stretch pt-5">

                                    <form method="post" name="user" id="user" action="task.php?mode=user">
                                        <p>Please enter password</p>
                                        <input type="password" name="password" id="password" class="form-control"> <br>
                                        <?php
                                        if (isset($statusMsgType) && $statusMsgType == 'empty') {
                                            echo '<span class="error">Please enter password</span> <br> <br>';
                                        } else if (isset($statusMsgType) && $statusMsgType == 'error') {
                                            echo '<span class="error">Password entered is wrong</span> <br> <br>';
                                        }
                                        ?>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-submit btn-primary">
                                    </form>

                                </div>
                            </div>
                        </div>                
                    <div class="col-lg-3">&nbsp;</div>
                </div>
                <?php
                }
                ?>

            </div>
        </div>

    </div>
</body>
</html>
