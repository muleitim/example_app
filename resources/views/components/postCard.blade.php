@props(['post', 'full' => false])

<div class="card ">

    {{-- Title --}}
    <h2 class="font-bold"> {{ $post->title }} </h2>

    {{-- Author and Date --}}
    <div class="text-xs font-light mb-4">
        <span>Posted {{ $post->created_at->diffForHumans() }} by </span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium" >{{ $post->user->username }}</a>
    </div>

    {{-- Body --}}
    @if ($full)
        <div class="text-sm">
            <span>{{ $post->body }}</span>
            
        </div>
    @else  
        <div class="text-sm">
            <span>{{ Str::words($post->body, 15) }}</span>
            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 ml-2" >Read more &rarr;</a>
        </div>
    @endif

    <div class="flex items-center justify-end gap-1 sm:gap-1 md:gap-4 lg:gap-6 xl:gap-6 mt-1 sm:mt-1 md:mt-4 lg:mt-6 " >
        {{ $slot }}
    </div>

    

</div>