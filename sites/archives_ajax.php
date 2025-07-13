<?php
header('Content-Type: application/json');
include 'get_archives.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$repositoryPath = __DIR__ . '/../gallery/galerija';  // update if needed

$data = getArchives($repositoryPath, $page, 8);

echo json_encode($data);
exit;
?>
