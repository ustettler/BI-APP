<?php
session_start();

// Überprüfe, ob der Benutzer angemeldet ist, sonst leite ihn zur logout.php Seite weiter
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
?>
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


// SQL-Abfrage für die Tabelle "stats_animation"
$sql_ani = "SELECT * FROM stats_animation";
$result_ani = $conn->query($sql_ani);

// Überprüfen, ob die Abfrage erfolgreich war
if (!$result_ani) {
    die("Abfragefehler: " . $conn->error);
}

// Daten in ein assoziatives Array konvertieren
$labels_from_database = array();
$data_from_database = array();
if ($result_ani->num_rows > 0) {
    while ($row = $result_ani->fetch_assoc()) {
        $labels_from_database[] = $row['month']; 
        $data_from_database[] = $row['value']; 
    }
}

// Function to update database value
function updateValue($columnName, $newValue) {
    global $conn;
    // Verwenden Prepared Statements, um SQL-Injektionen zu verhindern
    $sql = "UPDATE stats SET $columnName = ? WHERE id = 1"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newValue); 
    if ($stmt->execute() === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

// Check if form is submitted for editing
if(isset($_POST['editValue'])) {
    $columnName = $_POST['columnName']; 
    $newValue = $_POST['newValue'];
    updateValue($columnName, $newValue);
}

// Stats Animation - hinzufügen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Daten aus dem Formular erhalten
    $value = $_POST['value'];
    $month = $_POST['month'];

    // SQL-Abfrage zum Einfügen der Daten
    $sql_insert = "INSERT INTO stats_animation (value, month) VALUES ('$value', '$month')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Daten erfolgreich hinzugefügt.";
    } else {
        echo "Fehler beim Hinzufügen der Daten: " . $conn->error;
    }
}


// SQL-Abfrage für die Tabelle "stats_quantity"
$sql_quantity = "SELECT * FROM quantity_user";
$result_quantity = $conn->query($sql_quantity);

// Überprüfen, ob die Abfrage erfolgreich war
if (!$result_quantity) {
    die("Abfragefehler: " . $conn->error);
}

// Daten in ein assoziatives Array konvertieren
$labels_from_database_q = array();
$data_from_database_q = array();
if ($result_quantity->num_rows > 0) {
    while ($row = $result_quantity->fetch_assoc()) {
        $labels_from_database_q[] = $row['month']; // Verwende 'month' als Label
        $data_from_database_q[] = $row['user']; // Verwende 'user' als Datenwert
    }
}

// Check if form is submitted for editing
if(isset($_POST['editValue'])) {
    $columnName = $_POST['columnName']; 
    $newValue = $_POST['newValue'];
    updateValue($columnName, $newValue);
}

// Daten aus dem Formular erhalten
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['quantity']; // Verwende 'quantity' für Benutzer
    $month = $_POST['month'];

    // Überprüfen, ob der Eintrag bereits vorhanden ist
    $sql_check = "SELECT * FROM quantity_user WHERE user = '$user' AND month = '$month'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "Der Eintrag existiert bereits.";
    } else {
        // SQL-Abfrage zum Einfügen der Daten in die Tabelle "quantity_user"
        $sql_insert = "INSERT INTO quantity_user (user, month) VALUES ('$user', '$month')";

        // Versuche, die SQL-Abfrage auszuführen
        if ($conn->query($sql_insert) === TRUE) {
            echo "Daten erfolgreich hinzugefügt.";
        } else {
            echo "Fehler beim Hinzufügen der Daten: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <title>ADMIN  - BI Panel</title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
              <!--  PHP als komponennten einfüegn -->
            <h1><?php
    include './componenten/Logo_Admin.php';
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
                    <a href="./logout.php" class="btn">Logout</a>
                </div>
            </div>
        </div>
        <div class="content">
        
            <div class="cards">
                <div class="card">
                <div class="box" style="padding: 20px">
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
                        <br/>
                    <!-- Form for updating  -->
                    <form method="post">
                        <input type="hidden" name="columnName" value="today"> 
                        <input type="text" id="todayValue" name="newValue">
                        <button type="submit" class="btn" name="editValue" value="true">Updaten</button>
                    </form>   
                </div>
                </div>

                <div class="card">
                    <div class="box" style="padding: 20px">
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
                        <br />
                       <!-- Form for updating  -->
                        <form method="post">
                            <input type="hidden" name="columnName" value="week"> <!-- Spaltenname -->
                            <input type="text" id="weekValue" name="newValue">
                            <button type="submit" name="editValue" class="btn" value="true">Updaten</button>
                        </form>
                    </div>
                    <div class="icon-case">
                    
                    </div>
                </div>
                <div class="card">
                    <div class="box" style="padding: 20px">
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
                        <br/>
                        <!-- Form for updating -->
                        <form method="post">
                            <input type="hidden" name="columnName" value="year"> <!-- Spaltenname -->
                            <input type="text" id="yearValue" name="newValue">
                            <button type="submit" name="editValue" class="btn" value="true">Updaten</button>
                        </form>
                    </div>
                    <div class="icon-case">
                    </div>
                </div>

                <div class="card">
                    <div class="box" style="padding: 20px">    
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
                        <br/>
                        <!-- Form for updating  -->
                        <form method="post">
                            <input type="hidden" name="columnName" value="alll"> <!-- Spaltenname -->
                            <input type="text" id="alllValue" name="newValue">
                            <button type="submit" name="editValue" class="btn" value="true">Updaten</button>
                        </form>
                    </div>
                   
                </div>
            </div>

            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Berechnung</h2>
                    </div>
            
        <table>     
    <tr>
        <th>Periode</th>
        <th>Kw/h</th>
        <th>Betrag</th>
        <th>Datenblatt</th>
        <th>Löschen</th>
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
            echo "<td><a href='./delete_record.php?id=" . $row["id"] . "' class='btn-delete'>X</a></td>"; // Hier wird die Löschfunktion aufgerufen, wobei "id" die eindeutige ID des Datensatzes ist
            echo "</tr>";
        }
    } else {
        echo "Keine Rechnungsdaten gefunden";
    }
    ?>
</table >
<hr>
<h3 style="padding-top: 20px; padding-left: 20px">Neue Rechnung hinzufügen</h3>
<form action="./insert_record.php" method="post" style="padding-top: 20px; padding-left: 20px">
    <label for="periode">Periode:</label>
    <input id="periode" type="text" name="periode" required><br><br>

    <label for="total_kwh">Kw/h: &nbsp; &nbsp; </label>
    <input id="total_kwh" type="number"  name="total_kwh" required><br><br>

    <label for="money">Betrag:&nbsp;  </label>
    <input id="money" type="number"  name="money" required><br><br>


    <input type="submit" class="btn" value="Datensatz einfügen">
    </form>
    </div>

    <div class="content-2">
    <div class="recent-payments">
        <div class="title">
            <h2>Benutzer</h2>
        </div>
        <table>
            <tr>
                <td>
                    <canvas id="recentBarChart" width="300" height="300"></canvas>
                    <script>
                        var ctx1 = document.getElementById('recentBarChart').getContext('2d');
                        var recentBarChart = new Chart(ctx1, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode($labels_from_database_q); ?>,
                                datasets: [{
                                    label: 'Benutzer Anzahl ersten Monat',
                                    data: <?php echo json_encode($data_from_database_q); ?>,
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(75, 192, 192)',
                                        'rgb(255,255,0)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Benutzer in den letzte Monaten'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </td>
            </tr>
        </table>
        <hr>
        <h3 style="margin-left: 20px; margin-top: 20px">Neuen Benutzer anzahl</h3>
        <form method="post" style="margin-left: 20px; margin-top: 20px; margin-bottom: 50px>
            <label for="month">Monat:&nbsp; </label>
            <input type="text" id="month" name="month" required>
            <br/><br/>
            <label for="quantity">Menge:</label>
            <input type="text" id="quantity" name="quantity" required>
            <br/><br/>
            <button type="submit" class="btn"style="margin-bottom: 20px">Hinzufügen</button>
        </form>
    </div>
</div>



                <div class="statss">
                    <div class="title">
                        <h2>Statistik</h2>
                    </div>
                    <table>
        <tr>
            <td>
                <canvas id="doughnutChart" width="300" height="300"></canvas>
                <br/>
                <hr/>
                <h3 style="margin-top: 20px">Neue Werte hinzufügen</h3>
                <br/>
                <form method="post">
                    <label for="value">kW/h:&nbsp; </label>
                    <input type="text" id="value" name="value" required>
                <br/> <br/>
                    <label for="month">Monat:</label>
                    <input type="text" id="month" name="month" required>
                <br/><br/>
                    <button type="submit" class="btn">Hinzufügen</button>
                </form>

                <!-- JavaScript-Code -->
                <script>
                    var ctx = document.getElementById('doughnutChart').getContext('2d');
                    var doughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: <?php echo json_encode($labels_from_database); ?>,
                            datasets: [{
                                label: 'Stromverbrauch der letzten Monate',
                                data: <?php echo json_encode($data_from_database); ?>,
                                backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)',
                                    'rgb(75, 192, 192)',
                                    'rgb(255, 255, 0)',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Verbrauch der letzten Monate'
                                }
                            }
                        }
                    });
                </script>
            </td>
        </tr>
    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>