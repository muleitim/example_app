<x-layout>
    
    <h1 class="titleCenter">Timothy Mulei's Blog</h1>

    <div class="grid grid-cols-2 gap-1 sm:gap-1 md:gap-4 lg:gap-6 xl:gap-6" >    
        @foreach ($posts as $post)

            <x-postCard :post="$post" />

        @endforeach
    </div>

    <div>
        {{ $posts->links() }}
    </div>

</x-layout>