<?php

// Start session
session_start();

// Retrieve session data
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get book data
$bookData = $userData = array();

if(!empty($_GET['id'])) {
    include 'json_class.php';
    $db = new Json();
    $bookData = $db->getSingle($_GET['id']);
}

$userData = !empty($sessData['userData']) ? $sessData['userData'] : $bookData;
unset($_SESSION['sessData']['userData']);

$actionLabel = !empty($_GET['id'])? 'Edit' : 'Add';

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
    <title><?php echo $actionLabel;?> Book details</title>
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-1">&nbsp;</div>
                <div class="col-lg-10 mb-1">    
                    <div class="card overflow-hidden mt-2 row pt-2 pb-3">

                        <!-- Display status message -->
                        <?php if(!empty($statusMsg) && ($statusMsgType == 'success')) { ?>

                        <div class="col-xs-12">
                            <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                        </div>

                        <?php } elseif(!empty($statusMsg) && ($statusMsgType == 'error')) { ?>

                        <div class="col-xs-12">
                            <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                        </div>

                        <?php } ?>

                        <div class="row col-md-12">

                            <div class="col-lg-8 col-md-8 float-left">
                                <h2><?php echo $actionLabel; ?> Book</h2>
                            </div>

                            <div class="col-lg-4 col-md-4 float-right text-right">
                                <a href="index.php" class="btn btn-secondary">Back</a>
                            </div>

                        </div>
                        
                        <div class="col-md-12">
                            <form method="post" action="task.php">
                                <div class="form-group">
                                    <label>Select Categories</label>
                                    <select name="category" id="category" class="form-control" required="">
                                        <option value="Computer" <?php if (isset($userData['category'])) { echo $userData['category'] == "Computer" ? "selected=selected" : "";} ?>>Computer</option>
                                        <option value="Electronics" <?php if (isset($userData['category'])) { echo $userData['category'] == "Electronics" ? "selected=selected" : ""; } ?>>Electronics</option>
                                        <option value="Electrical" <?php if (isset($userData['category'])) { echo $userData['category'] == "Electrical" ? "selected=selected" : ""; } ?>>Electrical</option>
                                        <option value="Civil" <?php if (isset($userData['category'])) { echo $userData['category'] == "Civil" ? "selected=selected" : ""; } ?>>Civil</option>
                                        <option value="Mechanical" <?php if (isset($userData['category'])) { echo $userData['category'] == "Mechanical" ? "selected=selected" : ""; } ?>>Mechanical</option>
                                        <option value="Architecture" <?php if (isset($userData['category'])) { echo $userData['category'] == "Architecture" ? "selected=selected" : ""; } ?>>Architecture</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Book id</label>
                                    <input type="text" class="form-control" name="book_id" placeholder="Enter Book id" value="<?php echo !empty($userData['book_id'])?$userData['book_id']:''; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Book name</label>
                                    <input type="text" class="form-control" name="book_name" placeholder="Enter Book name" value="<?php echo !empty($userData['book_name'])?$userData['book_name']:''; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Author</label>
                                    <input type="text" class="form-control" name="author" placeholder="Enter Author" value="<?php echo !empty($userData['author'])?$userData['author']:''; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" name="qty" placeholder="Enter quantity" value="<?php echo !empty($userData['qty'])?$userData['qty']:''; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price" placeholder="Enter price" value="<?php echo !empty($userData['price'])?$userData['price']:''; ?>">
                                </div>
                                
                                <input type="hidden" name="id" value="<?php echo !empty($bookData['id']) ? $bookData['id'] : '' ; ?>">
                                <input type="submit" name="userSubmit" class="btn btn-success" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-lg-1">&nbsp;</div>
            
        </div>
    </div>
</body>
</html>
