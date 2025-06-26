<x-layout>
    
    <h1 class="titleCenter">Latest Posts</h1> 

    @if($posts->total() === 0)
        <div class="card">
            <h2 class="text-red-500 font-bold text-center mb-2" >There are currently no posts</h2>

            <img src="{{ asset('storage/posts_images/16_9.png' ) }}" alt="Default Image">

        </div>
    @else  
        <div class="grid grid-cols-2 gap-1 sm:gap-1 md:gap-4 lg:gap-6 xl:gap-6" >    
            @foreach ($posts as $post)

                <x-postCard :post="$post" />

            @endforeach
        </div>        
    @endif 

    <div>
        {{ $posts->links() }}
    </div>

</x-layout>