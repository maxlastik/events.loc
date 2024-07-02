<?php

namespace App\Services;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function store($data, CategoryStoreRequest $request)
    {
        $category = Category::create($data);

        if ($request->has('events')) {
            $category->events()->attach($request['events']);
        }
    }

    public function update($category, $data, CategoryUpdateRequest $request)
    {
        $category->update($data);

        if ($request->has('events')) {
            $category->events()->sync($request['events']);
        }
    }
}