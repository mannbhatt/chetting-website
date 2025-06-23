<?php 

function lastChat($id_1,$id_2,$conn){
     /**it fetch the last message and using for displaying those message in home page */
   $sql = "SELECT * FROM chats
           WHERE (from_id=? AND to_id=?)
           OR    (to_id=? AND from_id=?)
           ORDER BY chat_id DESC limit 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_1, $id_2, $id_1, $id_2]);

    if ($stmt->rowCount() > 0) {
    	$chat = $stmt->fetch();
    	return $chat;
    }else {
    	$chat ='';
    	return $chat;
    }

}
?>