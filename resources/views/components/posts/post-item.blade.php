@props(['post'])
<article class="[&:not(:last-child)]:border-b border-gray-100 pb-10">
    <div class="article-body grid grid-cols-12 gap-3 mt-5 items-start">
        <div class="article-thumbnail col-span-12 flex items-center">
            <a wire:navigate href="{{ route('posts.show',$post->slug) }}" >
                <img class="mw-100 mx-auto"
                    src="{{ $post->getCoverImage() }}"
                    alt="thumbnail">
            </a>
        </div>
        <div class="col-span-12">
            <div class="article-meta flex mt-2 text-sm items-center">
                <span class="mr-1 text-lg">{{ $post->author }}</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mt-2">
                <a wire:navigate href="{{ route('posts.show',$post->slug) }}" >
                    {{ $post->title }}
                </a>
            </h2>

            <p class="mt-2 text-base text-gray-700 font-light">
                {{ $post->meta_description }}
            </p>
            <div class="article-actions-bar mt-2 flex items-center justify-between">
                {{-- <div class="flex gap-x-2">
                    @foreach ($post->categories as $category)
                        <x-badge wire:navigate href="{{ route('posts.index', ['category' => $category->title]) }}" :labelTextColor="$category->label_text_color" :labelColor="$category->label_color" >
                            {{$category->title}}
                        </x-badge>
                    @endforeach
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-500 text-sm">{{$post->getReadingTime()}} min read</span>
                    </div>
                </div>
                <div>
                    <a class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6 text-gray-600 hover:text-gray-900">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span class="text-gray-600 ml-2">
                            1
                        </span>
                    </a>
                </div> --}}
                <div>
                    <div class="flex items-center">
                        <span class="text-gray-500 text-xs">. {{ $post->published_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</article>