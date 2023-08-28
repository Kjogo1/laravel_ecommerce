<?php

namespace App\Repositories\Products;

interface ProductRepositoryInterface {
    public function getCategoryAndDiscount();
    public function getAllProducts();
    public function getProductsById($productId);
    public function createProduct(array $product);
    public function updateProduct($productId, array $product);
    public function deleteProduct($productId);
    public function archive();
    public function archiveShowProduct($productId);
    public function forceDeleteProduct($productId);
    public function restoreProduct($productId);
}
