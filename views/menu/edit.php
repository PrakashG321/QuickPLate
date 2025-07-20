<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main>
        <div class="container">
            <div class="form-container" style="max-width: 600px;">
                <div class="form-header">
                    <h2>Edit Menu Item</h2>
                    <p>Update the details of this menu item</p>
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
                        <input type="text" name="name" id="name" class="form-control"
                            value="<?= htmlspecialchars($item['name']) ?>" required
                            placeholder="Enter item name">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required
                            placeholder="Describe this delicious item..." rows="4"><?= htmlspecialchars($item['description']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($)</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="<?= htmlspecialchars($item['price']) ?>" required
                            step="0.01" min="0" placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label>Current Image</label>
                        <div class="text-center mb-2">
                            <img src="/uploads/<?= htmlspecialchars($item['image']) ?>"
                                alt="<?= htmlspecialchars($item['name']) ?>"
                                style="max-width: 200px; height: 150px; object-fit: cover; border-radius: 8px; box-shadow: var(--shadow);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Update Image (optional)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <small style="color: var(--gray-medium); font-size: 0.875rem;">
                            Leave empty to keep current image. Accepted formats: JPG, PNG, GIF
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Item</button>
                        <a href="/menu" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>