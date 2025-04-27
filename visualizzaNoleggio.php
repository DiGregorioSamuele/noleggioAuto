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

    if (!$connessione) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    // Recupero delle date e del socio dal modulo
    $dataInizio = mysqli_real_escape_string($connessione, $_GET['dataInizio']);
    $dataFine = mysqli_real_escape_string($connessione, $_GET['dataFine']);
    $socioID = mysqli_real_escape_string($connessione, $_GET['socioID']);

    // Query per trovare i noleggi effettuati dal socio nel periodo
    $query = "
    SELECT n.codice_noleggio, n.inizio, n.fine, a.marca, a.modello
    FROM noleggi n
    JOIN auto a ON n.auto = a.targa
    WHERE n.socio = '$socioID'
      AND n.inizio <= '$dataFine'
      AND n.fine >= '$dataInizio'
";

    $cliente = mysqli_query($connessione, "SELECT nome, cognome FROM soci WHERE CF = '$socioID'");
    if ($cliente) {
        $row = mysqli_fetch_assoc($cliente);
        $nominativo = htmlspecialchars($row['nome'] . " " . $row['cognome']);
    } else {
        echo "<p><strong>Errore nel recupero dei dati del socio.</strong></p>";
        exit;
    }

    $risultato = mysqli_query($connessione, $query);

    if (mysqli_num_rows($risultato) > 0) {
        echo "<h1 class='titoloPagine'>Noleggi effettuati</h1>";
        echo "<div class='container'>";
        echo "<h2>Dettagli Noleggio di $nominativo dal $dataInizio al $dataFine</h2>";
        echo "<table border='2'>";
        echo "<tr>
            <th>Codice Noleggio</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Marca Auto</th>
            <th>Modello Auto</th>
          </tr>";

        while ($row = mysqli_fetch_assoc($risultato)) {
            echo "<tr>";
            echo "<td>{$row['codice_noleggio']}</td>";
            echo "<td>{$row['inizio']}</td>";
            echo "<td>{$row['fine']}</td>";
            echo "<td>{$row['marca']}</td>";
            echo "<td>{$row['modello']}</td>";
            echo "</tr>";
        }

        echo "</table> <br>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";

    } else {
        echo "<h1 class='titoloPagine'>Noleggi effettuati</h1>";
        echo "<div class='container'>";
        echo "<h2>Nessuna noleggio effettuato da '$nominativo ' per il periodo selezionato</h2>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    }

    // Chiudi connessione
    mysqli_close($connessione);
    ?>
</body>

</html>