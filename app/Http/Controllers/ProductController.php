<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = $this->productRepository->getAllProducts();
        return view('admin.dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $product = $this->productRepository->getCategoryAndDiscount();
        // dd($product);
        return view('admin.dashboard.products.create', ['categories' => $product[0], 'discounts' => $product[1]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $product = $this->productRepository->createProduct($request->all());

        if($product == 'success') {
            return redirect()->route('admin.product.index')->with('message', 'Successfully created Products');
        } else {
            return redirect()->route('admin.product.create')->withErrors($product);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        // $data = $this->productRepository->getProductsById($product);
        return view('admin.dashboard.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        // dd($product);
        $data = $this->productRepository->getCategoryAndDiscount();
        return view('admin.dashboard.products.edit',
         ['categories' => $data[0], 'discounts' => $data[1], 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        $check = $this->productRepository->updateProduct($product->id, $request->all());
        if($check == 'success') {
            return redirect()->route('admin.product.index')->with('message', 'Successfully created Products');
        } else {
            return redirect()->route('admin.product.edit')->withErrors($check);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $data = $this->productRepository->deleteProduct($product);

        if($data) {
            return redirect()->route('admin.product.index')->with('message', 'Successfully deleted Products.');
        } else {
            return redirect()->route('admin.product.index')->with('message', 'Delete Fail.');
        }
    }

    public function archive() {
        $data = $this->productRepository->archive();

        return view('admin.dashboard.products.archive', ['products' => $data]);
    }

    public function archiveShow($productId) {
        $data = $this->productRepository->archiveShowProduct($productId);
        return view('admin.dashboard.products.archiveShow', ['product' => $data]);
    }

    public function forceDelete($productId) {
        $data = $this->productRepository->forceDeleteProduct($productId);
        if($data) {
            return redirect()->route('admin.product.archive')->with('message', 'Successfully deleted Products.');
        } else {
            return redirect()->route('admin.product.archive')->with('message', 'Delete Fail.');
        }
    }

    public function restore($productId) {
        $data = $this->productRepository->restoreProduct($productId);
        if($data) {
            return redirect()->route('admin.product.archive')->with('message', 'Successfully restored Products.');
        } else {
            return redirect()->route('admin.product.archive')->with('message', 'Delete Fail.');
        }
    }
}
