<?php
function getConversation($user_id,$conn){
    /**getting all the conversations for current user */
    $sql="SELECT * FROM conversation
    WHERE user_1=? OR user_2=? ORDER BY conversation_id DESC";

    $stmt =$conn->prepare($sql);
    $stmt->execute([$user_id,$user_id]);
    if($stmt->rowCount() >0){
            $conversation = $stmt->fetchAll();
            /**
             * creating empty array to store the user conversation
             */
            $user_data=[];
            #looping through the conversation
            foreach($conversation as $conver)
            {
                #if conversation user_1 row equal to user_id
                if($conver['user_1']==$user_id){  
              /**this is used for getting reciver details and
               *  display the reciver view */
                    $sql2="SELECT name,username,P_P, last_seen
                        FROM users where user_id=? ";
                        $stmt2=$conn->prepare($sql2);
                        $stmt2->execute([$conver['user_2']]);
                }
                else{
                    $sql2="SELECT name,username,P_P, last_seen
                        FROM users where user_id=? ";
                        $stmt2=$conn->prepare($sql2);
                        $stmt2->execute([$conver['user_1']]);
                

                }
                /** the fetchAll() method is used to fetch all rows of a result set from a executed query using a prepared statement */
                $allConversation=$stmt2->fetchAll();

                #pushing data into the array
                array_push($user_data, $allConversation[0]);

            }
            return $user_data;
    }
    else{
        $conversation=[];
        return $conversation;
    }
}
?>