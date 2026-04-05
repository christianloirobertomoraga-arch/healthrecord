<?php 
// 1. Session Security (Optional for now, but recommended later)
// session_start(); 

// 2. Include Header (Remember ../ because we are in the auth folder)
include '../header.php'; 
?>
<section id="page-announcements">
<div class="max-w-3xl mx-auto py-12 px-6">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        
        <!-- Form Header -->
        <div class="bg-teal-600 p-8 text-white">
            <h2 class="text-2xl font-bold">Create New Announcement</h2>
            <p class="text-teal-100 text-sm">This will be visible to all students on the Announcements page.</p>
        </div>

        <!-- The Form -->
        <form action="save_announcement.php" method="POST" class="p-8 space-y-6">
            
            <!-- Title -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Announcement Title</label>
                <input type="text" name="title" required placeholder="e.g. Vaccination Drive 2026"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                <select name="category" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                    <option value="Health Update">Health Update</option>
                    <option value="Clinic Schedule">Clinic Schedule</option>
                    <option value="Emergency">Emergency</option>
                    <option value="General">General</option>
                </select>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Message Content</label>
                <textarea name="content" required rows="6" placeholder="Write the details here..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-teal-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-teal-700 transition shadow-lg shadow-teal-100">
                    Post Announcement
                </button>
                <a href="admin.php" class="text-slate-400 font-medium hover:text-slate-600">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>