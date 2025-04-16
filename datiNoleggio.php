<!-- filepath: c:\wamp64\www\noleggioAuto\datiNoleggio.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inserisci i dati del noleggio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
    <h1>Inserisci i dati del noleggio</h1>
    <form action="http://localhost/noleggioAuto/inserisciNoleggio.php" method="get">
        <label for="idNoleggio">Auto disponibili per il periodo selezionato:</label><br>
        <select id="targaAuto" name="targaAuto" required>
        <?php
        // Connessione al database
        $connection = mysqli_connect("localhost", "root", "", "noleggioAuto");

        // Controllo connessione
        if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
        }

        // Recupero delle date dal modulo
        $dataInizio = mysqli_real_escape_string($connection, $_GET['dataInizio']);
        $dataFine = mysqli_real_escape_string($connection, $_GET['dataFine']);

        // Query per ottenere le auto disponibili nel periodo selezionato
        $query = "
            SELECT DISTINCT a.targa, a.modello, a.marca
            FROM auto a
            WHERE a.targa NOT IN (
                SELECT n.auto
                FROM noleggi n
                WHERE ('$dataInizio' BETWEEN n.inizio AND n.fine)
                   OR ('$dataFine' BETWEEN n.inizio AND n.fine)
                   OR (n.inizio BETWEEN '$dataInizio' AND '$dataFine')
                   OR (n.fine BETWEEN '$dataInizio' AND '$dataFine')
            )
        ";
        $result = mysqli_query($connection, $query);

        // Popolamento del menu a tendina
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $targa = htmlspecialchars($row['targa']);
                $modello = htmlspecialchars($row['modello']);
                $marca = htmlspecialchars($row['marca']);
                echo "<option value='$targa'>$targa - $marca $modello</option>";
            }
        } else {
            echo "<option value=''>Nessuna auto disponibile</option>";
        }

        // Chiusura connessione
        mysqli_close($connection);
        ?>
    </select><br><br>

    <label for="codiceFiscale">Codice Fiscale Socio:</label><br>
    <input type="text" id="codiceFiscale" name="codiceFiscale" required><br><br>

    <label for="dataInizio">Data Inizio:</label><br>
    <input type="text" id="dataInizio" name="dataInizio" value="<?php echo htmlspecialchars($_GET['dataInizio']); ?>" readonly><br><br>

    <label for="dataFine">Data Fine:</label><br>
    <input type="text" id="dataFine" name="dataFine" value="<?php echo htmlspecialchars($_GET['dataFine']); ?>" readonly><br><br>

    <input type="submit" value="Inserisci noleggio">
    </form>
</body>
</html>