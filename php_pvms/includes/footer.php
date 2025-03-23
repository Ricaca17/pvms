<?php
// Don't include footer for login page and activation page
$current_page = basename($_SERVER['PHP_SELF']);
$public_pages = ['login.php', 'activate.php'];

if (!in_array($current_page, $public_pages)): 
?>
        </div><!-- End of main-content -->
    </div><!-- End of layout -->
<?php endif; ?>

    <script>
    // Dark mode toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', function() {
                const html = document.documentElement;
                const isDarkMode = html.classList.contains('dark');
                
                // Toggle dark mode class
                html.classList.toggle('dark');
                
                // Update toggle switch appearance
                const toggleSwitch = this.querySelector('.toggle-switch');
                toggleSwitch.classList.toggle('active');
                
                // Update icon
                const icon = this.querySelector('i');
                if (isDarkMode) {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                } else {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                }
                
                // Save preference in cookie
                document.cookie = `dark_mode=${!isDarkMode}; path=/; max-age=${60*60*24*365}`;
            });
        }
        
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
        }
        
        // Tab functionality
        const tabTriggers = document.querySelectorAll('.tab-trigger');
        if (tabTriggers.length > 0) {
            tabTriggers.forEach(trigger => {
                trigger.addEventListener('click', function() {
                    // Get the target tab content
                    const tabId = this.getAttribute('data-tab');
                    const tabContent = document.getElementById(tabId);
                    
                    // Remove active class from all triggers and contents
                    document.querySelectorAll('.tab-trigger').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked trigger and its content
                    this.classList.add('active');
                    tabContent.classList.add('active');
                });
            });
        }
        
        // Form validation
        const forms = document.querySelectorAll('form[data-validate]');
        if (forms.length > 0) {
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('error');
                            
                            // Show error message if it exists
                            const errorMsg = field.nextElementSibling;
                            if (errorMsg && errorMsg.classList.contains('error-message')) {
                                errorMsg.style.display = 'block';
                            }
                        } else {
                            field.classList.remove('error');
                            
                            // Hide error message if it exists
                            const errorMsg = field.nextElementSibling;
                            if (errorMsg && errorMsg.classList.contains('error-message')) {
                                errorMsg.style.display = 'none';
                            }
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
        }
        
        // Activation code input handling
        const codeInputs = document.querySelectorAll('.activation-code input');
        if (codeInputs.length > 0) {
            codeInputs.forEach((input, index) => {
                // Auto-focus next input when a digit is entered
                input.addEventListener('input', function() {
                    if (this.value.length === 1 && index < codeInputs.length - 1) {
                        codeInputs[index + 1].focus();
                    }
                });
                
                // Handle backspace to go to previous input
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        codeInputs[index - 1].focus();
                    }
                });
            });
        }
    });
    </script>
</body>
</html>