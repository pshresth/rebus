<!DOCTYPE html>
<html>
<head>
    <?PHP
    session_start();
    require('session_validation.php')
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
    <link rel="stylesheet" href="styles/about_page.css" type="text/css">
</head>
<title>About Rebus</title>

<body>
<?PHP
//session_start();
echo getTopNav();
?>
<br>

<div class="container" style="background-color: #f9f9f9;">
    <div>
        <h1 align="center">Rebus Puzzle: User Manual</h1>
    </div>
    <br>
    <div>
        <h4><p>Rebus is a picture and words based puzzle. Upon entering a word on the home input menu, the system
                generates a puzzle based on the word entered by the user. Each image shown on the puzzle contains the
                corresponding letter and it's position of the word that the user has to guess.</p></h4>
        <div>
            <h3>Admin Settings:</h3>
            <ol>
                <br><li class="aboutPageText">
                    Add Word: This page can be used to add new pair of words to the database.
                    Users can select an Image along with the words but it is not mandatory.
                    Images can be added later through <b>Word List</b> option as well.
                </li><br>

                <br><li class="aboutPageText">
                    Word List: This page can be used to view all the available words, english words and corresponding
                    images that are available in the database. Options to search and sort the words is available
                    along with page size configuration. Additionally, Words and Images can be edited and/or deleted
                    as well.
                </li><br>

                <br><li class="aboutPageText">
                    Users: This page can be used to add and delete admin users from the system.
                </li><br>

                <br><li class="aboutPageText">
                    Export: This button can be used to export all the data from tables in the database into an excel file. The
                    file will be downloaded to the folder specified in your browser.
                </li><br>

                <br> <li class="aboutPageText">
                    Import: This page can be used to import an excel file into the database.
                    <i><b>Caution:</b></i> Importing a new excel file will clear out all the data from your existing database
                    and replace it with the content of the imported excel file.
                </li><br>


                <br><li class="aboutPageText">Configure:</li><br>

                <br><li class="aboutPageText">
                    Backup: This button can be used to back up your database into the <i>SQL_FILES</i> folder on your domain host.
                    <i><b>Note:</b></i> The file will get saved in <i>.sql</i> format. Any number of backups within 24 hours
                    will be replaced with the latest version. However, new files are generated once everyday.
                </li><br>

                <br><li class="aboutPageText">Report:</li><br>

                <br><li class="aboutPageText">One Word Many Puzzle:</li><br>

                <br><li class="aboutPageText">Many Words One Puzzle:</li><br>

                <br><li class="aboutPageText">One Word Many Puzzle Plus:</li><br>
            </ol>

        </div>
        <div>
            <p style="float: right;">
                Designer, Instructor and System Administrator: <i>Mr. Siva R. Jasthi</i><br>
                Developed By: <i>Prashant Shrestha</i><br>
                <b><i>Capstone Project - Summer 2017</i></b><br></p>
        </div>


    </div>
</div>

</body>

</html>