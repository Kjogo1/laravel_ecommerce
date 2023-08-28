<?php

namespace App\Repositories\Products;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;

class ProductRepository implements ProductRepositoryInterface
{

    public function getCategoryAndDiscount()
    {
        $categories = Category::all();
        $discounts = Discount::all();

        return [$categories, $discounts];
    }
    public function getAllProducts()
    {
        return Product::orderBy('created_at', 'DESC')->get();
    }

    public function getProductsById($productId)
    {
        return Product::findOrFail($productId);
    }

    public function createProduct(array $product)
    {

        $product['discount_id'] = $product['discount'];
        $product['category_id'] = $product['category'];

        $validate = Validator::make($product, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'quantity' => 'required|numeric',
            'discount_id' => 'required',
            'category_id' => 'required',
        ]);

        if ($validate->fails()) {
            return $validate;
        }

        $imageFile = time() . '.' . $product['image']->extension();

        $product['image']->storeAs('public/products', $imageFile);

        $product['image'] = $imageFile;
        // $product['image']->move(public_path('products'), $imageFile);

        Product::create($product);

        return 'success';
    }

    public function updateProduct($productId, array $product)
    {
        $product['discount_id'] = $product['discount'];
        $product['category_id'] = $product['category'];

        $validate = Validator::make($product, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'quantity' => 'required|numeric',
            'discount_id' => 'required',
            'category_id' => 'required',
        ]);

        if ($validate->fails()) {
            return $validate;
        }

        $tempFile = Product::findOrFail($productId);

        if (array_key_exists('image', $product)) {
            $imageFile = time() . '.' . $product['image']->extension();
            $product['image']->storeAs('public/products', $imageFile);
            $product['image'] = $imageFile;

            if ($tempFile->image) {
                Storage::delete('public/products/' . $tempFile->image);
            }
        } else {
            $product['image'] = $tempFile->image;
        }

        $tempFile->update($product);

        return 'success';
    }

    public function deleteProduct($productId)
    {
        $check = $this->getProductsById($productId->id);

        // if($check->image) {
        //     Storage::delete('public/products/' . $check->image);
        // }

        return $check->delete();
    }

    public function archive() {
        $product = Product::onlyTrashed()->get();
        return $product;
    }

    public function archiveShowProduct($productId) {
        return Product::onlyTrashed()->where('id', $productId)->get();
    }

    public function forceDeleteProduct($productId) {
        $check = $this->archiveShowProduct($productId);
        if($check) {
            foreach($check as $check) {
                $image = $check->image;
            }

            if($image) {
                Storage::delete('public/products/' . $image);
            }
            $delete = Product::onlyTrashed()->where('id', $productId)->forceDelete();
        }
        return $delete;
    }
}
