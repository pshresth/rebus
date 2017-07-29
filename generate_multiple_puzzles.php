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
    <title>Rebus Puzzle List</title>
</head>
<body>
<?php
require('create_puzzle.php');
require ('utility_functions.php');
?>
<?PHP echo getTopNav(); ?>
<div class="container">
    <?php

    if (isset($_POST['max'])) { // this is takes in the variable MAX_COUNT
        $max = $_POST['max'];
    }
    if (isset($_POST['puzzles'])) {
        $input = preg_replace("/\r\n/", ",", validate_input($_POST['puzzles']));
        if ($input == '') {
            echo '<script type="text/javascript">alert("You did not enter any words. Please try again!"); window.location.href = "many_to_one.php"</script>';
        } else if (count(explode(",", trim($input))) < 2) {
            echo '<script type="text/javascript">alert("You must enter two or more words. Please try again"); window.location.href = "many_to_one.php"</script>';
        } else {
            $puzzles = explode(",", trim($input));
            //var_dump($puzzles);
            $wordList = array(); // we will use this to keep track of words being used so no repetition occurs
            if(count($puzzles) < $max){
               $max = count($puzzles);
            }
            echo '<h3 style="color:green;"><input type="checkbox" name="answer" onclick="toggleAnswer()">Show Answer</h3>';
            for ($k = 0; $k < $max; $k++){
                $puzzleWord= $puzzles[$k];
                echo '<div class="container"><h1 style="color:red;">Find the words for "' . $puzzleWord . '"</h1>';
                $puzzleChars = getWordChars($puzzleWord);
                $counter = 0;

                $word_array = array();
                $image_array = array();
                for ($i = 0; $i < count($puzzleChars); $i++) {
                    $word = getRandomWord($puzzleChars[$i], $wordList);
                    if (!empty($word)) {
                        array_push($word_array, $word['word']);
                        array_push($wordList, $word['word']);
                        array_push($image_array, $word['image']);
                    } else {
                        array_push($word_array, $puzzleChars[$i]);
                        array_push($image_array, "");
                        //$generate = false;
                    }
                }

                echo '<table class="table" id="print_table" border="0">';
                for ($i = 0; $i < count($puzzleChars); $i++) {
                    $word_chars = getWordChars($word_array[$i]);
                    $pos = array_search($puzzleChars[$i], $word_chars) + 1;
                    $len = count($word_chars);
                    $image = getImageIfExists($image_array[$i]);
                    $word = $word_array[$i];
                    if ($i === 0) {
                        echo '<tr>';
                    } else if ($i % 4 === 0) {
                        echo '</tr border="0"><tr>';
                    }
                    if (empty($image)) {
                        echo "<td align='center' style='vertical-align:bottom; border-top: none;'><h1> $puzzleChars[$i] </h1>
                          <figcaption class=\"print-figCaption\">" . $pos . '/' . $len . "</figcaption>
                          <div align='center' class='answerDiv'><h3>" . $word . "</h3></div></td>";

                    } else {
                        echo "<td align='center' style='border-top: none; vertical-align: bottom;'><img class=\"print-img\" src=" . $image . " alt =" . $image . ">
                          <figcaption class=\"print-figCaption\">" . $pos . '/' . $len . "</figcaption>
                          <div align='center' class='answerDiv'><h3>" . $word . "</h3></div></td>";
                    }
                }
                echo '</tr>';
                echo '</table></div>';
            }
        }
    }
    ?>


    <script>

        function toggleAnswer() {
            var x = document.getElementsByClassName('answerDiv');
            for(i = 0; i < x.length; i++ ){
                if (x[i].style.display === 'block') {
                    x[i].style.display = 'none';
                } else {
                    x[i].style.display = 'block';
                }
            }
        }

    </script>


</div>
</body>
</html>
