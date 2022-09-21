<?php

define("DB_SERVERNAME", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "guestbook");

$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn && $conn->connect_error) {
    echo "Connessione fallita: " . $conn->connect_error;
    die();
}

if (isset($_POST['name']) && isset($_POST['content'])) {
    $name = $_POST['name'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO `messages` (`id`, `name`, `content`) VALUES (NULL, ?, ?)");
    $stmt->bind_param("ss", $name, $content);
    $stmt->execute();
}


$stmt = $conn->prepare("SELECT * FROM `messages`");
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>!! XSS !!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
    
    <main>
        <div class="container">

        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Inserisci il tuo nome</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Inserisci il tuo messaggio</label>
                <textarea class="form-control" id="content" name="content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Invia commento</button>
        </form>

        <hr>

        <h1>GuestBook Classe 69</h1>

        <?php
            if ($result && $result->num_rows > 0) {
            ?>
                <?php 
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<h3>" . htmlspecialchars($row['name']) . '</h3>'; 
                        echo "<p>" . htmlspecialchars($row['content']) . '</p>'; 
                        echo "</div>";
                    }
                ?>
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