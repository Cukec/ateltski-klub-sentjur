<?php
require '../../config.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $stmt = $conn->prepare("DELETE FROM practices WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Trening uspešno izbrisan.";
    } else {
        echo "Napaka pri brisanju.";
    }
} else {
    echo "ID ni bil podan.";
}
?>
