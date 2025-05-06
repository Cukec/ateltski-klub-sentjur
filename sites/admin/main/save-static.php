<?php
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $section1 = $_POST['section_1'];
    $section2 = $_POST['section_2'];
    $section3 = $_POST['section_3'];
    $section4 = $_POST['section_4'];

    $sql = "UPDATE page_content SET section_1=?, section_2=?, section_3=?, section_4=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $section1, $section2, $section3, $section4, $id);

    if ($stmt->execute()) {
        echo "Uspešno posodabljanje vsebine";
    } else {
        echo "Napaka pri posodabljanju vsebine";
    }

    exit();
}
?>
