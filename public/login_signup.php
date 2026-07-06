<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login / Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "header.php"; ?>

<div class="auth-container">

    <!-- SUCCESS MESSAGE -->
    <?php if(isset($_GET['registered'])): ?>
        <p class="success-msg">
            Account created successfully! Please login.
        </p>
    <?php endif; ?>

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span>›</span>
        <span>Account</span>
    </div>

    <!-- GRID -->
    <div class="auth-wrapper">

        <!-- LOGIN -->
        <div class="auth-left">

            <h1>SIGN IN</h1>

            <p class="auth-desc">
                If you have an existing account, please sign in below.
            </p>

            <p id="loginError" class="error-msg"></p>

            <input 
                type="email" 
                id="loginEmail" 
                placeholder="EMAIL ADDRESS"
            >

            <div class="input-group">

                <input 
                    type="password" 
                    id="loginPassword" 
                    placeholder="Password"
                >

                <span 
                    class="toggle-password"
                    onclick="togglePassword('loginPassword', this)"
                >
                    👁
                </span>

            </div>

            <button class="btn-auth" onclick="submitLogin()">
                SIGN IN
            </button>

        </div>

        <!-- REGISTER -->
        <div class="auth-right">

            <h1>CREATE AN ACCOUNT</h1>

            <p class="auth-desc">
                Create your account to start your skincare journey.
            </p>

            <?php if(isset($_GET['error']) && $_GET['error'] === 'email_taken'): ?>
                <p class="error-msg" style="color: #e53e3e; font-size: 13px; margin-bottom: 12px; display:flex; align-items:center; gap:6px;">
                    <svg width="14" height="14" fill="none" stroke="#e53e3e" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    This email is already registered. Please sign in instead.
                </p>
            <?php endif; ?>

            <?php if(isset($_GET['error']) && $_GET['error'] === 'register_failed'): ?>
                <p class="error-msg" style="color: #e53e3e; font-size: 13px; margin-bottom: 12px; display:flex; align-items:center; gap:6px;">
                    <svg width="14" height="14" fill="none" stroke="#e53e3e" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    All fields are required. Please fill in everything.
                </p>
            <?php endif; ?>

            <form action="register.php" method="POST">

                <input 
                    name="name" 
                    placeholder="Full Name"
                    value="<?= htmlspecialchars($_GET['name'] ?? '') ?>"
                    required
                >

                <input 
                    name="email"
                    type="email"
                    placeholder="Email"
                    value="<?= htmlspecialchars($_GET['reg_email'] ?? '') ?>"
                    style="<?= (isset($_GET['error']) && $_GET['error'] === 'email_taken') ? 'border-color: #e53e3e; border-bottom: 2px solid #e53e3e;' : '' ?>"
                    required
                >

                <?php if(isset($_GET['error']) && $_GET['error'] === 'email_taken'): ?>
                    <span style="color: #e53e3e; font-size: 12px; margin-top: -8px; margin-bottom: 8px; display:block;">
                        ✕ Email already in use
                    </span>
                <?php endif; ?>

                <div class="input-group">

                    <input 
                        type="password"
                        name="password"
                        id="regPassword"
                        placeholder="Password"
                        required
                    >

                    <span 
                        class="toggle-password"
                        onclick="togglePassword('regPassword', this)"
                    >
                        👁
                    </span>

                </div>

                <button class="btn-auth black">
                    JOIN NOW
                </button>

            </form>

        </div>

    </div>

</div>

<script>

async function submitLogin(){

    const email = document
        .getElementById("loginEmail")
        .value
        .trim();

    const password = document
        .getElementById("loginPassword")
        .value
        .trim();

    const errorBox = document.getElementById("loginError");

    errorBox.innerText = "";

    if(!email || !password){
        errorBox.innerText = "Please fill in both fields";
        return;
    }

    try {

        const res = await fetch("login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();

        if(data.success){
            window.location.href = data.redirect || "index.php";
            return;
        }

        errorBox.innerText = data.error || "Login failed";

    } catch (e){
        console.error(e);
        errorBox.innerText = "Server error";
    }
}

function togglePassword(id, el){

    const input = document.getElementById(id);

    if(input.type === "password"){
        input.type = "text";
        el.innerText = "⌣";
    } else {
        input.type = "password";
        el.innerText = "👁";
    }
}
</script>

<?php include "footer.php"; ?>

</body>
</html>