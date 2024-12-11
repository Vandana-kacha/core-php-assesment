<?php

// Start session
session_start();

// Include and initialize DB class
require_once 'json_class.php';
$db = new Json();

// Set default redirect url
$redirectURL = 'index.php';

if(isset($_POST['userSubmit'])) {
    // Get form fields value 
    $id = $_POST['id'];
    $category = trim(strip_tags($_POST['category']));
    $book_id = trim(strip_tags($_POST['book_id']));
    $book_name = trim(strip_tags($_POST['book_name']));
    $author = trim(strip_tags($_POST['author']));
    $qty = trim(strip_tags($_POST['qty']));
    $price = trim(strip_tags($_POST['price']));
    
    $id_str = ''; 
    if(!empty($id)){ 
        $id_str = '?id='.$id; 
    } 
    
    // Fields validation 
    $errorMsg = ''; 
    if(empty($category)) { 
        $errorMsg .= '<p>Please select your category.</p>'; 
    }
    if(empty($book_name)) { 
        $errorMsg .= '<p>Please enter book name</p>'; 
    } 
    if(empty($author)) { 
        $errorMsg .= '<p>Please enter author</p>'; 
    } 
    
    // Submitted form data 
    $userData = array( 
        'category' => $category, 
        'book_id' => $book_id, 
        'book_name' => $book_name, 
        'author' => $author,
        'qty' => $qty,
        'price' => $price 
    );
    
    // Store the submitted field value in the session 
    $sessData['userData'] = $userData; 
    
    // Submit the form data 
    if(empty($errorMsg)) { 
        if(!empty($_POST['id'])) { 
            // Update user data 
            $update = $db->update($userData, $_POST['id']); 
             
            if($update) { 
                $sessData['isLogged'] = '1';
                $sessData['status']['type'] = 'success'; 
                $sessData['status']['msg'] = 'Book details has been updated successfully.'; 
                
                // Remove submitted fields value from session 
                unset($sessData['userData']); 
            } else { 
                $sessData['isLogged'] = '1';
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                
                // Set redirect url 
                $redirectURL = 'addedit.php'.$id_str; 
            } 
        } else { 
            // Insert user data 
            $insert = $db->insert($userData); 
            
            if($insert) { 
                $sessData['isLogged'] = '1';
                $sessData['status']['type'] = 'success'; 
                $sessData['status']['msg'] = 'Book details has been added successfully.'; 
                
                // Remove submitted fields value from session 
                unset($sessData['userData']); 
            } else { 
                $sessData['isLogged'] = '1';
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                
                // Set redirect url 
                $redirectURL = 'addedit.php'.$id_str; 
            } 
        } 
    } else { 
        $sessData['isLogged'] = '1';
        $sessData['status']['type'] = 'error'; 
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg; 
        
        // Set redirect url 
        $redirectURL = 'addedit.php'.$id_str; 
    } 
    
    // Store status into the session 
    $_SESSION['sessData'] = $sessData; 
} elseif(isset($_REQUEST['action_type']) && ($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])) { 
    // Delete data 
    $delete = $db->delete($_GET['id']); 
    
    if ($delete) {
        $sessData['isLogged'] = '1';
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Book has been deleted successfully.';
    } else { 
        $sessData['isLogged'] = '1';
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Some problem occurred, please try again.';
    }
    
    // Store status into the session 
    $_SESSION['sessData'] = $sessData; 
} else if (isset($_GET["changepassword"]) && $_GET["changepassword"] == "1") {

    $oldpass = $_POST['old_pass'];
    $newpass = $_POST['new_pass'];

    $change_pass = $db->changePassword($oldpass, $newpass);
    if ($change_pass) {
        $sessData['isLogged'] = '1';
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Password changed successfully.';
    } else {
        $sessData['isLogged'] = '1';
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Old password is not matched with new password';

        $redirectURL = 'change_password.php';
    }
    // Store status into the session
    $_SESSION['sessData'] = $sessData;
} else if (isset($_GET["mode"]) && $_GET["mode"] == "user") {
    
    if (empty($_POST["password"])) {
        $sessData['isLogged'] = '0';
        $sessData['status']['type'] = 'empty';
        $sessData['status']['msg'] = 'Please enter password.';
    } else {
        $login = $db->getUser($_POST["password"]);
        if ($login) {
            $sessData['isLogged'] = '1';
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Login successfully.';
        } else {
            $sessData['isLogged'] = '0';
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Password is wrong.';
        }
    }
    // Store status into the session
    $_SESSION['sessData'] = $sessData;
} else if (isset($_GET['search']) && $_GET['search'] == '1') {
   
    $result = $db->getResult($_POST['search']);

    $sessData['search'] = $_POST['search'];
    $sessData['userData'] = $result;
    $sessData['isLogged'] = '1';

    // Store status into the session
    $_SESSION['sessData'] = $sessData;
}

// Redirect to the respective page
header("Location:".$redirectURL);
exit();

?>
