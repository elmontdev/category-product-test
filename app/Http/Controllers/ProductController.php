<?php
namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // n+1 problem solution
            // $products = Product::with('category')->get();
            $query = Product::query()->with("category");

            //searching
            $query->when($request->get("search"), function ($q) use ($request) {
                $searchKey = $request["search"];
                $q->where(function ($subQuery) use ($searchKey) {
                    $subQuery->where("name", "like", "%" . $searchKey . "%")
                        ->orWhere("description", "like", "%" . $searchKey . "%")
                        ->orWhere("price", "like", "%" . $searchKey . "%")
                        ->orWhereHas("category", function ($categoryQuery) use ($searchKey) {
                            $categoryQuery->where("name", "like", "%" . $searchKey . "%");
                        });
                });
            });

            //pagination
            $perPage  = $request->get("per_page", 10);
            $products = $query->paginate($perPage);

            return response()->json([
                "message"      => "Product list retrieved successfully",
                "data"         => ProductResource::collection($products),
                "total"        => $products->total(),
                "per_page"     => $products->perPage(),
                "current_page" => $products->currentPage(),
                "last_page"    => $products->lastPage(),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            return response()->json([
                "message" => "Product created successfully",
                "data"    => ProductResource::make($product),
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                "message" => "Internal server error",
                "errors"  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return response()->json([
                    "message" => "Product not found",
                ], 404);
            }

            return response()->json([
                "message" => "Product retrieved successfully",
                "data"    => ProductResource::make($product),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return response()->json([
                    "message" => "Product not found",
                ], 404);
            }

            $product->update($request->validated());

            return response()->json([
                "message" => "Product updated successfully",
                "data"    => ProductResource::make($product),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return response()->json([
                    "message" => "Product not found",
                ], 404);
            }

            $product->delete();

            return response()->json([
                "message" => "Product deleted successfully",
                "data"    => ProductResource::make($product),
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }
}
