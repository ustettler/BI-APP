<?php
// your_script.php

// Include the credentials
require_once('./credentials.php');

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);
$sql = "SELECT * FROM stats";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
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
                                echo "<h1>" . $row["today"] . " kW/h</h1>"; // Daten aus der Spalte "today" in kW/h
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
                                echo "<h1>" . $row["week"] . " kW/h</h1>"; // Daten aus der Spalte "week" in kW/h
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
                                echo "<h1>" . $row["year"] . " kW/h</h1>"; // Daten aus der Spalte "week" in kW/h
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
                                echo "<h1>" . $row["alll"] . " kW/h</h1>"; // Daten aus der Spalte "week" in kW/h
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
                        <tr>
                            <td>Januar - März</td>
                            <td>1110</td>
                            <td>120 CHF</td>
                            <td><a href="#" class="btn">Anschauen</a></td>
                        </tr>
                        <tr>
                            <td>März - Juni</td>
                            <td>1110</td>
                            <td>120 CHF</td>
                            <td><a href="#" class="btn">Anschauen</a></td>
                        </tr>
                        <tr>
                            <td>Juni - Oktober</td>
                            <td>1110</td>
                            <td>120 CHF</td>
                            <td><a href="#" class="btn">Anschauen</a></td>
                        </tr>
                        
                    </table>
                </div>
                <div class="new-students">
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
</body>

</html>