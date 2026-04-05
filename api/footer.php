</main> <!-- Closes the <main> tag from header.php -->

    <!-- Global Footer Information -->
    <footer class="max-w-7xl mx-auto px-6 py-8 border-t border-slate-200">
        <div class="flex justify-between items-center text-slate-400 text-xs font-medium uppercase tracking-widest">
            <p>&copy; <?php echo date('Y'); ?> APCAS Campus Care</p>
            <p>Student Health Management System v1.0</p>
        </div>
    </footer>

    <!-- Global JavaScript -->
    <script>
        // 1. Sidebar/Navigation active state logic
        // This highlights the current page link in the menu
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('nav a');
        navLinks.forEach(link => {
            if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href'))) {
                link.classList.add('text-teal-600', 'font-bold');
            }
        });

        // 2. Mobile Menu Toggle (If you add one later)
        function toggleMobileMenu() {
            // logic here
        }
    </script>

    <!-- Specific Page Scripts (like your Modal Logic) -->
    <!-- It's better to link a separate JS file here -->
    <script src="/Project0/assets/js/main.js"></script>

</body>
</html>