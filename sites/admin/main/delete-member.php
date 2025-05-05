<?php
require '../../config.php';
$id = (int)$_GET['id'];
$conn->query("DELETE FROM team_members WHERE id = $id");
