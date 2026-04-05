<?php 
<?php
require __DIR__ . '/welcome.php';
// 1. Database logic
include_once 'config/db_connect.php';

// Fetch Total Records
$count_sql = "SELECT COUNT(*) as total FROM users";
$count_result = $conn->query($count_sql);
$total_records = ($count_result && $row = $count_result->fetch_assoc()) ? $row['total'] : 0;

// Fetch Total Announcements
$count_query = "SELECT COUNT(*) as total FROM announcements";
$count_result = mysqli_query($conn, $count_query);
$total_announcements = ($count_data = mysqli_fetch_assoc($count_result)) ? $count_data['total'] : 0;

// --- NEW: FETCH RSS NEWS ITEMS ---
$rss_url = "https://www.who.int/rss-feeds/news-english.xml";
$rss_data = @simplexml_load_file($rss_url);
$news_items = [];

if ($rss_data) {
    $namespaces = $rss_data->getNamespaces(true);
    for ($i = 0; $i < 5; $i++) { // Fetch 5 items for better sliding
        if (isset($rss_data->channel->item[$i])) {
            $item = $rss_data->channel->item[$i];
            
            // Try to find image
            $image_url = "https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=800&h=600&fit=crop"; // Default
            $media = $item->children($namespaces['media'] ?? null);
            if ($media && $media->content) {
                $image_url = (string)$media->content->attributes()->url;
            }

            $news_items[] = [
                'title' => (string)$item->title,
                'link'  => (string)$item->link,
                'date'  => date('M d, Y', strtotime((string)$item->pubDate)),
                'image' => $image_url
            ];
        }
    }
}
// --- END RSS FETCH ---

include 'header.php'; 
?>

<!-- Swiper Assets (Moved to top of content) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<main class="max-w-7xl mx-auto px-6 py-8">
    <!-- Hero Section -->
    <section class="grid lg:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <div class="text-center lg:text-left">
            <h2 class="text-5xl font-extrabold mt-4 mb-6 leading-tight">Welcome to <br><span class="text-teal-600 uppercase tracking-tight">APCAS Campus Care</span></h2>
            </div>
            <span class="text-teal-600 font-semibold bg-teal-50 px-1x py-1 rounded-full text-mdx">Digital Health For Modern Students.</span>
            <p class="text-lg text-slate-600 my-4 leading-relaxed">Your comprehensive student health management portal. Submit health records, stay informed with important health announcements, and ensure your well-being on campus.</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="Healthrecord.php" class="bg-teal-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-teal-700 transition shadow-lg shadow-teal-100 flex items-center justify-center">
                    Submit Health Record
                </a>
                <a href="announcements.php" class="bg-white border border-slate-200 px-8 py-4 rounded-xl font-bold hover:bg-slate-50 transition flex items-center justify-center text-slate-700">
                    View Announcements
                </a>
            </div>
        </div>

        <!-- Carousel Column -->
        <div class="h-96">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden h-full">
                <div class="swiper healthSwiper h-full">
                    <div class="swiper-wrapper">
                        <?php if (!empty($news_items)): ?>
                            <?php foreach ($news_items as $news): ?>
                                <div class="swiper-slide relative">
                                    <img src="<?php echo $news['image']; ?>" class="w-full h-full object-cover" alt="News">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                                    <div class="absolute bottom-0 p-8 text-white">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-teal-400 mb-2"><?php echo $news['date']; ?></p>
                                        <h4 class="text-xl font-bold leading-tight mb-4"><?php echo $news['title']; ?></h4>
                                        <a href="<?php echo $news['link']; ?>" target="_blank" class="inline-block text-xs font-bold bg-white/10 backdrop-blur-md border border-white/20 px-5 py-2 rounded-full hover:bg-white hover:text-slate-900 transition-all">Read More →</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Grid (Outside the hero grid for full width) -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-20">
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center transform hover:scale-105 transition duration-300">
            <p class="text-4xl font-black text-slate-800 mb-1"><?php echo $total_records; ?></p>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Health Records</p>
        </div>
        
        <a href="announcements.php" class="block bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center transform hover:scale-105 transition duration-300 hover:border-teal-200">
            <p class="text-4xl font-black text-slate-800 mb-1"><?php echo $total_announcements; ?></p>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Active Announcements</p>
        </a>

        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center transform hover:scale-105 transition duration-300">
            <p class="text-4xl font-black text-teal-600 mb-1">100%</p>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Secure Storage</p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center transform hover:scale-105 transition duration-300">
            <p class="text-4xl font-black text-purple-600 mb-1">Always</p>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">24/7 Access</p>
        </div>
    </section>
</main>

<script>
  const swiper = new Swiper('.healthSwiper', {
    loop: true,
    autoplay: { delay: 5000, disableOnInteraction: false },
    pagination: { el: '.swiper-pagination', clickable: true },
    effect: 'fade',
    fadeEffect: { crossFade: true },
  });
</script>

<?php include 'footer.php'; ?>