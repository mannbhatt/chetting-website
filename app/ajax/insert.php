 
<?php
session_start();
if(isset($_SESSION['username'])){
    if(isset($_POST['message']) && isset($_POST['to_id'])){

    
#database connection file
#it is used to stor sended message in database
    include '../db.conn1.php';

    #get data from xhr request and store them in var
    $message=$_POST['message'];
    $to_id=$_POST['to_id'];

    #get the logged in user's username from the session
    $from_id = $_SESSION['user_id'];

	$sql = "INSERT INTO 
	       chats (from_id, to_id, message) 
	       VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$from_id, $to_id, $message]);
    

    #if the message inserted
    if($res){
        /**
         * check if this is a first conversation between them
         */
        $sql2="SELECT * FROM conversation
            WHERE (user_1=? AND user_2=?)
            OR (user_2=? AND user_1=?)";
        $stmt2=$conn->prepare($sql2);
        $stmt2->execute([$from_id,$to_id,$from_id,$to_id]);

          //setting up the time zone
        
        date_default_timezone_set("Asia/Calcutta");

        $time=date("h:i:s:a");

        if($stmt2->rowCount()==0){
            #insert them into conversation table
            $sql3="INSERT INTO conversation(user_1,user_2)
            VALUES(?,?)";
             $stmt3=$conn->prepare($sql3);
             $stmt3->execute([$from_id,$to_id]);

        }
    

    }
    ?>

        <p class="rtext align-self-end
                                border rounded p-2 mb-1"><?=$message?>
            <small class="d-block"><?=$time?></small>
        </p>

<?php
}}else{
    header("Location: ../../micro.php");
    exit;
}
?>
