<?php
session_start();

#checking username,password,submitted
 if(
    isset($_POST['username']) &&
    isset($_POST['password']))
    {

         #database connection file
         include '../db.conn1.php';

         #get data and store them in var
    
         $username=$_POST['username'];
         $password=$_POST['password'];
 
         if(empty($username)){                     #indicats null 
            #error message
            $em="UserName is Requred";

            #redirect to 'micro.php' and passing errore message
            header("Location: ../../micro.php?error=$em&&$data");#to raise error in panel and show the entered name 
            exit;
        }
        else if(empty($password)){                     #indicats null 
            #error message
            $em='Password is Requred';

            #redirect to 'micro.php' and passing errore message
            header("Location: ../../micro.php?error=$em&&$data");#to raise error in panel
            exit;
        }
        else{
            $sql="SELECT * FROM users where username=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);

            #if user name is exist
            if($stmt->rowCount() === 1){
                #fethcing user data
                $user=$stmt->fetch();

                #if username's are strictly equl
                if ($user['username'] === $username) {
           
                    # verifying the encrypted password
                   if (password_verify($password, $user['password'])) {
         
                     # successfully logged in
                     # creating the SESSION
                     $_SESSION['username'] = $user['username'];
                     $_SESSION['name'] = $user['name'];
                     $_SESSION['user_id'] = $user['user_id'];
         
                     # redirect to 'home.php'
                     header("Location: ../../home.php");
         
                   }
            }else{
                        #error message
                        $em="Incorect Username or password";

                        #redirect to 'micro.php' and passing errore message
                        header("Location: ../../micro.php?error=$em&&$data");#to raise error in panel and show the entered name

                    }


                }else{
                     #error message
            $em="Incorect Username or password";

            #redirect to 'micro.php' and passing errore message
            header("Location: ../../micro.php?error=$em&&$data");#to raise error in panel and show the entered name 
            exit;                  
                }
            }
        }

    
    else{
        header("Location: ../../micro.php");
        exit;
    }
?>