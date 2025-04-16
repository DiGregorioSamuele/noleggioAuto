<!-- filepath: c:\wamp64\www\noleggioAuto\inserisciNoleggio.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Inserimento Noleggio</title>
</head>
<body>
    <?php
    // Connessione al database
    $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

    // Controllo connessione
    if (!$connection) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    // Recupero dell'ultimo codice_noleggio
    $queryUltimoCodice = "SELECT MAX(codice_noleggio) AS ultimoCodice FROM noleggi";
    $resultUltimoCodice = mysqli_query($connection, $queryUltimoCodice);
    $rowUltimoCodice = mysqli_fetch_assoc($resultUltimoCodice);
    $idNoleggio = $rowUltimoCodice['ultimoCodice'] + 1; // Incrementa di 1

    // Recupero dei dati dal modulo
    $targa = isset($_GET['targaAuto']) ? mysqli_real_escape_string($connection, $_GET['targaAuto']) : '';
    $CF = isset($_GET['codiceFiscale']) ? mysqli_real_escape_string($connection, $_GET['codiceFiscale']) : '';
    $dataInizio = isset($_GET['dataInizio']) ? mysqli_real_escape_string($connection, $_GET['dataInizio']) : '';
    $dataFine = isset($_GET['dataFine']) ? mysqli_real_escape_string($connection, $_GET['dataFine']) : '';
    $restituita = 0; // Se la checkbox è selezionata, restituita = 1, altrimenti 0

    // Controllo che tutti i campi siano stati compilati
    if (empty($targa) || empty($CF) || empty($dataInizio) || empty($dataFine)) {
        die("<p>Errore: Tutti i campi sono obbligatori.</p>");
    }

    // Query per inserire il noleggio
    $query = "INSERT INTO noleggi (codice_noleggio, auto, socio, inizio, fine, auto_restituita) 
              VALUES ('$idNoleggio', '$targa', '$CF', '$dataInizio', '$dataFine', '$restituita')";

    if (mysqli_query($connection, $query)) {
        echo "<p>Auto noleggiata con successo, il tuo codice noleggio è: $idNoleggio!</p>";
        echo "<table border='2'>";
        echo "<tr>";
        echo "<th>Codice Noleggio</th>";
        echo "<th>Targa</th>";
        echo "<th>Codice Fiscale</th>";
        echo "<th>Data Inizio</th>";
        echo "<th>Data Fine</th>";
        echo "<th>Restituita</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>$idNoleggio</td>";
        echo "<td>$targa</td>";
        echo "<td>$CF</td>";
        echo "<td>$dataInizio</td>";
        echo "<td>$dataFine</td>";
        echo "<td>" . ($restituita ? "Sì" : "No") . "</td>";
        echo "</tr>";
        echo "</table>";
    } else {
        echo "<p>Errore durante l'inserimento del noleggio: " . mysqli_error($connection) . "</p>";
    }

    // Chiusura connessione
    mysqli_close($connection);
    ?>
</body>
<a href="menu.html">Torna alla home</a>
</html>