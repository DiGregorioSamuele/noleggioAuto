<!DOCTYPE html>
<html>

<head>
    <title>Inserimento Noleggio</title>
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

    // Recupero dell'ultimo codice_noleggio
    $queryUltimoCodice = "SELECT MAX(codice_noleggio) AS ultimoCodice FROM noleggi";
    $risultatoultimoCodice = mysqli_query($connessione, $queryUltimoCodice);
    $ultimoCodice = mysqli_fetch_assoc($risultatoultimoCodice);
    $idNoleggio = $ultimoCodice['ultimoCodice'] + 1; // Incrementa di 1
    
    // Recupero dei dati dal modulo
    $targa = isset($_GET['targaAuto']) ? mysqli_real_escape_string($connessione, $_GET['targaAuto']) : '';
    $CF = isset($_GET['codiceFiscale']) ? mysqli_real_escape_string($connessione, $_GET['codiceFiscale']) : '';
    $dataInizio = isset($_GET['dataInizio']) ? mysqli_real_escape_string($connessione, $_GET['dataInizio']) : '';
    $dataFine = isset($_GET['dataFine']) ? mysqli_real_escape_string($connessione, $_GET['dataFine']) : '';
    $restituita = 0; // Imposta il valore di default per auto_restituita
    
    // Controllo che tutti i campi siano stati compilati
    if (empty($targa) || empty($CF) || empty($dataInizio) || empty($dataFine)) {
        die("<p>Errore: Tutti i campi sono obbligatori.</p>");
    }

    // Query per inserire il noleggio
    $query = "INSERT INTO noleggi (codice_noleggio, auto, socio, inizio, fine, auto_restituita) 
              VALUES ('$idNoleggio', '$targa', '$CF', '$dataInizio', '$dataFine', '$restituita')";

    if (mysqli_query($connessione, $query)) {
        echo "<h1 class='titoloPagine'>Auto noleggiata con successo</h1>";
        echo "<div class='container'>";
        echo "<h2>Il tuo codice noleggio è: $idNoleggio!</h2>";
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
        echo "</table> <br>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    } else {
        echo "<h1 class='titoloPagine'>Auto disponibili</h1>";
        echo "<div class='container'>";
        echo "<h2> Errore durante l'inserimento del noleggio: " . mysqli_error($connessione) . "</h2>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    }

    // Chiusura connessione
    mysqli_close($connessione);
    ?>
</body>

</html>