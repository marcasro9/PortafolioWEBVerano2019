<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $name = $last_name = $last_name2 = $number = $date = "";
$username_err = $password_err = $confirm_password_err = $email_err = $name_err = $last_name_err = $last_name2_err = $number_err = $date_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }

    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";     
    } else{
        $name = trim($_POST["name"]);
    }

    // Validate lastname
    if(empty(trim($_POST["lastname"]))){
        $last_name_err = "Please enter a LastName.";     
    } else{
        $last_name = trim($_POST["lastname"]);
    }

    // Validate lastname2
    if(empty(trim($_POST["lastname2"]))){
        $last_name2_err = "Please enter a LastName.";     
    } else{
        $last_name2 = trim($_POST["lastname2"]);
    }

    // Validate number
    if(empty(trim($_POST["number"]))){
        $number_err = "Please enter a Number.";     
    } else{
        $number = trim($_POST["number"]);
    }

    // Validate date
    if(empty(trim($_POST["date"]))){
        $date_err = "Please enter a Date.";     
    } else{
        $date = trim($_POST["date"]);
    }



    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) 
    && empty($name_err) && empty($last_name_err) && empty($last_name2_err) && empty($number_err) && empty($date_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email, name, lastname, lastname2, number, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssss", $param_username, $param_password, $param_email, $param_name, $param_lastname, $param_lastname2, $param_number, $param_date);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_name = $name;
            $param_lastname = $last_name;
            $param_lastname2 = $last_name2;
            $param_number = $number;
            $param_date = $date;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="container text-center">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-6 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>   
                <div class="form-group col-md-6 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>   
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group col-md-6 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div> 
            <div class="form-row">
                <div class="form-group col-md-6 <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                    <label>LastName</label>
                    <input type="text" name="lastname" class="form-control" value="<?php echo $last_name; ?>">
                    <span class="help-block"><?php echo $last_name_err; ?></span>
                </div> 
                <div class="form-group col-md-6 <?php echo (!empty($last_name2_err)) ? 'has-error' : ''; ?>">
                    <label>LastName</label>
                    <input type="text" name="lastname2" class="form-control" value="<?php echo $last_name2; ?>">
                    <span class="help-block"><?php echo $last_name2_err; ?></span>
                </div> 

            </div>
            <div class="form-row">
                <div class="form-group col-md-6 <?php echo (!empty($number_err)) ? 'has-error' : ''; ?>">
                    <label>Number</label>
                    <input type="number" name="number" class="form-control" value="<?php echo $number; ?>">
                    <span class="help-block"><?php echo $number_err; ?></span>
                </div> 
                <div class="form-group col-md-6 <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $date; ?>">
                    <span class="help-block"><?php echo $date_err; ?></span>
                </div> 

            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>