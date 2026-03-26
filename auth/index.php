<?php
include('../config/db_connect.php');

$message = "";
$message_type = "";

$count_query = "SELECT COUNT(*) as total FROM users";
$count_result = $conn->query($count_query);
if ($count_result) {
    $count_data = $count_result->fetch_assoc();
    $total_records = $count_data['total'];
} else {
    $total_records = 0;
}

// 4. Handle Form Submission for Health Records
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_record'])) {
    $fullName = $_POST['FullName'];
    $studentID = $_POST['StudentID'];
    $gradeSection = $_POST['Grade_and_Section'];
    $allergies = $_POST['KnownAllergies'];
    $conditions = $_POST['ExistingMedicalConditions'];
    $medications = $_POST['CurrentMedications'];

    $sql = "INSERT INTO users (FullName, StudentID, Grade_and_Section, KnownAllergies, ExistingMedicalConditions, CurrentMedications) VALUES (?, ?, ?, ?, ?, ?)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $fullName, $studentID, $gradeSection, $allergies, $conditions, $medications);
        
        if ($stmt->execute()) {
            $message = "Record submitted successfully!";
            $message_type = "success";
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Duplicate Entry error
            $message = "Error: Student ID " . htmlspecialchars($studentID) . " is already registered.";
            $message_type = "error";
        } else {
            $message = "An unexpected error occurred. Please try again.";
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APCAS Campus Care | Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <nav class="bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="bg-teal-500 p-2 rounded-lg text-white font-bold">ACC</div>
            <div>
                <h1 class="text-xl font-bold text-teal-600 leading-none">APCAS Campus Care</h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider">Student Health Portal</p>
            </div>
        </div>
        <div class="flex gap-6 font-medium text-slate-600 items-center">
            <a href="index.php" class="text-teal-600">Home</a>
            <a href="auth/Healthrecord.php" class="hover:text-teal-600 transition">Health Records</a>
            <button class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">Admin</button>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <span class="text-teal-600 font-semibold bg-teal-50 px-3 py-1 rounded-full text-sm">✨ Your Health, Our Priority</span>
                <h2 class="text-5xl font-extrabold mt-4 mb-6 leading-tight">Welcome to <br><span class="text-teal-600 uppercase">APCAS Campus Care</span></h2>
                <p class="text-lg text-slate-600 mb-8">Your comprehensive student health management portal. Submit records securely and stay informed.</p>
                <div class="flex gap-4">
                    <a href="auth/Healthrecord.php" class="bg-teal-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-teal-700 transition">Submit Health Record →</a>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-3xl font-bold"><?php echo $total_records; ?></p>
                    <p class="text-slate-500 text-sm">Total Records</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <p class="text-3xl font-bold text-teal-600">100%</p>
                    <p class="text-slate-500 text-sm">Secure Storage</p>
                </div>
                
                <div class="col-span-2 mt-4">
                    <h3 class="text-sm font-bold mb-3 text-slate-500 uppercase tracking-wider">Recent Activity</h3>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden text-sm">
                        <table class="w-full text-left">
                            <tbody class="divide-y">
                                <?php
                                $recent_sql = "SELECT FullName, created_at FROM users ORDER BY created_at DESC LIMIT 3";
                                $recent_result = $conn->query($recent_sql);
                                if ($recent_result->num_rows > 0) {
                                    while($recent = $recent_result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='px-6 py-3 font-medium text-slate-700'>" . htmlspecialchars($recent['FullName']) . "</td>";
                                        echo "<td class='px-6 py-3 text-slate-400 text-right'>" . date('M d', strtotime($recent['created_at'])) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td class='px-6 py-4 text-center text-slate-400 italic'>No records found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>