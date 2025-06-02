<?php
require_once '../../config.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

$msg ="";
$error ="false";

function isSafeInput($input) {
    // Seznam nevarnih SQL ukazov in znakov
    $blacklist = [
        'SELECT', 'DROP', 'DELETE', 'INSERT', 'UPDATE', 'UNION', 'TRUNCATE',
        'REPLACE', 'ALTER', 'RENAME', 'CREATE', 'EXEC', 'SHOW', '--', '#', ';'
    ];

    // Normalizacija vnosa (pretvorba v male črke in odstranjevanje nepotrebnih presledkov)
    $normalizedInput = strtoupper(trim($input));

    // Preverimo, ali vnos vsebuje katerokoli izmed nevarnih besed ali znakov
    foreach ($blacklist as $word) {
        if (stripos($normalizedInput, $word) !== false) {
            return false; // Nevaren vnos
        }
    }
    return true; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    if(isSafeInput($_POST['title'])) $title = sanitizeInput($_POST['title']);
    if(isSafeInput($_POST['content'])) $content = sanitizeInput($_POST['content']);
    if(isSafeInput($_POST['location'])) $location = sanitizeInput($_POST['location']);
    $type = $_POST['type'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $id_admin = 1; // Default admin ID

    if ($id > 0) {
        // Update existing news
        $stmt = $conn->prepare("UPDATE events SET `type` = ?, title = ?, content = ?, `location` = ?, date_start = ?, date_end = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $type, $title, $content, $location, $date_start, $date_end, $id);

        
        if ($stmt->execute()) {
            //echo "Novica uspešno posodobljena!";
            $msg = "Uspešno posodabljanje vsebine!";
        } else {
            //echo "Napaka pri posodabljanju novice: " . $stmt->error;
            $msg = "Napaka pri posodabljanju vsebine! Poskusite znova...";
            $error = "true";
        }

        $stmt->close();
    } else {
        //echo "Napaka: Neveljaven ID novice.";
        $msg = "Napaka pri posodabljanju vsebine! Poskusite znova...";
        $error = "true";
    }
}

header("location: admin.php?status_msg=" . urlencode($msg) . "&error=" . urlencode($error));
exit;
?>
