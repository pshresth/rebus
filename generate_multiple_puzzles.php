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
?>
<?PHP echo getTopNav(); ?>
<div class="container">
    <?php
    if (isset($_GET['puzzles'])) {
        $input = $_GET['puzzles'];
        $puzzles = explode(",", trim($input));
        $wordList = array(); // we will use this to keep track of words being used so no repetition occurs

        foreach ($puzzles as $puzzleWord) {
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
                    array_push($image_array, getImage(""));
                    $generate = false;
                }
            }

            echo '<table class="table" id="print_table" border="0">';
            for ($i = 0; $i < count($puzzleChars); $i++) {
                $word_chars = getWordChars($word_array[$i]);
                $pos = array_search($puzzleChars[$i], $word_chars) + 1;
                $len = count($word_chars);
                $image = getImageIfExists($image_array[$i]);
                if ($i === 0) {
                    echo '<tr>';
                } else if ($i % 4 === 0) {
                    echo '</tr border="0"><tr>';
                }
                if (empty($image)) {
                    echo "<td style='border-top: none;'><h1> $puzzleChars[$i] </h1><figcaption class=\"word_char\">" . $pos . '/' . $len . "</figcaption></td>";

                } else {
                    echo "<td style='border-top: none;'><img class=\"thumbnailSize\" src=" . $image . " alt =" . $image . "><figcaption class=\"word_char\">" . $pos . '/' . $len . "</figcaption></td>";
                    //echo "<tr align='center' style='vertical-align: middle;'>" . $pos . '/' . $len . "</tr></td>";
                }
            }
            echo '</tr>';
            echo '</table>';
        }
    }
    ?>

</div>
</body>
</html>
