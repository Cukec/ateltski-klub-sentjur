<?php
// Include the database configuration file
include 'config.php';

try {
    // Check if the form is submitted using POST method
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        // Get form data and validate them
        $title = isset($_POST['title']) ? trim($_POST['title']) : null;
        $content = isset($_POST['content']) ? trim($_POST['content']) : null;
        $shown = 1;
        $post_time = date('Y-m-d H:i:s');
        $news_id = isset($_POST['newsId']) ? trim($_POST['newsId']) : null;

        $action = isset($_POST['submit']) ? trim($_POST['submit']) : null;

        // Validate required fields
        if (empty($title) || empty($content)) {
            throw new Exception("Title and content are required fields.");
        }

        // Set id_admin (e.g., the current logged-in admin; static value for now)
        $id_admin = 1; // Update with the actual admin ID logic if needed

        if($action == 'Dodaj'){

            // Prepare the SQL query
            $stmt = $conn->prepare("INSERT INTO news (title, content, shown, post_time, id_admin) VALUES (?, ?, ?, ?, ?)");

            if (!$stmt) {
                throw new Exception("Failed to prepare SQL statement: " . $conn->error);
            }

            // Bind parameters to the query
            $stmt->bind_param("ssisi", $title, $content, $shown, $post_time, $id_admin);

            // Execute the query
            if ($stmt->execute()) {
                echo "New news added successfully!";
            } else {
                throw new Exception("Error executing query: " . $stmt->error);
            }

            // Close the statement
            $stmt->close();

            // Redirect back to the homepage or another page with success status
            header("Location: admin.php?status=success");
            exit();

        }else if($action == 'Spremeni'){
    
            // Pripravi UPDATE stavek
            $stmt = $conn->prepare("UPDATE news SET title = ?, content = ? WHERE id = ?");
    
            if (!$stmt) {
                throw new Exception("Napaka pri pripravi SQL stavka: " . $conn->error);
            }
    
            // Poveži parametre in izvedi poizvedbo
            $stmt->bind_param("ssi", $title, $content, $news_id);
    
            if ($stmt->execute()) {
                echo "Novica uspešno posodobljena!";
            } else {
                throw new Exception("Napaka pri izvajanju SQL poizvedbe: " . $stmt->error);
            }
    
            $stmt->close();
    
            // Preusmeri nazaj na admin stran
            header("Location: admin.php?status=updated");
            exit();
        }
        
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    // Log the error for debugging (optional: store it in a log file)
    error_log($e->getMessage());

    // Display an error message to the user
    echo "Error: " . htmlspecialchars($e->getMessage());
}


$conn->close();
?>

