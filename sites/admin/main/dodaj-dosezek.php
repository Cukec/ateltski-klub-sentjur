<?php
include("../../config.php");

$msgs = [];
$error = "false";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitizeInput($data, $conn) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return mysqli_real_escape_string($conn, $data);
    }

    // Checkbox vrednosti (nastavi na 1 ali 0)
    $is_tablica = isset($_POST['tablica']) ? 1 : 0;
    $is_club_acc = isset($_POST['club_acc']) ? 1 : 0;

    // Čiščenje in sanitizacija vhodnih podatkov
    $date = isset($_POST['date']) ? sanitizeInput($_POST['date'], $conn) : null;
    $description = isset($_POST['description']) ? sanitizeInput($_POST['description'], $conn) : null;
    $location = isset($_POST['location']) ? sanitizeInput($_POST['location'], $conn) : null;
    $id_people = isset($_POST['people']) ? (int) $_POST['people'] : null;
    $id_selection = isset($_POST['selection']) ? (int) $_POST['selection'] : null;
    $id_discipline = isset($_POST['discipline']) ? (int) $_POST['discipline'] : null;
    $tip = isset($_POST['tip']) && $is_tablica == 1 ? (int) $_POST['tip'] : null;

    // Priprava rezultata za različne discipline
    $result_time = null;
    $result_technical = null;

    if ($tip == 2) { // Tehnična disciplina (daljave, višine)
        $meters = isset($_POST['meters']) ? (int) $_POST['meters'] : 0;
        $cm = isset($_POST['cm']) ? sanitizeInput($_POST['cm'], $conn) : "0";
        $result_technical = "$meters.$cm";
    } elseif ($tip == 1) { // Tek (čas)
        $minutes = isset($_POST['minutes']) ? (int) $_POST['minutes'] : 0;
        $seconds = isset($_POST['seconds']) ? (int) $_POST['seconds'] : 0;
        $milliseconds = isset($_POST['milliseconds']) ? sanitizeInput($_POST['milliseconds'], $conn) : "0";

        // Zapiše milisekunde točno takoj za "."
        if ($minutes > 0) {
            $result_time = "$minutes:" . str_pad($seconds, 2, "0", STR_PAD_LEFT) . ".$milliseconds";
        } else {
            $result_time = "$seconds.$milliseconds";
        }
    }

    // Preverjanje, ali so obvezna polja izpolnjena
    if ($date || $description || $location || $id_people || $id_selection || $id_discipline) {
        // Priprava varnega poizvedbenega stavka
        $stmt = $conn->prepare("INSERT INTO accomplishments (date, is_tablica, is_club_acc, id_people, id_discipline, id_selection, result_time, result_technical, description, location) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiisssss", $date, $is_tablica, $is_club_acc, $id_people, $id_discipline, $id_selection, $result_time, $result_technical, $description, $location);

        if ($stmt->execute()) {
            $msgs[] = "Dosežek uspešno dodan!";
        } else {
            $msgs[] = "Napaka pri dodajanju dosežka!Poskusite znova...";
        }
        $stmt->close();
    } else {
        $msgs[] =  "Napaka pri vnosu podatkov dosežka!Poskusite znova...";
    }
}

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));
?>
