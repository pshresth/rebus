<?php include 'navbar.php';



// Start session to store variables

if(!isset($_SESSION))

{

    session_start();

}

// Allows user to return 'back' to this page

ini_set('session.cache_limiter','public');

session_cache_limiter(false);



?>

<!DOCTYPE html>

<html>

<head>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet"/>

</head>

<body class="body_background">

<div id="wrap">

    <div class="container">

        <h3>List View</h3>

        <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">

            <thead>

            <tr>

                <th>Title</th>

                <th>Category</th>

                <th>Subcategory</th>

                <th>Created On</th>

                <th>Actions</th>

            </tr>

            </thead>

            <tbody>





            <?php

            require 'db_configuration.php';



            // Establishing Connection with Server

            $servername = DATABASE_HOST;

            $db_username = DATABASE_USER;

            $db_password = DATABASE_PASSWORD;

            $database = DATABASE_DATABASE;



            // Create connection

            $conn = new mysqli($servername, $db_username, $db_password, $database);



            // Check connection

            if ($conn->connect_error) {

                die("Connection failed: " . $conn->connect_error);

            }

            // echo "Connected successfully<br>";

            $conn->set_charset("utf8");



            //$order = isset($_GET['sort'])?$_GET['sort']:'bookmark_date';

            $sql = "SELECT * FROM bookmarks";

            $result = $conn->query($sql);



            if ($result->num_rows > 0) {

//    echo "<table><tr><th><a href='view.php?sort=bookmark_title'>Title</a></th><th><a href='view.php?sort=bookmark_category'>Category</a></th><th><a href='view.php?sort=bookmark_subcategory'>Subcategory</a></th><th><a href='view.php?sort=bookmark_date'>Date</a></th></tr>";

                // output data of each

                while($row = $result->fetch_assoc()) {

                    echo '<tr><td><a href="'.$row['bookmark_url'].'">'.$row['bookmark_title'].'</a></td>

                        <td>'.$row["bookmark_category"]."</td>
                
                        <td>".$row["bookmark_subcategory"]."</td>
                
                        <td>".$row["bookmark_date"]."</td>
                
                        <td>".$row["bookmark_date"]."</td></tr>";

                }







            } else {

                echo "0 results";

            }

            $conn->close();

            ?>

            </tbody>

            <tfoot>

            <tr>

                <th>Title</th>

                <th>Category</th>

                <th>Subcategory</th>

                <th>Created On</th>

                <th>Actions</th>

            </tr>

            </tfoot>

        </table>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#info').DataTable();

    });

</script>

</body>

</html>

