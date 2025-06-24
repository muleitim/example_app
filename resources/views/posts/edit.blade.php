<x-layout>
    
    <a href="{{ route('dashboard') }}" class="block mb-2 text-xs text-blue-500">&larr; Go back to your dashboard</a>

    <div class="card"> 
        <h2 class="font-bold mb-4" >Update post</h2>

    <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data" >
            @csrf
            @method('PUT')

            {{-- Post Title --}}
            <div class="mb-4" >
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ $post->title }}" class="input @error('title') ring-red-500 @enderror" >

                @error('title')
                    <p class="error" >{{ $message }}</p>
                @enderror
            </div>

            {{-- Post Body --}}
            <div class="mb-4" >
                <label for="body">Post Content</label>

                <textarea name="body" rows="5" class="input @error('body') ring-red-500 @enderror" >{{ $post->body }}</textarea>
                
                @error('body')
                    <p class="error" >{{ $message }}</p>
                @enderror
            </div>

            {{-- Current cover photo if exists --}}
            @if ($post->image)
                <div class="rounded-md mb-4 w-full sm:w-1/2 md:w-1/2 lg:w-1/2 object-cover overflow-hidden" >               
                        <label>Current Cover Photo</label>
                        <img src="{{ asset('storage/' . $post->image ) }}" alt="Post Image">                                        
                </div>
            @endif

            {{-- Post Image --}}
            <div class="mb-4">
                <label for="image">Cover Photo</label>
                <input type="file" name="image" id="image">

                @error('image')
                    <p class="error" >{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button class="btn">Update</button>

        </form>
    </div>

</x-layout>