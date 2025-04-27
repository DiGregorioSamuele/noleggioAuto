<!DOCTYPE html>
<html>

<head>
    <title>Calcola Prezzo Noleggio</title>
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

    $codiceNoleggio = $_GET['codiceNoleggio'];
    $dataRestituzione = new DateTime($_GET['dataRestituzione']);
    $descrizione = htmlspecialchars($_GET['descrizione']);

    // Query per ottenere i dettagli del noleggio
    $query = "SELECT n.codice_noleggio, n.inizio, n.fine, a.targa, a.marca, a.modello, a.costo_giornaliero
              FROM noleggi n
              JOIN auto a ON n.auto = a.targa
              WHERE n.codice_noleggio = '$codiceNoleggio'
              ORDER BY n.codice_noleggio";

    $risultato = mysqli_query($connessione, $query);

    // Aggiorna lo stato dell'auto come restituita
    $aggiornaRestituzione = "UPDATE noleggi SET auto_restituita = 1 WHERE codice_noleggio = '$codiceNoleggio'";
    mysqli_query($connessione, $aggiornaRestituzione);

    if (mysqli_num_rows($risultato) != 0) {
        echo "<h1 class='titoloPagine'>Calcolo Noleggio</h1>";
        echo "<div class='container' style='max-width: 1300px; margin: 0 auto;'>";
        echo "<h2>Resoconto del noleggio: $codiceNoleggio</h2>";
        echo "<table border='2'>";
        echo "<tr>
                <th>Codice Noleggio</th>
                <th>Auto</th>
                <th>Data Inizio</th>
                <th>Data Fine</th>
                <th>Data Restituzione</th>
                <th>Giorni</th>
                <th>Costo Giornaliero</th>
                <th>Prezzo Totale</th>
                <th>Descrizione</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($risultato)) {
            $dataInizio = new DateTime($row['inizio']);
            $dataFine = new DateTime($row['fine']);
            $giorni = 0;
            $prezzoNoleggio = 0;

            // Calcolo del prezzo
            if ($dataRestituzione > $dataFine) {
                $giorni = $dataFine->diff($dataInizio)->days + 1;
                $prezzoNoleggio = $giorni * $row['costo_giornaliero'];
                $giorniExtra = $dataRestituzione->diff($dataFine)->days;
                $prezzoNoleggio += $giorniExtra * ($row['costo_giornaliero'] * 1.5);
                $giorni += $giorniExtra;
            } elseif ($dataRestituzione < $dataFine) {
                $giorni = $dataRestituzione->diff($dataInizio)->days + 1;
                $prezzoNoleggio = $giorni * $row['costo_giornaliero'];
            } else {
                $giorni = $dataFine->diff($dataInizio)->days + 1;
                $prezzoNoleggio = $giorni * $row['costo_giornaliero'];
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['codice_noleggio']) . "</td>";
            echo "<td>" . htmlspecialchars($row['marca'] . " " . $row['modello']) . "</td>";
            echo "<td>" . htmlspecialchars($row['inizio']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fine']) . "</td>";
            echo "<td>" . htmlspecialchars($dataRestituzione->format('Y-m-d')) . "</td>";
            echo "<td>" . htmlspecialchars($giorni) . "</td>";
            echo "<td>€ " . number_format($row['costo_giornaliero'], 2) . "</td>";
            echo "<td>€ " . number_format($prezzoNoleggio, 2) . "</td>";
            echo "<td>" . htmlspecialchars($descrizione) . "</td>";
            echo "</tr>";
        }

        echo "</table> <br>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    } else {
        echo "<h1 class='titoloPagine'>Calcolo Noleggio</h1>";
        echo "<div class='container'>";
        echo "<h2>Nessun noleggio trovato</h2>";
        echo "<a href='menu.html' class='btn'>Torna al menu</a>";
        echo "</div>";
    }

    // Chiusura connessione
    mysqli_close($connessione);
    ?>
</body>

</html>