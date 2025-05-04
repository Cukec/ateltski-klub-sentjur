<?php

include("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action'])) {

    if ($_POST['action'] == "save") {

        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $url = isset($_POST['url']) ? trim($_POST['url']) : '';

        $sql = "INSERT INTO links (title, url) VALUES (?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $title, $url);

        if ($stmt->execute()) {
            echo "<script>alert('Uspešno dodana povezava'); window.location.href = document.referrer;</script>";
        } else {
            echo "<script>alert('Napaka pri dodajanju povezave'); window.location.href = document.referrer;</script>";
        }

    } else if ($_POST['action'] == "change") {

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $url = isset($_POST['url']) ? trim($_POST['url']) : '';

        if ($id > 0) {
            $sql = "UPDATE links SET title = ?, url = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $title, $url, $id);

            if ($stmt->execute()) {
                echo "<script>alert('Uspešno posodobljena povezava'); window.location.href = document.referrer;</script>";
            } else {
                echo "<script>alert('Napaka pri posodabljanju povezave'); window.location.href = document.referrer;</script>";
            }
        }

    } else if ($_POST['action'] == "delete") {

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        if ($id > 0) {
            $sql = "DELETE FROM links WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo "<script>alert('Uspešno izbrisana povezava'); window.location.href = document.referrer;</script>";
            } else {
                echo "<script>alert('Napaka pri brisanju povezave'); window.location.href = document.referrer;</script>";
            }
        }

    } else {
        echo "<script>alert('NAPAKA pri izbiranju operacije (DODAJ / SPREMENI / IZBRIŠI)'); window.location.href = document.referrer;</script>";
    }

} else {
    echo "<script>alert('Napaka!'); window.location.href = document.referrer;</script>";
}
?>
