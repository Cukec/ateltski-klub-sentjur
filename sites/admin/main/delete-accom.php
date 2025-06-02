<?php
include("../../config.php");

$msgs = [];
$error = "false";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Cast to integer for security

    if ($id > 0) {
        
            $stmt = $conn->prepare("DELETE FROM accomplishments WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $msgs[] = "Dosežek uspešno izbrisan!";
            } else {
                $msgs[]= "Napaka pri brisanju: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
            }

            $stmt->close();
    } else {
        $msgs[] = "(opozorilo) Neveljaven ID!";
    }
} else {
    $msgs[] = "(opozorilo) Manjkajoči ID za brisanje!";
}

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));
?>
