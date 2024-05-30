<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;

    }

    public function index(){
        $all_categories = $this->category->paginate(5);
        $uncategorized_count = 0;
        $all_posts = $this->post->all();

        foreach($all_posts as $post){
            if($post->categoryPost->count() == 0){
                $uncategorized_count++;
            }
        }

        return view('admin.categories.index')
                ->with('all_categories', $all_categories)
                ->with('uncategorized_count', $uncategorized_count);

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = ucwords(strtolower($request->name));
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $category = $this->category->findOrFail($id);

        $request->validate([
            'updatename' => 'required|max:50|unique:categories,name,' . $id
        ]);
        $category->name = ucwords(strtolower($request->updatename));

        $category->save();

        return redirect()->back();
    }
    public function destroy($id){
        $category = $this->category->findOrFail($id);
        $category->Delete();
        
        return redirect()->back();
    }
}
