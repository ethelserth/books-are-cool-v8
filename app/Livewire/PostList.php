<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{   
    use WithPagination;

    #[Url()]
    public $sort = 'desc';

    #[Url()]
    public $search = '';

    #[Url()]
    public $category = '';

    public function setSort($sort){
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc' ;
    }

    #[On('search')]  
    public function updateSearch($search){
        $this->search = $search;
    }

    public function clearFilters(){
        $this->sort = 'desc';
        $this->search = '';
        $this->category = '';
    }

    #[Computed()]
    public function posts(){
        return Post::published()
                    ->enabled()
                    ->orderBy('published_at',$this->sort)
                    ->when($this->activeCategory,function($query){
                        $query->withCategory($this->category);
                    })
                    ->where('title','like',"%{$this->search}%")
                    ->orWhere('author','like',"%{$this->search}%")
                    ->paginate(9);
        // return Post::published()->orderBy('published_at','desc')->simplePaginate(9);
    }

    #[Computed()]
    public function activeCategory()
    {
        return Category::where('slug', $this->category)->first();
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
