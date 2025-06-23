<x-layout>

    <h2 class="title">Posts by {{ $user->username }} &#9830; {{ $posts->total() }} </h2>

    {{-- User's Posts--}}

    <div class="grid grid-cols-2 gap-1 sm:gap-1 md:gap-4 lg:gap-6 xl:gap-6" >    
        @foreach ($posts as $post)

            <x-postCard :post="$post" />

        @endforeach
    </div>

    <div>
        {{ $posts->links() }}
    </div>

</x-layout>