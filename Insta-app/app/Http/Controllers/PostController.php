<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all(); //retrieves all the categories

        return view('users.posts.create')
            ->with('all_categories', $all_categories);

    }

    public function store(Request $request){
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        $this->post->user_id = Auth::user()->id;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        # Save the categories of the post to the category_post pivot table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
            /*
                2D associative array
                $category_post = [
                   ['category_id' => 1] ,
                    ['category_id' => 2],
                     ['category_id' => 3]
                ];
            */ 
        }

        $this->post->categoryPost()->createMany($category_post);

        #Go back to homepage
        return redirect()->route('index');
    }

    public function show($id){
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);
        $all_categories = $this->category->all();

        // Get all the category IDs of this post. Save in an array.
        $selected_categories = [];
        foreach($post->categoryPost as $category_post){
            $selected_categories[] = $category_post->category_id;
        }

        if($post->user->id != Auth::user()->id){
            return back();
        }
                return view('users.posts.edit')
                    ->with('post', $post)
                    ->with('all_categories', $all_categories)
                    ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){
        # Validate the form data
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        #Update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        if($request->image){
            $post->image ='data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        #Delete all records from category_post table related to this post
        $post->categoryPost()->delete();

        # Save the new categories to category_post table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        return redirect()->route('post.show', $id);
    }

    public function delete($id){
        $post = $this->post->findOrFail($id);
        $post->forceDelete();
        // Only active when softdelete is active 
        
        return redirect()->route('index');
    }
}
