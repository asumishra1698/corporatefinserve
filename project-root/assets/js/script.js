const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const toggleBtn = document.querySelector('.toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });

    function confirmDelete(userId) {
        // Create the confirmation popup
        const confirmation = document.createElement('div');
        confirmation.classList.add('confirmation-popup');
        confirmation.innerHTML = `
            <p>Are you sure you want to delete this user?</p>
            <button class="confirm-btn" onclick="deleteUser(${userId})">Confirm</button>
            <button class="cancel-btn" onclick="this.parentElement.remove()">Cancel</button>
        `;
        document.body.appendChild(confirmation);
    }

    async function deleteUser(userId) {
        const response = await fetch('./users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'delete',
                user_id: userId,
            }),
        });

        const result = await response.json();
        if (result.success) {
            alert('User deleted successfully!');
            location.reload(); // Reload the page to update the user list
        } else {
            alert('Failed to delete user.');
        }
        document.querySelector('.confirmation-popup').remove();
    }
     
     // Fetch stats data dynamically
     async function fetchStats() {
        const response = await fetch('modules/stats.php');
        const stats = await response.json();

        document.getElementById('totalPages').innerText = stats.totalPages;
        document.getElementById('totalUsers').innerText = stats.totalUsers;
        document.getElementById('totalPosts').innerText = stats.totalPosts;
    }

    // Call fetchStats on page load
    fetchStats();