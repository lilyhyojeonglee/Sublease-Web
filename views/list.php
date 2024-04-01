<!DOCTYPE html>
<html>
<body>
<h2>Sublease Availability</h2>
<div class="list-group list-group-flush border-bottom scrollarea">
    <?php
    $jsonPath = 'data/data.json';

    if (file_exists($jsonPath)) {
        $json = file_get_contents($jsonPath);
        $data = json_decode($json, true);
    } else {
        echo "Error: json file not found.";

    }

    foreach ($data as $item):
    ?>
        <a href="listing.html" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <strong class="mb-1"><?php echo ($item['name']); ?></strong>
                <small><?php echo ($item['location']); ?></small>
            </div>
            <div class="col-10 mb-1 small"><?php echo ($item['description']); ?></div>
            <div class="sublease-image">
                <img src="<?php echo ($item['image']); ?>" alt="Item image">
            </div>
        </a>
    <?php endforeach; ?>
</div>
</body>
</html>
