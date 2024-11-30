document.addEventListener("DOMContentLoaded", function () {
  const folderContainer = document.getElementById("folderContainer");
  const createFolderButton = document.getElementById("createFolder");
  const searchInput = document.getElementById("searchInput");
  const uploadButton = document.getElementById("uploadButton");
  const uploadModal = document.getElementById("uploadModal");
  const closeModalButton = document.querySelector(".close");
  const uploadFileButton = document.getElementById("uploadFileButton");
  const returnButton = document.querySelector(".return");

  let userId;
  fetch('get_folder_id.php')
    .then(response => response.text())
    .then(folderId => {
      
      userId = folderId;
      //=========================================================================================================================
      const rootFolderName = userId;
      let currentFolderPath = rootFolderName;
      fetchFilesAndFolders(currentFolderPath);

      createFolderButton.addEventListener("click", createFolder);
      searchInput.addEventListener("input", filterFolders);
      uploadButton.addEventListener("click", openUploadModal);
      closeModalButton.addEventListener("click", closeUploadModal);
      uploadFileButton.addEventListener("click", function () {
        uploadFile(currentFolderPath);
      });

      function fetchFilesAndFolders(currentFolderPath) {
        const params = new URLSearchParams();
        params.append("folderName", currentFolderPath);

        const url = `list_files.php?${params.toString()}`;
        // console.log(url);

        fetch(url)
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              renderFoldersAndFiles(data.contents);
            } else {
              alert(data.message);
            }
          })
      }
      

      function renderFoldersAndFiles(contents) {
        folderContainer.innerHTML = "";
        
        contents.forEach((item) => {
          if (item.indexOf(".") !== 0) {
            if (item.indexOf(".") !== -1) {
              createFileIcon(userId, item);
            } else {
              createFolderIcon(userId, item);
            }
          }
        });
      }

      function createFolderIcon(userId, folderName) {
        const folderIcon = document.createElement("div");
        folderIcon.classList.add("folderIcon");
        folderIcon.dataset.userId = userId;
        folderIcon.dataset.folderName = folderName;
        folderIcon.innerHTML = `
            <i class="fas fa-folder" style="font-size: 48px; color: #F8D775;"></i>
            <div class="folderName">${folderName}</div>
            <div class="iconcont">
                <button class="downloadButton downloadFolderButton" style="display: none;">
                    <img src="download.svg" style="width:20px"></img>
                </button>
                <button class="deleteButton " style="display: none;">
                    <img src="delete.svg" style="width:20px"></img>
                </button>
            </div>`;
        const downloadFolderButton = folderIcon.querySelector(
          ".downloadFolderButton"
        );
        downloadFolderButton.addEventListener("click", function (event) {
          event.stopPropagation();
          const folderPath = currentFolderPath + "/" + folderName;
          downloadFolder(folderPath);
        });
        const deleteButton = folderIcon.querySelector(".deleteButton");
        deleteButton.addEventListener("click", function (event) {
          event.stopPropagation();
          const confirmed = confirm(`Are you sure you want to delete this folder?`);
          if (confirmed) {
            const folderPath = currentFolderPath + "/" + folderName;
            deleteFolder(folderPath);
          }
        });
        folderIcon.addEventListener("click", function (event) {
          openFolder(userId, folderName);
          event.cancelBubble = true;
        });
        folderIcon.addEventListener("mouseenter", () => showButtons(folderIcon));
        folderIcon.addEventListener("mouseleave", () => hideButtons(folderIcon));
        folderContainer.appendChild(folderIcon);
      }

      function openFolder(userId, folderName) {
        if (!currentFolderPath.endsWith('/')) {
          currentFolderPath += '/';
        }
        currentFolderPath += folderName;
        updateDirPath();
        fetchFilesAndFolders(currentFolderPath);
      }
      returnButton.addEventListener("click", function () {
        openParentDirectory();
      });
      function openParentDirectory() {
        if (currentFolderPath !== userId) {
          const folders = currentFolderPath.split("/");
          if (folders.length > 1) {
            folders.pop();
            currentFolderPath = folders.join("/");
            fetchFilesAndFolders(currentFolderPath);
            updateDirPath();
          }
        }
        else {
          updateDirPath();
        }
      }

      function updateDirPath() {
        if (currentFolderPath == userId) {
          const dirPT = document.querySelector(".dirPT");
          dirPT.textContent = `../`;
        } else {
          const dirPT = document.querySelector(".dirPT");
          const folderNameIndex = currentFolderPath.indexOf('/') + 1;
          const remainingPath = currentFolderPath.substring(folderNameIndex);
          // console.log('Remaining Path:', remainingPath);
          dirPT.textContent = `../${remainingPath}`;
        }
      }

      function createFileIcon(userId, fileName) {
        const fileIcon = document.createElement("div");
        fileIcon.classList.add("fileIcon");
        fileIcon.dataset.userId = userId;
        fileIcon.dataset.fileName = fileName;
        fileIcon.innerHTML = `
            <i class="fas fa-file" style="font-size: 48px; color: #666;"></i>
            <div class="fileName">${fileName}</div>
            <div class="iconcont">
                <button class="downloadButton" style="display: none;">
                    <img src="download.svg" style="width:20px"></img>
                </button>
                <button class="deleteButton" style="display: none;">
                    <img src="delete.svg" style="width:20px"></img>
                </button>
            </div>`;


        const downloadButton = fileIcon.querySelector(".downloadButton");
        downloadButton.addEventListener("click", function (event) {
          event.stopPropagation();
          const fileName = fileIcon.dataset.fileName;
          const folderPath = currentFolderPath;
          downloadFile(fileName, folderPath);
        });

        const deleteButton = fileIcon.querySelector(".deleteButton");
        deleteButton.addEventListener("click", function (event) {
          event.stopPropagation();
          const confirmed = confirm(`Are you sure you want to delete this file?`);
          if (confirmed) {
            const fileName = fileIcon.dataset.fileName;
            const folderPath = currentFolderPath + "/" + fileName;
            deleteFile(folderPath);
          }
        });


        fileIcon.addEventListener("mouseenter", () => showButtons(fileIcon));
        fileIcon.addEventListener("mouseleave", () => hideButtons(fileIcon));

        folderContainer.appendChild(fileIcon);
      }

      function showButtons(folderIcon) {
        const deleteButton = folderIcon.querySelector(".deleteButton");
        const downloadButton = folderIcon.querySelector(".downloadButton");
        deleteButton.style.display = "inline-block";
        downloadButton.style.display = "inline-block";
      }

      function hideButtons(folderIcon) {
        const deleteButton = folderIcon.querySelector(".deleteButton");
        const downloadButton = folderIcon.querySelector(".downloadButton");
        deleteButton.style.display = "none";
        downloadButton.style.display = "none";
      }
      function showButton(fileIcon) {
        const deleteButton = fileIcon.querySelector(".deleteButton");
        const downloadButton = fileIcon.querySelector(".downloadButton");
        deleteButton.style.display = "inline-block";
        downloadButton.style.display = "inline-block";
      }

      function hideButton(fileIcon) {
        const deleteButton = fileIcon.querySelector(".deleteButton");
        const downloadButton = fileIcon.querySelector(".downloadButton");
        deleteButton.style.display = "none";
        downloadButton.style.display = "none";
      }

      function createFolder() {
        const folderName = prompt("Enter folder name:");
        if (folderName) {
          createSubFolder(userId, folderName);
        }
      }
      createRootFolder();
      function createRootFolder(userId, folderName) {
        fetch("create_user_folder.php", {
          method: "GET",
        })
      }


      function createSubFolder(userId, folderName) {
        const formData = new FormData();
        formData.append("userId", userId);
        formData.append("folderName", folderName);
        formData.append("currentFolderPath", currentFolderPath);

        fetch("create_folder.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              fetchFilesAndFolders(currentFolderPath);
            } else {
              alert(data.message);
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while creating the folder.");
          });
      }

      function filterFolders() {
        const searchTerm = searchInput.value.toLowerCase();
        const allIcons = document.querySelectorAll('.folderIcon, .fileIcon');

        allIcons.forEach(icon => {
          const iconText = icon.querySelector('.folderName, .fileName').textContent.toLowerCase();
          if (iconText.includes(searchTerm)) {
            icon.style.display = 'flex';
          } else {
            icon.style.display = 'none';
          }
        });
      }


      function openUploadModal() {
        uploadModal.style.display = "block";
      }

      function closeUploadModal() {
        uploadModal.style.display = "none";
      }

      function uploadFile(folderPath) {
        const fileInput = document.getElementById("fileInput");
        const file = fileInput.files[0];

        if (file) {
          const formData = new FormData();
          formData.append("userId", userId);
          formData.append("file", file);
          formData.append("folderPath", folderPath);

          fetch("upload.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                alert("File uploaded successfully.");
                fetchFilesAndFolders(currentFolderPath);
                closeUploadModal();
              } else {
                alert(data.message);
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              alert("An error occurred while uploading the file.");
            });
        } else {
          alert("Please select a file to upload.");
        }
      }


      // Function to download file
      function downloadFile(fileName, folderPath) {
        const url = `download.php?fileName=${encodeURIComponent(
          fileName
        )}&folderPath=${encodeURIComponent(folderPath)}`;

        fetch(url)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.blob();
          })
          .then((blob) => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
          })
          .catch((error) => {
            console.error("Error downloading file:", error);
          });
      }

      function downloadFolder(folderPath) {
        fetch(`create_zip.php?folderPath=${encodeURIComponent(folderPath)}`)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.blob();
          })
          .then((blob) => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
          })
          .catch((error) => {
            console.error("Error downloading folder:", error);
          });
      }


      function deleteFolder(folderPath) {
        const formData = new FormData();
        formData.append("folderPath", folderPath);

        fetch("delete_folder.php", {
          method: "POST",
          body: formData,
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              fetchFilesAndFolders(currentFolderPath);
            } else {
              console.error('Error:', data.message);
              alert('An error occurred while deleting the folder.');
            }
          })

      }

      function deleteFile(filePath) {
        if (!filePath) {
          console.error('File path not provided.');
          alert('File path not provided.');
          return;
        }

        const formData = new FormData();
        formData.append('filePath', filePath);

        fetch('delete_file.php', {
          method: 'POST',
          body: formData
        })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            console.log('Response from server:', data);
            if (data.success) {
              fetchFilesAndFolders(currentFolderPath);
            } else {
              console.error('Error:', data.message);
              alert('An error occurred while deleting the file.');
            }
          })

      }

      //=======================================================================================

    })
    .catch(error => {
      console.error('Error fetching folder ID:', error);
    });


});
