<script>
// Modern Sidebar Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.erp-menu-link[data-submenu]');
    
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const submenuId = this.getAttribute('data-submenu');
            const submenu = document.getElementById(submenuId);
            const isOpen = submenu.classList.contains('open');
            
            // Close all other submenus
            document.querySelectorAll('.erp-submenu.open').forEach(sub => {
                if (sub !== submenu) {
                    sub.classList.remove('open');
                    const link = document.querySelector(`[data-submenu="${sub.id}"]`);
                    if (link) link.classList.remove('open');
                }
            });
            
            // Toggle current submenu
            if (isOpen) {
                submenu.classList.remove('open');
                this.classList.remove('open');
            } else {
                submenu.classList.add('open');
                this.classList.add('open');
            }
        });
    });
    
    // Highlight active menu item based on current page
    const currentPage = window.parent.location.pathname.split('/').pop();
    const activeLinks = document.querySelectorAll(`a[href*="${currentPage}"]`);
    activeLinks.forEach(link => {
        link.classList.add('active');
        // Open parent menu if it's a submenu item
        const parentSubmenu = link.closest('.erp-submenu');
        if (parentSubmenu) {
            parentSubmenu.classList.add('open');
            const parentLink = document.querySelector(`[data-submenu="${parentSubmenu.id}"]`);
            if (parentLink) parentLink.classList.add('open');
        }
    });
});
</script>
