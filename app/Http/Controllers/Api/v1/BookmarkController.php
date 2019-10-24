<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\BookmarkResource;
use App\Http\Resources\BookmarkResourceCollection;
use App\Bookmark;
use Intervention\Image\Facades\Image;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): BookmarkResourceCollection
    {
        return new BookmarkResourceCollection(Bookmark::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'url' => 'required|url',
            'user_id' => 'required',
            'summary' => '',
            'image' => 'image',
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('bookmarks', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

        $mergedData = array_merge(
            $validatedData,
            $imageArray ?? ['image' => null]
        );

        $bookmark = Bookmark::create($mergedData);

        return new BookmarkResource($bookmark);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark): BookmarkResource
    {
        return new BookmarkResource($bookmark);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark): BookmarkResource
    {
        $validatedData = $request->validate([
            'name' => '',
            'url' => 'url',
            'user_id' => '',
            'summary' => '',
            'image' => 'image',
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('bookmarks', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

        $mergedData = array_merge(
            $validatedData,
            $imageArray ?? []
        );

        $bookmark->update($mergedData);

        return new BookmarkResource($bookmark);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();

        return response()->json();
    }
}

