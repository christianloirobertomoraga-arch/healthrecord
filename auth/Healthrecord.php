<?php
session_start();
include '../config/db_connect.php';

// ADD THIS: Return JSON for the View button
if (isset($_GET['ajax']) && isset($_GET['view_id'])) {
    $id = intval($_GET['view_id']);
    $res = $conn->query("SELECT * FROM users WHERE id = $id");
    echo json_encode($res->fetch_assoc());
    exit;
}

// ... rest of your code

$count_query = "SELECT COUNT(*) as total FROM users";
$count_result = $conn->query($count_query);
$count_data = $count_result->fetch_assoc();
$total_records = $count_data['total'];

$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_record'])) {
    // Basic Info
    $fullName = $_POST['FullName'];
    $studentID = $_POST['StudentID'];
    $gradeSection = $_POST['Grade_and_Section'];
    $parentGuardian = $_POST['ParentGuardian'] ?? '';
    
    // Medical Text Areas
    $allergies = $_POST['KnownAllergies'] ?? '';
    $childhoodDisease = $_POST['ChildhoodDisease'] ?? '';
    $surgical = $_POST['SurgicalOperations'] ?? '';
    $injuries = $_POST['InjuriesIllness'] ?? '';

    // Immunization & Covid
    $immuno = $_POST['Immunization'] ?? 'No';
    $bcg = $_POST['BCG'] ?? 'No';
    $polio = $_POST['OralPolio'] ?? 'No';
    $dpt = $_POST['DPT'] ?? 'No';
    $hepaA = $_POST['HepaA'] ?? 'No';
    $hepaB = $_POST['HepaB'] ?? 'No';
    $cov1 = $_POST['Covid1stDose'] ?: null; // Use null for empty dates
    $cov2 = $_POST['Covid2ndDose'] ?: null;
    $covB = $_POST['CovidBooster'] ?: null;

    // Family History (Checkboxes)
    $fHeart = $_POST['Family_HeartDisease'] ?? 'No';
    $fTB = $_POST['Family_Tuberculosis'] ?? 'No';
    $fDiab = $_POST['Family_Diabetes'] ?? 'No';
    $fCan = $_POST['Family_Cancer'] ?? 'No';
    $fAsth = $_POST['Family_Asthma'] ?? 'No';
    $fAll = $_POST['Family_Allergy'] ?? 'No';

    // Habits & Systems
    $hExer = $_POST['HistExercise'] ?? 'No';
    $hSmoke = $_POST['HistSmoking'] ?? 'No';
    $hAlco = $_POST['HistAlcohol'] ?? 'No';
    $hDrug = $_POST['HistDrugs'] ?? 'No';
    $hHead = $_POST['HeadHeadache'] ?? 'No';
    $hInj = $_POST['HeadInjury'] ?? 'No';
    $eGlass = $_POST['EyeGlasses'] ?? 'No';
    $eCont = $_POST['EyeContacts'] ?? 'No';
    $eTrub = $_POST['EyeTrouble'] ?? 'No';
    $earHear = $_POST['EarHearing'] ?? 'No';
    $earAid = $_POST['EarAid'] ?? 'No';
    $earDrum = $_POST['EarEardrum'] ?? 'No';
    $earCleft = $_POST['EarCleft'] ?? 'No';
    $earSpeech = $_POST['EarSpeech'] ?? 'No';
    $neckMass = $_POST['NeckMass'] ?? 'No';

    $sql = "INSERT INTO users (
        FullName, StudentID, Grade_and_Section, ParentGuardian, KnownAllergies, 
        ChildhoodDisease, SurgicalOperations, InjuriesIllness, Immunization, 
        BCG, OralPolio, DPT, HepaA, HepaB, Covid1stDose, Covid2ndDose, CovidBooster, 
        FamilyHeartDisease, FamilyTB, FamilyDiabetes, FamilyCancer, FamilyAsthma, 
        FamilyAllergy, HistExercise, HistSmoking, HistAlcohol, HistDrugs, 
        HeadHeadache, HeadInjury, EyeGlasses, EyeContacts, EyeTrouble, 
        EarHearing, EarAid, EarEardrum, EarCleft, EarSpeech, NeckMass
    ) VALUES (" . str_repeat("?,", 37) . "?)";

    $stmt = $conn->prepare($sql);
    
    // Binding 38 parameters (s = string, i = integer)
    // Note: Dates are treated as strings in bind_param
    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssssssssss", 
        $fullName, $studentID, $gradeSection, $parentGuardian, $allergies,
        $childhoodDisease, $surgical, $injuries, $immuno,
        $bcg, $polio, $dpt, $hepaA, $hepaB, $cov1, $cov2, $covB,
        $fHeart, $fTB, $fDiab, $fCan, $fAsth,
        $fAll, $hExer, $hSmoke, $hAlco, $hDrug,
        $hHead, $hInj, $eGlass, $eCont, $eTrub,
        $earHear, $earAid, $earDrum, $earCleft, $earSpeech, $neckMass
    );

    try {
        if ($stmt->execute()) {
            $message = "Complete health record submitted successfully!";
            $message_type = "success";
        }
    } catch (mysqli_sql_exception $e) {
        $message = ($e->getCode() == 1062) ? "Student ID already exists." : "Error: " . $e->getMessage();
        $message_type = "error";
    }
    $stmt->close();
}
    // --- DELETE LOGIC ---
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $del_sql = "DELETE FROM users WHERE id = ?";
    $del_stmt = $conn->prepare($del_sql);
    $del_stmt->bind_param("i", $delete_id);
    
    if ($del_stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=deleted");
        exit();
    }
}

// --- VIEW/FETCH LOGIC (For AJAX or Modal) ---
$view_data = null;
if (isset($_GET['view_id'])) {
    $view_id = $_GET['view_id'];
    $view_sql = "SELECT * FROM users WHERE id = ?";
    $view_stmt = $conn->prepare($view_sql);
    $view_stmt->bind_param("i", $view_id);
    $view_stmt->execute();
    $view_data = $view_stmt->get_result()->fetch_assoc();

    // ---------------------------------
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APCAS Campus Care | Student Health Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes badge-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .animate-spin-slow { animation: badge-spin 3s linear infinite; }
        .hidden { display: none; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <nav class="bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="bg-teal-500 p-2 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-teal-600 leading-none">APCAS Campus Care</h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider">Student Health Portal</p>
            </div>
        </div>
        <div class="flex gap-6 font-medium text-slate-600 items-center">
            <button onclick="showPage('home')" class="hover:text-teal-600 transition">Home</button>
            <button onclick="showPage('records')" class="hover:text-teal-600 transition">Health Records</button>
            <button onclick="showPage('announcements')" class="hover:text-teal-600 transition">Announcements</button>
            <button onclick="showPage('admin')" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">Admin</button>
        </div>
    </nav>

    <section id="page-home" class="page-content max-w-7xl mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <span class="text-teal-600 font-semibold bg-teal-50 px-3 py-1 rounded-full text-sm">Your Health, Our Priority</span>
                <h2 class="text-5xl font-extrabold mt-4 mb-6 leading-tight">Welcome to <br><span class="text-teal-600 uppercase">APCAS Campus Care</span></h2>
                <p class="text-lg text-slate-600 mb-8">Your comprehensive student health management portal. Submit health records, stay informed with important health announcements, and ensure your well-being on campus.</p>
                <div class="flex gap-4">
                    <button onclick="showPage('records')" class="bg-teal-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-teal-700 transition">Submit Health Record</button>
                    <button onclick="showPage('announcements')" class="border border-slate-200 px-6 py-3 rounded-xl font-bold hover:bg-slate-100 transition">View Announcements</button>
                </div>
            </div>
            <div class="relative bg-teal-50 rounded-3xl p-12 flex justify-center items-center h-80">
                <div class="bg-white p-8 rounded-2xl shadow-xl text-center relative z-10">
                    <div class="bg-teal-100 text-teal-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold">Campus Health</h3>
                    <p class="text-slate-400 text-sm">Electronic Records System</p>
                </div>
                <div class="absolute top-4 right-4 bg-white px-3 py-2 rounded-lg shadow-md text-xs font-bold border border-green-100 text-green-600 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span> Records Secure
                </div>
                <div class="absolute bottom-4 left-4 bg-white px-3 py-2 rounded-lg shadow-md text-xs font-bold border border-orange-100 text-orange-600">Updates Real-time</div>
            </div>
        </div>

       <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-20">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
        <p class="text-3xl font-bold"><?php echo $total_records; ?></p>
        <p class="text-slate-500 text-sm">Health Records</p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
        <p class="text-3xl font-bold">4</p>
        <p class="text-slate-500 text-sm">Active Announcements</p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
        <p class="text-3xl font-bold text-teal-600">100%</p>
        <p class="text-slate-500 text-sm">Secure Storage</p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
        <p class="text-3xl font-bold text-purple-600">Always</p>
        <p class="text-slate-500 text-sm">24/7 Access</p>
    </div>
</div>
    </section>

    <section id="page-records" class="page-content hidden max-w-4xl mx-auto py-12 px-6">
        
        <?php if (!empty($message)): ?>
    <div class="<?php echo ($message_type == 'success') ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500'; ?> border-l-4 p-4 mb-6 rounded-r-xl shadow-sm">
        <div class="flex items-center gap-3">
            <div class="<?php echo ($message_type == 'success') ? 'text-green-500' : 'text-red-500'; ?>">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold <?php echo ($message_type == 'success') ? 'text-green-800' : 'text-red-800'; ?> uppercase tracking-wide">
                    <?php echo ($message_type == 'success') ? 'Submission Successful' : 'Duplicate Record Detected'; ?>
                </p>
                <p class="text-xs <?php echo ($message_type == 'success') ? 'text-green-700' : 'text-red-700'; ?> mt-1"><?php echo $message; ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<form action="" method="POST" class="space-y-8 pb-20">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">General Information</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold mb-2">FullName *</label>
                <input type="text" name="FullName" required class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">StudentID *</label>
                <input type="text" name="StudentID" required class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Grade & Section *</label>
                <input type="text" name="Grade_and_Section" required class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Parent / Guardian</label>
                <input type="text" name="ParentGuardian" class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">Medical History</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="md:col-span-2"><label class="text-sm font-semibold">Known Allergies</label><textarea name="KnownAllergies" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div><label class="text-sm font-semibold">Childhood Diseases</label><textarea name="ChildhoodDisease" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div><label class="text-sm font-semibold">Surgical Operations</label><textarea name="SurgicalOperations" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div class="md:col-span-2"><label class="text-sm font-semibold">Injuries / Illness / Hospitalizations</label><textarea name="InjuriesIllness" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">Immunization</h3>
            <div class="space-y-3">
                <?php 
                $immunes = ['Immunization', 'BCG', 'OralPolio', 'DPT', 'HepaA', 'HepaB'];
                foreach($immunes as $item): ?>
                <div class="flex justify-between items-center p-2 hover:bg-slate-50 rounded-lg">
                    <span class="text-sm font-medium"><?= $item ?></span>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-1 text-xs"><input type="radio" name="<?= $item ?>" value="Yes"> Yes</label>
                        <label class="flex items-center gap-1 text-xs"><input type="radio" name="<?= $item ?>" value="No"> No</label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">Covid-19 Vaccines</h3>
            <div class="space-y-4">
                <div><label class="text-xs font-bold text-slate-500">1st Dose Date</label><input type="date" name="Covid1stDose" class="w-full border p-2 rounded-lg bg-slate-50"></div>
                <div><label class="text-xs font-bold text-slate-500">2nd Dose Date</label><input type="date" name="Covid2ndDose" class="w-full border p-2 rounded-lg bg-slate-50"></div>
                <div><label class="text-xs font-bold text-slate-500">Booster Date</label><input type="date" name="CovidBooster" class="w-full border p-2 rounded-lg bg-slate-50"></div>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">Health Checklist</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Family History</p>
                <div class="space-y-2">
                    <?php $fam = ['Heart Disease', 'Tuberculosis', 'Diabetes', 'Cancer', 'Asthma', 'Allergy']; 
                    foreach($fam as $f): ?>
                        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded">
                            <span><?= $f ?></span>
                            <input type="checkbox" name="Family_<?= str_replace(' ', '', $f) ?>" value="Yes">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Head & Eyes</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Frequent Headache</span><input type="checkbox" name="HeadHeadache" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Severe Head Injury</span><input type="checkbox" name="HeadInjury" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Worn Eyeglasses</span><input type="checkbox" name="EyeGlasses" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Eye Trouble</span><input type="checkbox" name="EyeTrouble" value="Yes"></label>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Habits/Social</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Regular Exercise</span><input type="checkbox" name="HistExercise" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Smoking</span><input type="checkbox" name="HistSmoking" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Alcohol</span><input type="checkbox" name="HistAlcohol" value="Yes"></label>
                </div>
            </div>
        </div>
    </div>
<div>
    <p class="font-bold text-sm mb-4 text-slate-400">ENT & Neck</p>
    <div class="space-y-2">
        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Difficulty Hearing</span><input type="checkbox" name="EarHearing" value="Yes"></label>
        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Worn Hearing Aid</span><input type="checkbox" name="EarAid" value="Yes"></label>
        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Ruptured Eardrum</span><input type="checkbox" name="EarEardrum" value="Yes"></label>
        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Cleft Palate</span><input type="checkbox" name="EarCleft" value="Yes"></label>
        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Speech Problem</span><input type="checkbox" name="EarSpeech" value="Yes"></label>
        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Enlarged Neck Mass</span><input type="checkbox" name="NeckMass" value="Yes"></label>
    </div>
</div>
    <button type="submit" name="submit_record" class="w-full bg-teal-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-teal-700 shadow-lg shadow-teal-200 transition">
        Submit Final Health Record
    </button>
</form>
    </section>

    <section id="page-announcements" class="page-content hidden max-w-6xl mx-auto py-12 px-6">
        <div class="mb-10">
            <h2 class="text-3xl font-bold">Health Announcements</h2>
            <p class="text-slate-500">Stay informed with the latest health updates, vaccination schedules, and important notices from our campus health team. [cite: 139]</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border-l-4 border-red-500 shadow-sm relative group overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex gap-2">
                        <span class="bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-1 rounded uppercase">Disease Prevention</span>
                        <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-1 rounded uppercase flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Urgent
                        </span>
                    </div>
                    <span class="text-slate-400 text-xs">Dec 12, 2024 [cite: 191]</span>
                </div>
                <h4 class="text-xl font-bold mb-3 group-hover:text-teal-600 transition">Important: Dengue Prevention Guidelines [cite: 180]</h4>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">Due to the increase in dengue cases in our area, we urge everyone to take preventive measures: 1. Remove standing water around your homes... [cite: 182, 184]</p>
                <button class="text-teal-600 font-bold text-sm flex items-center gap-1">Read more â†’</button>
            </div>

            <div class="bg-white p-6 rounded-2xl border-l-4 border-green-500 shadow-sm group">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex gap-2">
                        <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-1 rounded uppercase">Nutrition</span>
                        <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-1 rounded uppercase">Low</span>
                    </div>
                    <span class="text-slate-400 text-xs">Dec 8, 2024</span>
                </div>
                <h4 class="text-xl font-bold mb-3 group-hover:text-teal-600 transition">Healthy Eating Tips for Students [cite: 167]</h4>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">Good nutrition is essential for academic success! Here are some tips for maintaining a healthy diet: Start your day with a nutritious breakfast... [cite: 168]</p>
                <button class="text-teal-600 font-bold text-sm flex items-center gap-1">Read more â†’</button>
            </div>

            <div class="bg-white p-6 rounded-2xl border-l-4 border-yellow-500 shadow-sm group">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex gap-2">
                        <span class="bg-pink-50 text-pink-600 text-[10px] font-bold px-2 py-1 rounded uppercase">Mental Health</span>
                        <span class="bg-yellow-50 text-yellow-600 text-[10px] font-bold px-2 py-1 rounded uppercase">Medium</span>
                    </div>
                    <span class="text-slate-400 text-xs">Dec 10, 2024</span>
                </div>
                <h4 class="text-xl font-bold mb-3 group-hover:text-teal-600 transition">Mental Health Awareness Week Activities [cite: 151]</h4>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">Join us for Mental Health Awareness Week! We have planned various activities to promote wellness and mental health support among students... [cite: 152]</p>
                <button class="text-teal-600 font-bold text-sm flex items-center gap-1">Read more â†’</button>
            </div>
        </div>
    </section>

<section id="page-admin" class="page-content hidden max-w-7xl mx-auto py-12 px-6">
    <div class="flex gap-2">
    <a href="export_records.php" class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-bold hover:bg-slate-50 transition flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export to Excel
    </a>
    
    <button class="bg-teal-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-teal-700 transition flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        New Announcement
    </button>
</div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold tracking-wider">
    <tr>
        <th class="px-6 py-4">#</th>
        <th class="px-6 py-4">Full Name</th>
        <th class="px-6 py-4">Student ID</th>
        <th class="px-6 py-4">Grade & Section</th>
        <th class="px-6 py-4">Date Submitted</th>
        <th class="px-6 py-4 text-right">Actions</th>
    </tr>
</thead>
            <tbody class="divide-y text-sm">
    <?php
    // Fetch all records from the 'users' table
    $sql_admin = "SELECT id, FullName, StudentID, Grade_and_Section, created_at FROM users ORDER BY created_at DESC";
    $result_admin = $conn->query($sql_admin);

    // Initialize the counter starting at 1
    $row_num = 1; 

    if ($result_admin && $result_admin->num_rows > 0) {
        while($row = $result_admin->fetch_assoc()) {
            echo "<tr class='hover:bg-slate-50 transition'>";
            // This shows 1, 2, 3... instead of the jumpy SQL ID
            echo "<td class='px-6 py-4 font-bold text-teal-600'>" . $row_num . "</td>"; 
            echo "<td class='px-6 py-4 font-bold text-slate-700'>" . htmlspecialchars($row['FullName']) . "</td>";
            echo "<td class='px-6 py-4 text-slate-500'>" . htmlspecialchars($row['StudentID']) . "</td>";
            echo "<td class='px-6 py-4 text-slate-500'>" . htmlspecialchars($row['Grade_and_Section']) . "</td>";
            echo "<td class='px-6 py-4 text-slate-400'>" . date('M d, Y', strtotime($row['created_at'])) . "</td>";
            // Inside your while($row = $result_admin->fetch_assoc()) loop:
            echo "<td class='px-6 py-4 text-right'>
                <button onclick='viewRecord(" . $row['id'] . ")' class='text-teal-600 hover:underline mr-2'>View</button>
                <a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")' class='text-red-400 hover:text-red-600'>Delete</a>
                </td>";
            echo "</tr>";
            
            // Increase the counter for the next row
            $row_num++; 
        }
    } else {
        echo "<tr><td colspan='6' class='px-6 py-10 text-center text-slate-400'>No student records found.</td></tr>";
    }
    ?>
</tbody>
        </table>
    </div>
</section>

    <footer class="max-w-7xl mx-auto px-6 py-12 border-t mt-20 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-2 grayscale opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            <span class="text-sm font-bold">Â© 2024 APCAS Campus Care. All rights reserved. [cite: 114]</span>
        </div>
        <div class="flex gap-6 text-sm text-slate-400">
            <a href="#" class="hover:text-teal-600">Privacy Policy</a>
            <a href="#" class="hover:text-teal-600">Terms of Service</a>
            <a href="#" class="hover:text-teal-600">Contact Support</a>
        </div>
    </footer>

    <script>
    function viewRecord(id) {
    fetch('?view_id=' + id + '&ajax=1')
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('modalContent');
            
            // Helper function to create a "Yes/No" badge
            const badge = (val) => val === 'Yes' 
                ? `<span class="text-red-600 font-bold">YES</span>` 
                : `<span class="text-slate-400">No</span>`;

            content.innerHTML = `
                <div class="max-h-[70vh] overflow-y-auto pr-2 space-y-6">
                    <div class="bg-slate-50 p-4 rounded-xl">
                        <h4 class="text-xs font-bold text-teal-600 uppercase mb-3">Student & Guardian</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div><p class="text-slate-500">Full Name</p><p class="font-bold">${data.FullName}</p></div>
                            <div><p class="text-slate-500">ID Number</p><p class="font-bold">${data.StudentID}</p></div>
                            <div><p class="text-slate-500">Grade/Section</p><p class="font-bold">${data.Grade_and_Section}</p></div>
                            <div><p class="text-slate-500">Guardian</p><p class="font-bold">${data.ParentGuardian || 'N/A'}</p></div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-teal-600 uppercase mb-2">Medical History</h4>
                        <div class="space-y-2 text-sm">
                            <p><strong>Allergies:</strong> ${data.KnownAllergies || 'None'}</p>
                            <p><strong>Childhood Diseases:</strong> ${data.ChildhoodDisease || 'None'}</p>
                            <p><strong>Surgical/Injuries:</strong> ${data.SurgicalOperations || 'None'}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="border p-3 rounded-xl">
                            <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Immunization</h4>
                            <div class="text-xs space-y-1">
                                <p class="flex justify-between">BCG: ${badge(data.BCG)}</p>
                                <p class="flex justify-between">Polio: ${badge(data.OralPolio)}</p>
                                <p class="flex justify-between">Hepa B: ${badge(data.HepaB)}</p>
                            </div>
                        </div>
                        <div class="border p-3 rounded-xl">
                            <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Covid-19</h4>
                            <div class="text-xs space-y-1">
                                <p>1st: ${data.Covid1stDose || '---'}</p>
                                <p>2nd: ${data.Covid2ndDose || '---'}</p>
                                <p>Booster: ${data.CovidBooster || '---'}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-teal-50/50 p-4 rounded-xl">
                        <h4 class="text-xs font-bold text-teal-600 uppercase mb-3">System Review & History</h4>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-1 text-xs">
                            <p class="flex justify-between">Heart Disease: ${badge(data.FamilyHeartDisease)}</p>
                            <p class="flex justify-between">Diabetes: ${badge(data.FamilyDiabetes)}</p>
                            <p class="flex justify-between">Asthma: ${badge(data.FamilyAsthma)}</p>
                            <p class="flex justify-between border-t mt-1 pt-1">Frequent Headache: ${badge(data.HeadHeadache)}</p>
                            <p class="flex justify-between border-t mt-1 pt-1">Eye Glasses: ${badge(data.EyeGlasses)}</p>
                            <p class="flex justify-between border-t mt-1 pt-1">Hearing Aid: ${badge(data.EarAid)}</p>
                            <p class="flex justify-between border-t mt-1 pt-1">Smoking: ${badge(data.HistSmoking)}</p>
                            <p class="flex justify-between border-t mt-1 pt-1">Alcohol: ${badge(data.HistAlcohol)}</p>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('viewModal').classList.remove('hidden');
        });
}

function closeModal() {
    document.getElementById('viewModal').classList.add('hidden');
}
    function showPage(pageId) {
        // --- ADMIN SECURITY CHECK ---
        if (pageId === 'admin') {
            const user = prompt("Enter Admin Username:");
            const pass = prompt("Enter Admin Password:");

            if (user === "Admin" && pass === "Password@321") {
                alert("Login Successful! Welcome to the Dashboard.");
            } else {
                alert("Access Denied: Invalid Credentials.");
                return; // Stop the function from showing the admin page
            }
        }
        // ----------------------------

        // Hide all pages
        document.querySelectorAll('.page-content').forEach(page => {
            page.classList.add('hidden');
        });
        
        // Show the selected page
        const selectedPage = document.getElementById('page-' + pageId);
        if (selectedPage) {
            selectedPage.classList.remove('hidden');
        }
        
        window.scrollTo(0, 0);
    }

    // Auto-show records page if a message (success/error) exists
    <?php if (!empty($message)): ?>
        showPage('records');
    <?php endif; ?>
    
</script>
<div id="viewModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-8 shadow-2xl relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">&times;</button>
        <h3 class="text-2xl font-bold text-teal-600 mb-6">Student Health Details</h3>
        <div id="modalContent" class="space-y-4">
            </div>
        <button onclick="closeModal()" class="mt-8 w-full bg-slate-100 py-3 rounded-xl font-bold hover:bg-slate-200 transition">Close</button>
    </div>
</div>
</body>
</html>