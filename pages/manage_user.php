<section class="container">
    <h2>User Management</h2>

    <!-- Role Filter -->
    <div class="role-filter">
        <select id="role" onchange="fetchUsers()">
            <option value="all">All Roles</option>
            <option value="user">User</option>
            <option value="moderator">Admin</option>
        </select>
    </div>

    <!-- Users Table -->
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="users-table">
            <!-- Users will be loaded here via AJAX -->
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div id="pagination" class="pagination">
        <!-- Pagination links will be loaded here via AJAX -->
    </div>
</section>