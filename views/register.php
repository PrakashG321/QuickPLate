<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
    <script>
        // Client-side validation function
        function validateForm() {
            let name = document.getElementById('full_name').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let phone = document.getElementById('phone').value;
            let profilePhoto = document.getElementById('profile_photo').value;
            
            let emailError = document.getElementById('email-error');
            let passwordError = document.getElementById('password-error');
            let nameError = document.getElementById('name-error');
            let phoneError = document.getElementById('phone-error');
            let photoError = document.getElementById('photo-error');
            let valid = true;

   
            emailError.textContent = '';
            passwordError.textContent = '';
            nameError.textContent = '';
            phoneError.textContent = '';
            photoError.textContent = '';

            if (!name) {
                nameError.textContent = 'Full Name is required.';
                valid = false;
            }

            if (!email) {
                emailError.textContent = 'Email is required.';
                valid = false;
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                emailError.textContent = 'Please enter a valid email address.';
                valid = false;
            }

            if (!password) {
                passwordError.textContent = 'Password is required.';
                valid = false;
            } else if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters long.';
                valid = false;
            }

  
            if (phone && !/^\d{10}$/.test(phone)) {
                phoneError.textContent = 'Please enter a valid phone number (10 digits).';
                valid = false;
            }

            if (!profilePhoto) {
                photoError.textContent = 'Profile photo is required.';
                valid = false;
            }

            return valid;
        }
    </script>
</head>

<body>
    <?php include __DIR__ . '/../views/partials/header.php'; ?>

    <main>
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2>Create Account</h2>
                    <p>Join our QuickPlate community</p>
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

                <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required
                            value="<?= htmlspecialchars($name ?? '') ?>" placeholder="Enter your full name">
                        <div id="name-error" class="field-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required
                            value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Enter your email">
                        <div id="email-error" class="field-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required
                            placeholder="Create a password">
                        <div id="password-error" class="field-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="<?= htmlspecialchars($phone ?? '') ?>" placeholder="Enter your phone">
                        <div id="phone-error" class="field-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="profile_photo">Profile Photo</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*">
                        <div id="photo-error" class="field-error"></div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="/login" style="color: var(--primary-color);">Sign in here</a></p>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>
