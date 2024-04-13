<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Recommended Topics</h3>
    <div class="topics flex flex-wrap justify-start gap-2">
        @foreach ($categories as $category)
            <x-badge wire:navigate href="{{ route('posts.index', ['category' => $category->title]) }}" :labelTextColor="$category->label_text_color" :labelColor="$category->label_color" >
                {{$category->title}}
            </x-badge>
        @endforeach
    </div>
</div>