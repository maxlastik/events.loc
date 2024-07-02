<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $queryEvents = Event::query();

        $queryEvents->where('status', 1);

        if ($request->has('search')) {
            $queryEvents->whereAny(['title', 'description'], 'LIKE', '%'.$request->search.'%');
        };

        if ($request->has('categories')) {
            $queryCategories = $request->categories;
            $queryCategoriesArray = explode(',', $queryCategories);
            $queryEvents->whereHas('categories', function (Builder $query) use ($queryCategoriesArray) {
                $query->whereIn('id', $queryCategoriesArray);
            });
        }

        $events = $queryEvents->orderBy('created_at', 'desc')->paginate(9)->onEachSide(2)->withQueryString();

        return view('index', compact('categories', 'events'));
    }

    public function showEvent(Event $event)
    {
        return view('event-details', compact('event'));
    }
}
