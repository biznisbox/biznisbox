<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    private $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function getProducts()
    {
        $products = $this->productModel->getProducts();

        if ($products) {
            return api_response($products, __('response.products.get_success'));
        }
        return api_response(null, __('response.products.get_failed'), 400);
    }

    public function getProduct($id)
    {
        $product = $this->productModel->getProduct($id);

        if ($product) {
            return api_response($product, __('response.product.get_success'));
        }
        return api_response(null, __('response.product.not_found'), 404);
    }

    public function createProduct(Request $request)
    {
        $productData = $request->all();
        $product = $this->productModel->createProduct($productData);

        if ($product) {
            return api_response($product, __('response.product.create_success'), 201);
        }
        return api_response(null, __('response.product.create_failed'), 400);
    }

    public function updateProduct(Request $request, $id)
    {
        $productData = $request->all();
        $product = $this->productModel->updateProduct($id, $productData);

        if ($product) {
            return api_response($product, __('response.product.update_success'));
        }
        return api_response(null, __('response.product.not_found'), 404);
    }

    public function deleteProduct($id)
    {
        $product = $this->productModel->deleteProduct($id);

        if ($product) {
            return api_response(null, __('response.product.delete_success'));
        }
        return api_response(null, __('response.product.not_found'), 404);
    }

    public function getProductNumber()
    {
        $productNumber = $this->productModel->getProductNumber();
        return api_response($productNumber, __('response.product.get_success'));
    }
}
