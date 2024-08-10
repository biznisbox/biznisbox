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
        $product = $this->productModel->createProduct($data);
        return $product;
    }

    public function updateProduct($id, $data)
    {
        $product = $this->productModel->updateProduct($id, $data);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->productModel->deleteProduct($id);
        return $product;
    }

    public function getProducts()
    {
        $products = $this->productModel->getProducts();
        return $products;
    }

    public function getProduct($id)
    {
        $product = $this->productModel->getProduct($id);
        return $product;
    }

    public function getProductsByCategory($id)
    {
        $products = $this->productModel->getProductsByCategory($id);
        return $products;
    }

    public function getProductByBarcode($barcode)
    {
        $product = $this->productModel->getProductByBarcode($barcode);
        return $product;
    }

    public function getProductNumber()
    {
        $product = $this->productModel->getProductNumber();
        return $product;
    }
}
