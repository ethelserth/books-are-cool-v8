<x-app-layout author="{{$post->author}}" datePublished="{{$post->published_at}}" image="{{$post->getCoverImage()}}" title="{{$post->meta_title}}">
    <article class="mx-auto py-5">
        <div class="outer-wrap mx-auto">
            <h1 class="text-6xl font-bold text-center text-gray-800">
                {{$post->title}}
            </h1>
            <p class="m-5 text-xl text-center font-bold text-gray-800">{{$post->author}}</p>
            <p class="m-5 text-l text-center font-bold text-gray-500">{{$post->meta_description}}</p>
            <img class="w-full my-2 rounded-lg" src="{{ $post->getCoverImage() }}" alt="{{$post->title}}">
        </div>
        <div class="inner-wrap mx-auto col-span-4 md:col-span-3 w-full" style="max-width:700px">
            
            <div class="mt-2 flex justify-between items-center">
                <div class="flex py-5 text-base items-center gap-x-2">
                    <div class="ml-2">
                        @foreach ($post->categories as $category)
                            <x-badge wire:navigate href="{{ route('posts.index', ['category' => $category->title]) }}" :labelTextColor="$category->label_text_color" :labelColor="$category->label_color" >
                                {{$category->title}}
                            </x-badge>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-x-2">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-500 text-sm">{{$post->getReadingTime()}} min read</span>
                    </div>
                </div>
            </div>

            <div class="article-content py-3 prose text-gray-800 text-lg text-justify">
                {!! html_entity_decode($post->content) !!}
            </div>


            <div class="mt-10 comments-box border-t border-gray-100 pt-10">
                <h2 class="text-2xl font-semibold text-gray-900 mb-5">Discussions</h2>
                <textarea
                    class="w-full rounded-lg p-4 bg-gray-50 focus:outline-none text-sm text-gray-700 border-gray-200 placeholder:text-gray-400"
                    cols="30" rows="7"></textarea>
                <button
                    class="mt-3 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                    Post Comment
                </button>

                {{-- <!-- <a class="text-yellow-500 underline py-1" href=""> Login to Post Comments</a> -->

                <div class="user-comments px-3 py-2 mt-5">
                    <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
                        <div class="user-meta flex mb-4 text-sm items-center">
                            <img class="w-7 h-7 rounded-full mr-3" src="" alt="mn">
                            <span class="mr-1">user name</span>
                            <span class="text-gray-500">. 15 days ago</span>
                        </div>
                        <div class="text-justify text-gray-700  text-sm">
                            comment content
                        </div>
                    </div>
                    <!-- <div class="text-gray-500 text-center">
                        <span> No Comments Posted</span>
                    </div> -->
                </div> --}}
            </div>
        </div>
    </article>
</x-app-layout>