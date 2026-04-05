<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: auth/admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | APCAS Campus Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .split-bg {
            background: linear-gradient(to right, #f8fafc 50%, #ffffff 50%);
        }
        @media (max-width: 768px) {
            .split-bg { background: #ffffff; }
        }
    </style>
</head>
<body class="split-bg font-sans antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- LEFT SIDE: Role Selection -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 md:p-16 space-y-8">
            <div class="text-center mb-4">
                <h2 class="text-slate-900 text-3xl font-black uppercase tracking-tight">Identify Yourself</h2>
                <p class="text-slate-500 mt-2">Select your portal to continue</p>
            </div>

            <div class="w-full max-w-sm space-y-4">
                <!-- Student Button -->
                <a href="clear_session.php?dest=index.php" class="group flex items-center justify-between bg-white border-2 border-slate-100 p-6 rounded-3xl shadow-sm hover:border-teal-500 hover:shadow-xl hover:shadow-teal-50 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="bg-teal-50 p-3 rounded-2xl text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <div>
                            <span class="block font-bold text-xl text-slate-800">Student</span>
                            <span class="text-sm text-slate-400">Access health records</span>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 group-hover:text-teal-500 translate-x-0 group-hover:translate-x-2 transition-all"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>

                <!-- Admin Button -->
                <a href="auth/login.php" class="group flex items-center justify-between bg-white border-2 border-slate-100 p-6 rounded-3xl shadow-sm hover:border-slate-800 hover:shadow-xl hover:shadow-slate-100 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-50 p-3 rounded-2xl text-slate-600 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <span class="block font-bold text-xl text-slate-800">Administrator</span>
                            <span class="text-sm text-slate-400">Manage campus health</span>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 group-hover:text-slate-800 translate-x-0 group-hover:translate-x-2 transition-all"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            
            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-12">© 2026 APCAS Campus Care</p>
        </div>

        <!-- RIGHT SIDE: Welcome Content -->
        <div class="w-full md:w-1/2 bg-white flex flex-col justify-center p-8 md:p-24">
            <div class="max-w-xl">
                <h2 class="text-[#0f172a] text-5xl md:text-7xl font-black leading-tight mb-2">
                    Welcome to
                </h2>
                <h1 class="text-[#10b981] text-5xl md:text-7xl font-black leading-tight mb-8">
                    APCAS CAMPUS CARE
                </h1>
                
                <div class="inline-block bg-[#f0fdfa] px-6 py-2 rounded-full mb-10">
                    <p class="text-[#059669] font-bold text-lg md:text-xl">
                        Digital Health For Modern Students.
                    </p>
                </div>

                <p class="text-slate-500 text-xl md:text-2xl leading-relaxed font-medium">
                    Your comprehensive student health management portal. Submit health records, stay informed with important health announcements, and ensure your well-being on campus.
                </p>
            </div>
        </div>

    </div>

</body>
</html>