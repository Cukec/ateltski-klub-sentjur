<?php
// Poveži se z bazo podatkov (poskrbi, da boš uporabil svojo povezavo)
require_once 'config.php'; // Poskrbi, da imaš ustrezno datoteko za povezavo

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $newsId = $_GET['id'];

    // Preprečimo SQL injection z uporabo pripravljenih izjav
    $sql = "DELETE FROM news WHERE id = :id";
    $stmt = $conn->prepare($sql);
    
    // Bind parametra za ID
    $stmt->bindParam(':id', $newsId, PDO::PARAM_INT);

    try {
        // Izvedi poizvedbo
        $stmt->execute();

        // Preveri, ali je bila novica dejansko izbrisana
        if ($stmt->rowCount() > 0) {
            echo "Novica je bila uspešno izbrisana.";
        } else {
            echo "Napaka: Novica z ID-jem $newsId ne obstaja.";
        }
    } catch (PDOException $e) {
        // Če pride do napake pri poizvedbi, jo obravnavaj
        echo "Napaka pri brisanju: " . $e->getMessage();
    }
} else {
    echo "Napaka: Ni bil poslan veljaven ID novice.";
}
?>
