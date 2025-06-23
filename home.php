<?php
session_start();
if(isset($_SESSION['username'])){
#database connection file

include 'app/db.conn1.php';
include 'app/helpers/user.php';
include 'app/helpers/conversation.php';
include 'app/helpers/lastchat.php';

include 'app/helpers/timeAgo.php';


#Getting User data 
$user = getUser($_SESSION['username'],$conn);

#getting user conversation information
$conversations=getConversation($user['user_id'],$conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="uploads/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            /*background-image:url("image/back.png");*/
        }
        body {
			background-image: url("uploads/back2.png");
			background-size:cover;
			background-repeat: no-repeat;
            background-position: center center;
		}
		

        .w-10 {
            width: 10%;
        }

        a {
            text-decoration: none;
        }

        .fs-big {
            font-size: 5rem !important;
        }

        .online {
            width: 10px;
            height: 10px;
            background: green;
            border-radius: 50%;
        }
    </style>
</head>

<body class=" d-flex
            justify-content-center
            align-items-center
            vh-100">
    <div class="p-2 w-400
            rounded shadow" style="background-color:#86f6e7; border:2px solid #86f6e7">
        <div>
            <div class=" d-flex
                                mb-3 p-3 bg-light
                                justify-content-between
                                align-items-center " >
                <div class=" d-flex
                                            align-items-center" >
                    <img src="uploads/<?=$user['P_P']?>" class="w-25 rounded-circle">
                    <h3 class="fs-xs m-2">
                        <?=$user['name']?>
                    </h3>
                </div>
                <a href="logout.php" class="btn btn-dark">Logout</a>
            </div>
            <div class="input-group mb-3">
                <input type="text" placeholder="Search..." id="searchText" class="form-control">
                <button class="btn sbtn-primary" id="searchBtn" style="background-color: cornflowerblue;"><i
                        class="fa fa-search"></i></button>
            </div>
            <ul id="chatList" class="list-group mvh-50 overflow-auto">
                <?php
                        if(!empty($conversations)){ #if searched user is signed in this app ?> 

                <?php foreach($conversations as $conver) { ?>

                <li class="list-group-item">
                    <a href="chat.php?user=<?=$conver['username']?>"
                        class="d-flex justify-content-between align-items-center p-2">

                        <div class="d-flex align-items-center">
                            <img src="uploads/<?=$conver['P_P']?>" class="w-10 rounded-circle">

                            <h3 class="fs-xs m-2">
                                <?=$conver['name'] ?><br>
                                <small>
                                    <?php
                            
                           # echo  lastChat($_SESSION['user_id'],$conver['user_id'],$conn);

                        ?>
                                </small>
                            </h3>
                        </div>
                        <?php if(last_seen($conver['last_seen']) == 'Active'){ ?>


                        <div title="online">
                            <div class="online"></div>
                        </div>
                        <?php } ?>
                    </a>
                </li>
                <?php } ?>
                <?php } else{ ?>
                <div class="alert alert-info text-center">
                    <i class="fa fa-comments d-block fs-big"></i>
                    No,message yet,Start the Conversation
                </div>
                <?php } ?>

            </ul>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                //Search
                $("#searchText").on("input", function () {
                    var searchText = $(this).val();
                    if (searchText == "") return;
                    //it set the input message and search in search.php
                    $.post('app/ajax/search.php',
                        {
                            key: searchText
                        },
                        function (data, status) {
                            $("#chatList").html(data);
                        });

                });

                //by button
                //Search
                $("#searchBtn").on("click", function () {
                    var searchText = $("#searchText").val();
                    if (searchText == "") return;
                    $.post('app/ajax/search.php',
                        {
                            key: searchText
                        },
                        function (data, status) {
                            $("#chatList").html(data);
                        });

                });
                /**
                 * auto update last seen for logged in user
                 */
                let lastSeenUpdate = function () {
                    $.get("app/ajax/update_last_seen.php");
                }
                lastSeenUpdate();
                /**
                 * auto update last seen every 10sec
                 */
                setInterval(lastSeenUpdate, 10000);
            });
        </script>
</body>

</html>



<?php
}else{("Location: micro.php");
    exit;
    }
?>