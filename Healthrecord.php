<?php 
// 1. Session and Security
session_start();

// 2. Database Connection (Note the ../ to go up one folder)
include_once 'config/db_connect.php';

// 3. Logic for Success/Error Messages
$message = "";
$message_type = "";

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $message = "Your health record has been submitted successfully.";
        $message_type = "success";
    } elseif ($_GET['status'] == 'error') {
        $message = "There was an error saving your record. Please try again.";
        $message_type = "error";
    } elseif ($_GET['status'] == 'duplicate') {
        $message = "A record with this Student ID already exist.";
        $message_type = "error";
    }
}

// 4. The Top Piece (Note the ../)
include 'header.php'; 
?>


<section id="page-records" class="page-content max-w-4xl mx-auto py-12 px-6">

<!-- Data Privacy Security Note -->
<div class="mt-6 bg-teal-50 border border-teal-100 rounded-2xl p-6 text-sm text-slate-600 leading-relaxed shadow-sm flex items-start gap-3">
    <!-- Optional: A small shield icon to emphasize security -->
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-teal-600 mt-0.5 flex-shrink-0">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
    </svg>
    <p>
        <span class="font-bold text-teal-700">Security Note:</span> 
        All records are encrypted and only accessible by authorized school health personnel in compliance with <span class="font-semibold text-slate-700">Data Privacy Act of 2012</span>.
    </p>
</div><br>

<?php if (!empty($message)): ?>
        <div class="<?php echo ($message_type == 'success') ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500'; ?> border-l-4 p-4 mb-6 rounded-r-xl shadow-sm">
            <div class="flex items-center gap-3">
                <div class="<?php echo ($message_type == 'success') ? 'text-green-500' : 'text-red-500'; ?>">
                    <?php if ($message_type == 'success'): ?>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    <?php else: ?>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-sm font-bold <?php echo ($message_type == 'success') ? 'text-green-800' : 'text-red-800'; ?> uppercase tracking-wide">
                        <?php echo ($message_type == 'success') ? 'Action Successful' : 'Attention Required'; ?>
                    </p>
                    <p class="text-xs <?php echo ($message_type == 'success') ? 'text-green-700' : 'text-red-700'; ?> mt-1"><?php echo $message; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
<form id="healthDataForm" action="auth/submit.php" method="POST">
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 mb-8">
    <div class="flex items-center gap-4 mb-2">
        <div class="p-3 bg-teal-500 rounded-xl text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Student Health Record Form</h2>
    </div>
    <p class="text-slate-500 text-sm ml-14">Please fill in all required fields (*) to submit your health record</p><br>    
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex items-center gap-2 text-teal-600 font-bold uppercase tracking-wider text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Student Information
        </div><br>
            <div>
                <label class="block text-sm font-semibold mb-2">FullName * (E.g Juan A. DelaCruz)</label>
                <input type="text" name="FullName" required class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">StudentID *</label>
                <input type="text" name="StudentID" required class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Age *</label>
                <input name="Age" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/30 focus:border-teal-500 transition-all outline-none">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Date of Birth</label>
                <input type="date" name="DOB" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/30 focus:border-teal-500 outline-none">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Blood Type</label>
                <select name="BloodType" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/30 focus:border-teal-500 outline-none">
                    <option value="">Select blood type</option>
                    <option>O+</option>
                    <option>O-</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Year *</label>
                <select name="YearLevel" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/30 focus:bg-white focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none appearance-none">
                    <option value="">Select year level</option>
                    <option>SECONDARY EDUCATION</option>
                    <option>1st Year</option>
                    <option>2nd Year</option>
                    <option>3rd Year</option>
                    <option>4th Year</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Program *</label>
                <select name="Program" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/30 focus:border-teal-500 transition-all outline-none">
                    <option value="">Select program</option>
                    <option>BSIT/ACT</option>
                    <option>BSN</option>
                    <option>BSCE</option>
                    <option>BSA</option>
                    <option>BSED</option>
                    <option>BSPSYCH</option>
                    <option>JUNIOR HIGH</option>
                    <option>SENIOR HIGH</option>
                </select>
            </div><br>
        
            <div>
                <label class="block text-sm font-semibold mb-2">Parent / Guardian (E.g Juan S. Dela Cruz)</label>
                <input type="text" name="ParentGuardian" class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Parent Contact No.</label>
                <input type="text" name="ParentContacts" class="w-full border p-3 rounded-xl bg-slate-50 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div><label class="text-sm font-semibold">Childhood Diseases</label><textarea name="ChildhoodDisease" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div><label class="text-sm font-semibold">Surgical Operations</label><textarea name="SurgicalOperations" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div class="md:col-span-2"><label class="text-sm font-semibold">Injuries / Illness / Hospitalizations</label><textarea name="InjuriesIllness" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
        </div>
         
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">Medical Information</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div><label class="text-sm font-semibold">Known Allergies</label><textarea name="KnownAllergies" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div><label class="text-sm font-semibold">Existing Medical Condition</label><textarea name="ExistingMedicalCondition" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
            <div><label class="text-sm font-semibold">Current Medications</label><textarea name="CurrentMedications" rows="2" class="w-full border p-3 rounded-xl bg-slate-50"></textarea></div>
                <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Last Medical Check Up</label>
                <input type="date" name="LastMedicalCheckUp" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/30 focus:border-teal-500 outline-none">
                </div>
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

<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <h3 class="text-lg font-bold border-b pb-4 mb-6 text-teal-600 uppercase">Health Checklist</h3>
    
    <div class="grid md:grid-cols-2 gap-8 items-start">
        
        <div class="space-y-8">
            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Family History</p>
                <div class="space-y-2">
                    <?php foreach(['HeartDisease', 'Tuberculosis', 'Diabetes', 'Cancer', 'Allergy'] as $f): ?>
                        <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded">
                            <span><?= preg_replace('/(?<!^)([A-Z])/', ' $1', $f) ?></span>
                            <input type="checkbox" name="Family_<?= $f ?>" value="Yes">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Head</p>
                <div class="space-y-2 mb-4">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Frequent Headache</span><input type="checkbox" name="HeadHeadache" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Severe Head Injury</span><input type="checkbox" name="HeadInjury" value="Yes"></label>
                </div>
                <p class="font-bold text-sm mb-4 text-slate-400">Eyes</p>
                <div class="space-y-2">   
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Worn Eyeglasses</span><input type="checkbox" name="EyeGlasses" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Worn Contact Lenses</span><input type="checkbox" name="EyeContacts" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Eye Trouble</span><input type="checkbox" name="EyeTrouble" value="Yes"></label>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Abdomen</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Ulcer</span><input type="checkbox" name="Ulcer" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Gall bladder</span><input type="checkbox" name="Gallbladder" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Jaundices</span><input type="checkbox" name="Jaundices" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Tumor Growth, Cyst, Cancer</span><input type="checkbox" name="TumorGrowthCystCancer" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Abdominal Pain</span><input type="checkbox" name="AbdominalPain" value="Yes"></label>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Nervous System</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Convulsion or Epilepsy</span><input type="checkbox" name="ConvulsionEpilepsy" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Difficulty of going to sleep</span><input type="checkbox" name="Difficultytosleep" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Previous Psychiatric Treatment</span><input type="checkbox" name="PsychiatricTreatment" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Difficulty in Concentration </span><input type="checkbox" name="Concentration" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Loss of Memory or Amnesia</span><input type="checkbox" name="LossofMemory" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Excessive sleepiness</span><input type="checkbox" name="Excessivesleepiness" value="Yes"></label>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Habits/Social</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Regular Exercise</span><input type="checkbox" name="HistExercise" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Smoking</span><input type="checkbox" name="HistSmoking" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Alcohol</span><input type="checkbox" name="HistAlcohol" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Drugs</span><input type="checkbox" name="HistDrugs" value="Yes"></label>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Ear, Nose & Throat</p>
                <div class="space-y-2 mb-4">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Difficulty Hearing</span><input type="checkbox" name="EarHearing" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Worn Hearing Aid</span><input type="checkbox" name="EarAid" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Ruptured Eardrum</span><input type="checkbox" name="EarEardrum" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Cleft Palate</span><input type="checkbox" name="EarCleft" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Speech Problem</span><input type="checkbox" name="EarSpeech" value="Yes"></label>
                </div>
                <p class="font-bold text-sm mb-4 text-slate-400">Neck</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Enlarge Mass</span><input type="checkbox" name="NeckMass" value="Yes"></label>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Heart and Lungs</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Tuberculosis</span><input type="checkbox" name="Tuberculosis" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Asthma</span><input type="checkbox" name="Asthma" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Shortness of Breath</span><input type="checkbox" name="ShortnessofBreath" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Pain/Pressure in Chest</span><input type="checkbox" name="PainChest" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Palpitation</span><input type="checkbox" name="Palpitation" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Heart Trouble</span><input type="checkbox" name="HeartTrouble" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>High Blood Pressure</span><input type="checkbox" name="HighBloodPress" value="Yes"></label>
                </div>
            </div>

            <div>
                <p class="font-bold text-sm mb-4 text-slate-400">Bone and Joint</p>
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Worn Neck or Back Brace Support</span><input type="checkbox" name="WornNeckBackBraceSupport" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Bone and Joint Disability or Deformity</span><input type="checkbox" name="BoneJointDisabilityDeformity" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Loss of Arm, Leg, finger, or toe </span><input type="checkbox" name="LossArmLegfingertoe" value="Yes"></label>
                    <label class="flex items-center justify-between text-xs bg-slate-50 p-2 rounded"><span>Foot Trouble</span><input type="checkbox" name="FootTrouble" value="Yes"></label>
                </div>
            </div>
        </div> </div> </div>
<button type="button" id="reviewBtn" class="w-full bg-teal-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-teal-700 shadow-lg transition">
    Review Health Record
</button>
<!-- Data Privacy Note Box -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-6 text-sm text-blue-900 leading-relaxed shadow-sm">
    <p>
        <span class="font-bold text-blue-800">Note:</span> 
        The Personal Information and/or Sensitive Information contained in the medical data form that I gave to APCAS, whether manually or electronically, pursuant to School Medical Profile under the protection prescribed by the Data Privacy Act of 2012 and its implementing rules and regulations.
    </p>
</div>
</form>
</section>
<!-- Review Modal Overlay -->
<div id="reviewModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl max-h-[90vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col">
        <!-- Header -->
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-xl font-black text-slate-800">Review Your Information</h3>
            <p class="text-sm text-slate-500">Please check your details before final submission.</p>
        </div>

        <!-- Review Body (Scrollable) -->
        <div id="reviewContent" class="p-8 overflow-y-auto text-slate-700 space-y-4">
            <!-- JavaScript will inject the data here -->
        </div>

        <!-- Footer Buttons -->
        <div class="p-6 border-t border-slate-100 bg-slate-50 flex gap-4">
            <button type="button" id="closeModal" class="flex-1 py-3 font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                Go Back & Edit
            </button>
            <button type="button" id="finalSubmit" class="flex-1 py-3 font-bold text-white bg-teal-600 rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-100">
                Confirm & Submit
            </button>
        </div>
    </div>
</div>
<script>
const reviewBtn = document.getElementById('reviewBtn');
const reviewModal = document.getElementById('reviewModal');
const closeModal = document.getElementById('closeModal');
const finalSubmit = document.getElementById('finalSubmit');
const reviewContent = document.getElementById('reviewContent');
const healthForm = document.querySelector('form'); // Make sure your form tag is selected correctly

reviewBtn.addEventListener('click', () => {
    reviewContent.innerHTML = '';
    
    // 1. Get all input, select, and textarea elements inside the form
    const inputs = healthForm.querySelectorAll('input, select, textarea');
    let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';

    inputs.forEach((input) => {
        // Skip hidden inputs and the submit button itself
        if (input.type === 'hidden' || input.type === 'button' || input.type === 'submit') return;

        // Get a clean label from the 'name' attribute
        let label = input.name.replace(/([A-Z])/g, ' $1').trim();
        let displayValue = "";

        // 2. Logic for Checkboxes (Unchecked = "No", Checked = "Yes")
        if (input.type === 'checkbox') {
            displayValue = input.checked ? 
                '<span class="text-teal-600 font-bold">Yes</span>' : 
                '<span class="text-slate-400 italic">No</span>';
        } 
        // 3. Logic for Radio buttons
        else if (input.type === 'radio') {
            // Only show the label once for the group, and show which one is picked
            if (!input.checked) return; // Skip the ones not picked
            displayValue = input.value;
        }
        // 4. Logic for Text/Select/Date
        else {
            displayValue = input.value !== "" ? 
                input.value : 
                '<span class="text-slate-400 italic">None/No Answer</span>';
        }

        html += `
            <div class="border-b border-slate-50 pb-2">
                <span class="text-[10px] uppercase font-black text-teal-600 block">${label}</span>
                <span class="font-medium text-slate-800">${displayValue}</span>
            </div>
        `;
    });

    html += '</div>';
    reviewContent.innerHTML = html;
    reviewModal.classList.remove('hidden');
});

// Hide modal if "Go Back" is clicked
closeModal.addEventListener('click', () => {
    reviewModal.classList.add('hidden');
});

// Final Submit action
finalSubmit.addEventListener('click', () => {
    // Show a loading state (optional)
    finalSubmit.innerHTML = "Processing...";
    finalSubmit.disabled = true;
    
    // Programmatically submit the form to submit.php
    healthForm.submit();
});
</script>
<?php 
// 5. The Bottom Piece
include 'footer.php'; 
?>
