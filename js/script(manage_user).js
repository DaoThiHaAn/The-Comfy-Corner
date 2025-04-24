function fetchUsers(page = 1) {
    const role = document.getElementById("role").value;

    fetch(`${base_url}pages/fetch_users_ajax.php?role=${role}&page=${page}`)
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
document.addEventListener("DOMContentLoaded", () => fetchUsers());