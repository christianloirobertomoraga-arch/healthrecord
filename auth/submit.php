<?php
include_once '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. The "Source of Truth" - list your DB columns exactly
    $fields = [
        'FullName', 'StudentID', 'Age', 'DOB', 'BloodType', 'YearLevel', 'Program', 
        'ParentGuardian', 'ParentContacts', 'ChildhoodDisease', 'SurgicalOperations', 
        'InjuriesIllness', 'KnownAllergies', 'ExistingMedicalCondition', 'CurrentMedications', 
        'LastMedicalCheckUp', 'Immunization', 'BCG', 'OralPolio', 'DPT', 'HepaA', 'HepaB', 
        'Covid1stDose', 'Covid2ndDose', 'CovidBooster', 'Family_HeartDisease', 
        'Family_Tuberculosis', 'Family_Diabetes', 'Family_Cancer', 'Family_Allergy', 
        'HeadHeadache', 'HeadInjury', 'EyeGlasses', 'EyeContacts', 'EyeTrouble', 'Ulcer', 
        'Gallbladder', 'Jaundices', 'TumorGrowthCystCancer', 'AbdominalPain', 
        'ConvulsionEpilepsy', 'Difficultytosleep', 'PsychiatricTreatment', 'Concentration', 
        'LossofMemory', 'Excessivesleepiness', 'HistExercise', 'HistSmoking', 'HistAlcohol', 
        'HistDrugs', 'EarHearing', 'EarAid', 'EarEardrum', 'EarCleft', 'EarSpeech', 
        'NeckMass', 'Tuberculosis', 'Asthma', 'ShortnessofBreath', 'PainChest', 
        'Palpitation', 'HeartTrouble', 'HighBloodPress', 'WornNeckBackBraceSupport', 
        'BoneJointDisabilityDeformity', 'LossArmLegfingertoe', 'FootTrouble'
    ];

    $data = [];
    foreach ($fields as $field) {
        // This handles the 'ParentContacts_' typo by looking for the clean 'ParentContacts' 
        // If the HTML still has the underscore, you MUST fix the HTML name to 'ParentContacts'
        if (!isset($_POST[$field]) || $_POST[$field] === '') {
            $data[$field] = null; 
        } else {
            $data[$field] = $_POST[$field];
        }
    }

    // 2. Build the SQL targeting the 'users' table
    $columns = implode(", ", array_map(function($c) { return "`$c`"; }, array_keys($data)));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    
    $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // 3. Bind all values
        $types = str_repeat("s", count($data)); 
        $values = array_values($data);
        $stmt->bind_param($types, ...$values);
    }
}
// submit.php around line 49

try {
    if ($stmt->execute()) {
        // Change 'success=1' to 'status=success'
        header("Location: ../Healthrecord.php?status=success");
        exit();
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        // Change 'error=duplicate' to 'status=duplicate'
        // Also note: your HTML input name is 'StudentID', not 'student_id'
        $student_id = $_POST['StudentID']; 
        header("Location: ../Healthrecord.php?status=duplicate&id=" . urlencode($student_id));
        exit();
    } else {
        header("Location: ../Healthrecord.php?status=error");
        exit();
    }
}
?>