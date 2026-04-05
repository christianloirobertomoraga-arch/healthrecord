<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | APCAS Campus Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-10 border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-slate-800 uppercase italic">Admin Portal</h2>
            <p class="text-slate-400 text-sm mt-1">Please enter your credentials to manage records.</p>
        </div>

        <form action="authenticate.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-teal-600 uppercase mb-2">Username</label>
                <input type="text" name="username" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl focus:border-teal-500 outline-none transition">
            </div>
            <div>
                <label class="block text-[10px] font-black text-teal-600 uppercase mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl focus:border-teal-500 outline-none transition">
            </div>
            
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-black transition shadow-lg shadow-slate-200">
                Sign In to Dashboard
            </button>
        </form>
        
        <a href="../welcome.php" class="block text-center mt-6 text-xs text-slate-400 hover:text-teal-600 transition">← Back to Selection</a>
    </div>
</body>
</html>