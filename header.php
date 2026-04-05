<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
        /* .hidden is usually not needed anymore for separate pages */
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
            <!-- CRITICAL CHANGE: Use <a> tags with actual file paths -->
            <a href="/Project0/index.php" 
            class="hover:text-teal-600 transition">Home</a>
            <a href="/Project0/Healthrecord.php" class="hover:text-teal-600 transition">Health Records</a>
            <a href="/Project0/announcements.php" class="hover:text-teal-600 transition">Announcements</a>
           
           <!-- ADMIN ONLY SECTION -->
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <!-- Admin Dashboard Link -->
                <a href="/Project0/auth/admin.php" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-sm text-sm font-bold">
                    Admin Dashboard
                </a>
                
                <?php 
                // Determine the correct path to logout.php
                $logout_path = (basename(getcwd()) == 'auth') ? 'logout.php' : 'auth/logout.php';
                ?>
                
              <a href="<?php echo $logout_path; ?>"
           class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
        </a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pt-2 pb-8">




    