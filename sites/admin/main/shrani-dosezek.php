<?php

include("../../config.php");

//var_dump($_POST);

$msgs = [];
$error = "false";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    function sanitize($value, $conn) {
        return mysqli_real_escape_string($conn, trim($value));
    }

    // Get values from the form
    $id = (int) ($_POST["id"] ?? 0); // ID of the record to update
    $date = sanitize($_POST["date"] ?? "", $conn);
    $description = sanitize($_POST["description"] ?? "", $conn);
    $location = sanitize($_POST["location"] ?? "", $conn);
    $id_people = (int) ($_POST["people"] ?? 0);
    $id_selection = (int) ($_POST["selection"] ?? 0);
    $id_discipline = (int) ($_POST["discipline"] ?? 0);
    $is_tablica = isset($_POST["tablica"]) ? 1 : 0;
    $is_club_acc = 0; // Default to 0 if not provided
    $tip = (int) ($_POST["tip"] && $is_tablica == 1 ?? 0);

    // Initialize results
    $result_technical = null;
    $result_time = null;

    // Process Technical Results (tip = 2)
    if ($tip === 2) {
        $meters = sanitize($_POST["meters"] ?? "0", $conn);
        $cm = sanitize($_POST["cm"] ?? "00", $conn);
        $cm = str_pad($cm, 2, "0", STR_PAD_LEFT);
        $result_technical = "$meters.$cm";
    }

    // Process Running Results (tip = 1)
    if ($tip === 1) {
        $min = (int) ($_POST["minutes"] ?? 0);
        $sec = str_pad((int) ($_POST["seconds"] ?? 0), 2, "0", STR_PAD_LEFT);
        $msec = str_pad((int) ($_POST["milliseconds"] ?? 0), 2, "0", STR_PAD_LEFT);
        $result_time = $min > 0 ? "$min:$sec.$msec" : "$sec.$msec";
    }

    // Ensure the record ID is valid
    if ($id > 0) {
        // Prepare the UPDATE statement
        $stmt = $conn->prepare("UPDATE accomplishments 
            SET date = ?, is_tablica = ?, is_club_acc = ?, id_people = ?, id_discipline = ?, id_selection = ?, 
                result_time = ?, result_technical = ?, description = ?, location = ? 
            WHERE id = ?");

        // Bind parameters
        $stmt->bind_param("siiiiissssi", $date, $is_tablica, $is_club_acc, $id_people, $id_discipline, $id_selection, $result_time, $result_technical, $description, $location, $id);

        // Execute the query
        if ($stmt->execute()) {
            $msgs[] = "Uspešno posodabljanje dosežka!";
        } else {
            $msgs[] = "Napaka pri posodabljanju dosežka!Poskusite znova...";
        }

        // Close statement
        $stmt->close();
    } else {
        $msgs[] = "(opozorilo) Napačen id dosežka!Poskusite znova...";
    }

    // Close database connection
    $conn->close();
}

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));

?>
