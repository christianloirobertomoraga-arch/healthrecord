<?php
include '../config/db_connect.php';

// 1. Set headers to force download as CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=APCAS_Health_Records_' . date('Y-m-d') . '.csv');

// 2. Open the "output" stream
$output = fopen('php://output', 'w');

// 3. Set the Column Headers (The first row of the Excel file)
fputcsv($output, array(
    'ID', 'Full Name', 'Student ID', 'Grade & Section', 'Parent/Guardian', 
    'Allergies', 'Childhood Disease', 'Surgical Operations', 'Injuries/Illness',
    'Immunization', 'BCG', 'Oral Polio', 'DPT', 'Hepa A', 'Hepa B',
    'Covid 1st Dose', 'Covid 2nd Dose', 'Booster',
    'Family Heart Disease', 'Family TB', 'Family Diabetes', 'Family Cancer', 'Family Asthma', 'Family Allergy',
    'Exer', 'Smoke', 'Alco', 'Drugs', 'Headache', 'Head Injury', 
    'Glasses', 'Contacts', 'Eye Trouble', 'Hearing', 'Hearing Aid', 'Eardrum', 'Cleft', 'Speech', 'Neck Mass', 'Date Submitted'
));

// 4. Fetch the data from the database
$query = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($query);

// 5. Loop through the data and write to CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>