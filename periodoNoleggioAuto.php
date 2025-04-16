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
    <form action="http://localhost/noleggioAuto/datiNoleggio.php" method="get">
        <label for="dataInizio">Data Inizio:</label><br>
        <input type="date" id="dataInizio" name="dataInizio" required><br><br>

        <label for="dataFine">Data Fine:</label><br>
        <input type="date" id="dataFine" name="dataFine" required><br><br>

        <input type="submit" value="Inserisci Dati Noleggio">
    </form>
</body>
</html>