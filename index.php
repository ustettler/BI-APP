<?php

// Include the credentials
require_once('./credentials.php');

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// SQL-Abfrage für die Tabelle "stats"
$sql_stats = "SELECT * FROM stats";
$result_stats = $conn->query($sql_stats);

// SQL-Abfrage für die Tabelle "bills"
$sql_bills = "SELECT * FROM bills";
$result_bills = $conn->query($sql_bills);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
   
    <title>BI Admin Panel</title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
              <!--  PHP als komponennten einfüegn -->
            <h1><?php
    include './componenten/Logo.php';
            ?>
        </h1>
        </div>
        <ul>
            <li> <span>Dashboard</span> </li>
            <li><span>Statistik</span> </li>
            <li><span>Profil</span> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                   <!--  <button type="submit"></button> -->
                </div>
                <div class="user">
                    <a href="#" class="btn">Neu</a>
                    <div class="img-case">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                <div class="box">
                        <?php
                        // SQL-Abfrage zum Abrufen von Daten
                        $sql = "SELECT today FROM stats";
                        $result = $conn->query($sql);

                        // Überprüfen, ob Datensätze vorhanden sind
                        if ($result->num_rows > 0) {
                            // Ausgabe der Daten in einer HTML-Box
                            while($row = $result->fetch_assoc()) {
                                echo "<span id='kwh' style='font-size: 36px; font-weight: bold; color: green;'>" . $row["today"] . "</span> kW/h";
                            }
                        } else {
                            echo "Keine Daten gefunden";
                        }
                        ?>
                        <h3>Heute</h3>
                    </div>
                    <div class="icon-case">
                    </div>
                </div>

                <div class="card">
                    <div class="box">
                    <?php
                    // SQL-Abfrage zum Abrufen von Daten
                        $sql = "SELECT week FROM stats";
                        $result = $conn->query($sql);

                        // Überprüfen, ob Datensätze vorhanden sind
                        if ($result->num_rows > 0) {
                            // Ausgabe der Daten in einer HTML-Box
                            while($row = $result->fetch_assoc()) {
                                echo "<span id='kwh-week' style='font-size: 36px; font-weight: bold; color: green;'>" . $row["week"] . "</span> kW/h"; 
                            }
                        } else {
                            echo "Keine Daten gefunden..";
                        }

    
                        ?>
                        <h3>Diese Woche</h3>
                    </div>
                    <div class="icon-case">
                    </div>
                </div>

                <div class="card">
                    <div class="box">
                    <?php
                    // SQL-Abfrage zum Abrufen von Daten
                        $sql = "SELECT year FROM stats";
                        $result = $conn->query($sql);

                        // Überprüfen, ob Datensätze vorhanden sind
                        if ($result->num_rows > 0) {
                            // Ausgabe der Daten in einer HTML-Box
                            while($row = $result->fetch_assoc()) {
                                echo "<span id='kwh-year' style='font-size: 36px; font-weight: bold; color: green;'>" . $row["year"] . "</span> kW/h";// Daten aus der Spalte "week" in kW/h
                            }
                        } else {
                            echo "Keine Daten gefunden..";
                        }
                        ?>
                        <h3>Dieses Jahr</h3>
                    </div>
                    <div class="icon-case">
                    </div>
                </div>


                <div class="card">
                    <div class="box">    
                    <?php
                        // SQL-Abfrage zum Abrufen von Daten
                        $sql = "SELECT alll FROM stats";
                        $result = $conn->query($sql);

                        // Überprüfen, ob Datensätze vorhanden sind
                        if ($result->num_rows > 0) {
                            // Ausgabe der Daten in einer HTML-Box
                            while($row = $result->fetch_assoc()) { 
                                echo "<span id='kwh-all' style='font-size: 36px; font-weight: bold; color: green;'>" . $row["alll"] . "</span> kW/h";
                            }
                        } else {
                            echo "Keine Daten gefunden..";
                        }

                        // Verbindung schließen
                        $conn->close();
                        ?>
                        <h3>Von anfang</h3>
                    </div>
                    <div class="icon-case">
                    </div>
                </div>
            </div>

            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Berechnung</h2>
                        <a href="#" class="btn">Alles anschauen</a>
                    </div>
                    <table>
                          
                    <tr>
            <th>Periode</th>
            <th>Kw/h</th>
            <th>Betrag</th>
            <th>Datenblatt</th>
        </tr>
        <?php
        // Überprüfen, ob Datensätze vorhanden sind
        if ($result_bills->num_rows > 0) {
            // Ausgabe der Daten in jeder Zeile der Tabelle
            while($row = $result_bills->fetch_assoc()) {
                echo "<tr>";
                // Ausgabe der Rechnungsdaten
                echo "<td>" . $row["periode"] . "</td>";
                echo "<td>" . $row["total_kwh"] . "</td>";
                echo "<td>" . $row["money"] . " CHF</td>";
                echo "<td><a href='generate_pdf.php?periode=" . $row["periode"] . "&total_kwh=" . $row["total_kwh"] . "&money=" . $row["money"] . "' class='btn' target='_blank'>PDF generieren</a></td>";
                echo "</tr>";
            }
        } else {
            echo "Keine Rechnungsdaten gefunden";
        }
        ?>
                        
                    </table>
                </div>
                <div class="statss">
                    <div class="title">
                        <h2>Statistik</h2>
                        <a href="#" class="btn">Alles anschauen</a>
                    </div>
                    <table>
                        <!--  
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>option</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>John Steve Doe</td>
                            <td></td>
                        </tr>
                        <tr>
                        -->

                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>