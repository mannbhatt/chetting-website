<?php
function getUser($username,$conn){    
    /**this  function is used to getting user information from the table */
    $sql="SELECT * FROM users
        where username=?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    if($stmt->rowCount() === 1){
        $user = $stmt->fetch();
        return $user;
    }
    else{
        $user = [];
        return $user;
    }
}