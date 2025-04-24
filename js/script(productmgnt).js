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

    // Dynamically get the project folder from the current URL
    const currentPath = window.location.pathname;
    const projectFolder = currentPath.split('/')[1]; // Get the first folder in the path

    // Check if the current URL is exactly '/productmgnt/' (with no extra parameters or segments)
    if (currentPath === `/${projectFolder}/productmgnt`) {
        // Construct the new path dynamically
        const newPath = `/${projectFolder}/productmgnt/view_all_products`;

        // Update the URL to 'productmgnt/view_all_products' with the project folder
        window.history.replaceState(null, '', newPath);
        window.location.reload(); // Reload the page to apply the new URL
    }
});