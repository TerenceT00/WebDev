<?php
    require_once "config.php";
    $id = $_GET['username'];
    $concertid = $_GET['concert_id'];
    $sql = "SELECT * from concert where id =$concertid";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: adminHomepage.php");
        exit;
    }
       
   if($_SERVER["REQUEST_METHOD"] == "POST"){
    $newname = $_POST["newname"];
    $newtype = $_POST["newtype"];
    $newdetails = $_POST["newdetails"];
    $newdate = $_POST["newdate"];
    $newstartTime = $_POST["newstartTime"];
    $newendTime = $_POST["newendTime"];
    $checktime = "SELECT * from concert WHERE DATE(date) = '$newdate'";
    $result = mysqli_query($link,$checktime);
    while($row = mysqli_fetch_assoc($result)){        
        if($row["name"] != "$newname"){
            if($row["date" ]== "$newdate"){
               if($row["start_time"]>=$newstartTime && $row["start_time"]<=$newendTime){

                    header("Location: adminHomepage.php?username=$id&submit=empty");
                    exit();
                } elseif($row["end_time"]<=$newendTime && $row["end_time"] >= $newstartTime){
                    header("Location: adminHomepage.php?username=$id&submit=empty");
                    exit();
                } 
            } 
        } 
    }

    if(!isset($_FILES["fileToUpload"])){
        $target_dir = "image/";
        $target_file = $target_dir.basename($_FILES['fileToUpload']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              $upfile = "UPDATE concert SET image_path = '$target_file' WHERE id = $concertid";
              if(mysqli_query($link,$upfile)){
                echo "Record updated successfully";
              }else{
                echo "Error updating record: " . mysqli_error($link); 
              }
            
            } else {
              echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    $edit = "UPDATE concert SET name = '$newname', type = '$newtype', details = '$newdetails', date = '$newdate',
    start_time = '$newstartTime',
    end_time = '$newendTime' 
    WHERE id = $concertid";
    
    if(mysqli_query($link,$edit)){
        echo "Record updated successfully";
        header("location: adminHomepage.php?username=$id");

    } else {
        echo "Error updating record: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./cssfile/headerstyle.css">
    <link rel="stylesheet" href="./cssfile/styleAddNewConcert.css">
    <a href="logout.php" class="logout-button"><img src="./image/logout.png"></a>
</head>
<body>
    <?php include "adminHeader.html" ?>
    <?php include "adminNavigation.php" ?>
    <div class="heading">
        <h3>Edit Concert</h3>
    </div>
    <div class="mainbox">

        <form action="<?php $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']?>" method="POST"  enctype="multipart/form-data">
            <div>
                <label>Name</label>
                <input type="text" name="newname" value=<?php 
                
                echo $row["name"]?>>
            </div>
            <div>
                <label>Type</label>
                <input type="text" name="newtype" value=<?php echo $row["type"]?>>
            </div>
            <div>
                <label>Details</label>
                <?php $string = $row["details"]; ?>
                <input type="text" name="newdetails" value="<?php echo $string;?>">
            </div>
            <div>
                <label>Date</label>
                <input type="date" name="newdate" value=<?php echo $row["date"]?>>
            </div> 
            <div>
                <label>Start Time</label>
                <input type="time" name="newstartTime" value=<?php echo $row["start_time"]?>> 
            </div>
            <div>
                <label>End Time</label>
                <input type="time" name="newendTime" value=<?php echo $row["end_time"]?>>
            </div>
            <div>
                <label>Select image to upload:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">     
            </div>
            <div>
             <input type="submit" id="submit" value="Edit">
            </div>  
        </form>
   
    </div>
</body>
</html>