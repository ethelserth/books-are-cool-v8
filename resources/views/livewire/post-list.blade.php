<div class="px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-grey-600">
            @if ($this->search || $this->activeCategory)
                <button class="gray-500 text-xs mr-3" wire:click="clearFilters()" >X</button>
            @endif
            @if ($this->activeCategory)
                <x-badge wire:navigate href="{{ route('posts.index', ['category' => $this->activeCategory->title]) }}" :labelTextColor="$this->activeCategory->label_text_color" :labelColor="$this->activeCategory->label_color" >
                    {{$this->activeCategory->title}}
                </x-badge>
            @endif
            @if ($this->search)
                <span class="ml-2">
                    Containing : <strong>{{$this->search}}</strong>
                </span>
            @endif
        </div>
        <div class="flex items-center space-x-4 font-light ">
            <button class="{{ $this->sort === 'desc' ? 'text-gray-900 border-b b0order-gray-700' : 'text-gray-500' }} py-4" 
                wire:click="setSort('desc')" >Latest</button>
            <button class="{{ $this->sort === 'asc' ? 'text-gray-900 border-b b0order-gray-700' : 'text-gray-500' }} py-4 " 
                wire:click="setSort('asc')" >Oldest</button>
        </div>
    </div>
    <div class="py-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($this->posts as $post)
            <x-posts.post-item :post="$post" />    
        @endforeach
    </div>

    <div class="my-3">
        {{ $this->posts->onEachSide(3)->links(); }}
    </div>

</div>

