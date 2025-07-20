<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../views/partials/header.php'; ?>

    <main>
        <div class="container">
            <div class="form-header">
                <h2>User Profile</h2>
                <p>Manage your personal information</p>
            </div>

            <div class="profile-container">
                <?php if (isset($user) && !empty($user)): ?>
                    <div class="profile-main">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <?php if (!empty($user['profile_photo'])): ?>
                                    <img src="/uploads/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile Photo">
                                <?php else: ?>
                                    <span><?= strtoupper(substr($user['full_name'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="profile-info">
                                <h3><?= htmlspecialchars($user['full_name']) ?></h3>
                                <p style="color: var(--primary-color); font-weight: 500;"><?= htmlspecialchars($user['role']) ?></p>
                            </div>
                        </div>

                        <div class="profile-details">
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span><?= htmlspecialchars($user['email']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Phone</span>
                                <span><?= htmlspecialchars($user['phone']) ?></span>
                            </div>

                        
                            <?php if ($user['role'] == 'admin'): ?>
                                <div class="detail-row">
                                    <span class="detail-label">Admin Dashboard Access</span>
                                    <span>Has access to manage menu</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="profile-actions">
                            <a href="/update-profile" class="btn btn-primary">Update Profile</a>
                            <form method="post" action="/delete-profile" style="display: inline;"
                                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </form>
                        </div>
                    </div>

                    <div class="profile-sidebar">
                        <div class="profile-card">
                            <h4>Profile Completion</h4>
                            <p style="font-size: 2rem; color: var(--success-color); font-weight: bold;">100%</p>
                        </div>
                        <div class="profile-card">
                            <h4>Member Since</h4>
                            <p style="font-size: 1.2rem; color: var(--primary-color);"><?= date('M Y') ?></p>
                        </div>
                        <div class="profile-card">
                            <h4>Role</h4>
                            <p style="font-size: 1.2rem; color: var(--secondary-color); text-transform: capitalize;"><?= htmlspecialchars($user['role']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-user-message">
                        <h3>No user found. Please log in or register to access your profile.</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>
