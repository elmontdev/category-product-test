<?php
namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index(Request $request)
    {

        // dd(request("search"));\
        // return $request["search"];
        try {

            // $categories = Category::all();

            //database cateogory name => Electronics
            //search => %ctro%

            $query = Category::query(); //select

            // if ($request->has("search")) {
            //     $query->where("name", "like", "%" . $request["search"] . "%");
            // }

            $query->when($request->has("search"), function ($q) use ($request) {
                $searchKey = $request["search"];
                $q->where(function ($subQuery) use ($searchKey) {
                    $subQuery->where("name", "like", "%" . $searchKey . "%")
                        ->orWhere("description", "like", "%" . $searchKey . "%");
                });
            });

            // $categories = $query->get();

            //use pagnation

            $perPage = $request->get("per_page", 10); //default 10
                                                      // dd($perPage);
            $categories = $query->paginate($perPage);

            return response()->json([
                "message"      => "Categories retrievedsuccessfully",
                "data"         => CategoryResource::collection($categories),
                "total"        => $categories->total(),
                "per_page"     => $categories->perPage(),
                "current_page" => $categories->currentPage(),
                "last_page"    => $categories->lastPage(),
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal servererror",
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
                    "message" => "Category notfound",
                ], 404);
            }

            return response()->json([
                "message" => "Category retrievedsuccessfully",
                "data"    => CategoryResource::make($category),
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal servererror",
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
                "message" => "Category createdsuccessfully",
                "data"    => CategoryResource::make($category),
            ], 201);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal servererror",
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
                    "message" => "Category notfound",
                ], 404);
            }

            $category->update($request->validated());

            return response()->json([
                "message" => "Category updatedsuccessfully",
                "data"    => CategoryResource::make($category->refresh()),
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal servererror",
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
                    "message" => "Category notfound",
                ], 404);
            }

            $category->delete();

            return response()->json([
                "message" => "Category deletedsuccessfully",
            ], 200);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                "message" => "Internal servererror",
            ], 500);
        }
    }
}
