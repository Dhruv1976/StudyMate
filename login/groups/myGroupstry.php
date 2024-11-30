<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start();
    if (!isset($_SESSION['user_id'])) {

        header("location: /studyMate/src/login/form/form.html");
        exit;
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="navstyle.css">
    <link rel="stylesheet" href="popup.css">
    <?php
    include ("dbconnect.php");
    include ("returnUser.php");
    ?>

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

                <div class="user-icon dropdown-trigger" id="userIcon"><i class="fas fa-user" style="padding: 7px;"></i>
                </div>

            </div>
        </div>
        <div class="dropdown_menu menu ">
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

    <div>


        <div class="content" id="content">

            <!-- Sidebar for chat list -->
            <div class="chat-sidebar window" id="chat-sidebar">
                <h2>Groups
                    <input type="search" name="searchgroups" id="searchgroups" placeholder="search Groups"
                        style="margin-top: 10px;font-size: medium;width: 170px;padding: 7px;border-radius: 7px;"
                        oninput="searchGroups(this.value)">
                </h2>

                <ul class="chat-list" id="chat-list">


                </ul>
            </div>

            <!-- file window  -->
            <div class="chat-container">

                <div class="chat-header" id="group-options-btn">
                    <h1 id="group-name" data-window="chat-sidebar">Click here to select group</h1>
                    <button id="menu-button" class="menu-button">&#9776;</button>

                </div>

                <div id="filePreview" class="file-preview">
                    <img id="previewImage" src="#" alt="Preview Image">
                    <div id="fileDetails"></div>
                    <div style="display:flex;">
                        <button id="sendButton" style="display: none;">Send</button>
                        <button id="cancelButton" style="display: none;">Cancel</button>
                    </div>
                </div>



                <!--Group window-->
                <div class="chat-messages" id="chat-messages">

                    <div id="filesContainer">
                        <div class="file-entry"> Study with studyMate share and downolad files
                            <div class=""
                                style="display: flex;    height: 310px;justify-content: center;align-items: center;">
                                <image style="  width:100%;  height: 100%;" src="no-group.png" />
                            </div>
                            you haven't selected any group select or join group to be a part of community
                        </div>
                    </div>
                    <div id="tempholder">

                    </div>
                </div>
                <div class="input-container">

                    <button id="uploadFile">Upload File</button>


                    <div class="">
                        <!-- <button onclick=" openHelpGroupswindow()">
                Help
            </button> -->
                        <button onclick="openCreateGroupswindow()">
                            Create Groups
                        </button>
                        <button onclick="openjoinwindow()">
                            join Groups
                        </button>
                    </div>
                </div>
            </div>

            <div class="options-window window" id="options-window">
                <ul>
                    <li id="view-members-btn" data-window="memberslistwindow">View Members</li>
                    <li id="view-requests-btn" data-window="requestlistwindow">Request List</li>
                    <!-- <li data-window="Files">Files</li>
        <li data-window="Add Members">Add Members</li>
        <li data-window="Invite via Link">Invite via Link</li> future-->
                </ul>
            </div>

            <div class="memberslistwindow window" id="memberslistwindow">
                <ul id="memberlist">
                    <li>memberslist</li>
                </ul>
            </div>

            <div class="requestlistwindow window" id="requestlistwindow">
                <ul id="requestlist">
                    <li>requestlist</li>
                </ul>
            </div>
            <div class="newGroup window" id="newGroup">
                <div class="newGroup-content">
                    <div class="new-header">
                        <h3>Create Group </h3>
                        <button class="btn" id="closenew">&times;</button>
                    </div>
                    <div class="createGroupForm">

                        <label for="groupName">Group Name:</label>
                        <div class="form-group">

                            <input type="text" id="groupName" name="groupName" maxlength="50" required>
                        </div>
                        <label for="groupDescription">Group Description:</label>
                        <div class="form-group">

                            <textarea id="groupDescription" name="groupDescription" style='height: 61px;'
                                maxlength="255" placeholder="Optional"></textarea>
                        </div>
                        <span id="errorMessage"></span>
                        <div class="form-group">
                            <button id="submitButton">Create Group</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="joinGroup window" id="joinGroup">
                <div class="joinGroup-content">
                    <div class="join-header">
                        <h3>Join Groups </h3>

                        <button class="btn" id="closejoin">&times;</button>
                    </div>
                    <div class="joingrouptable">
                        <table border="1" id="myTable">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Group Name</th>
                                    <th>Admin</th>
                                    <th>Description</th>
                                    <th>REQUEST</th>
                                </tr>


                            </thead>
                            <tbody>

                                <!-- Table body will be dynamically populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    
        <div class="alert" id="alert">
            <h2>StudyMate Says:</h2>
            <div class="alert-content">
                <textarea id="alertmsg" readonly>
        </textarea>
                <div class="alert-close">
                    <button id="closeAlert" style="margin-bottom:15px;margin-right:15px;">Ok</button>
                </div>
            </div>

        </div>
    </div>
    <?php
    echo "<script>
    </script>
    ";



    ?>
    <!-- nav -->

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
            // Send request to logout PHP script
            fetch("./logout.php")
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

    <!-- nav end -->
    <script>
        let result; // to check if the user if admin or not

        let group_id;


        let groupname = document.getElementById("group-name");
        const groupOptionsBtn = document.getElementById('group-options-btn');
        const optionsWindow = document.getElementById('options-window');
        const fileDetails = document.getElementById('fileDetails');
        const cancelButton = document.getElementById('cancelButton');

        const options = document.querySelectorAll('.options-window ul li');
        const menuButton = document.getElementById('menu-button');
        const chatSidebar = document.getElementById('chat-sidebar');
        const membersListWindow = document.getElementById('memberslistwindow');

        const requestListWindow = document.getElementById('requestlistwindow');
        const addButtons = document.querySelectorAll('.add-btn');
        const rejectButtons = document.querySelectorAll('.reject-btn');

        const filePreview = document.getElementById('filePreview');
        const fileOptions = document.getElementById("fileOptions");
        const filesContainer = document.getElementById("filesContainer");
        const previewImage = document.getElementById('previewImage');
        const sendButton = document.getElementById('sendButton');

        const closejoin = document.getElementById("closejoin");
        const closenew = document.getElementById("closenew");
        const newwindow = document.getElementById("newGroup");
        const joinwindow = document.getElementById("joinGroup");
        const tableBody = document.querySelector("#myTable tbody");

        const inputgroupname = document.getElementById("groupName");
        const inputdescription = document.getElementById("groupDescription");
        const submitButton = document.getElementById("submitButton");

        const errorMessage = document.getElementById("errorMessage");
        const closeAlert = document.getElementById('closeAlert');
        const Alerting = document.getElementById('alert');
        const alertmsg = document.getElementById('alertmsg');
        Alerting.style.display = 'none'

        const groupData = <?php echo json_encode(fetchQuery("select groupname,group_id from group_status_list where user_id = '" . $_SESSION['user_id'] . "' and (`status` = 'member' or `status` = 'admin')", "study_mate")); ?>;


        function Alert(str) {
            alertmsg.innerHTML = str;
            console.log(str)
            Alerting.style.display = 'block'
            closeOtherWindows();
        }

        let GroupInBar; // for searching groups in side bar



        createTable(groupData);
        function closeOtherWindows() {
            var closeWindow = document.querySelectorAll(".window");
            closeWindow.forEach(e => {
                e.style.display = 'none';
            });
            menuButton.innerHTML = '&#9776;';
        }

        function getUpdatedGroups() {
            Fetch("./getUpdatedGroups.php?user_id=<?php echo $_SESSION['user_id']; ?>", 'json')
                .then(function (response) {
                    if (response) {
                        createTable(response)
                    }
                    else {
                        console.log("no updated group can't be fetched.")
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
            // createtable()
        }
        function createTable(data) {
            deleteElementById("chat-list");
            GroupInBar = []
            newElement("ul", { class: "chat-list", id: "chat-list" }, "", "chat-sidebar");

            if (data.length > 0) {

                data.forEach(function (element) {
                    var subdiv = newElement("li", { class: "chat-list-item", id: element.groupname }, element.groupname, "chat-list");
                    GroupInBar.push(subdiv)
                    subdiv.addEventListener('click', function () {

                        var group = element['groupname'];
                        var username = '<?php echo $_SESSION['name']; ?>';
                        Fetch("./isAdmin.php?ingroup=" + encodeURIComponent(group) + "&username=" + encodeURIComponent(username), 'json')
                            .then(data => {
                                // console.log('isadmin: ' + data['result'])
                                result = data['result']
                                getUpdatedFiles();
                                appendRequestsList(group, data['result']);
                            })
                            .catch(error => console.error('Error:', error));
                        chatSidebar.style.display = "none"
                    });
                });
            }
        }
        function insertfiles(response) {

            filesContainer.innerHTML = response;
        }

        async function Fetch(url, responseType) {
            try {

                const response = await fetch(url);


                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }


                if (responseType === 'json') {
                    return await response.json();
                } else if (responseType === 'text') {
                    return await response.text();
                } else {
                    throw new Error('Invalid response type. Use "json" or "text".');
                }
            } catch (error) {

                console.error('Error:', error);
                throw error;
            }
        }
        function getUpdatedjoinGroups() {
            Fetch("./getUpdatedJoinGroup.php?user_id=<?php echo $_SESSION['user_id']; ?>", "text")
                .then(data => {

                    tableBody.innerHTML = (data);

                    document.querySelectorAll(".button").forEach(button => {

                        button.addEventListener("click", (event) => {
                            console.log(event.target.name)
                            if (Alerting.style.display == "none") {
                                var groupname = event.target.name;

                                if (groupname) {
                                    Fetch("./groupJoinRequest.php?group=" + encodeURIComponent(groupname) + "&groupid=" + encodeURIComponent(event.target.id), 'text')
                                        .then(data => {

                                            Alert(data);
                                            getUpdatedjoinGroups();
                                        })
                                        .catch(function (error) {
                                            console.error(error);
                                        });
                                    closeOtherWindows();

                                }
                            }
                        });
                    });

                })

                .catch(function (error) {
                    console.error(error);
                });
        }
        getUpdatedjoinGroups();

        function deleteElementById(id) {
            var elementToDelete = document.getElementById(id);
            if (elementToDelete) {
                elementToDelete.remove();
            }
        }

        function newElement(elementName, attributes, Value, parentId) {
            const parentElement = document.getElementById(parentId);

            const newElement = document.createElement(elementName);
            for (const [key, value] of Object.entries(attributes)) {
                newElement.setAttribute(key, value);
            }
            newElement.innerHTML = Value;
            if (!parentElement) {
                document.body.appendChild(newElement)
            }
            else
                parentElement.appendChild(newElement);
            return newElement;
        }



        function getUpdatedFiles() {
            // console.log(groupname.innerHTML+","+result)
            Fetch("./getFilesContents.php?groupName=" + encodeURIComponent(groupname.innerHTML) + "&admin=" + encodeURIComponent(result), 'text')
                .then(data => {
                    insertfiles(data)
                    filecantdownload();
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

        function appendMembersList(group) {

            deleteElementById("memberlist");
            newElement("ul", { id: "memberlist" }, "", "memberslistwindow");

            Fetch("./appendMRlist.php?group=" + encodeURIComponent(group) + "&request=member", 'json')
                .then(function (response) {
                    response.forEach(userdata => {
                        // console.log( userdata['username']+" : "+userdata['status'])
                        var status = (userdata['status'] == 'admin') ? " : admin" : " : member";
                        newElement("li", { id: "key", class: "chat-list-item" }, '<b>'+userdata['username'] + status+'</b>', "memberlist");
                    });
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

        function appendRequestsList(group, result) {
            // console.log(group + " " + result);

            if (result == "true") {
                document.getElementById("view-requests-btn").style.display = 'block';
                deleteElementById("requestlist");
                newElement("ul", { id: "requestlist" }, "", "requestlistwindow");

                Fetch("./appendMRlist.php?group=" + encodeURIComponent(group) + "&request=pending", 'json')
                    .then(function (response) {
                        if (response.length > 0) {
                            response.forEach(userdata => {
                                for (const key in userdata) {
                                    if (Object.hasOwnProperty.call(userdata, key)) {
                                        const value = userdata[key];
                                        newElement("li", { id: value, class: "chat-list-item" },' <div><b>' + value + '</b></div><div> <button class="add-btn">Add</button> <button class="reject-btn">Reject</button></div>', "requestlist");
                                    }
                                }
                            });
                            addEventsTONewButtons();
                        } else {
                            newElement("li", { id: "nothing", class: "chat-list-item" }, '<div style=" height: 174px;display:flex;align-items:center;justify-content:center;flex-direction:column;"><img src="doubt.png" style="height: 126px;"><div>NO REQUESTs FOUND AT THIS MOMENT..</div></div>', "requestlist");
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            } else {
                document.getElementById("view-requests-btn").style.display = 'none';
            }
        }


        function acceptfile(id, name) {
            if (Alerting.style.display == 'none') {
                Fetch("./accept_reject.php?fileid=" + encodeURIComponent(id) + "&filerequest=accepted", 'json')
                    .then(function (response) {
                        console.log(response['result'])
                        if (response['result'] == true) {
                            Alert("File with name : " + name + " is accepted")
                            getUpdatedFiles();

                        } else {
                            Alert("File with name : " + name + " couldn't be accepted");
                        }

                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        }

        function addEventsTONewButtons() {
            document.querySelectorAll('.requestlistwindow ul li').forEach(function (li) {

                li.addEventListener('click', function (event) {
                    console.log("function envoked")
                    console.log(event.target)
                    if (event.target.classList.contains('add-btn')) {
                        const requestName = li.id;

                        console.log('Adding ' + requestName + '...');
                        Fetch("./update_request.php?requestName=" + encodeURIComponent(li.id) + "&Action=add" + "&groupname=" + encodeURIComponent(groupname.innerHTML), 'text')
                            .then(data => {
                                appendMembersList(groupname.innerHTML)
                                console.log('Added ' + requestName);
                                deleteElementById(requestName)
                            })
                            .catch(function (error) {
                                console.error(error);
                            });


                        this.remove();
                    } else if (event.target.classList.contains('reject-btn')) {
                        const requestName = this.textContent.trim();
                        console.log('Rejecting ' + li.id + '...');

                        Fetch("./update_request.php?requestName=" + encodeURIComponent(li.id) + "&Action=rejected" + "&groupname=" + encodeURIComponent(groupname.innerHTML), 'text')
                            .then(data => {

                                console.log('rejected ' + requestName);
                                deleteElementById(requestName)
                            })
                            .catch(function (error) {
                                console.error(error);
                            });
                        appendMembersList(groupname.innerHTML)
                        console.log('Rejected ' + requestName);
                        this.remove();
                    }

                });
            });
        }

        function rejectfile(id, name) {
            if (Alerting.style.display == 'none') {
                Fetch("./accept_reject.php?fileid=" + encodeURIComponent(id) + "&filerequest=rejected", 'json')
                    .then(function (response) {
                        if (response['result'] == true) {
                            Alert("File with name : " + name + " is rejected")
                            getUpdatedFiles();

                        } else {
                            Alert("File with name : " + name + " couldn't be rejected");
                        }

                    })
                    .catch(function (error) {
                        console.error(error); // Handle errors here
                    });
            }
        }

        function searchGroups(str) {
            GroupInBar.forEach((e) => {
                let item = e.id.toLowerCase();
                if (item.includes(str.toLowerCase())) {
                    // if (Alerting.style.display != 'block')
                    e.style.display = "block";
                } else {
                    e.style.display = "none";
                }
            });


        }
        function openCreateGroupswindow() {
            closeOtherWindows();
            menuButton.innerHTML = '&#9776;';
            if (document.getElementById("newGroup").style.display == 'block')
                document.getElementById("newGroup").style.display = 'none'
            else
                if (Alerting.style.display == 'none')
                    document.getElementById("newGroup").style.display = 'block'
        }
        function openjoinwindow() {
            closeOtherWindows()
            menuButton.innerHTML = '&#9776;';
            if (document.getElementById("joinGroup").style.display == 'block')
                document.getElementById("joinGroup").style.display = 'none'
            else
                if (Alerting.style.display == 'none')
                    document.getElementById("joinGroup").style.display = 'block'
        }

        function validateInput(input) {
            const pattern = /^[a-zA-Z0-9\s]*$/;
            if (pattern.test(input)) {
                input = input.replace(/\s/g, '_');
            } else {
                let inputWithoutSpecialChars = input.replace(/[^a-zA-Z0-9\s]/g, '');
                inputWithoutSpecialChars = inputWithoutSpecialChars.replace(/\s/g, '_');

                if (input !== inputWithoutSpecialChars) {
                    console.log("Special characters found and removed. Checking Name: " + inputWithoutSpecialChars);
                }

                input = inputWithoutSpecialChars;
            }
            return input;
        }




        closeAlert.addEventListener('click', () => {

            Alerting.style.display = 'none'
        })
        submitButton.addEventListener("click", () => {
            var Tempgroup = inputgroupname.value;
            var TempDescription = inputdescription.value;

            if (Tempgroup.length > 0) {
                errorMessage.innerHTML = "";

                Fetch("./createNewGroup.php?groupName=" + encodeURIComponent(Tempgroup) + "&groupDescription=" + encodeURIComponent(TempDescription), 'text')
                    .then(function (response) {

                        if (response.length > 0) {

                            if (response == "  Group `" + validateInput(Tempgroup) + "` created sucessfully.  ") {
                                getUpdatedGroups();
                            }

                            Alert(response)
                        } else {
                            Alert("Error while creating Group.");
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }

            else
                errorMessage.innerHTML = "Please enter your group name.";
        })
        options.forEach(function (option) {

            option.addEventListener('click', function () {
                var windowId = option.getAttribute('data-window');
                var windowElement = document.getElementById(windowId);

                closeOtherWindows();
                menuButton.innerHTML = '&#10006;';
                if (windowElement)
                    windowElement.style.display = 'block';

                optionsWindow.style.display = 'block';
            });
        });

        groupname.addEventListener("click", function () {

            if (chatSidebar.style.display == "block")
                chatSidebar.style.display = "none"
            else {
                closeOtherWindows();
                if (Alerting.style.display != 'block') {
                    chatSidebar.style.display = "block"
                    menuButton.innerHTML = '&#9776;';
                }

            }


        })


        document.getElementById('chat-sidebar').addEventListener('click', function (event) {
            if (event.target && event.target.nodeName == 'LI') {
                var groupName = event.target.textContent.trim();
                groupname.innerHTML = groupName;
                menuButton.innerHTML = '&#9776;';

            }

        });



        document.getElementById("uploadFile").addEventListener("click", function () {

            if (groupname.innerHTML != "Click here to select group") {

                var fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = '.pdf, .doc, .docx';
                fileInput.style.display = 'none';
                document.body.appendChild(fileInput);

                fileInput.click();

                fileInput.addEventListener('change', function (event) {
                    var selectedFile = event.target.files[0];
                    // console.log('Selected file:', selectedFile);



                    fileDetails.innerHTML = '';

                    var fileName = document.createElement('p');
                    fileName.textContent = 'File Name: ' + selectedFile.name;
                    fileDetails.appendChild(fileName);

                    var fileSize = document.createElement('p');
                    fileSize.textContent = 'File Size: ' + selectedFile.size + ' bytes';
                    fileDetails.appendChild(fileSize);

                    var fileModified = document.createElement('p');
                    fileModified.textContent = 'Date Modified: ' + selectedFile.lastModifiedDate;
                    fileDetails.appendChild(fileModified);


                    filePreview.style.display = 'block';

                    sendButton.style.display = 'block';
                    // 
                    previewImage.style.display = 'none';
                    if (selectedFile.type.startsWith('image/')) {
                        previewImage.src = URL.createObjectURL(selectedFile);
                        previewImage.onload = function () {
                            URL.revokeObjectURL(this.src);
                            previewImage.style.display = 'block';
                        };
                    }

                    sendButton.selectedFile = selectedFile;

                    if (Alerting.style.display != 'block')
                        cancelButton.style.display = "block";


                    document.body.removeChild(fileInput);


                });
            }
            else {
                Alert("Please Select or join a Group.")
            }
            closeOtherWindows()

        });

        cancelButton.addEventListener('click', function () {
            closeOtherWindows()
            filePreview.style.display = 'none';


        })

        sendButton.addEventListener('click', function () {
            closeOtherWindows()
            filePreview.style.display = 'none';

            var selectedFile = this.selectedFile;
            var formData = new FormData();
            formData.append('file', selectedFile);
            formData.append('group', groupname.innerHTML);
            formData.append('name', '<?php echo $_SESSION['name'] ?>');

            var xhr = new XMLHttpRequest();

            xhr.open('POST', '../sendfile/upload.php');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    Alert(this.responseText)
                    getUpdatedFiles();

                } else {
                    Alert('Error uploading file :', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Request failed');
            };
            xhr.send(formData);
            deleteElementById("tempholder");
            newElement("div", { id: "tempholder" }, "", "chat-messages");



        });
        // var data = groupname.innerHTML;



        menuButton.addEventListener('click', function () {
            if (groupname.innerHTML != "Click here to select group") {

                if (optionsWindow.style.display === 'block') {
                    closeOtherWindows()
                    optionsWindow.style.display = 'none';
                    menuButton.innerHTML = '&#9776;'; // Menu icon when closed
                } else {
                    closeOtherWindows()
                    if (Alerting.style.display != 'block') {
                        optionsWindow.style.display = 'block';
                        menuButton.innerHTML = '&#10006;'; // Cross icon when opened
                    }
                }
                appendMembersList(groupname.innerHTML)

            } else {
                Alert("Please Select or join a Group.")
            }

        });
        closejoin.addEventListener("click", () => {
            joinwindow.style.display = 'none'
        })
        closenew.addEventListener("click", () => {
            newwindow.style.display = 'none'
        })

        function filecantdownload() {
            var x = document.querySelectorAll(".cant-download")
            x.forEach(e => {
                e.addEventListener("click", () => {
                    Alert("This file can only be downloaded after the admin approves it.")
                })
            })
        }
        
    </script>

</body>

</html>