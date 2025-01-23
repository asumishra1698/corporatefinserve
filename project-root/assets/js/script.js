const sidebar = document.querySelector(".sidebar");
const content = document.querySelector(".content");
const toggleBtn = document.querySelector(".toggle-btn");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");
  content.classList.toggle("collapsed");
});



// Fetch stats data dynamically
async function fetchStats() {
  const response = await fetch("modules/stats.php");
  const stats = await response.json();

  document.getElementById("totalPages").innerText = stats.totalPages;
  document.getElementById("totalUsers").innerText = stats.totalUsers;
  document.getElementById("totalPosts").innerText = stats.totalPosts;
}

// Call fetchStats on page load
fetchStats();
