<?php

require_once "class_Database.php";

class User extends Database {
        
    //acquired properties on register
    protected $firstname;
    protected $lastname;
    protected $email;
    private $password;
    
    //derived properties
    private $userID;
    
    //other properties
    protected $DOB; //date of birth
    protected $gender; // 0 for male, 1 for female
    protected $profilePictureID; 
    
    
    function __construct($firstname,$lastname,$email,$password){
        
        echo "USER : Constructor!<br>";
        
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
                        
    }
    
    // create User methods
    protected function createUser($firstname,$lastname){
        echo "User : In createUser<br>";
        
        $this->generateUserID($firstname,$lastname);
                
        echo "userID : $this->userID <br>";
        echo "email : $this->email<br>";
        echo "password : $this->password <br>";
        
        $this->addUserEntryinDB(); 
    }
    
    public function loginUser(){
        //echo "USER : LoginUser!<br>";
        
        /*
        This function will allow an existing user to log in, based on input username and input password. 
        
        - will essentially involve checking if the input password and the hashed password from the database, match. 
        
        Should return TRUE if the login was successful, or FALSE otherwise. 
        
        */
        
    }
    
    protected function generateUserID($firstname,$lastname){
        echo "User : In generateUsername<br>";
        $str1 = substr($firstname, 0, 2); // first 2 letters of firstname
        $str1 .= substr($lastname, 0, 3); // first 3 letters of lastname
        $string = strtolower($str1); // making lowercase
        
        $isUserIDUnique = FALSE;
        $idx = 0;
        while ($isUserIDUnique == FALSE){
            $userID = $string . rand(0,9); // appending a random digit.
            $userID .= rand(0,9); // appending a random digit.
            
            $isUserIDUnique = $this->checkIfUserIDUnique($userID);
            $idx++;
            
            if($idx >100){
                echo "No unique user ID could be generated!";
                break;
            }
        }
        
        $this->userID = $userID;
        
    }
    
    protected function checkIfUserIDUnique($userID){
    /* write a function that checks on the database to see if the generated userID is unique. The function should return TRUE if generated userID is indeed unique, or FALSE otherwise. 
    */
        
    }

        
    // Database methods
    protected function addUserEntryinDB(){
        

    }
    
    protected function updateUserPassword(){
        // function to update password 
    }
    
}//end class




?>