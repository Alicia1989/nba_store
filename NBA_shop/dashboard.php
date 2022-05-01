<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["is_loggedin"]) || $_SESSION["is_loggedin"] !== true) {
	header("location: login.php");
	exit;
}

require 'config.php';

// define variables
$error = $description =  "";

// If upload button is clicked ...
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Check if image is empty
	if (empty($_POST["image"])) {
		$$error = "Please upload image.";
	}

	// Check if image description is empty
	if (!isset($_POST["description"]) || empty(trim($_POST["description"]))) {
		$$error = "Please enter image descripiton.";
	} else {
		$description = trim($_POST["description"]);
	}

	if (empty($error)) {
		// get the image from the request 
		$filename = $_FILES["image"]["name"];
		$tempname = $_FILES["image"]["tmp_name"];
		$filepath = "uploads/" . $filename;
 
		// prepare sql statement
		$sql = "INSERT INTO images (url, description) VALUES ('$filepath', '$description')";
		

		// Execute query
		$result = mysqli_query($connection, $sql);

		if ($result) {  
			// Now let's move the uploaded image into the folder: image
			if (move_uploaded_file($tempname, $filepath)) {
				$msg = "Image uploaded successfully";
			} else {
				$msg = "Failed to upload image";
			}
		}else{
			die(mysqli_error($connection));
		}
	}
}

// run query to get all images
$result = mysqli_query($connection, "SELECT * FROM images");

 // Close connection
 mysqli_close($connection);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="uft-8">
	<link rel="stylesheet" href="style2.css">
	<link rel="stylesheet" href="style3.css">
	<title>Members area</title>
</head>

<body>
	<main class="container">

		<div class="member-header">
			<h2 class="success">Welcome Member</h2>
			<a href="logout.php">Logout</a>
		</div>


		<div id="content">
			<?php if (!is_null($error) && !empty($error)) { ?>
				<div class="error-msg">
					<?php echo $error; ?>
				</div>
			<?php } ?>
			<form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data">

				<div class="form">

					<fieldset>
						<legend>Upload Your Image</legend>
						<div class="Upload-img">
							<input id="file-upload" type="file" name="image" required accept="image/png, image/gif, image/jpeg">
						</div>

						<div>
							<textarea id="text" cols="40" rows="4" name="description" required placeholder="Say something about this image..."></textarea>
						</div>
						<div>
							<button class="submit" type="submit" name="upload">Upload</button>
						</div>

					</fieldset>

				</div>
			</form>


		</div>

		<div class="table-container">
			<table>
				<tr>
					<th class="row-1">#</th>
					<th class="row-2">Image</th>
					<th>Text</th>

				</tr>
				<?php
				$rows = mysqli_num_rows($result);
				if ($rows > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
				?>
						<tr>
							<td><?php echo $row['id'] ?></td>
							<td class="row-2">
								<img class="data-img" src="<?php echo $row['url'] ?>" alt="">
							</td>
							<td><?php echo $row['description'] ?></td>

						</tr>
				<?php }
				} ?>
			</table>
		</div>

	</main>
</body>

</html>