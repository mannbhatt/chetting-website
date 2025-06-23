<?php 
  session_start();

  if (!isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat App -Sign Up</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"		integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"><link rel="stylesheet" href="css/style.css">
<link rel="icon" href="uploads/logo.png">
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
			</style>
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100
			 ">
	<div class="w-400 p-5 shadow rounded" style="background-color:#76c8f8">
		<form method="post" action="app/http/signup.php" enctype="multipart/form-data" style="background-color:#76c8f8">
			<div class="d-flex
	 		            justify-content-center
	 		            align-items-center
	 		            flex-column">

				<img src="uploads/logo.png" class="w-25">
				<h3 class="display-4 fs-1 
	 		           text-center">
					Sign Up</h3>
			</div>
			<?php if(isset($_GET['error']))
				#Warning: Undefined array key "error"
				#in C:\xampp\htdocs\chetting\signup.php 
				#on line 44 to 
				#solve this error
					{
			?>
			<div class="alert alert-warning" role="alert">
				<?php
                    echo htmlspecialchars($_GET['error']);
                    ?>
			</div>
			<?php 
				}?>
			<?php
				  if (isset($_GET['name'])){
					$name = $_GET['name'];
				 }else $name='';

				 if (isset($_GET['username'])){
					$username = $_GET['username'];
				 }else $username='';
				 ?>

			<div class="mb-3">
				<label class="form-label">
					Name</label>
				<input type="text" name="name" value="<?=$name?>" class="form-control">
			</div>
			<div class="mb-3">
				<label class="form-label">
					User name</label>
				<input type="text" name="username" value="<?=$username?>" class="form-control">
			</div>

			<div class="mb-3">
				<label class="form-label">
					Password</label>
				<input type="password" class="form-control" name="password">

			</div>

			<div class="mb-3">
				<label class="form-label">
					Profile Picture</label>
				<input type="file" class="form-control" name="pp">
			</div>

			<button type="submit" class="btn btn-primary">
				Sign Up</button>
			<a href="micro.php">Login</a>
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
</body>

</html>
<?php
 }else{
	echo"error";
	header("Location: home.php");
   	exit;
}
 ?>