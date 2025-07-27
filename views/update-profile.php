<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../views/partials/header.php'; ?>

    <main>
        <div class="container">
            <div class="form-container" style="max-width: 600px;">
                <div class="form-header">
                    <h2>Update Profile</h2>
                    <p>Keep your information up to date</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" action="/update-profile">
                    <input type="hidden" name="current_photo" value="<?= htmlspecialchars($user['profile_photo']) ?>">

                    <div class="form-group">
                        <label>Current Photo</label>
                        <div class="text-center">
                            <?php if (!empty($user['profile_photo'])): ?>
                                <div class="profile-avatar" style="margin: 0 auto;">
                                    <img src="/uploads/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Current Profile Photo">
                                </div>
                            <?php else: ?>
                                <div class="profile-avatar" style="margin: 0 auto;">
                                    <span><?= strtoupper(substr($user['full_name'], 0, 1)) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control"
                            value="<?= htmlspecialchars($user['full_name']) ?>" placeholder="Enter your full name">
                        <?php if (!empty($errors['name'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['name']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="<?= htmlspecialchars($user['email']) ?>" placeholder="Enter your email">
                        <?php if (!empty($errors['email'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['email']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="<?= htmlspecialchars($user['phone']) ?>" placeholder="Enter your phone">
                        <?php if (!empty($errors['phone'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['phone']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="profile_photo">Update Photo</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*">
                        <?php if (!empty($errors['photo'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['photo']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="/dashboard" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>