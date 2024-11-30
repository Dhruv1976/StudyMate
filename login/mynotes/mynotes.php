<?php
session_start();


if (!isset($_SESSION['user_id'])) {
  // Redirect to login page
  header("location: /studyMate/src/login/form/form.html");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudyMate</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
        <li><a href="/studyMate/src/login/quicknotes/quicknotes.php">Quick notes</a></li>
        <li><a href="/studyMate/src/login/mynotes/mynotes.php">My Notes</a></li>
        <li><a href="/studyMate/src/login/groups/myGroupstry.php">Community</a></li>
      </ul>
      <div id="menus" style="display: flex;">

        <div class="toggle_btn"><i class="fa-solid fa-bars" style="padding: 7px;"></i></div>

        <div class="user-icon dropdown-trigger" id="userIcon"><i class="fas fa-user" style="padding: 7px;"></i></div>

      </div>
    </div>
    <div class="dropdown_menu ">
      <li><a href="/studyMate/src/login/quicknotes/quicknotes.php">Quick notes</a></li>
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





  <div id="folders">
    <h2>Folders</h2>
    <div id="searchContainer">
      <input type="text" id="searchInput" placeholder="Search..." />
      <button id="searchButton"><i class="fas fa-search"></i></button>
    </div>
    <div id="dirPath">
      <div class="dirPI">
        <div class="dirPT">../</div><button class="return"><i class="fa fa-arrow-left fa-xl"></i>
      </div>
      <hr id="hrdir">
    </div>
    <div id="folderContainer">

    </div>
    <div id="buttonContainer">
      <button id="createFolder">
        <i class="fas fa-folder-plus"></i> Create Folder
      </button>
      <button id="uploadButton"><i class="fas fa-upload"></i> Upload</button>
    </div>
  </div>


  <div id="uploadModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 style="padding-bottom :30px">Upload File</h2>
      <input type="file" id="fileInput">
      <button id="uploadFileButton" >Upload</button>
    </div>
  </div>
  <script src="script.js"></script>

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
      toggle_btn.addEventListener("click", (event) => {
        mainDropDownMenu.classList.toggle('open');
        userDropdownMenu.classList.remove('open'); // Close user dropdown menu when main dropdown menu is opened
        updateToggleButtonIcon();
        event.stopPropagation();
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
      fetch("logout.php")
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
  <script>  function openResetPasswordPopup() {
      document.getElementById("resetPasswordPopup").style.display = "flex";
    }

    // Function to close the reset password popup
    function closeResetPasswordPopup() {
      document.getElementById("resetPasswordPopup").style.display = "none";
    }

    // for the reset password button
    document.getElementById("resetPasswordBtn").addEventListener("click", function (event) {
      event.preventDefault();
      openResetPasswordPopup();
    });

    // for the reset password form submission
    document.getElementById("resetPasswordForm").addEventListener("submit", function (event) {
      event.preventDefault();
      const newPassword = document.getElementById("newPassword").value;
      const confirmPassword = document.getElementById("confirmPassword").value;

      // Validate if both passwords match
      if (newPassword !== confirmPassword) {
        document.getElementById("resetPasswordMessage").textContent = "Passwords do not match.";
        return;
      }

      // Send request to reset password 
      fetch("reset_password.php", {
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