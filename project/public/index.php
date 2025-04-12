<?php
require_once '../app/Classes/VehicleManager.php';
$vehicleManager = new VehicleManager('../data/vehicles.json');
$vehicles = $vehicleManager->getVehicles();

include 'views/header.php';
?>
<div class="row">
    <?php if (empty($vehicles)): ?>
        <div class="col-12">
            <div class="alert alert-info">No vehicles found. Add your first vehicle!</div>
        </div>
    <?php else: ?>
        <?php foreach ($vehicles as $id => $vehicle): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($vehicle['image']); ?>" class="card-img-top"
                         alt="<?php echo htmlspecialchars($vehicle['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($vehicle['name']); ?></h5>
                        <p class="card-text">Type: <?php echo htmlspecialchars($vehicle['type']); ?></p>
                        <p class="card-text">Price: $<?php echo htmlspecialchars($vehicle['price']); ?></p>
                        <div class="btn-group">
                            <a href="views/edit.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include 'views/footer.php'; ?>