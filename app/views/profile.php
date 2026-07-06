<!DOCTYPE html>
<html>
<head>
<title>My Profile — AI DermaAssist</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --white: #ffffff; --bg: #f7f7f7; --border: #e5e5e5;
    --text: #111111; --muted: #888888; --sidebar-w: 240px;
}
body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; font-size: 14px; }
.layout { display: flex; min-height: 100vh; }

.sidebar { width: var(--sidebar-w); background: var(--white); border-right: 1px solid var(--border); padding: 28px 16px; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; }
.sidebar-logo { font-size: 14px; font-weight: 600; color: var(--text); padding: 0 8px; margin-bottom: 32px; }
.back-home a { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); text-decoration: none; padding: 7px 8px; border-radius: 6px; margin-bottom: 4px; transition: color 0.15s, background 0.15s; }
.back-home a:hover { color: var(--text); background: var(--bg); }
.menu-label { font-size: 10px; color: var(--muted); padding: 0 8px; margin-bottom: 4px; letter-spacing: 0.06em; text-transform: uppercase; }
.menu a { display: flex; align-items: center; gap: 10px; padding: 9px 8px; border-radius: 6px; margin-bottom: 1px; text-decoration: none; color: var(--muted); font-size: 13px; transition: color 0.15s, background 0.15s; }
.menu a i { width: 16px; text-align: center; font-size: 13px; }
.menu a:hover { color: var(--text); background: var(--bg); }
.menu .active { color: var(--text); background: var(--bg); font-weight: 500; }
.sidebar-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
.logout { margin-top: auto; }
.logout a { display: flex; align-items: center; gap: 10px; padding: 9px 8px; border-radius: 6px; text-decoration: none; color: #e53e3e; font-size: 13px; transition: background 0.15s; }
.logout a:hover { background: #fff5f5; }

.main { flex: 1; padding: 40px 48px; max-width: 860px; }
.page-title { font-size: 20px; font-weight: 600; margin-bottom: 2px; }
.page-sub { font-size: 13px; color: var(--muted); margin-bottom: 28px; }

.profile-header { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 24px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.profile-identity { display: flex; align-items: center; gap: 16px; }
.avatar { width: 52px; height: 52px; border-radius: 50%; background: #111; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; flex-shrink: 0; }
.profile-name { font-size: 16px; font-weight: 600; margin-bottom: 2px; }
.profile-email { font-size: 12px; color: var(--muted); margin-bottom: 6px; }
.profile-badge { display: inline-block; padding: 2px 8px; border: 1px solid var(--border); border-radius: 4px; font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; }
.stats-box { display: flex; align-items: center; gap: 28px; }
.stat { text-align: center; }
.stat-num { font-size: 22px; font-weight: 600; line-height: 1; margin-bottom: 3px; }
.stat-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; }
.stats-div { width: 1px; height: 36px; background: var(--border); }

.grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
.card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 20px 24px; }
.card-title { font-size: 13px; font-weight: 600; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
.card-title i { font-size: 12px; color: var(--muted); cursor: pointer; transition: color 0.15s; }
.card-title i:hover { color: var(--text); }

.row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
.row:last-of-type { border-bottom: none; }
.row span:first-child { color: var(--muted); }
.row input { background: var(--bg); border: 1px solid var(--border); padding: 6px 10px; color: var(--text); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 13px; outline: none; text-align: right; transition: border-color 0.15s; }
.row input:focus { border-color: #111; }

.security-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; font-size: 13px; cursor: pointer; border-radius: 6px; transition: background 0.15s; }
.security-row:hover { background: var(--bg); padding-left: 6px; }
.security-row span:last-child { color: var(--muted); font-size: 11px; }

#saveBtn { display: none; margin-top: 14px; padding: 8px 18px; border: 1px solid #111; border-radius: 6px; background: #111; color: #fff; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: opacity 0.15s; }
#saveBtn:hover { opacity: 0.8; }

.view-history { display: inline-flex; align-items: center; gap: 5px; margin-top: 12px; font-size: 12px; color: var(--text); cursor: pointer; text-decoration: none; font-weight: 500; transition: opacity 0.15s; }
.view-history:hover { opacity: 0.5; }

.modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); justify-content: center; align-items: center; z-index: 999; }
.modal-box { position: relative; background: var(--white); padding: 28px; border-radius: 12px; width: 360px; border: 1px solid var(--border); animation: fadeUp 0.2s ease; }
@keyframes fadeUp { from { transform: translateY(8px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.modal-box h3 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
.modal-sub { font-size: 12px; color: var(--muted); margin-bottom: 20px; }
.close-btn { position: absolute; top: 16px; right: 16px; font-size: 16px; color: var(--muted); cursor: pointer; background: none; border: none; transition: color 0.15s; }
.close-btn:hover { color: var(--text); }
.input-group { margin-bottom: 12px; }
.input-group label { display: block; font-size: 11px; color: var(--muted); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.05em; }
.input-group input { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; font-size: 13px; outline: none; transition: border-color 0.15s; }
.input-group input:focus { border-color: #111; background: var(--white); }
.modal-actions { display: flex; justify-content: flex-end; margin-top: 20px; }
.btn-primary { padding: 9px 20px; border: none; border-radius: 6px; background: #111; color: #fff; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: opacity 0.15s; }
.btn-primary:hover { opacity: 0.8; }

@media (max-width: 860px) { .main { padding: 28px 20px; } .grid { grid-template-columns: 1fr; } .profile-header { flex-direction: column; align-items: flex-start; gap: 16px; } }
</style>
</head>
<body>
<div class="layout">

<?php require 'partials/sidebar.php'; ?>

<div class="main">
    <h1 class="page-title">My Profile</h1>
    <p class="page-sub">Manage your personal information and account settings.</p>

    <div class="profile-header">
        <div class="profile-identity">
            <div class="avatar"><?= strtoupper(substr($user['name'],0,1)) ?></div>
            <div>
                <div class="profile-name"><?= $user['name'] ?></div>
                <div class="profile-email"><?= $user['email'] ?></div>
                <span class="profile-badge">Member</span>
            </div>
        </div>
        <div class="stats-box">
            <div class="stat">
                <div class="stat-num"><?= count($history) ?></div>
                <div class="stat-label">Analyses</div>
            </div>
            <div class="stats-div"></div>
            <div class="stat">
                <div class="stat-num"><?= !empty($history) ? date('d M', strtotime($history[0]['created_at'])) : '—' ?></div>
                <div class="stat-label">Last Scan</div>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="card-title">Personal Information <i class="fa fa-pen" onclick="toggleEdit()"></i></div>
            <form method="POST" action="profile.php?page=update" id="editForm">
                <div class="row"><span>Username</span><input type="text" name="name" value="<?= $user['name'] ?>" disabled></div>
                <div class="row"><span>Email</span><input type="email" name="email" value="<?= $user['email'] ?>" disabled></div>
                <button type="submit" id="saveBtn">Save Changes</button>
            </form>
        </div>
        <div class="card">
            <div class="card-title">Security</div>
            <div class="security-row" onclick="openModal()">
                <span>Change Password</span>
                <span><i class="fa fa-chevron-right" style="font-size:10px;"></i></span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Activity</div>
        <div class="row"><span>Analyses Done</span><span><?= count($history) ?></span></div>
        <div class="row"><span>Last Analysis</span><span><?= !empty($history) ? date('d M Y', strtotime($history[0]['created_at'])) : '—' ?></span></div>
        <a class="view-history" onclick="window.location='profile.php?page=history'">
            View full history <i class="fa fa-arrow-right" style="font-size:10px;"></i>
        </a>
    </div>
</div>
</div>

<?php require 'partials/password_modal.php'; ?>
<script>
let editMode = false;
function toggleEdit(){
    editMode = !editMode;
    document.querySelectorAll('#editForm input').forEach(i => i.disabled = !editMode);
    document.getElementById('saveBtn').style.display = editMode ? 'block' : 'none';
}
function openModal(){ document.getElementById('passwordModal').style.display='flex'; }
function closeModal(){ document.getElementById('passwordModal').style.display='none'; }
</script>
</body>
</html>
