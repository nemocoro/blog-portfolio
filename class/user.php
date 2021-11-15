<?php
    require_once 'database.php';
    
    class User extends Database
    {
        private $conn;

        public function __construct()
        {
            //establish db connection
            $this->conn = $this->connect();
        }

        public function register($firstname,$lastname,$address,$contact_no,$username,$password)
        {
            $hashed_password = password_hash($password,PASSWORD_DEFAULT); 
            //encrypts your password
            
            $sql = "INSERT INTO accounts(username,password) VALUES('{$username}','{$hashed_password}')"; //insert sql statement to insert the username and the encrypted password to table accounts

            $result = $this->conn->query($sql);
            //runs the sql statement; returns TRUE if successful, otherwise, returns FALSE. 

            if( $result ) //checks if the $sql runs successfully
            {
                //if the $result is TRUE, we will get the account_id and insert the rest of the data in table users
                
                $account_id = $this->conn->insert_id; //gets the account_id

                $sql = "INSERT INTO users(first_name,last_name,address,contact_number,account_id) VALUES('$firstname','$lastname','$address',$contact_no,$account_id)";
                // echo "$sql";
                // exit;
                $result = $this->conn->query($sql);
                //runs the sql statement; returns TRUE if successful, otherwise, returns FALSE.
                
                if($result) //checks if the $sql runs successfully
                {
                    //if $result is TRUE, display success message and redirect to login page.

                    $_SESSION["success"] = 1; //1 means the operation is successful, 0 means otherwise
                    $_SESSION["message"] = "Registration Successful."; //the success message to be displayed.
    
                    header("Location: ../views/index.php");
                }
                else
                {
                    // if the $result id FALSE, we will set the error message to be displayed using the $_session and then redirect back to the register.php
                    
                    $_SESSION["success"] = 0; //1 means the operation is successful, 0 means otherwise
                    $_SESSION["message"] = "An error occured. Failed to register. Kindly try again."; //the error message to be displayed.
    
                    header("Location: ../views/register.php");
                } 
            }
            else
            {
                // if the $result id FALSE, we will set the error message to be displayed using the $_session and then redirect back to the register.php
                
                $_SESSION["success"] = 0; //1 means the operation is successful, 0 means otherwise
                $_SESSION["message"] = "An error occured. Failed to register. Kindly try again."; //the error message to be displayed.

                header("Location: ../views/register.php");
            }
            

        }

        public function login($username, $password)
        {
            $sql = "SELECT * FROM accounts INNER JOIN users ON accounts.account_id=users.account_id WHERE username = '{$username}'";

            $result = $this->conn->query($sql);

            if( $result && $result->num_rows>0)
            {
                $user = $result->fetch_assoc(); //getting the result as an associative array
                
                //check if password is correct
                if( password_verify($password,$user["password"])) 
                {
                    //save certain data to session
                    $_SESSION["account_id"] = $user["account_id"];
                    $_SESSION["firstname"] = $user["first_name"];
                    $_SESSION["lastname"] = $user["last_name"];
                    $_SESSION["username"] = $user["username"];

                    if( $user["role"] == "A") //if the role is A, meaning admin, redirect to dashboard.php
                    {
                        header("Location: ../views/dashboard.php");
                    }
                    else
                    {
                        //if role is not A, it means, most probably, U - regular user
                        header("Location: ../views/profile.php");
                    }

                }
                else
                {
                    // if password is incorrect,display and error message
                
                    $_SESSION["success"] = 0; //1 means the operation is successful, 0 means otherwise
                    $_SESSION["message"] = "Incorrect password."; //the error message to be displayed.
    
                    header("Location: ../views/index.php");                
                }
            }
            else
            {
                // if the $result is FALSE AND there are no results returned fromt he sql statement, we will set the error message to be displayed using the $_session and then redirect back to the index.php (login page)
                
                $_SESSION["success"] = 0; //1 means the operation is successful, 0 means otherwise
                $_SESSION["message"] = "Incorrect username."; //the error message to be displayed.

                header("Location: ../views/index.php");                
            }
        }

        public function getUser($account_id)
        {
            $sql = "SELECT accounts.account_id,username,password,role, user_id,first_name,last_name,address,contact_number FROM accounts INNER JOIN users ON accounts.account_id=users.account_id WHERE accounts.account_id = $account_id";

            $result = $this->conn->query($sql);

            if( $result && $result->num_rows>0)
            {
                return $result->fetch_assoc();
            }
            else
            {
                return FALSE;
            }
        }
    }
?>