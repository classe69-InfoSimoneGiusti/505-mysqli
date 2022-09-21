<?php

define("DB_SERVERNAME", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "university");

$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn && $conn->connect_error) {
    echo "Connessione fallita: " . $conn->connect_error;
    die();
}


if (isset($_GET['name'])) {

    $name = $_GET['name'];  //Antonio 
    // ' OR '1' = '1    => // SELECT * FROM `students` WHERE name = '' OR '1' = '1'
    $sql = "SELECT * FROM `students` WHERE name = '" . $name . "'"; // SELECT * FROM `students` WHERE name = 'Antonio' 

} else {
    $sql = 'SELECT * FROM `students`';
}


$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>!! SQL INJECTION !!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
    
    <main>
        <div class="container">

        <form action="" method="GET">
            <div class="mb-3">
                <label for="name" class="form-label">Filtra per nome</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <button type="submit" class="btn btn-primary">CERCA</button>
        </form>

        <hr>

        <?php
            if ($result && $result->num_rows > 0) {
            ?>
                <ul>
                    <?php 
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>" . $row['name'] . ' ' . $row['surname'] . '</li>'; 
                        }
                    ?>
                </ul>
            <?php
            } elseif ($result) {
                ?>
                    <div class="alert alert-primary">
                        Nessun risultato trovato
                    </div>
                <?php
            } else {
                ?>
                    <div class="alert alert-warning">
                        Errore nella query
                    </div>
                <?php
            }
        ?>

            

        </div>
    </main>

</body>
</html>


<?php
    $conn->close();
?>