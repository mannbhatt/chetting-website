<?php

echo "Updating...";                //update the last active time in database
session_start();
#check if the user is logged  in
if(isset($_SESSION['username'])){
    #database connection file
    include '../db.conn1.php';
    #get the logged in user's username from SESSION
    $id=$_SESSION['user_id'];
    $sql="UPDATE users SET last_seen =NOW() WHERE user_id= ?";
    $stmt=$conn->prepare($sql);
    $stmt=$stmt->execute([$id]);
}else{
    header("Location: ../../micro.php");
    exit;
}
?>