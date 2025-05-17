<?php
require_once '../../app/Classes/VehicleManager.php';
$vehicleManager = new VehicleManager('../../data/vehicles.json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$vehicle = $vehicleManager->getVehicle($id);

if (!$vehicle) {
    header('Location: public/index.php');
    exit;
}

$deleted = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    if ($vehicleManager->deleteVehicle($id)) {
        header('Location: ../index.php');
        exit;
    } else {
        $error = "Failed to delete vehicle. Please try again.";
    }
}

include 'header.php';
?>

<h2>Delete Vehicle</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="<?php echo htmlspecialchars($vehicle['image']); ?>" class="card-img" alt="<?php echo htmlspecialchars($vehicle['name']); ?>">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($vehicle['name']); ?></h5>
                <p class="card-text">Type: <?php echo htmlspecialchars($vehicle['type']); ?></p>
                <p class="card-text">Price: $<?php echo htmlspecialchars($vehicle['price']); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-warning">
    Are you sure you want to delete this vehicle? This action cannot be undone.
</div>

<form method="post" action="delete.php?id=<?php echo $id; ?>">
    <input type="hidden" name="confirm" value="yes">
    <button type="submit" class="btn btn-danger">Confirm Delete</button>
    <a href="../index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'footer.php'; ?>