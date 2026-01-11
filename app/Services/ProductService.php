<?php

namespace App\Services;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class ProductService
{
    private $productModel;
    public function __construct()
    {
        $this->productModel = new Product();
    }

    /**
     * Function to create product
     * @param array $data Product data
     * @return Product|bool Return created product or false
     */
    public function createProduct($data)
    {
        $data = array_merge($data, ['number' => $this->productModel->getProductNumber()]);
        $product = $this->productModel->create($data);
        if (!$product) {
            return false;
        }
        incrementLastItemNumber('product', settings('product_number_format'));
        sendWebhookForEvent('product:created', $product->toArray());
        return $product;
    }

    /**
     * Function to update product
     * @param string $id Product id
     * @param array $data Product data
     * @return Product|bool Return updated product or false
     */
    public function updateProduct($id, $data)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return false;
        }
        $data['number'] = $product->number; // Prevent changing the product number
        $product->update($data);
        $product->save();
        sendWebhookForEvent('product:updated', $product->toArray());
        return $product;
    }

    /**
     * Function to delete product
     * @param string $id Product id
     * @return Product|bool Return deleted product or false
     */
    public function deleteProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return false;
        }
        $product->delete();
        sendWebhookForEvent('product:deleted', $product->toArray());
        return $product;
    }

    /**
     * Function to get all products with category
     * @return void Return all products with category
     */
    public function getProducts()
    {
        $products = $this->productModel->with(['category'])->get();

        createActivityLog('retrieve', null, Product::$modelName, 'Product');
        return $products;
    }

    /**
     * Function to get product by id with category
     * @param string $id Product id
     * @return void Return product with category
     */
    public function getProduct($id)
    {
        $product = $this->productModel->with(['category'])->find($id);
        if (!$product) {
            return false;
        }
        $product = $this->appendPdfLinks($product);
        createActivityLog('retrieve', $id, Product::$modelName, 'Product');
        return $product;
    }

    /**
     * Function to get products by category
     * @param string $id Category id
     * @return void Return products by category
     */
    public function getProductsByCategory($id)
    {
        $products = $this->productModel->where('category_id', $id)->get();
        createActivityLog('retrieveByCategory', null, Product::$modelName, 'Product');
        return $products;
    }

    /**
     * Function to get product by barcode
     * @param string $barcode Product barcode
     * @return void Return product by barcode
     */
    public function getProductByBarcode($barcode)
    {
        $product = $this->productModel->where('barcode', $barcode)->first();
        createActivityLog('retrieveBarcode', $product->id, Product::$modelName, 'Product');
        return $product;
    }

    /**
     * Function to get product number
     * @return void Return product number
     */
    public function getProductNumber()
    {
        return $this->productModel->getProductNumber();
    }

    /**
     * Function for get product document
     */
    public function getProductPdf($id, $type = 'stream')
    {
        $product = $this->productModel->find($id);
        $settings = settings([
            'company_name',
            'company_address',
            'company_city',
            'company_zip',
            'company_country',
            'company_phone',
            'company_email',
            'company_vat',
            'company_logo',
            'show_barcode_on_documents',
            'default_currency',
        ]);
        if (!$product) {
            return false;
        }

        $pdf = PDF::loadView('pdfs.product', compact('product', 'settings'));

        if ($type == 'attach') {
            createActivityLog('AttachProduct', $product->id, Product::$modelName, 'Product');
            return $pdf->output();
        }
        if ($type == 'download') {
            createActivityLog('DownloadProduct', $product->id, Product::$modelName, 'Product');
            return $pdf->download('Product ' . $product->number . '.pdf');
        } else {
            createActivityLog('ViewProduct', $product->id, Product::$modelName, 'Product');
            return $pdf->stream('Product ' . $product->number . '.pdf');
        }
    }

    public static function appendPdfLinks($product)
    {
        $product->preview_pdf = URL::signedRoute('getProductPdf', [
            'id' => $product->id,
            'type' => 'preview',
        ]);
        $product->download_pdf = URL::signedRoute('getProductPdf', [
            'id' => $product->id,
            'type' => 'download',
        ]);
        return $product;
    }
}
