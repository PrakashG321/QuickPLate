<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Menu Item - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main>
        <div class="container">
            <div class="form-container" style="max-width: 600px;">
                <div class="form-header">
                    <h2>Create New Menu Item</h2>
                    <p>Add a delicious new item to your menu</p>
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

                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Item Name</label>
                        <input type="text" name="name" id="name" class="form-control" required
                            placeholder="e.g., Margherita Pizza"
                            value="<?= htmlspecialchars($name ?? '') ?>">
                        <?php if (!empty($errors['name'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['name']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required
                            placeholder="Describe the ingredients, taste, and what makes this item special..."
                            rows="4"><?= htmlspecialchars($description ?? '') ?></textarea>
                        <?php if (!empty($errors['description'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['description']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($)</label>
                        <input type="number" name="price" id="price" class="form-control" required
                            step="0.01" min="0" placeholder="0.00"
                            value="<?= htmlspecialchars($price ?? '') ?>">
                        <?php if (!empty($errors['price'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['price']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="image">Item Image</label>
                        <input type="file" name="image" id="image" class="form-control" required accept="image/*">
                        <small style="color: var(--gray-medium); font-size: 0.875rem;">
                            Upload a high-quality image of your menu item. Accepted formats: JPG, PNG, GIF (Max: 5MB)
                        </small>
                        <?php if (!empty($errors['image'])): ?>
                            <div class="field-error"><?= htmlspecialchars($errors['image']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Create Item</button>
                        <a href="/menu" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>