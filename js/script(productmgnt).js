function toggleDrawer() {
    const drawer = document.querySelector('.drawer');
    if (drawer) {
        drawer.classList.toggle('active');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggle-drawer-btn');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleDrawer);
    }

    // Check if the 'tab' parameter is missing in the URL
    const urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has('tab')) {
        // Add 'tab=view_all_products' to the URL without reloading the page
        urlParams.set('tab', 'view_all_products');
        const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
        window.history.replaceState(null, '', newUrl);
        window.location.reload(); // Reload the page to apply the new URL
    }
});