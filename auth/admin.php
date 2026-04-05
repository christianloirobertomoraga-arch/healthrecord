<?php
session_start();
// Security Guard: Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/db_connect.php';

if (isset($_POST['save_update'])) {

    $id = $_POST['id'];

    $sql = "UPDATE users SET 

    -- Basic Info
    FullName='{$_POST['FullName']}',
    StudentID='{$_POST['StudentID']}',
    Age='{$_POST['Age']}',
    DOB='{$_POST['DOB']}',
    BloodType='{$_POST['BloodType']}',
    YearLevel='{$_POST['YearLevel']}',
    Program='{$_POST['Program']}',
    ParentGuardian='{$_POST['ParentGuardian']}',
    ParentContacts='{$_POST['ParentContacts']}',

    -- History
    ChildhoodDisease='{$_POST['ChildhoodDisease']}',
    SurgicalOperations='{$_POST['SurgicalOperations']}',
    InjuriesIllness='{$_POST['InjuriesIllness']}',
    KnownAllergies='{$_POST['KnownAllergies']}',
    ExistingMedicalCondition='{$_POST['ExistingMedicalCondition']}',
    CurrentMedications='{$_POST['CurrentMedications']}',
    LastMedicalCheckUp='{$_POST['LastMedicalCheckUp']}',

    -- Immunization
    Immunization='{$_POST['Immunization']}',
    BCG='{$_POST['BCG']}',
    OralPolio='{$_POST['OralPolio']}',
    DPT='{$_POST['DPT']}',
    HepaA='{$_POST['HepaA']}',
    HepaB='{$_POST['HepaB']}',

    -- Covid
    Covid1stDose='{$_POST['Covid1stDose']}',
    Covid2ndDose='{$_POST['Covid2ndDose']}',
    CovidBooster='{$_POST['CovidBooster']}',

    -- Family History
    Family_HeartDisease='{$_POST['Family_HeartDisease']}',
    Family_Tuberculosis='{$_POST['Family_Tuberculosis']}',
    Family_Diabetes='{$_POST['Family_Diabetes']}',
    Family_Cancer='{$_POST['Family_Cancer']}',
    Family_Allergy='{$_POST['Family_Allergy']}',

    -- Checklist
    HeadHeadache='{$_POST['HeadHeadache']}',
    HeadInjury='{$_POST['HeadInjury']}',
    EyeGlasses='{$_POST['EyeGlasses']}',
    EyeContacts='{$_POST['EyeContacts']}',
    EyeTrouble='{$_POST['EyeTrouble']}',
    Ulcer='{$_POST['Ulcer']}',
    Gallbladder='{$_POST['Gallbladder']}',
    Jaundices='{$_POST['Jaundices']}',
    TumorGrowthCystCancer='{$_POST['TumorGrowthCystCancer']}',
    AbdominalPain='{$_POST['AbdominalPain']}',
    ConvulsionEpilepsy='{$_POST['ConvulsionEpilepsy']}',
    Difficultytosleep='{$_POST['Difficultytosleep']}',
    PsychiatricTreatment='{$_POST['PsychiatricTreatment']}',
    Concentration='{$_POST['Concentration']}',
    LossofMemory='{$_POST['LossofMemory']}',
    Excessivesleepiness='{$_POST['Excessivesleepiness']}',
    HistExercise='{$_POST['HistExercise']}',
    HistSmoking='{$_POST['HistSmoking']}',
    HistAlcohol='{$_POST['HistAlcohol']}',
    HistDrugs='{$_POST['HistDrugs']}',
    EarHearing='{$_POST['EarHearing']}',
    EarAid='{$_POST['EarAid']}',
    EarEardrum='{$_POST['EarEardrum']}',
    EarCleft='{$_POST['EarCleft']}',
    EarSpeech='{$_POST['EarSpeech']}',
    NeckMass='{$_POST['NeckMass']}',
    Tuberculosis='{$_POST['Tuberculosis']}',
    Asthma='{$_POST['Asthma']}',
    ShortnessofBreath='{$_POST['ShortnessofBreath']}',
    PainChest='{$_POST['PainChest']}',
    Palpitation='{$_POST['Palpitation']}',
    HeartTrouble='{$_POST['HeartTrouble']}',
    HighBloodPress='{$_POST['HighBloodPress']}',
    WornNeckBackBraceSupport='{$_POST['WornNeckBackBraceSupport']}',
    BoneJointDisabilityDeformity='{$_POST['BoneJointDisabilityDeformity']}',
    LossArmLegfingertoe='{$_POST['LossArmLegfingertoe']}',
    FootTrouble='{$_POST['FootTrouble']}'

    WHERE id=$id
    ";

    if ($conn->query($sql)) {
        echo "<script>alert('Record updated successfully'); window.location.href='admin.php';</script>";
    } else {
        echo "Error updating: " . $conn->error;
    }
}
// DELETE RECORD
if (isset($_GET['delete_id'])) {

    $id = intval($_GET['delete_id']);

    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql)) {
        echo "<script>alert('Record deleted successfully'); window.location.href='admin.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Run query FIRST
$sql_admin = "SELECT * FROM users ORDER BY created_at DESC";
$result_admin = $conn->query($sql_admin);
?>
<style>
@media print {
    /* Hide everything you don't want on paper */
    nav, .sidebar, .flex-col, button, .no-print, .text-right {
        display: none !important;
    }

    /* Ensure the table takes up the full page width */
    body, .max-w-7xl, section {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    /* Make sure hidden Excel columns stay hidden in print too */
    .hidden {
        display: none !important;
    }

    /* Force the table to show borders on paper */
    th, td {
        border: 1px solid #ddd !important;
        padding: 8px !important;
        color: black !important;
    }
}
</style>
<style>
    @media print {
    /* Hide UI elements like buttons, sidebars, and close icons */
    .no-print, button, .close-modal, nav, .sidebar {
        display: none !important;
    }

    /* Reset background colors for printer ink saving */
    body {
        background-color: white !important;
        color: black !important;
    }

    /* Ensure labels and headers are bold on paper */
    h2, h3, strong, b {
        color: black !important;
        font-weight: bold !important;
    }

    /* If your view uses a grid (2 columns), force it to look clean on paper */
    .grid {
        display: block !important;
    }

    .border-b {
        border-bottom: 1px solid #000 !important;
        margin-bottom: 15px !important;
        padding-bottom: 5px !important;
    }
}
</style>
<?php include '../header.php'; ?>


<!-- Table Controls: Search | Input | Export -->
<div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
    
    <!-- 1. Left: Search Bar -->
    <div class="relative w-full md:w-80">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input 
            type="text" 
            id="adminSearchInput" 
            onkeyup="filterAdminTable()" 
            placeholder="Search records..." 
            class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-teal-500 outline-none text-sm transition shadow-sm"
        >
    </div>

    <!-- Container for Right-side Buttons -->
    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
        
        <a href="admin_announcements.php" 
           class="flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-5 py-2.5 rounded-xl font-bold transition shadow-sm text-sm whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            New Announcement
        </a>

        <!-- 2. Middle: Input New Data Button -->
        <a href="../Healthrecord.php" 
           class="flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-5 py-2.5 rounded-xl font-bold transition shadow-sm text-sm whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Input New Data
        </a>

        <button 
        onclick="window.print()" 
        class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold transition shadow-sm text-sm"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Print Report
    </button>


        <!-- 3. Right: Export Button -->
        <button 
            onclick="exportTableToExcel('admin-table')" 
            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold transition shadow-md text-sm whitespace-nowrap"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                <polyline points="14.5 2 14.5 8 20 8"/>
                <line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/>
            </svg>
            Export to Excel
        </button>
    </div>
</div>
<section class="max-w-7xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
       <table id="admin-table" class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">Full Name</th>
                    <th class="px-6 py-4">Student ID</th>
                    <th class="px-6 py-4">Year and Program</th>
                    <th class="px-6 py-4">Date Submitted</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                <?php
if ($result_admin && $result_admin->num_rows > 0) {
    $row_num = 1; // Initialize the counter
    while($row = $result_admin->fetch_assoc()) {
        ?>
        <tr class="hover:bg-slate-50 transition">
            <td class="px-6 py-4 font-bold text-teal-600"><?= $row_num++ ?></td>
            
            <td class="px-6 py-4 font-bold text-slate-700"><?= htmlspecialchars($row['FullName']) ?></td>
            <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($row['StudentID']) ?></td>
            
            <td class="px-6 py-4 text-slate-500">
                <?= htmlspecialchars($row['YearLevel'] . " - " . $row['Program']) ?>
            </td>
            
            <td class="px-6 py-4 text-slate-400"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
            
            <td class="px-6 py-4 text-right flex justify-end gap-3 items-center">
                <button onclick="viewRecord(<?= $row['id'] ?>)" class="text-teal-600 hover:underline">View</button>
                
                <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)" 
                    class="text-slate-600 hover:text-teal-600 transition">
                    Edit
                </button>

                <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="text-red-400 hover:text-red-600">
                    Delete
                </a>
            </td>
        </tr>
        <?php
    } // End of While
} else {
    // Optional: Show this if the database is empty
    echo "<tr><td colspan='6' class='p-10 text-center text-slate-400'>No health records found.</td></tr>";
}
?>
            </tbody>
        </table>
    </div>
</section>

<?php include '../footer.php'; ?>

<script>
function filterAdminTable() {
    // Declare variables
    var input, filter, table, tr, td, i, j, txtValue, visibleCount;
    input = document.getElementById("adminSearchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector("table"); // Targets your existing table
    tr = table.getElementsByTagName("tr");
    visibleCount = 0;

    // Loop through all table rows (starting from index 1 to skip header)
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none"; // Hide the row by default
        td = tr[i].getElementsByTagName("td");
        
        // Loop through every cell in the current row
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = ""; // Show row if match found
                    visibleCount++;
                    break; // Stop looking in this row once a match is found
                }
            }
        }
    }
    
    // Update the record counter
    document.getElementById("visibleRowCount").innerText = visibleCount;
}

// Run once on load to set initial count
document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll("table tr").length - 1;
    document.getElementById("visibleRowCount").innerText = rows > 0 ? rows : 0;
});
// Helper to create Yes/No badges
function badge(value) {
    const isPositive = value === 'Yes' || value === '1' || value === true;
    const color = isPositive ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700';
    const text = isPositive ? 'Yes' : 'No';
    return `<span class="px-2 py-0.5 rounded-full font-bold ${color}">${text}</span>`;
}

function openEditModal(data) {
    console.log("Data received for editing:", data);
    if (!data) {
        alert("Error: No data received for this student.");
        return;
    }

    // 1. Set the record ID (for UPDATE query)
    document.getElementById('edit_id').value = data.id;

    // 2. Map General Information (Updated to match new SQL)
    document.getElementById('edit_FullName').value = data.FullName || '';
    document.getElementById('edit_StudentID').value = data.StudentID || '';
    document.getElementById('edit_Age').value = data.Age || '';
    document.getElementById('edit_DOB').value = data.DOB || '';
    document.getElementById('edit_BloodType').value = data.BloodType || '';
    document.getElementById('edit_YearLevel').value = data.YearLevel || '';
    document.getElementById('edit_Program').value = data.Program || '';
    document.getElementById('edit_ParentGuardian').value = data.ParentGuardian || '';
    document.getElementById('edit_ParentContacts').value = data.ParentContacts || '';

    // 3. Map Vaccination Dates
    document.getElementById('edit_Covid1stDose').value = data.Covid1stDose || '';
    document.getElementById('edit_Covid2ndDose').value = data.Covid2ndDose || '';
    document.getElementById('edit_CovidBooster').value = data.CovidBooster || '';

    // 4. Map Medical Information (Textareas)
    document.getElementById('edit_ChildhoodDisease').value = data.ChildhoodDisease || '';
    document.getElementById('edit_SurgicalOperations').value = data.SurgicalOperations || '';
    document.getElementById('edit_InjuriesIllness').value = data.InjuriesIllness || '';
    document.getElementById('edit_KnownAllergies').value = data.KnownAllergies || '';
    document.getElementById('edit_ExistingMedicalCondition').value = data.ExistingMedicalCondition || '';
    document.getElementById('edit_CurrentMedications').value = data.CurrentMedications || '';
    document.getElementById('edit_LastMedicalCheckUp').value = data.LastMedicalCheckUp || '';
    
    // 5. Dynamic Map for ALL Checkboxes/Dropdowns (Matches new SQL exactly)
    const checkables = [
        'Immunization', 'BCG', 'OralPolio', 'DPT', 'HepaA', 'HepaB',
        'Family_HeartDisease', 'Family_Tuberculosis', 'Family_Diabetes', 'Family_Cancer', 'Family_Allergy',
        'HeadHeadache', 'HeadInjury', 'EyeGlasses', 'EyeContacts', 'EyeTrouble',
        'Ulcer', 'Gallbladder', 'Jaundices', 'TumorGrowthCystCancer', 'AbdominalPain',
        'ConvulsionEpilepsy', 'Difficultytosleep', 'PsychiatricTreatment', 'Concentration', 
        'LossofMemory', 'Excessivesleepiness', 'HistExercise', 'HistSmoking', 'HistAlcohol', 'HistDrugs',
        'EarHearing', 'EarAid', 'EarEardrum', 'EarCleft', 'EarSpeech', 'NeckMass',
        'Tuberculosis', 'Asthma', 'ShortnessofBreath', 'PainChest', 'Palpitation', 
        'HeartTrouble', 'HighBloodPress', 'WornNeckBackBraceSupport', 
        'BoneJointDisabilityDeformity', 'LossArmLegfingertoe', 'FootTrouble'
    ];

    checkables.forEach(field => {
        const el = document.getElementById('edit_' + field);
        if (el) { el.value = data[field] || 'No'; }
    });

    document.getElementById('editModal').classList.remove('hidden');
}


// Navigation & Modal Closing Logic
function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }
function closeModal() { document.getElementById('viewModal').classList.add('hidden'); }

window.onload = () => {
    const lastPage = localStorage.getItem('activePage') || 'home';
    showPage(lastPage);
};

<?php if (!empty($message)): ?>
    showPage('records');
<?php endif; ?>
</script>
<div id="viewModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-5xl w-full p-8 shadow-2xl relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
        <h3 class="text-2xl font-bold text-teal-600 mb-6">Student Health Details</h3>
            <div id="modalContent" class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
            </div>
        <div class="flex gap-3 mt-6">
    <button onclick="printMedicalRecord('modalContent')" 
        class="flex-1 bg-teal-600 text-white py-3 rounded-xl font-bold hover:bg-teal-700 transition">
        Print Record
    </button>

    <button onclick="closeModal()" 
        class="flex-1 bg-slate-100 py-3 rounded-xl font-bold hover:bg-slate-200 transition">
        Close
    </button>
</div>
    </div>
</div>
<div id="editModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden shadow-2xl relative flex flex-col">
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Edit Student Health Record</h3>
                <p class="text-xs text-slate-500">Update all medical information for this student.</p>
            </div>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-red-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        
        <form id="editForm" method="POST" class="overflow-y-auto p-8 space-y-8 custom-scrollbar">
            <input type="hidden" name="id" id="edit_id">
            
            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Full Name</label>
                    <input type="text" name="FullName" id="edit_FullName" class="w-full border-2 border-slate-100 p-3 rounded-xl focus:border-teal-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Student ID</label>
                    <input type="text" name="StudentID" id="edit_StudentID" class="w-full border-2 border-slate-100 p-3 rounded-xl focus:border-teal-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Age</label>
                    <input type="number" name="Age" id="edit_Age" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Date of Birth</label>
                    <input type="date" name="DOB" id="edit_DOB" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Blood Type</label>
                    <input type="text" name="BloodType" id="edit_BloodType" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Year Level</label>
                        <input type="text" name="YearLevel" id="edit_YearLevel" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Program</label>
                        <input type="text" name="Program" id="edit_Program" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Guardian</label>
                        <input type="text" name="ParentGuardian" id="edit_ParentGuardian" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold font-black text-teal-600 uppercase mb-1">Guardian Contact</label>
                        <input type="text" name="ParentContacts" id="edit_ParentContacts" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase">History</h5>
                    <textarea name="ChildhoodDisease" id="edit_ChildhoodDisease" placeholder="Childhood Diseases" class="w-full border p-3 rounded-xl text-sm" rows="2"></textarea>
                    <textarea name="SurgicalOperations" id="edit_SurgicalOperations" placeholder="Surgical Operations" class="w-full border p-3 rounded-xl text-sm" rows="2"></textarea>
                    <textarea name="ExistingMedicalCondition" id="edit_ExistingMedicalCondition" placeholder="Existing Conditions" class="w-full border p-3 rounded-xl text-sm" rows="2"></textarea>
                </div>
                <div class="space-y-4">
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase">Current Status</h5>
                    <textarea name="KnownAllergies" id="edit_KnownAllergies" placeholder="Known Allergies" class="w-full border p-3 rounded-xl text-sm border-red-100" rows="2"></textarea>
                    <textarea name="InjuriesIllness" id="edit_InjuriesIllness" placeholder="Injuries / Hospitalization" class="w-full border p-3 rounded-xl text-sm" rows="2"></textarea>
                    <textarea name="CurrentMedications" id="edit_CurrentMedications" placeholder="Current Medications" class="w-full border p-3 rounded-xl text-sm" rows="2"></textarea>
                </div>
                    <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase">Last Medical Check Up</h5>
                    <input type="date" name="LastMedicalCheckUp" id="edit_LastMedicalCheckUp" class="w-full border-2 border-slate-100 p-3 rounded-xl outline-none transition">
                </div>            
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="p-5 border rounded-2xl bg-slate-50">
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase mb-4">Basic Immunization</h5>
                    <div class="grid grid-cols-2 gap-4">
                        <?php 
                        $immunes = ['BCG', 'OralPolio', 'DPT', 'HepaA', 'HepaB', 'Immunization'];
                        foreach($immunes as $f): ?>
                            <div class="flex justify-between items-center">
                                <label class="text-xs text-slate-600"><?= $f ?>:</label>
                                <select name="<?= $f ?>" id="edit_<?= $f ?>" class="text-xs border rounded-lg p-1">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="p-5 border rounded-2xl bg-slate-50">
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase mb-4">Covid-19 Vaccination</h5>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between"><label class="text-xs text-slate-600">1st Dose:</label><input type="date" name="Covid1stDose" id="edit_Covid1stDose" class="text-xs border rounded p-1"></div>
                        <div class="flex items-center justify-between"><label class="text-xs text-slate-600">2nd Dose:</label><input type="date" name="Covid2ndDose" id="edit_Covid2ndDose" class="text-xs border rounded p-1"></div>
                        <div class="flex items-center justify-between"><label class="text-xs text-slate-600">Booster:</label><input type="date" name="CovidBooster" id="edit_CovidBooster" class="text-xs border rounded p-1"></div>
                    </div>
                </div>
            </div>

            <div class="border rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-slate-100 px-4 py-2 text-[10px] font-black text-slate-500 uppercase">Detailed Health Checklist</div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-5 bg-white">
                    <?php 
                    $checkables = [
                        'Family_HeartDisease', 'Family_Tuberculosis', 'Family_Diabetes', 'Family_Cancer', 'Family_Allergy',
                        'HeadHeadache', 'HeadInjury', 'EyeGlasses', 'EyeContacts', 'EyeTrouble', 'Ulcer', 'Gallbladder',
                        'Jaundices', 'TumorGrowthCystCancer', 'AbdominalPain', 'ConvulsionEpilepsy', 'Difficultytosleep',
                        'PsychiatricTreatment', 'Concentration', 'LossofMemory', 'Excessivesleepiness', 'HistExercise',
                        'HistSmoking', 'HistAlcohol', 'HistDrugs', 'EarHearing', 'EarAid', 'EarEardrum', 'EarCleft',
                        'EarSpeech', 'NeckMass', 'Tuberculosis', 'Asthma', 'ShortnessofBreath', 'PainChest', 
                        'Palpitation', 'HeartTrouble', 'HighBloodPress', 'WornNeckBackBraceSupport', 
                        'BoneJointDisabilityDeformity', 'LossArmLegfingertoe', 'FootTrouble'
                    ];
                    foreach($checkables as $c): ?>
                        <div class="flex flex-col gap-1">
                            <label class="text-[9px] font-bold text-slate-400 uppercase"><?= str_replace('_', ' ', $c) ?></label>
                            <select name="<?= $c ?>" id="edit_<?= $c ?>" class="text-[11px] border rounded p-1 bg-slate-50">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex gap-4 pt-6 sticky bottom-0 bg-white">
                <button type="submit" name="save_update" class="flex-1 bg-teal-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-teal-700 shadow-lg shadow-teal-200 transition-all">Update Health Record</button>
                <button type="button" onclick="closeEditModal()" class="px-8 bg-slate-100 text-slate-500 py-4 rounded-2xl font-bold hover:bg-slate-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
function viewRecord(id) {
    const modal = document.getElementById('viewModal');
    const content = document.getElementById('modalContent');
    modal.classList.remove('hidden');
    content.innerHTML = '<div class="flex justify-center p-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-600"></div></div>';
    
    fetch(`get_student_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Helper for Badge styling in View Mode
            const getBadge = (val) => {
                const isYes = val === 'Yes';
                return `<span class="px-2 py-0.5 rounded text-[14px] font-bold ${isYes ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'}">${val || 'No'}</span>`;
            };

            content.innerHTML = `
                <div class="space-y-8">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Full Name</p><p class="text-sm font-bold text-slate-800">${data.FullName || '-'}</p></div>
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Student ID</p><p class="text-sm font-bold text-slate-800">${data.StudentID || '-'}</p></div>
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Program</p><p class="text-sm font-bold text-slate-800">${data.YearLevel} - ${data.Program}</p></div>
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Age / DOB</p><p class="text-sm text-slate-700">${data.Age} yrs | ${data.DOB}</p></div>
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Blood Type</p><p class="text-sm text-slate-700">${data.BloodType || '-'}</p></div>
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Parent</p><p class="text-sm text-slate-700">${data.ParentGuardian || '-'}</p></div>
                        <div><p class="text-[14px] uppercase font-bold text-slate-400">Guardian Contact</p><p class="text-sm text-slate-700">${data.ParentContacts || '-'}</p></div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <h5 class="text-[10px] font-black text-teal-600 uppercase">Previous Medical History</h5>
                            <div class="p-3 border rounded-lg text-md bg-white"><b>Childhood:</b> ${data.ChildhoodDisease || 'None'}</div>
                            <div class="p-3 border rounded-lg text-md bg-white"><b>Surgeries:</b> ${data.SurgicalOperations || 'None'}</div>
                            <div class="p-3 border rounded-lg text-md bg-white"><b>Injuries/Illness/Hospitalizations:</b> ${data.InjuriesIllness || 'None'}</div>
                        </div>
                        <div class="space-y-3">
                            <h5 class="text-[10px] font-black text-teal-600 uppercase">Current Status</h5>
                            <div class="p-3 border border-red-100 rounded-lg text-md bg-red-50/30"><b>Allergies:</b> ${data.KnownAllergies || 'None'}</div>
                            <div class="p-3 border rounded-lg text-md bg-white"><b>Existing Medical Conditions:</b> ${data.ExistingMedicalCondition || 'None'}</div>
                            <div class="p-3 border rounded-lg text-md bg-white"><b>Current Medications:</b> ${data.CurrentMedications || 'None'}</div>
                            <div class="p-3 border rounded-lg text-md bg-white font-bold">Last Medical Check Up:</b> ${data.LastMedicalCheckUp || 'N/A'}</div>
                            </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Basic Immunization</h5>
                            <div class="grid grid-cols-2 gap-2 text-[14px]">
                                <div class="flex justify-between"><span>Immunization:</span> ${getBadge(data.Immunization)}</div>
                                <div class="flex justify-between"><span>BCG:</span> ${getBadge(data.BCG)}</div>
                                <div class="flex justify-between"><span>Polio:</span> ${getBadge(data.OralPolio)}</div>
                                <div class="flex justify-between"><span>DPT:</span> ${getBadge(data.DPT)}</div>
                                <div class="flex justify-between"><span>Hepa A:</span> ${getBadge(data.HepaA)}</div>
                                <div class="flex justify-between"><span>Hepa B:</span> ${getBadge(data.HepaB)}</div>
                            </div>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Covid-19 Vaccination</h5>
                            <div class="text-[14px] space-y-1">
                                <div class="flex justify-between"><span>1st Dose:</span> <span class="font-bold">${data.Covid1stDose || 'N/A'}</span></div>
                                <div class="flex justify-between"><span>2nd Dose:</span> <span class="font-bold">${data.Covid2ndDose || 'N/A'}</span></div>
                                <div class="flex justify-between"><span>Booster:</span> <span class="font-bold">${data.CovidBooster || 'N/A'}</span></div>
                            </div>
                        </div>
                    </div>

                     <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Family History</h5>
                            <div class="grid grid-cols-1 gap-2 text-[14px]">
                            <div class="flex justify-between border-b border-slate-50"><span>Heart Disease</span> ${getBadge(data.Family_HeartDisease)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Tuberculosis</span> ${getBadge(data.Family_Tuberculosis)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Diabetes</span> ${getBadge(data.Family_Diabetes)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Cancer</span> ${getBadge(data.Family_Cancer)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Allergy</span> ${getBadge(data.Family_Allergy)}</div>
                            </div>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Habit/Social</h5>
                            <div class="text-[14px] space-y-1">
                                <div class="flex justify-between border-b border-slate-50"><span>Regular Exercise</span> ${getBadge(data.HistExercise)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Smoking</span> ${getBadge(data.HistSmoking)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Alcohol</span> ${getBadge(data.HistAlcohol)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Drugs</span> ${getBadge(data.HistDrugs)}</div>
                         </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14x] font-bold text-slate-400 uppercase mb-3">Head</h5>
                            <div class="grid grid-cols-1 gap-2 text-[14px]">
                            <div class="flex justify-between border-b border-slate-50"><span>Frequent Headache</span> ${getBadge(data.HeadHeadache)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Severe Head Injury</span> ${getBadge(data.HeadInjury)}</div>
                            </div>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Ear, Nose and Throat</h5>
                            <div class="text-[14px] space-y-1">
                            <div class="flex justify-between border-b border-slate-50"><span>Difficulty Hearing</span> ${getBadge(data.EarHearing)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Worn Hearing Aid</span> ${getBadge(data.EarAid)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Ruptured Eardrum</span> ${getBadge(data.EarEardrum)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Cleft Palate</span> ${getBadge(data.EarCleft)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Speech Problem Palate</span> ${getBadge(data.EarSpeech)}</div>
                         </div>
                    </div>

                       <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Eyes</h5>
                            <div class="grid grid-cols-1 gap-2 text-[14px]">
                            <div class="flex justify-between border-b border-slate-50"><span>Worn Eyeglasses</span> ${getBadge(data.EyeGlasses)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Worn Contact Lenses</span> ${getBadge(data.EyeContacts)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Eye Trouble</span> ${getBadge(data.EyeTrouble)}</div>
                            </div>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Neck</h5>
                            <div class="text-[14px] space-y-1">
                            <div class="flex justify-between border-b border-slate-50"><span>Enlarge Mass</span> ${getBadge(data.NeckMass)}</div>
                        </div>
                    </div>
                     
                    <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Abdomen</h5>
                            <div class="grid grid-cols-1 gap-2 text-[14px]">
                            <div class="flex justify-between border-b border-slate-50"><span>Ulcer</span> ${getBadge(data.Ulcer)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Gall bladder</span> ${getBadge(data.Gallbladder)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Jaundices</span> ${getBadge(data.Jaundices)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Tumor Growth, Cyst, Cancer</span> ${getBadge(data.TumorGrowthCystCancer)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Abdominal Pain</span> ${getBadge(data.AbdominalPain)}</div>
                            </div>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Heart and Lungs</h5>
                            <div class="text-[14px] space-y-1">
                            <div class="flex justify-between border-b border-slate-50"><span>Tuberculosis</span> ${getBadge(data.Tuberculosis)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Asthma</span> ${getBadge(data.Asthma)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Shortness of Breath</span> ${getBadge(data.ShortnessofBreath)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Pain/Pressure in Chest</span> ${getBadge(data.PainChest)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Palpitation</span> ${getBadge(data.Palpitation)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Heart Trouble</span> ${getBadge(data.HeartTrouble)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>High Blood Pressure</span> ${getBadge(data.HighBloodPress)}</div>
                        </div>
                    </div>

                     <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Nervous System</h5>
                            <div class="grid grid-cols-1 gap-2 text-[14px]">
                            <div class="flex justify-between border-b border-slate-50"><span>Convulsion or Epilepsy</span> ${getBadge(data.ConvulsionEpilepsy)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Difficulty of going to sleep</span> ${getBadge(data.Difficultytosleep)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Previous Psychiatric Treatment</span> ${getBadge(data.PsychiatricTreatment)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Difficulty in Concentration </span> ${getBadge(data.Concentration )}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Loss of Memory or Amnesia</span> ${getBadge(data.LossofMemory)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Excessive sleepiness</span> ${getBadge(data.Excessivesleepiness)}</div>
                            </div>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <h5 class="text-[14px] font-bold text-slate-400 uppercase mb-3">Bone and Joint</h5>
                            <div class="text-[14px] space-y-1">
                            <div class="flex justify-between border-b border-slate-50"><span>Worn Neck or Back Brace Support</span> ${getBadge(data.WornNeckBackBraceSupport)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Bone and Joint Disability or Deformity</span> ${getBadge(data.BoneJointDisabilityDeformity)}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Loss of Arm, Leg, finger, or toe </span> ${getBadge(data.LossArmLegfingertoe )}</div>
                            <div class="flex justify-between border-b border-slate-50"><span>Foot Trouble</span> ${getBadge(data.FootTrouble)}</div>
                        </div>
                    </div>
            `;
        })
        .catch(err => {
            content.innerHTML = '<p class="text-red-500 text-center p-10">Failed to load record details.</p>';
        });
}
</script>
<!-- Load SheetJS Library -->
<script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>

<script>
/**
 * Filters the table rows based on search input
 */

/**
 * Exports the HTML table to an Excel file
 */
function exportTableToExcel(tableId) {
    const table = document.getElementById(tableId);
    if (!table) {
        alert("System Error: Table not found. Please ensure the table has id='admin-table'.");
        return;
    }

    try {
        // 1. Create a worksheet from the HTML table
        const worksheet = XLSX.utils.table_to_sheet(table);
        
        // 2. Create a new empty workbook and append the worksheet
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Health Records");

        // 3. Generate a dynamic filename with today's date
        const date = new Date().toISOString().slice(0, 10);
        const filename = `Student_Health_Records_${date}.xlsx`;

        // 4. Trigger the download
        XLSX.writeFile(workbook, filename);
    } catch (error) {
        console.error("Excel Export Error:", error);
        alert("Failed to export. Please check the browser console for details.");
    }
}
function printMedicalRecord(divId) {
    const content = document.getElementById(divId).innerHTML;

    const printWindow = window.open('', '', 'width=900,height=650');

    printWindow.document.write(`
        <html>
        <head>
            <title>Medical Record</title>
            <style>
                body {
                    font-family: 'Times New Roman', serif;
                    padding: 10px;
                }
                h1 {
                    text-align: left;
                    margin-bottom: 5px;
                }
                p {
                    text-align: left;
                    margin-top: 0;
                }
                .section {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <h1>STUDENT HEALTH SERVICES</h1>
            <p>Official Medical Examination Record</p>
            <hr>

            ${content}

            <br><br>
            <div style="display:flex; justify-content:space-between;">
                <div>
                    _______________________<br>
                    School Nurse Signature
                </div>
                <div>
                    Date Printed: ${new Date().toLocaleDateString()}
                </div>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print();
}
</script>
</body>
</html>