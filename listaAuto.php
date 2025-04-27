<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Auto in vetrina</title>
    <link rel="stylesheet" href="stile.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .slider-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .auto-card {
            background-color: #ffffff;
            width: 300px;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .auto-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .auto-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .auto-card h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #1e3a8a;
        }

        .auto-card p {
            margin: 10px 0;
            font-size: 1rem;
            color: #333;
        }

        .auto-card p strong {
            color: #1e40af;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background-color: #1e40af;
            color: white;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <?php
    // Connessione al database
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "noleggioauto";

    $connessione = new mysqli($host, $user, $password, $database);
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Query per ottenere i dettagli delle auto
    $sql = "SELECT modello, marca, targa, costo_giornaliero FROM auto";
    $risultato = $connessione->query($sql);

    // Array per associare le targhe ai percorsi delle immagini
    $immagini = [
        "AB123CD" => "images/fiat.png",
        "EF456GH" => "images/ford.png",
        "IJ789KL" => "images/volkswagen.png",
        "MN012OP" => "images/toyota.png",
        "QR345ST" => "images/renault.jpg",
        "UV678WX" => "images/peugeot.jpg",
        "YZ901AB" => "images/bmw.jpg",
        "CD234EF" => "images/audi.png",
        "GH567IJ" => "images/hyundai.jpg",
        "KL890MN" => "images/kia.jpg",

        // Aggiungi altre targhe e percorsi immagine qui
    ];

    $immaginePredefinita = "images/default.jpg"; // Immagine predefinita se la targa non è nell'array
    ?>

    <h1 class="titoloPagine">Auto Noleggio</h1>
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div class="slider-container">

            <?php
            if ($risultato && $risultato->num_rows > 0) {
                while ($row = $risultato->fetch_assoc()) {
                    $modello = htmlspecialchars($row["modello"]);
                    $marca = htmlspecialchars($row["marca"]);
                    $targa = htmlspecialchars($row["targa"]);
                    $costo = htmlspecialchars($row["costo_giornaliero"]);

                    // Ottieni il percorso immagine dalla targa
                    $imgPath = isset($immagini[$targa]) ? $immagini[$targa] : $immaginePredefinita;

                    echo "
                <div class='auto-card'>
                    <img src='$imgPath' alt='Auto $marca $modello'>
                    <h3>$marca $modello</h3>
                    <p><strong>Targa:</strong> $targa</p>
                    <p><strong>Costo:</strong> €$costo/giorno</p>
                </div>
                ";
                }
            } else {
                echo "<p style='text-align:center;'>Nessuna auto trovata.</p>";
            }

            $connessione->close();
            ?>
        </div>
        <a href="menu.html" class="btn">Torna al menu</a>
    </div>
</body>

</html>