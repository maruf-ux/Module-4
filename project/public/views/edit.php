<?php
require_once '../../app/Classes/VehicleManager.php';
$vehicleManager = new VehicleManager('../data/vehicles.json');

$errors = [];
$success = false;
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$vehicle = $vehicleManager->getVehicle($id);

if (!$vehicle) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
    $image = trim($_POST['image'] ?? '');

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($type)) {
        $errors[] = "Type is required";
    }

    if (!$price || $price <= 0) {
        $errors[] = "Valid price is required";
    }

    if (empty($image)) {
        $errors[] = "Image URL is required";
    }

    // If no errors, update the vehicle
    if (empty($errors)) {
        $vehicleData = [
            'name' => $name,
            'type' => $type,
            'price' => $price,
            'image' => $image
        ];

        if ($vehicleManager->editVehicle($id, $vehicleData)) {
            $success = true;
            $vehicle = $vehicleManager->getVehicle($id);
        } else {
            $errors[] = "Failed to update vehicle";
        }
    }
}

include 'views/header.php';
?>
<h2>Edit Vehicle</h2>
<?php if ($success): ?>
    <div class="alert alert-success"> Vehicle updated successfully! <a href="index.php">View all vehicles</a>
    </div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post" action="edit.php?id=<?php echo $id; ?>">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name"
               value="<?php echo htmlspecialchars($vehicle['name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <input type="text" class="form-control" id="type" name="type"
               value="<?php echo htmlspecialchars($vehicle['type']); ?>" required>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price"
               value="<?php echo htmlspecialchars($vehicle['price']); ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Image URL</label>
        <input type="text" class="form-control" id="image" name="image"
               value="<?php echo htmlspecialchars($vehicle['image']); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Vehicle</button>
</form>
<?php include 'views/footer.php'; ?>