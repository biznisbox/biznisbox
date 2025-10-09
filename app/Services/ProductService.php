<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    private $productModel;
    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function createProduct($data)
    {
        return $this->productModel->createProduct($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->productModel->updateProduct($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->productModel->deleteProduct($id);
    }

    public function getProducts()
    {
        return $this->productModel->getProducts();
    }

    public function getProduct($id)
    {
        return $this->productModel->getProduct($id);
    }

    public function getProductsByCategory($id)
    {
        return $this->productModel->getProductsByCategory($id);
    }

    public function getProductByBarcode($barcode)
    {
        return $this->productModel->getProductByBarcode($barcode);
    }

    public function getProductNumber()
    {
        return $this->productModel->getProductNumber();
    }
}
