<?php
require '../../config.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = (int)$data['id'];
$direction = $data['direction'];

$current = $conn->query("SELECT display_order FROM team_members WHERE id = $id")->fetch_assoc();
$current_order = (int)$current['display_order'];

$target_order = $direction === 'up' ? $current_order - 1 : $current_order + 1;
$target = $conn->query("SELECT id FROM team_members WHERE display_order = $target_order")->fetch_assoc();

if ($target) {
    $conn->query("UPDATE team_members SET display_order = $current_order WHERE id = " . (int)$target['id']);
    $conn->query("UPDATE team_members SET display_order = $target_order WHERE id = $id");
}
