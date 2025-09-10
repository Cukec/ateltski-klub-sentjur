<?php
require_once 'config.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$year = isset($_GET['year']) && $_GET['year'] !== 'all' ? (int)$_GET['year'] : null;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$rowIndex = 1;

if ($year) {
    $query = "SELECT YEAR(a.date) AS year, a.description, p.name, p.surname
              FROM accomplishments a
              JOIN people p ON a.id_people = p.id
              WHERE a.is_club_acc = 1 AND YEAR(a.date) = ?
              ORDER BY a.date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
} else {
    $query = "SELECT YEAR(a.date) AS year, a.description, p.name, p.surname
              FROM accomplishments a
              JOIN people p ON a.id_people = p.id
              WHERE a.is_club_acc = 1
              ORDER BY year DESC, a.date DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

$currentYear = null;

while ($row = $result->fetch_assoc()) {
    $rowYear     = isset($row['year']) ? (int)$row['year'] : '';
    $name        = isset($row['name']) ? $row['name'] : '';
    $surname     = isset($row['surname']) ? $row['surname'] : '';
    $description = isset($row['description']) ? $row['description'] : '';

    if ($rowYear === '' || ($name === '' && $surname === '') || $description === '') continue;

    if (!$year && $rowYear !== $currentYear) {
        // prazna vrstica med leti
        if ($currentYear !== null) $rowIndex++;
        $sheet->setCellValue("A$rowIndex", $rowYear);
        $rowIndex++;
        $currentYear = $rowYear;

        // Glava tabele
        $sheet->setCellValue("A$rowIndex", "Ime in priimek");
        $sheet->setCellValue("B$rowIndex", "Opis dosežka");
        $rowIndex++;
    } elseif ($year && $currentYear === null) {
        // če filtriramo po letu, dodamo glavo
        $sheet->setCellValue("A$rowIndex", "Ime in priimek");
        $sheet->setCellValue("B$rowIndex", "Opis dosežka");
        $rowIndex++;
        $currentYear = $year;
    }

    $sheet->setCellValue("A$rowIndex", $name . ' ' . $surname);
    $sheet->setCellValue("B$rowIndex", $description);
    $rowIndex++;
}

// Nastavi header za prenos Excel datoteke
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="dosezki.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
