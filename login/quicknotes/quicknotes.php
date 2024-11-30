<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  header("location: /studyMate/src/login/form/form.html");
  exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="expires" content="-1" />
  <meta http-equiv="cache-control" content="no-cache" />
  <title>StudyMate</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="navstyle.css">
  <link rel="stylesheet" href="popup.css">
</head>

<body>
  <div class="nav_header">
    <div class="nav">
      <div class="logo_name">
        <div class="logo"><img src="logo.png" alt="StudyMate Logo"></div>
        <div><a href="#" name="logo"> StudyMate </a></div>
      </div>
      <ul class=" link">
        <li><a href="quicknotes.php">Quick notes</a></li>
        <li><a href="/studyMate/src/login/mynotes/mynotes.php">My Notes</a></li>
        <li><a href="/studyMate/src/login/groups/myGroupstry.php">Community</a></li>
      </ul>
      <div id="menus" style="display: flex;">

        <div class="toggle_btn"><i class="fa-solid fa-bars" style="padding: 7px;"></i></div>

        <div class="user-icon dropdown-trigger" id="userIcon"><i class="fas fa-user" style="padding: 7px;"></i></div>

      </div>
    </div>
    <div class="dropdown_menu ">
      <li><a href="quicknotes.php">Quick notes</a></li>
      <li><a href="/studyMate/src/login/mynotes/mynotes.php">My Notes</a></li>
      <li><a href="/studyMate/src/login/groups/myGroupstry.php">Community</a></li>
      <!-- <li><a href="form.html" class="action_btn">Get Started</a></li> -->
    </div>
    <div class="dropdown_menu user-dropdown-menu">
      <li><a href="#" style="font-weight:bold; cursor: default;"> Hello, User</a></li>
      <li><a href="#" id="resetPasswordBtn">Reset Password</a></li>
      <li><a id="logoutBtn" class="action_btn">logout</a></li>
    </div>
  </div>

  <!-- popup========================================== -->
  <div class="popup-container" id="resetPasswordPopup" style="display: none;">
    <div class="popup-content">
      <span class="close-button" onclick="closeResetPasswordPopup()"><i class="fa-solid fa-xmark"></i></span>
      <h2>Reset Password</h2>
      <form id="resetPasswordForm">
        <label for="newPassword">Enter New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <div id="resetPasswordMessage" style="color: red;"></div>
        <input type="submit" value="Change">
      </form>
    </div>
  </div>

  <!-- =================quicknotes body ====================== -->
  <div class="modal_body">
    <div class="modal">
      <div class="modal-content">
        <textarea class="modal-title" placeholder="Title"></textarea>
        <textarea class="modal-text" placeholder="Take a note..." rows="20"></textarea>
        <span class="modal-close-button">Close</span>
      </div>
    </div>
    <main>
      <header class="modal_header">
        <img class="header-logo" src="svg/note_logo.svg">
        <h2 class="header-title">Quick Notes</h2>
      </header>
      <div id="form-container">
        <form id="form" autocomplete="off">
          <input id="note-title" placeholder="Title" type="text">
          <input id="note-text" placeholder="Take a note..." type="text">
          <div id="form-buttons">
            <button type="submit" id="submit-button">Submit</button>
            <button type="button" id="form-close-button">Close</button>
          </div>
        </form>
      </div>
      <div id="notes"></div>
      <div id="placeholder">
        <img id="placeholder-logo" src="svg/note_logo.svg" alt="lightbulb">
        <p id="placeholder-text">Notes you add appear here</p>
      </div>
      <div id="color-tooltip">
        <div class="color-option" data-color="#fff" id="white"></div>
        <div class="color-option" data-color="#d7aefb" id="purple"></div>
        <div class="color-option" data-color="#fbbc04" id="orange"></div>
        <div class="color-option" data-color="#a7ffeb" id="teal"></div>
      </div>
    </main>
  </div>
  <script src="script.js"></script>
  <!-- ====================================== -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggle_btn = document.querySelector('.toggle_btn');
      const toggleBtnIcon = document.querySelector('.toggle_btn i');
      const mainDropDownMenu = document.querySelector('.dropdown_menu'); // Main dropdown menu
      const userIcon = document.querySelector('.user-icon.dropdown-trigger');
      const userDropdownMenu = document.querySelector('.user-dropdown-menu'); // User dropdown menu

      // Function to update toggle button icon
      function updateToggleButtonIcon() {
        const isMainOpen = mainDropDownMenu.classList.contains('open');
        if (isMainOpen) {
          toggleBtnIcon.classList = 'fa-solid fa-xmark';
        } else {
          toggleBtnIcon.classList = 'fa-solid fa-bars';
        }
      }

      // Toggle the main dropdown menu
      toggle_btn.addEventListener("click", () => {
        mainDropDownMenu.classList.toggle('open');
        userDropdownMenu.classList.remove('open'); // Close user dropdown menu when main dropdown menu is opened
        updateToggleButtonIcon();
      });

      // Toggle the user dropdown menu
      userIcon.addEventListener('click', (event) => {
        userDropdownMenu.classList.toggle('open');
        mainDropDownMenu.classList.remove('open'); // Close main dropdown menu when user dropdown menu is opened
        updateToggleButtonIcon();
        event.stopPropagation(); // Prevent the click event from bubbling up to the document click listener
      });

      // Close dropdown menus when clicking outside of them
      document.addEventListener('click', (event) => {
        const targetElement = event.target;
        if (!userDropdownMenu.contains(targetElement) && targetElement !== userIcon) {
          userDropdownMenu.classList.remove('open');
        }
        if (!mainDropDownMenu.contains(targetElement) && targetElement !== toggle_btn) {
          mainDropDownMenu.classList.remove('open');
        }
        updateToggleButtonIcon();
      });
    });
    document.getElementById("logoutBtn").addEventListener("click", function () {
      // Send request to logout PHP script
      fetch("php/logout.php")
        .then(response => {
          if (response.ok) {
            window.location.href = "/studyMate/src/login/index.html"; // Replace with your index page URL
          } else {
            console.error("Logout failed");
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
    });






  </script>


  <script>
    function openResetPasswordPopup() {
      document.getElementById("resetPasswordPopup").style.display = "flex";
    }

    // Function to close the reset password popup
    function closeResetPasswordPopup() {
      document.getElementById("resetPasswordPopup").style.display = "none";
    }

    // Event listener for the reset password button
    document.getElementById("resetPasswordBtn").addEventListener("click", function (event) {
      event.preventDefault();
      openResetPasswordPopup();
    });

    // Event listener for the reset password form submission
    document.getElementById("resetPasswordForm").addEventListener("submit", function (event) {
      event.preventDefault();
      const newPassword = document.getElementById("newPassword").value;
      const confirmPassword = document.getElementById("confirmPassword").value;

      // Validate if both passwords match
      if (newPassword !== confirmPassword) {
        document.getElementById("resetPasswordMessage").textContent = "Passwords do not match.";
        return;
      }

      // Send request to reset password PHP script
      fetch("php/reset_password.php", {
        method: "POST",
        body: new URLSearchParams({
          newPassword: newPassword
        })
      })
        .then(response => response.text())
        .then(result => {
          // Display the result message
          document.getElementById("resetPasswordMessage").textContent = result;
        })
        .catch(error => {
          console.error("Error:", error);
          document.getElementById("resetPasswordMessage").textContent = "Error resetting password.";
        });
    });

    // Event listener for the close button
    document.querySelector(".close-button").addEventListener("click", closeResetPasswordPopup);
  </script>



</body>

</html>