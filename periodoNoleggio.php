<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleziona Periodo</title>
    <script>
        function validaData(event) {
            const dataInizio = document.getElementById('dataInizio').value;
            const dataFine = document.getElementById('dataFine').value;

            if (dataInizio > dataFine) {
                event.preventDefault(); // Impedisce l'invio del modulo
                alert("La data di inizio non può essere successiva alla data di fine.");
            }
        }
    </script>
</head>

<body>
    <h1 class="titoloPagine">Seleziona il periodo di noleggio</h1>
    <div class="container">
        <form action="http://localhost/noleggioAuto/visualizzaNoleggio.php" method="GET" onsubmit="validaData(event)">
            <label for="socioID">Seleziona Socio:</label>
            <select id="socioID" name="socioID" required>
                <?php
                // Connessione al database
                $connessione = mysqli_connect("localhost", "root", "", "noleggioAuto");

                // Controllo connessione
                if (!$connessione) {
                    die("Connessione al database fallita: " . mysqli_connect_error());
                }

                // Query per ottenere i codici fiscali dei soci
                $query = "SELECT CF, nome, cognome FROM soci";
                $risultato = mysqli_query($connessione, $query);

                // Popolamento del menu a tendina
                if ($risultato && mysqli_num_rows($risultato) > 0) {
                    while ($row = mysqli_fetch_assoc($risultato)) {
                        $cf = htmlspecialchars($row['CF']);
                        $nome = htmlspecialchars($row['nome']);
                        $cognome = htmlspecialchars($row['cognome']);
                        echo "<option value='$cf'>$cf - $cognome $nome</option>";
                    }
                } else {
                    echo "<option value=''>Nessun socio disponibile</option>";
                }

                // Chiusura connessione
                mysqli_close($connessione);
                ?>
            </select>
            <br><br>
            <label for="dataInizio">Data Inizio:</label>
            <input type="date" id="dataInizio" name="dataInizio" required>
            <br><br>
            <label for="dataFine">Data Fine:</label>
            <input type="date" id="dataFine" name="dataFine" required>
            <br><br>
            <button type="submit">Visualizza Noleggio</button>
        </form>
    </div>
</body>

</html>