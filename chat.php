<?php
session_start();
if(isset($_SESSION['username'])){
#database connection file

include 'app/db.conn1.php';
include 'app/helpers/chat.php';
include 'app/helpers/opened.php';

include 'app/helpers/user.php';
include 'app/helpers/timeAgo.php';



if(!isset($_GET['user'])){
    header("Location:home.php");
    exit;
}


#Getting User data 
$ChatWith= getUser($_GET['user'],$conn);

if(empty($ChatWith)){
    header("Location:home.php");
    exit;
}
$chats=getChats($_SESSION['user_id'],$ChatWith['user_id'],$conn);

opened($ChatWith['user_id'],$conn,$chats);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="uploads/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .w-15 {
            width: 15%;
        }

        .fs-sm {
            font-size: 1.4rem;
        }

        small {
            color: #bbb;
            font-size: 0.9rem;
            text-align: right;
            
        }

        .rtext {
            width: 65%;
            background: #f8f9fa;
            color: #444;
        }

        .ltext {
            width: 65%;
            background: #3289c8;
            color: #fff;
        }

        .chat-box {
            overflow-y: auto;
            max-height: 50vh;
            overflow-x: hidden;
        }

        /*width*/
        *::-webkit-scrollbar {
            width: 3px;
        }

        /*Track*/
        *::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle*/
        *::-webkit-scrollbar-thumb {
            background: #aaa;
        }

        /*Handle on Hover*/
        *::-webkit-scrollbar-thumb:hover {
            background: #3289c8;
        }

        textarea {
            resize: none;
        }
        body {
			background-image: url("uploads/back2.png");
			background-size:cover;
			background-repeat: no-repeat;
            background-position: center center;
		}
        
            
        
    </style>

</head>

<body class=" d-flex
            justify-content-center
            align-items-center
            vh-100">
    <div class="w-400 shadow p-4 rounded"style="background-color:#86f6e7" >
        <a href="home.php" class="fs-4 link-dark">&#8592;</a>

        <div class="d-flex align-items-center" style="background-color:#85ffe4">
            <img src="uploads/<?=$ChatWith['P_P']?>" class="w-15 rounded-circle">

            <h3 class="display-4 fs-sm m-2">
                <?=$ChatWith['name']?><br>
                
                <div title="online" class="d-flex align-items-center">
                <?php
                            if(last_seen($ChatWith['last_seen'])== "Active"){
                                ?>

                    <div class="online"></div>
                    <small class="d-block p-1" style="color:#000000">Online</small>
                    <?php } else{ ?>
                    <small class="d-block p-1" style="color:#000000">
                        Last Seen:<?=last_seen($ChatWith['last_seen']) ?>
                    </small>
                    <?php } ?>
                </div>
            </h3>
        </div>


            <div class="shadow p-4 rounded
                            d-flex flex-column
                            mt-2  chat-box" id="chatBox" 
                            style="background-image: url('uploads/chat2.png');
			                        background-size:cover;
		                        	background-repeat: no-repeat;
                                    background-position: center center;">
                <?php
                    if(!empty($chats)){
                        foreach($chats as $chat){
                            if($chat['from_id'] == $_SESSION['user_id']){
                             ?>  
                             <p class="rtext align-self-end
                                border rounded p-2 mb-1">
                                <?=$chat['message']?>
                             <small class="d-block"><?=$chat['created-at']?></small>
                </p> 
                            <?php
                            }else{?>
                             <p class="ltext
                            border rounded p-2 mb-1"><?=$chat['message']?>
                    <small class="d-block"><?=$chat['created-at']?></small>
                </p>


                <?php
                }}
                
                }else{?>
                    <div class="alert alert-info text-center" >
                                <i class="fa fa-comments d-block fs-big"></i>
                                No,message yet,Start the Conversation                           </div>
                      
                    <?php }?>
            </div>

            <div class="input-group mb-3">
                <textarea cols="3" id="message" class="form-control"></textarea>
                <button class="btn btn-primary" id="sendBtn">
                    <i class="fa fa-paper-plane"></i></button>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        var scrollDown = function () {
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        scrollDown();
        
        $(document).ready(function () {

            $("#sendBtn").on('click',function(){ 
                //when btn is clicked message is going on insert.php and stor message in database from related user using user_id 
                message =$('#message').val();
                if(message == " ")return;
                $.post("app/ajax/insert.php",
                {
                    message:message,
                    to_id: <?=$ChatWith['user_id']?>
                },
                function(data,status){   //it append the message in chatBox
                    $("#message").val("");
                   
                    $("#chatBox").append(data);
                    scrollDown();
                });
            });
            /**
                         * auto update last seen for logged in user
                         */
                        let lastSeenUpdate=function(){
                        $.get("app/ajax/update_last_seen.php");
                    }
                    lastSeenUpdate();
                    
                    /**
                     * auto update last seen every 10sec
                     */
                    setInterval(lastSeenUpdate,10000);

                    //auto refresh/reload
                    let fechData=function(){
                        $.post("app/ajax/getMessage.php",     //it fetch message and get message
                        {
                            id_2:<?=$ChatWith['user_id']?>
                        },
                        function(data,status){
                    $("#chatBox").append(data);
                    if(data !=" " ) scrollDown();
                });}
            fechData();
            /**
                     * auto update last seen every 0.5sec
                     */
                    setInterval(fechData,500);

        
        });
    </script>


</body>

</html>
<?php
}else{("Location: micro.php");
    exit;
    }
?>