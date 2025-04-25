function fetchUsers(page = 1) {
    const role = document.getElementById("role").value;

    // Update the URL dynamically
    const newUrl = `${base_url}manage_user?role=${role}&pagenum=${page}`;
    window.history.pushState(null, "", newUrl);

    fetch(`${base_url}pages/fetch_users_ajax.php?role=${role}&pagenum=${page}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.html) {
                document.getElementById("users-table").innerHTML = data.html;
                document.getElementById("pagination").innerHTML = data.pagination;

                // Add event listeners for pagination links
                document.querySelectorAll("#pagination a").forEach((link) => {
                    link.addEventListener("click", (e) => {
                        e.preventDefault();
                        const page = e.target.getAttribute("data-page");
                        fetchUsers(page);
                    });
                });
            } else {
                alert(data.message || "Failed to fetch users.");
            }
        })
        .catch((error) => {
            console.error("Error fetching users:", error);
        });
}

// Assign admin role to a user
function assignAdmin(username) {
    if (confirm("Are you sure you want to make this user an admin?")) {
        fetch(base_url + "pages/assign_admin_ajax.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `username=${username}`,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    fetchUsers(); // Refresh the user list
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error("Error assigning admin role:", error);
            });
    }
}

// Fetch users on page load
document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const role = urlParams.get("role") || "all"; // Default to "all" if no role is specified
    document.getElementById("role").value = role; // Set the dropdown to the correct role
    fetchUsers()
});

// Handle browser back/forward navigation
window.addEventListener("popstate", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const role = urlParams.get("role") || "all";
    const page = urlParams.get("page") || 1;

    document.getElementById("role").value = role; // Update the dropdown
    fetchUsers(page); // Fetch users for the current state
});