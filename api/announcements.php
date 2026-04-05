<?php 
// 1. Database Connection
include_once 'config/db_connect.php';

// 2. Fetch Announcements (Newest first)
$query = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($query);

// 3. Include Header
include 'header.php'; 
?>

<section class="max-w-4xl mx-auto py-12 px-6">
    
    <!-- Page Title -->
    <div class="text-center mb-16">
        <h2 class="text-4xl font-black text-slate-800 mb-4 tracking-tight">Campus Health Updates</h2>
        <p class="text-slate-500 max-w-lg mx-auto font-medium">Stay informed with the latest medical advisories and clinic announcements from the APCAS Health Office.</p>
        <div class="h-1.5 w-20 bg-teal-500 mx-auto mt-6 rounded-full"></div>
    </div>

    <!-- The Feed -->
    <div class="space-y-10">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <article class="relative pl-8 border-l-2 border-slate-100 hover:border-teal-400 transition-colors pb-4">
                    <!-- The Date Dot -->
                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-white border-2 border-teal-500 rounded-full"></div>
                    
                    <div class="mb-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                            <?php echo date('F d, Y', strtotime($row['created_at'])); ?>
                        </span>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-teal-50 text-teal-600 text-[10px] font-black uppercase rounded-lg">
                                <?php echo htmlspecialchars($row['category']); ?>
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-slate-800 mb-4"><?php echo htmlspecialchars($row['title']); ?></h3>
                        
                        <p class="text-slate-600 leading-relaxed text-lg">
                            <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                        </p>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Fallback -->
            <div class="text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-bold">No announcements have been posted yet.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>