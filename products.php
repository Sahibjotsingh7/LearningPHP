<?php
// Fetch data from Fake Store API
$url = "https://fakestoreapi.com/products";
$response = file_get_contents($url);
$products = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fake Store Carousel</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item {
            padding: 40px;
            background-color: #f9f9f9;
        }
        .product-image {
            max-width: 100%;
            height: 300px;
            object-fit: contain;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 20px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Fake Store Products</h2>

    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <?php foreach ($products as $index => $product): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row align-items-center">
                        
                        <div class="col-md-5 text-center">
                            <img src="<?= htmlspecialchars($product['image']) ?>" class="product-image" alt="Product Image">
                        </div>
                
                        <div class="col-md-7">
                            <h3><?= htmlspecialchars($product['title']) ?></h3>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <h4 class="text-success">$<?= number_format($product['price'], 2) ?></h4>
                            <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
 
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
