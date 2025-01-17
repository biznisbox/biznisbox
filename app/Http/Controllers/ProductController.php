<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
/**
 * @group Products
 *
 * APIs for managing products
 */
class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Create a new product
     *
     * @param  object  $request data from the form
     * @return array $product product
     */
    public function createProduct(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request->all());
        if (!$product) {
            return api_response(null, __('responses.item_not_created'), 400);
        }
        return api_response($product, __('responses.item_created_successfully'));
    }

    /**
     * Update product
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the product
     * @return array $product product
     */
    public function updateProduct(ProductRequest $request, string $id)
    {
        $product = $this->productService->updateProduct($id, $request->all());
        if (!$product) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($product, __('responses.item_updated_successfully'));
    }

    /**
     * Delete product
     *
     * @param  string  $id id of the product
     * @return array $product product
     */
    public function deleteProduct(string $id)
    {
        $product = $this->productService->deleteProduct($id);
        if (!$product) {
            return api_response(null, __('responses.item_not_deleted'), 400);
        }
        return api_response($product, __('responses.item_deleted_successfully'));
    }

    /**
     * Get all products
     *
     * @return array $products Products
     */
    public function getProducts()
    {
        $products = $this->productService->getProducts();
        if (!$products) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($products, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get product by id
     *
     * @param  string  $id id of the product
     * @return array $product product
     */
    public function getProduct(string $id)
    {
        $product = $this->productService->getProduct($id);
        if (!$product) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($product, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get products by category
     *
     * @param  string  $id id of the category
     * @return array $products Products
     */
    public function getProductsByCategory(string $id)
    {
        $products = $this->productService->getProductsByCategory($id);
        if (!$products) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($products, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get products by barcode
     *
     * @param  string  $barcode barcode of the product
     * @return array $product product
     */
    public function getProductByBarcode(string $barcode)
    {
        $product = $this->productService->getProductByBarcode($barcode);
        if (!$product) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($product, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get product number
     *
     * @return array $product product
     */
    public function getProductNumber()
    {
        $number = $this->productService->getProductNumber();
        return api_response($number, __('responses.data_retrieved_successfully'));
    }
}
