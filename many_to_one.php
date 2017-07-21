<!DOCTYPE html>
<html>
<head>
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
</head>
<title>Rebus Many-To-One</title>
<body>
<?PHP
session_start();
require('session_validation.php');
require ('utility_functions.php');
?>
<?PHP echo getTopNav(); ?>
<div class="divTitle">
    <font class="font">Rebus Puzzle (Many To One)</font>
</div>
<br>
<div>
    <form method="get">
        <div class="container">
            <div class="inputDiv"><input type="textbox" name="puzzles" id="name-textbox" placeholder="Enter words separated by a comma to generate multiple puzzles" onclick="this.placeholder = ''"  />
            </div>
            <br>
            <div style="text-align:center">
                <input class="main-buttons" type="submit" value="Show me.." />
            </div>
        </div>
    </form>
</div>

<?php
if (isset($_GET['puzzles'])) {
    $words = validate_input($_GET['puzzles']);
    if ($words == '') {
        echo "<p class= \"fontword\" style=\" color:red;\">You did not enter any words. Please try again.</p>";

    }
    else if (count(explode(',', $words)) < 2) {
        echo "<p class= \"fontword\" style=\" color:red;\">You must enter two or more words separated by a comma. Please try again.</p>";
    }else{
    // Everything is good redirect it to puzzle page
    header("Location: generate_multiple_puzzles.php?puzzles=".$words);
}
}
?>
</body>
</html>
