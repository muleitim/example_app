@props(['post', 'full' => false])

<div class="card w-full sm:w-full md:w-3/4 lg:w-1/2 mx-auto ">

    {{-- Cover Photo --}}
    <div class="mb-1" >
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image ) }}" alt="">
        @else 
            <img src="{{ asset('storage/posts_images/500_333.png') }}" alt="" >
        @endif        
    </div>

    {{-- Title --}}
    <p class="font-bold leading-none text-sm sm:text-sm md:text-sm lg:text-base "> {{ $post->title }} </p>

    {{-- Author and Date --}}
    <div class="text-xs font-light mb-2">
        <span>Posted {{ $post->created_at->diffForHumans() }} by </span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium" >{{ $post->user->username }}</a>
    </div>

    {{-- Body --}}
    @if ($full)
        <div class="text-sm  ">            
            <span>{!! nl2br(e($post->body)) !!}</span>  
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