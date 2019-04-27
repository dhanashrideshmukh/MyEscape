<?php

class User {

    public $username;
    public $password;
    public $email;

    public function __construct($username, $password, $email) {

        $this->username = $username;
        $this->password = $Password;

        $this->email = $Email;
    }

    
    public static function login() {//add in santisation for email
               
            $db = Db::getInstance();
            if(!is_null($db)){
            try{
            $query = $db->prepare("SELECT * FROM user WHERE Username = :username AND Password = :password");
            if(isset($_POST['username'])&& $_POST['username']!=""){
                $username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if(isset($_POST['password'])&& $_POST['password']!=""){
                $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            $query->bindParam(':username', $username);
            $query->bindParam(':password', $password);
            $query->execute();
            $results = $query->fetchAll();
            if ($results) {
                 header('location:?controller=blog&action=create');
            } 
            else {
                $message = "Username and/or password are incorrect.\\nPlease try again.";
        
                echo '<script type="text/javascript">alert("'.$message.'");history.go(-1);</script>';
                die();
            }
            }
            catch(PDOException $e){              
                $e->getMessage();
                // log this exception somewhere
                throw  new Exception();
            }                     
         }
            
    }
        
    
    

    public static function register() {
        $db = Db::getInstance();
         if(!is_null($db))
        {
            try{
        
        if(isset($_POST['Username'])&& $_POST['Username']!=""){
            $username = filter_input(INPUT_POST,'Username', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['Password'])&& $_POST['Password']!=""){
            $password = filter_input(INPUT_POST,'Password', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        
        $username = $_POST["Username"];
        $password = $_POST['Password'];
        $email = $_POST["Email"];

           
        $sql_u = $db->prepare("SELECT * FROM user where Username='$username'");
        $sql_e = $db->prepare("SELECT * FROM user where Email = '$email'");
        $res_u = $sql_u->execute();
        $res_e = $sql_e->execute();
     
  	if ($sql_u->fetchColumn()> 0) {
  	   die("Sorry... username already taken"."Try differnt username". "<a href='?controller=user&action=register'>Register</a> "); 
         
        }
        elseif ($sql_e->fetchColumn() > 0) {
        die("Sorry... email is already taken")  ;    
        
        }
        else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $rej = $db->prepare("INSERT INTO user (Username, Email, Password) VALUES ( :username, :email, :password)");
    


        $rej->bindParam(':username', $username);
        $rej->bindParam(':password', $hashed_password);
        $rej->bindParam(':email', $email);

        
        $result = $rej->execute();
         
         if ($result ==1 ) { 
             echo "Please enter the login details";
             header('location:?controller=user&action=login');}            
            
            }
            }
            catch(PDOException $e){
                $e->getMessage();
                // log this exception somewhere
                throw  new Exception();
            }
            
        }
    }

    
    public static function readMine($username) 
    {        
      $list = [];
      $db = Db::getInstance();
      if(!is_null($db)){      
       try{   
            $sqlfindmine= "Call readMyBlogs (:username)";
       
      
            $req = $db->prepare($sqlfindmine);
            require_once('blog.php');
            $req->execute(array(':username' => $username));
            foreach($req->fetchAll() as $blog) 
                {
              $list[] = new Blog($blog['BlogID'], $blog['Title'], $blog['Content'], $blog['CountryName'], $blog['ContinentName'], $blog['CategoryName'],$blog['Username'], $blog['LikeCounter'],$blog['ViewCounter']);
            }
            return $list;
       }
       catch(PDOException $e){
           $e->getMessage();           
           
           // log this exception somewhere
           throw  new Exception();
       }
             
    }
    }
    
    
    public static function contactus() {
        $db = Db::getInstance();
        if(!is_null($db)){
        try{    
            $stmt = $db->prepare("INSERT INTO userfeedback (FullName, Email,Comments) VALUES ( :FullName, :Email, :Comments)");
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $comments = $_POST["comments"];
            $stmt->bindParam(':FullName', $fullname);
            $stmt->bindParam(':Email', $email);
            $stmt->bindParam(':Comments', $comments);
            $result = $stmt->execute();
             if ($result ==1 ) { echo "Thanks for the feedback,we will get back to you soon";}
        }
        catch(PDOException $e){
            $e->getMessage();
            // log this exception somewhere
            throw  new Exception();
        }        
    }
    }
    
    
    public static function filterInput($userDetail) {//create a sanitising function for sanitising strings
        if (isset($_POST["$userDetail"]) && $_POST["$userDetail"] != "") {
            return filter_input(INPUT_POST, $userDetail, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        }
    }
    
    
    public static function modify() {
        $db = Db::getInstance();
        if(!is_null($db))
        {
        try{
        $req = $db->prepare("Call updatePassword(:username, :newPassword);");
        $req->bindParam(':username', $username);
        $req->bindParam(':newPassword', $newPassword);
        
        $passwordUpdateDetails = filter_input_array(INPUT_POST);
        //asking whether title is empty refers to whether the addform has been submitted yet, if not the query is run
        if (!empty($_POST['username'])) {//loops through Post Superglobal array, sanitising each input item
            foreach ($passwordUpdateDetails as $formDetail => $formValue) {
                ${$formDetail} = User::filterInput($formDetail);
            }
            $req->execute();
            
        }
        }
        catch (PDOException $e){
            $e->getMessage();
            // log this exception somewhere
            throw  new Exception();
        }
        }
    }
    
    public static function confirmUserExists() {
        $db = Db::getInstance();
        if(!is_null($db)){
        try{
        $req = $db->prepare("Call confirmUserExists(:username);");
        $req->bindParam(':username', $username);        
        $passwordUpdateDetails = filter_input_array(INPUT_POST);
        //asking whether title is empty refers to whether the addform has been submitted yet, if not the query is run
        if (!empty($_POST['username'])) {//loops through Post Superglobal array, sanitising each input item
            foreach ($passwordUpdateDetails as $formDetail => $formValue) {
                ${$formDetail} = User::filterInput($formDetail);
            }
            $req->execute();
            $user = $req->fetch();
            
             if($user){
              return true;
      }
            else{
            throw new Exception('A real exception should go here'); //replace with a more meaningful exception
            }
        }
        }
        catch (PDOException $e){
            $e->getMessage();
            // log this exception somewhere
            throw  new Exception();
        }
        }
    }
}