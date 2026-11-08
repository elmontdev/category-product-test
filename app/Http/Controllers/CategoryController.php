<?php
namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index()
    {
        try {
            $categories = Category::all();

            return response()->json([
                "message" => "Categories retrieved successfully",
                "data"    => CategoryResource::collection($categories),
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Display a specific category.
     */
    public function show(string $id)
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    "message" => "Category not found",
                ], 404);
            }

            return response()->json([
                "message" => "Category retrieved successfully",
                "data"    => CategoryResource::make($category),
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create($request->validated());

            return response()->json([
                "message" => "Category created successfully",
                "data"    => CategoryResource::make($category),
            ], 201);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Update an existing category.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    "message" => "Category not found",
                ], 404);
            }

            $category->update($request->validated());

            return response()->json([
                "message" => "Category updated successfully",
                "data"    => CategoryResource::make($category->refresh()),
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }

    /**
     * Delete an existing category.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    "message" => "Category not found",
                ], 404);
            }

            $category->delete();

            return response()->json([
                "message" => "Category deleted successfully",
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal server error",
            ], 500);
        }
    }
}
