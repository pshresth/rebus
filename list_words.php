<!DOCTYPE html>
<html>
<head>
    <?PHP
    session_start();
    require('session_validation.php');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/main_style.css" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles/custom_nav.css" type="text/css">
    <title>Final Project</title>
</head>
<body>
<?php
require('db_configuration.php');
?>
<?PHP echo getTopNav(); ?>
<div id="pop_up_fail" class="container pop_up" style="display:none">
    <div class="pop_up_background">
        <img class="pop_up_img_fail" src="pic/info_circle.png">
        <div class="pop_up_text">Incorrect! <br>Try Again!</div>
        <button class="pop_up_button" onclick="toggle_display('pop_up_fail')">OK</button>
    </div>
</div>
<div class="container">
    <table class="table table-condensed main-tables" id="puzzle_table">
        <thead>
        <tr>
            <th>Word ID</th>
            <th>Word</th>
            <th>Master Word</th>
            <th>Image Thumbnail</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //session_start();

        $sql = 'SELECT * FROM words limit 50;';
        $result =  run_sql($sql);
        $count = 0;
        while($row = $result->fetch_assoc())
        {
            $masterWord = GetMasterWord($row['rep_id']);
            echo '<tr>
          <td>'.$row['word_id'].'</td>
          <td>'.$row['word_value'].'</td>
          <td>'.$masterWord.'</td>
          <td><img class="thumbnailSize" src="./Images/'.$row['image_name'].'.jpg" alt ="'.$row['image'].'"></td>
          <td>
          <a href="admin_edit_synonyms.php?word='.$masterWord.'"&button=edit">
          <img class="table_image" src="pic/edit.jpg" alt="Edit '.$masterWord.' word"></img></a>
        
            <form class="upload" method="post" name="importFrom" enctype="multipart/form-data" onsubmit="return validateForm()">
              <label class="upload"><input class="upload" type="file" name="fileToUpload" id="fileToUpload"></label>
              <input class="upload" type="hidden" name="word_id" value="'.$row['word_id'].'" />
              <input class="upload" type="submit" value="Upload/Replace Image" name="submit">
            </form>
          </td>
          </tr>';
            $count++;
        }

        if(isset($_POST['submit'])){

            $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
            echo $inputFileName;
            echo $_POST['word_id'];

            $target_dir = "./Images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            echo $target_file;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imageName = basename($_FILES["fileToUpload"]["name"], '.'.$imageFileType);
            echo $imageName;
            copy($inputFileName,$target_file);
$image = addslashes(file_get_contents($inputFileName));

           // echo $imageFileType;


            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
               $sql = 'UPDATE words SET image_name=\''.$imageName.'\' WHERE word_id='.$_POST['word_id'].'';
               $result =  run_sql($sql);
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            echo '<h2 style="color:	green;" class="upload">Import Successful!</h2>';
        }

        // *** delete button functionality ***
//        if(isset($_GET['puzzleID']))
//        {
//            if($_GET['button'] == 'delete')
//            {
//                $id = $_GET['puzzleID'];
//
//                $sql = 'DELETE FROM puzzle_words WHERE puzzle_id='.$id.';';
//                $result =  $db->query($sql);
//
//                $sql = 'DELETE FROM puzzles WHERE puzzle_id='.$id.';';
//                $result =  $db->query($sql);
//                //header("Location:list_puzzles.php"); stoped woking and gave an error
//                echo "<meta http-equiv=\"refresh\" content=\"0;URL=list_puzzles.php\">";
//            }
//        }

        function GetMasterWord($repId){
            $sqlcheck = 'SELECT * FROM words where word_id ='.$repId.'';
            $result =  run_sql($sqlcheck);
            $row = $result->fetch_assoc();
            return $row["word_value"];
        }
//
//        ?>
        <script>
            function validateForm() {
                var eng = document.forms["importFrom"]["fileToUpload"].value;
                if (eng == "") {

                    document.getElementById("error").style = "display:block;background-color: #ce4646;padding:5px;color:#fff;";
                    return false;
                }
            }

        </script>
        </tbody>
    </table>
</div>
</body>
</html>
