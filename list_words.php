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
<!--    <form method="post">-->
<!--        <select name="size">-->
<!--            <option value="50">View 50</option>-->
<!--            <option value="25"><a href="#size=25&page=1"/>View 25</option>-->
<!--            <option value="100">View 100</option>-->
<!--            <option value="All">View All</option>-->
<!--        </select>-->
<!--        <input type="hidden"/>-->
<!---->
<!--    </form>-->
    <table class="table table-condensed main-tables" id="puzzle_table">
        <thead>
        <tr>
            <th>Word ID</th>
            <th>Word</th>
            <th>English Word</th>
            <th>Image Thumbnail</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = 'SELECT * FROM words;';
        $result = run_sql($sql);
        $resArr = mysqli_fetch_array($result, MYSQLI_NUM );
        $count = 0;
        $data = array();
        while($row = $result->fetch_assoc())
        {
            array_push($data, $row);
        }
        $limit = 50;
        $totalRows = count($data);
        if(isset($_GET['page']))
        {
            $page=$_GET['page'] + 1;
            $offset = $limit * ($page-1) ;
        }else{
            $page = 1;
            $offset = 0;
        }

       // echo "Max Page:";
        $maxPages = ceil($totalRows/$limit);
        $sql = 'SELECT * FROM words LIMIT '.$offset.','.$limit.' ;';
        $result = run_sql($sql);

        //echo "Page;" .$page;
//        $remainingRows = $totalRows - ($page * $limit);
//        echo "Rem";
//        echo $left_rec = $remainingRows - ($page * $limit);

        if( $page > 1 && $page < $maxPages) {
            $last = $page - 2;
            echo "<a href = \"?page=$last\" style=\"font-size:160%;\"> << Last 50 Records</a> | ";
            echo "<a href = \"?page=$page\" style=\"font-size:160%;\">Next 50 Records >> </a>";
        }else if( $page == 1 ) {
            echo "<a href = \"?page=$page\" style=\"font-size:160%;\">Next 50 Records >> </a>";
       }else{
            $last = $page - 2;
            echo "<a href = \"?page=$last\" style=\"font-size:160%;\"> << Last 50 Records</a>";
        }

        while ($row = $result->fetch_assoc()) {
            $word_id = $row['word_id'];
            echo '<tr>
          <td>' . $word_id . '</td>
          <td>' . $row['word'] . '</td>
          <td>' . $row['english_word'] . '</td>
          <td><img class="thumbnailSize" src="./Images/' . $row['image'] . '" alt ="' . $row['image'] . '"></td>
          <td>
          <a href="admin_edit_synonyms.php?id=' . $word_id . '"&button=edit">
          <img class="table_image" src="pic/edit.jpg" alt="Edit ' . $word_id . ' word"></a>
          <a href="list_words.php?id=' . $word_id . '"&button=delete">
          <img class="table_image" src="pic/delete.jpg" alt="Deleteword"></a>
            <form class="upload" method="post" name="importFrom" enctype="multipart/form-data" onsubmit="return validateForm()">
              <label class="upload"><input class="upload" type="file" name="fileToUpload" id="fileToUpload"></label>
              <input class="upload" type="hidden" name="word_id" value="' . $word_id . '" />
              <input class="upload" type="submit" value="Upload/Replace Image" name="submit">
            </form>
          </td>
          </tr>';
            $count++;
        }


        if (isset($_POST['submit'])) {

            $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
            echo $inputFileName;
            echo $_POST['word_id'];

            $target_dir = "./Images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            echo $target_file;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $imageName = basename($_FILES["fileToUpload"]["name"]);
            echo $imageName;
            copy($inputFileName, $target_file);

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $sql = 'UPDATE words SET image=\'' . $imageName . '\' WHERE word_id=' . $_POST['word_id'] . '';
                $result = run_sql($sql);
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            echo '<h2 style="color:	green;" class="upload">Import Successful!</h2>';
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
        }

        // *** delete button functionality ***
        //        if(isset($_GET['word_id']))
        //        {
        //            if($_GET['button'] == 'delete')
        //            {
        //                $id = $_GET['word_id'];
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
