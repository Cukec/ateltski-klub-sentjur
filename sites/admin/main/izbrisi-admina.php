<?php
require_once '../../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Ne dovoli brisanja, če ostaneš brez admina (opcijsko)
    $rezultat = $conn->query("SELECT COUNT(*) AS total FROM admin");
    $skupno = $rezultat->fetch_assoc()['total'] ?? 0;
    if ($skupno <= 1) {
        echo json_encode(['success' => false, 'message' => 'Ne moreš izbrisati zadnjega admina.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM admini WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Admin uspešno izbrisan.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Napaka pri brisanju.']);
    }

    $stmt->close();
}
