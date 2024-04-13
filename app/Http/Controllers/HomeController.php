<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke( Request $request ){
        return view('home',[
            'featuredPost' => Post::published()->featured()->enabled()->latest('published_at')->take(3)->get(),
            'lattestPost' => Post::published()->enabled()->latest('published_at')->take(9)->get()
        ]);
    }
}
