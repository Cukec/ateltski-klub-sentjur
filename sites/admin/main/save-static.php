<?php
include('../../config.php');

$msgs = [];
$error = "false";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Sanitize input just to be safe
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $section1 = $_POST['section_1'] ?? '';
    $section2 = $_POST['section_2'] ?? '';
    $section3 = $_POST['section_3'] ?? '';
    $section4 = $_POST['section_4'] ?? '';

    if ($id > 0) {
        $sql = "UPDATE page_content SET section_1=?, section_2=?, section_3=?, section_4=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $section1, $section2, $section3, $section4, $id);

        if ($stmt->execute()) {
            // Redirect back with a success message
            //header("Location: staticne-actions.php?success=1");
            $msgs[] = "Uspešno posodobljena vsebina.";
            
        } else {
            //header("Location: staticne-actions.php?error=1");
            $msgs[] = "Napaka pri posodabljanju vsebine.";
            
        }
    } else {
        //header("Location: staticne-actions.php?error=1");
        $msgs[] = "Napaka pri pridobivanju id!";
        
    }
}

$status_msg = implode(" ", $msgs);
header("location: admin.php?status_msg=" . urlencode($status_msg) . "&error=" . urlencode($error));
exit();
?>
