<div id="passwordModal" class="modal">
    <div class="modal-box">

        <button class="close-btn" onclick="closeModal()">&times;</button>

        <h3>Change Password</h3>
        <p class="modal-sub">Enter a new password for your account.</p>

        <form method="POST" action="profile.php?page=password">

            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm" placeholder="••••••••" required>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-primary">Update Password</button>
            </div>

        </form>

    </div>
</div>
