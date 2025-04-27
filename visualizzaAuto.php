<!DOCTYPE html>
<html>

<head>
    <title>Auto Disponibili</title>
    <link rel="stylesheet" href="stile.css" />
</head>

<body>
    <?php
    // Connessione al database
    $connessione = mysqli_connect("localhost", "root", "", "noleggioAuto");

    // Controllo connessione
    if (!$connessione) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    // Recupero delle date dal modulo
    $dataInizio = $_GET['dataInizio'];
    $dataFine = $_GET['dataFine'];

    // Query per trovare le auto disponibili
    $query = "
        SELECT a.targa, a.modello, a.marca
        FROM auto a
        WHERE a.targa NOT IN (
            SELECT n.auto
            FROM noleggi n
            WHERE (n.inizio <= '$dataInizio' AND n.fine >= '$dataInizio')
               OR (n.inizio <= '$dataFine' AND n.fine >= '$dataFine')
               OR (n.inizio >= '$dataInizio' AND n.fine <= '$dataFine')
        )
    ";

    $risultato = mysqli_query($connessione, $query);

    // Visualizzazione delle auto disponibili
    if (mysqli_num_rows($risultato) != 0) {
        echo "<h1 class='titoloPagine'>Auto disponibili</h1>";
        echo "<div class='container'>";
        echo "<h2>Dal $dataInizio al $dataFine</h2>";
        echo "<table border='2'>";
        echo "<tr>";
        echo "<th>Targa</th>";
        echo "<th>Marca</th>";
        echo "<th>Modello</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_array($risultato)) {
            echo "<tr>";
            echo "<td>$row[targa]</td>";
            echo "<td>$row[marca]</td>";
            echo "<td>$row[modello]</td>";
            echo "</tr>";
        }
        echo "</table> <br>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    } else {
        echo "<h1 class='titoloPagine'>Auto disponibili</h1>";
        echo "<div class='container'>";
        echo "<h2>Nessuna auto disponibile per il periodo selezionato</h2>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    }

    // Chiusura connessione
    mysqli_close($connessione);
    ?>
</body>

</html>