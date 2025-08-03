<button id="toggleSidebar">Menu</button> <!-- side bar menu, with button that can hide the menu -->

<aside class="sidebar" id="sidebar">
  <ul>
    <li><a href="pants.php">Pants</a></li>
    <li><a href="hoodies.php">Hoodies</a></li>
    <li><a href="socks.php">Socks</a></li>
    <li><a href="shirts.php">Shirts</a></li>
    <li><a href="about.php">About</a></li>
  </ul>
</aside>

<script>
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.querySelector(".main-content");
  const toggleBtn = document.getElementById("toggleSidebar");

  toggleBtn.addEventListener("click", function () {
    sidebar.classList.toggle("hidden");
    mainContent.classList.toggle("expanded");
  });
</script>