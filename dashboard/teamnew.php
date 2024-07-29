<?php include 'header.php'; ?>

<!-- CONTENT -->
<section id="content">
<style>
        .button-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn i {
            margin-right: 8px;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Center the modal */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Decrease the width to make it smaller */
            max-width: 500px; /* Set a max width to prevent it from being too large on larger screens */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 10px;
        }

        .modal-footer {
            text-align: right;
        }

        .btn-copy {
            background-color: #28a745;
        }

        .btn-copy:hover {
            background-color: #218838;
        }

        .btn-share {
            background-color: #17a2b8;
        }

        .btn-share:hover {
            background-color: #138496;
        }

        .copy-input {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
        }
        @media (max-width: 768px) {
    .modal-content {
        width: 90%;
        margin: 20px auto;
    }
}

    </style>
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Team Management</h1>
            </div>
        </div>

        <!-- Button Container -->
        <div class="button-container">
            <a href="#" id="openModalBtn" class="btn btn-primary">
                <i class='bx bx-user-plus'></i>
                <span class="text">Add Employee</span>
            </a>
        </div>
    </main>
    <!-- MAIN -->

    <!-- Modal -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Generate Signup Link</h2>
            </div>
            <div class="modal-body">
                <form id="signupForm">
                    <label for="role">Role:</label>
                    <select id="role" name="role">
                        <!-- Options will be populated dynamically -->
                    </select>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Generate Link">
                </form>
                <div id="linkResult" style="margin-top: 10px;">
                    <input type="text" id="inviteLink" class="copy-input" readonly>
                    <button class="btn btn-copy" id="copyLinkBtn">Copy Link</button>
                    <button class="btn btn-share" id="shareLinkBtn">Share Link</button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="closeModalBtn">Close</button>
            </div>
        </div>
    </div>
</section>
<!-- CONTENT -->
<script src="script.js"></script>
<script>
    // Modal functionality
    var modal = document.getElementById("signupModal");
    var openBtn = document.getElementById("openModalBtn");
    var closeBtn = document.getElementsByClassName("close")[0];
    var closeModalBtn = document.getElementById("closeModalBtn");

    openBtn.onclick = function() {
        modal.style.display = "block";
        loadAllowedRoles(); // Load allowed roles when the modal is opened
    }

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    closeModalBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function loadAllowedRoles() {
        fetch('get_allowed_roles.php') // PHP file to fetch allowed roles
            .then(response => response.json())
            .then(data => {
                var roleSelect = document.getElementById("role");
                roleSelect.innerHTML = ''; // Clear previous options
                data.forEach(role => {
                    var option = document.createElement("option");
                    option.value = role.value;
                    option.textContent = role.text;
                    roleSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Form submission and link generation
    document.getElementById("signupForm").onsubmit = function(event) {
        event.preventDefault();
        var role = document.getElementById("role").value;
        var inviterId = 1; // Replace with actual inviter ID if available
        
        // Generate the link with role and inviter_id
        var generatedLink = "http://yourdomain.com/register.php?role=" + role + "&inviter_id=" + inviterId;
        
        document.getElementById("inviteLink").value = generatedLink;
    }

    // Copy link to clipboard
    document.getElementById("copyLinkBtn").onclick = function() {
        var copyText = document.getElementById("inviteLink");
        copyText.select();
        document.execCommand("copy");
        alert("Link copied to clipboard!");
    }

    // Share link (simple alert for demo purposes)
    document.getElementById("shareLinkBtn").onclick = function() {
        var link = document.getElementById("inviteLink").value;
        alert("Share this link: " + link);
    }
    // Copy link to clipboard
document.getElementById("copyLinkBtn").onclick = async function() {
    try {
        const link = document.getElementById("inviteLink").value;
        await navigator.clipboard.writeText(link);
        alert("Link copied to clipboard!");
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
}

</script>

</body>
</html>
