<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
    <script>
        // Client-side validation
        function validateForm() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let emailError = document.getElementById('email-error');
            let passwordError = document.getElementById('password-error');
            let valid = true;

    
            emailError.textContent = '';
            passwordError.textContent = '';

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
                    <h2>Welcome Back</h2>
                    <p>Sign in to your account</p>
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

                <form method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required
                            value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Enter your email">
                        <div id="email-error" class="field-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required
                            placeholder="Enter your password">
                        <div id="password-error" class="field-error"></div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
                </form>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="/register" style="color: var(--primary-color);">Create one here</a></p>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>
