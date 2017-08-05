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
require('utility_functions.php');
?>
<?PHP echo getTopNav(); ?>
<div class="container">
    <?php
    if (isset($_POST['max'])) { // this is for one to many puzzle which provides a MAX_COUNT
        $maxProvided = true;
        $max = $_POST['max'];
    } else { // this is for one to many
        $maxProvided = false;
    }
    if (isset($_POST['puzzle'])) {
        $input = preg_replace("/\r\n/", ",", validate_input($_POST['puzzle']));
        // Verify the input value provided meets our requirements
        if ($input == '') {
            // If input is empty, go back to one_to_many page
            echo '<script type="text/javascript">alert("You did not enter any words. Please try again!"); ';
            if ($maxProvided) {
                echo 'window.location.href = "one_to_many_plus.php"</script>';
            } else {
                echo 'window.location.href = "one_to_many.php"</script>';
            }
        } else if (count(explode(",", trim($input))) > 1) {
            // If input contains more than one words, go back to previous page
            echo '<script type="text/javascript">alert("You can only enter one word. Please try again"); ';
            if ($maxProvided) {
                echo 'window.location.href = "one_to_many_plus.php"</script>';
            } else {
                echo 'window.location.href = "one_to_many.php"</script>';
            }
        } else {
            // Display preferences
            echo '<div id="displayPreferences">';
            echo '<input type="radio" name="showImage" value="Show Images" checked onclick="toggleImage()" /><label>Show Images</label>';
            echo '<input type="radio" style="margin-left:15px;" name="showImage" value="Mask Images" onclick="toggleImage()" /><label>Mask Images</label>';
            echo '<input type="radio" style="margin-left:15px;" name="showImage" value="Show Numbers Only" onclick="toggleImage()" /><label>Show Numbers Only</label>';
            echo '<input type="radio" style="margin-left:15px;" name="showImage" value="Mask Letters Only" onclick="toggleImage()" /><label>Show Letters Only</label>';
            echo '</div>';

            echo '<div id="answerPreferences">';
            echo '<input type="radio" name="showAnswers" value="Do Not Show Answers" checked onclick="toggleAnswer()" /><label>Do Not Show Answers</label>';
            echo '<input type="radio" style="margin-left:15px;" name="showAnswers" value="Show Answers Below the Image" onclick="toggleAnswer()" /><label>Show Answers Below the Image</label>';
            echo '<input type="radio" style="margin-left:15px;" name="showAnswers" value="Show Answers At the end of the page" onclick="toggleAnswer()" /><label>Show Answers At the end of the page</label>';
            echo '</div>';

//            echo '<div id="imagePreferences">';
//            echo '<input type="radio" name="imageSize" value="Do Not Show Answers" checked onclick="toggleAnswer()" /><label>Do Not Show Answers</label>';
//            echo '<input type="radio" style="margin-left:15px;" name="showAnswers" value="Show Answers Below the Image" onclick="toggleAnswer()" /><label>Show Answers Below the Image</label>';
//            echo '<input type="radio" style="margin-left:15px;" name="showAnswers" value="Show Answers At the end of the page" onclick="toggleAnswer()" /><label>Show Answers At the end of the page</label>';
//            echo '</div>';

            echo '<div id="rowSizePreference">';
            echo '<h5>Number of words per row: <input type="number" name="rowSize" min="3" max = "10" value="4"/> Range is from 3 to 10</h5>';
            echo '</div>';

            //echo '<h3 style="color:green;"><input type="checkbox" name="answer" onclick="toggleAnswer()">Show Answer</h3>';


            $rowSize;
            // Display the puzzles generated for given word
            $puzzles = explode(",", trim($input));
            $wordList = array(); // we will use this to keep track of words being used so no repetition occurs
            $allAnswers = "";
            foreach ($puzzles as $puzzleWord) {
                echo '<div class="container"><h1 style="color:red;">Find the words for "' . $puzzleWord . '"</h1>';
                $puzzleChars = getWordChars($puzzleWord);
                $generate = true;
                $counter = 0;
                $allAnswers .= "<h1>Answers for ".$puzzleWord.": </h1>";
                while ($generate) {
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
                            if (!$maxProvided) {
                                $generate = false;
                                //  break;
                            }
                        }
                    }

                    //if ($generate) {
                    $counter++;
                    $allAnswers .="<h2>Puzzle #".$counter."</h2>";
                    echo '<h1>Puzzle #' . $counter . '</h1>';
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
                            echo "<td align='center' style='border-top: none; vertical-align: bottom;'>
                              <h1 class='char'> $puzzleChars[$i] </h1>
                              <figcaption class=\"print-figCaption\">" . $pos . '/' . $len . "</figcaption>
                            <div align='center' class='answerDiv'><h3>" . $word . "</h3></div></td>";
                        } else {
                            echo "<td align='center' style='border-top: none; vertical-align: bottom;'>
                              <h1 class='letters' style='display:none;'> $puzzleChars[$i] </h1>
                              <div class='maskImage'><img class=\"print-img\" src=" . $image . " alt =" . $image . "></div>
                              <figcaption class=\"print-figCaption\">" . $pos . '/' . $len . "</figcaption>
                            <div align='center' class='answerDiv'><h3>" . $word . "</h3></div></td>";
                        }
                        $allAnswers .= "<h5>".$word."</h5>";
                    }
                    echo '</tr>';
                    echo '</table>';
                    //  }
                    if ($maxProvided) {
                        // only display max count number of puzzles
                        if ($counter == $max) {
                            $generate = false;
                        }
                    }
                }

            }
          //  $allAnswers = preg_replace("</td>","",$allAnswers);
           // echo $allAnswers;
            echo '<div name="allAnswers" style="display:none"><h3>'.$allAnswers.'</h3></div>';
        }
    }
    ?>

    <script>
        function toggleImage() {
            var show = document.getElementsByName('showImage');
            var images = document.getElementsByClassName('print-img');
            var letters = document.getElementsByClassName('letters');
            var chars = document.getElementsByClassName('chars');
            var masks = document.getElementsByClassName('maskImage');

            if (show[1].checked) {
                for (i = 0; i < images.length; i++) {
                    images[i].style.display = 'none';
                }
                for (i = 0; i < masks.length; i++) {
                    masks[i].style.display = 'block';
                }
                for (i = 0; i < chars.length; i++) {
                    chars[i].style.display = 'none';
                }
                for (i = 0; i < letters.length; i++) {
                    letters[i].style.display = 'none';
                }
            } else if (show[2].checked) {
                for (i = 0; i < images.length; i++) {
                    images[i].style.display = 'none';
                }
                for (i = 0; i < masks.length; i++) {
                    masks[i].style.display = 'none';
                }
                for (i = 0; i < chars.length; i++) {
                    chars[i].style.display = 'none';
                }
                for (i = 0; i < letters.length; i++) {
                    letters[i].style.display = 'none';
                }
            } else if (show[3].checked) {
                for (i = 0; i < images.length; i++) {
                    images[i].style.display = 'none';
                }
                for (i = 0; i < masks.length; i++) {
                    masks[i].style.display = 'none';
                }
                for (i = 0; i < chars.length; i++) {
                    chars[i].style.display = 'block';
                }
                for (i = 0; i < letters.length; i++) {
                    letters[i].style.display = 'block';
                }
            } else {
                for (i = 0; i < images.length; i++) {
                    images[i].style.display = 'block';
                }
                for (i = 0; i < masks.length; i++) {
                    masks[i].style.display = 'block';
                }
                for (i = 0; i < chars.length; i++) {
                    chars[i].style.display = 'block';
                }
                for (i = 0; i < letters.length; i++) {
                    letters[i].style.display = 'none';
                }
            }
        }

        function toggleAnswer() {
            var options = document.getElementsByName('showAnswers');
            var x = document.getElementsByClassName('answerDiv');
            var allAnswers = document.getElementsByName("allAnswers");
            if (options[1].checked) {
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = 'block';
                }
                allAnswers[0].style.display = 'none';
            } else if(options[2].checked) {
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = 'none';
                }
                allAnswers[0].style.display = 'block';
            } else {
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = 'none';
                }
                allAnswers[0].style.display = 'none';
            }
        }

    </script>

</div>
</body>
</html>
