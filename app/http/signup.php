<?php

    #checking username,password,name,submitted
     if(isset($_POST['name'])&& 
        isset($_POST['username']) &&
        isset($_POST['password'])){

            #database connection file
        include '../db.conn1.php';

        #get data and store them in var
        $name=$_POST['name'];
        $username=$_POST['username'];
        $password=$_POST['password'];

        #data formatting
        $data='name='.$name.'&username='.$username;

        #simple validation
        if(empty($name)){                     #indicats null 
            #error message
            $em="Name is Requred";

            #redirect to 'signup.php' and passing errore message
            header("Location: ../../signup.php?error=$em&&data"); #to raise error in panel
            exit;
        }
        else if(empty($username)){                     #indicats null 
            #error message
            $em="UserName is Requred";

            #redirect to 'signup.php' and passing errore message
            header("Location: ../../signup.php?error=$em&&$data");#to raise error in panel and show the entered name 
            exit;
        }
        else if(empty($password)){                     #indicats null 
            #error message
            $em='valid Password is Requred';

            #redirect to 'signup.php' and passing errore message
            header("Location: ../../signup.php?error=$em&&$data");#to raise error in panel
            exit;
        }
        else{
            #checking the database if the username is taken
            $sql="SELECT username 
                  FROM users
                  WHERE username=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);

            if($stmt->rowCount()>0){
                $em ="the username($username) is taken";
                header("Location: ../../signup.php?error=$em&$data");
                exit;
            }
            else{
                #profile Picture uploading
                if(isset($_FILES['pp'])){
                    #get data and store them in var
                    $img_name=$_FILES['pp']['name'];
                    $tmp_name=$_FILES['pp']['tmp_name'];
                    $error=$_FILES['pp']['error'];

                    #if there is not error occurred while uploading
                    if($error === 0){
                        
                        #get image extension store it in var
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);


                        /**convert the image extension into lower case and store it in var */
                        $img_ex_lc=strtolower($img_ex);

                        /**creating array that stores allowed to upload image extension  */
                        $allowed_exs=array("jpg","jpeg","png");

                        #checking image extension
                        if(in_array($img_ex_lc,$allowed_exs)){

                            #renaming the image with user's username
                            #like:username.$ig_ex_lc
                            $new_img_name =$username. '.'.$img_ex_lc;

                            #creating uploading path or root directory
                            $img_upload_path='../../uploads/'.$new_img_name;

                            #move uploaded image to ./uploads folder

                            move_uploaded_file($tmp_name,$img_upload_path);
                        }else{
                            $em="you can't upload files of this type";
                        header("Location: ../../signup.php?error=$em&$data");
                        exit;

                        }

 
                    }                    
                }
                //password hashing
                $password=password_hash($password,PASSWORD_DEFAULT);

                #if the user upload Profile Picture
                if(isset($new_img_name)){
                    #inserting data into database
                    /**execute=after preparing the SQL statement using the prepare() method, you can bind values to the prepared statement using placeholders and then execute it using the execute() 
                     * 
                     * $stmt means="stmt" is an abbreviation for "statement." It refers to the prepared statement object that represents an SQL statement in PHP. 
                    */


                    $sql ="INSERT INTO users
                            (name,username,password,P_P)
                            VALUES (?,?,?,?)";
                    $stmt=$conn->prepare($sql);
                    $stmt->execute([$name,$username,$password,$new_img_name]);
                }else{
                    #inserting 
                    $sql ="INSERT INTO users
                    (name,username,password)
                    VALUES (?,?,?)";
                    $stmt=$conn->prepare($sql);
                    $stmt->execute([$name,$username,$password]);

                }
                #success message
                $sm="Account created successfully";

                #redirect to 'micro.php' and passing success message
                header("Location: ../../micro.php?success=$sm");
                exit;
            }
        }
    }
    else{
        header("Location: ../../micro.php");
        exit;
    
    }
    ?>