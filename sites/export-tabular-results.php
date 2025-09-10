<?php
require_once 'config.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$selectedDiscipline = $_GET['discipline'] ?? '';
$selectedSelection = $_GET['selection'] ?? '';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$rowIndex = 1;

// Pridobi selekcije
$selectionsQuery = "SELECT id, title FROM selection ORDER BY id ASC";
$selections = $conn->query($selectionsQuery);

// Pridobi discipline
$disciplineQuery = "SELECT id, title FROM discipline ORDER BY num_out ASC";
$disciplineResult = $conn->query($disciplineQuery);
$disciplines = [];
while ($d = $disciplineResult->fetch_assoc()) {
    $disciplines[] = $d;
}

while ($selection = $selections->fetch_assoc()) {
    $selectionId = $selection['id'];
    $selectionTitle = $selection['title'];

    if ($selectedSelection && $selectedSelection != $selectionId) continue;

    // Naslov selekcije
    $sheet->setCellValue("A$rowIndex", $selectionTitle);
    $rowIndex++;

    foreach ($disciplines as $discipline) {
        $disciplineId = $discipline['id'];
        $disciplineTitle = $discipline['title'];

        if ($selectedDiscipline && $selectedDiscipline != $disciplineId) continue;

        $query = "SELECT a.result_time, a.result_technical, a.date, a.location, p.name, p.surname
                  FROM accomplishments a
                  JOIN people p ON a.id_people = p.id
                  WHERE a.is_tablica = 1
                    AND a.id_selection = ?
                    AND a.id_discipline = ?
                  ORDER BY a.date DESC";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $selectionId, $disciplineId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Naslov discipline
            $sheet->setCellValue("A$rowIndex", $disciplineTitle);
            $rowIndex++;

            // Glava tabele
            $sheet->setCellValue("A$rowIndex", "Rezultat");
            $sheet->setCellValue("B$rowIndex", "Ime in priimek");
            $sheet->setCellValue("C$rowIndex", "Leto");
            $sheet->setCellValue("D$rowIndex", "Kraj");
            $rowIndex++;

            while ($row = $result->fetch_assoc()) {
                $rezultat = $row['result_time'] ?: $row['result_technical'];
                $ime = $row['name'] . ' ' . $row['surname'];
                $leto = date("Y", strtotime($row['date']));
                $kraj = $row['location'];

                $sheet->setCellValue("A$rowIndex", $rezultat);
                $sheet->setCellValue("B$rowIndex", $ime);
                $sheet->setCellValue("C$rowIndex", $leto);
                $sheet->setCellValue("D$rowIndex", $kraj);
                $rowIndex++;
            }

            $rowIndex++; // prazna vrstica po tabeli
        }
    }
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="dosezki.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
