<?php
include("../../config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Cast to integer for security

    if ($id > 0) {
        
            $stmt = $conn->prepare("DELETE FROM accomplishments WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo "✅ Dosežek uspešno izbrisan!";
            } else {
                echo "❌ Napaka pri brisanju: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
            }

            $stmt->close();
    } else {
        echo "⚠️ Neveljaven ID!";
    }
} else {
    echo "⚠️ Manjkajoči ID za brisanje!";
}
?>
