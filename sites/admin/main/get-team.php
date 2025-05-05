<?php
require '../../config.php';
$result = $conn->query("SELECT * FROM team_members ORDER BY display_order ASC");
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
