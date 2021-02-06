<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$id = $_GET["username"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./cssfile/headerstyle.css">
    <link rel="stylesheet" href="./cssfile/styleAddNewConcert.css">
    <a href="logout.php" class="logout-button"><img src="./image/logout.png"></a>
</head>
<body>
    <?php include "adminHeader.html" ?>
    <?php include "adminNavigation.php" ?>
    <div class="heading">
        <h3>Add New Concert</h3>
    </div>
    <div class="mainbox">
        <form action="addConcert.php?username=<?php echo $_GET['username']; ?>" method="POST" enctype="multipart/form-data">
        <div>
                <label>Name</label>
                <input type="text" name="name">
            </div>
            <div>
                <label>Type</label>
                <input type="text" name="type">
            </div>
            <div>
                <label>Details</label>
                <input type="text" name="details">
            </div>
            <div>
                <label>Date</label>
                <input type="date" name="date" >
            </div> 
            <div>
                <label>Start Time</label>
                <input type="time" name="startTime"> 
            </div>
            <div>
                <label>End Time</label>
                <input type="time" name="endTime">
            </div>
            <div>
                <label>Poster</label>
                <label>Select image to upload:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">     
            </div>
            <div>
                <input type="submit" id="submit" name="submit" value="Add">
            </div>
        </form>
    </div>
</body>
</html>