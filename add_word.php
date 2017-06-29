<!DOCTYPE html>
<html>
<head>
    <?PHP
    session_start();
    require('session_validation.php');
    require('db_configuration.php');
    require
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="javascript/typeahead.min.js"></script>
    <link rel="stylesheet" href="styles/custom_nav.css" type="text/css">
    <title>Final Project</title>
</head>
<body>
<style type="text/css">
    .bs-example {
        font-family: sans-serif;
        position: relative;
        margin: 50px;
    }

    .typeahead, .tt-query, .tt-hint {
        border: 2px solid #CCCCCC;
        border-radius: 8px;
        font-size: 24px;
        height: 30px;
        line-height: 30px;
        outline: medium none;
        padding: 8px 12px;
        width: 396px;
    }

    .typeahead {
        background-color: #FFFFFF;
    }

    .typeahead:focus {
        border: 2px solid #0097CF;
    }

    .tt-query {
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    }

    .tt-hint {
        color: #999999;
    }

    .tt-dropdown-menu {
        background-color: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        margin-top: 12px;
        padding: 8px 0;
        width: 422px;
    }

    .tt-suggestion {
        font-size: 24px;
        line-height: 24px;
        padding: 3px 20px;
    }

    .tt-suggestion.tt-is-under-cursor {
        background-color: #0097CF;
        color: #FFFFFF;
    }

    .tt-suggestion p {
        margin: 0;
    }
</style>
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
    <button id="addRow" name="addRow" onclick="AddTableRows()"/>
    <div>
        <table class="table table-condensed main-tables" id="word_table">
            <thead>
            <tr>
                <th>Word</th>
                <th>English Word</th>
                <th>Image Thumbnail</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <form action="" method="post">
                <tr>
                    <td><input type="textbox" name="word" id="name" /> </td>
                    <td><input type="textbox" name="eng_word" id="eng_word" /> </td>
                    <td> <label class="upload"><input class="upload" type="file" name="fileToUpload"
                                                      id="fileToUpload"></label></td>
                    <td><img class="thumbnailSize" src="./Images/' . $row['image'] . '" alt="' . $row['image'] . '"></td>
                    <td><input class="upload" type="submit" value="Upload/Replace Image" name="submit"></td>
                    </tr>
            </form>

               <?php


                if (isset($_POST['submit']))
                    if(isset($_GET['word'])) {
                        echo $word = $_GET['word'];
                    }
                    if(isset($_GET['eng_word'])) {
                        echo $eng = $_GET['eng_word'];
                    }

                    if(isset($_GET['fileToUpload'])) {
                        echo $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
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
                    }
                echo $inputFileName;


                $sql = 'INSERT INTO words (word_id, word_value, english_word, image) VALUES (DEFAULT, \'' . $word . '\', \'' . $eng . '\',\''.$imageName.'\');';


                $sql = 'UPDATE words SET image=\'' . $imageName . '\' WHERE word_id=' . $_POST['word_id'] . '';
                $result = run_sql($sql);
                $uploadOk = 1;
                } else {
                echo "File is not an image.";
                $uploadOk = 0;
                }
                echo '<h2 style="color:	green;" class="upload">Import Successful!</h2>';
                echo '
                <META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">
                ';
                }

                // *** delete button functionality ***
                // if(isset($_GET['word_id']))
                // {
                // if($_GET['button'] == 'delete')
                // {
                // $id = $_GET['word_id'];
                //
                // $sql = 'DELETE FROM puzzle_words WHERE puzzle_id='.$id.';';
                // $result = $db->query($sql);
                //
                // $sql = 'DELETE FROM puzzles WHERE puzzle_id='.$id.';';
                // $result = $db->query($sql);
                // //header("Location:list_puzzles.php"); stoped woking and gave an error
                // echo "

                // }
                // }
                //
                // ?>
                <script>
                    function validateForm() {
                        var eng = document.forms["importFrom"]["fileToUpload"].value;
                        if (eng == "") {

                            document.getElementById("error").style = "display:block;background-color: #ce4646;padding:5px;color:#fff;";
                            return false;
                        }
                    }

                    function AddTableRows(){
                        alert("add rows");
                       // Find a <table> element with id="myTable":
                        var table = document.getElementById("myTable");

                        // Create an empty <tr> element and add it to the 1st position of the table:
                        var row = table.insertRow(git);

                    }

                </script>
            </tbody>
        </table>
    </div>
</body>
</html>
