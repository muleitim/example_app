<x-layout>
    <h1 class="titleCenter">Request a password reset email</h1>

    {{-- Session Messages --}}
    @if (session('status'))
        <x-flashMsg msg="{{ session('status') }}" />
    @endif

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('password.request') }}" method="post"  x-data="formSubmit" @submit.prevent="submit">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}"
                    class="input @error('email') ring-red-500 @enderror">

                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <p class="mb-4">Note that the email may take about 3 minutes to be delivered to your inbox.</p>

            {{-- Submit Button --}}
            <button x-ref="btn" class="btn">Submit</button>
        </form>
    </div>
</x-layout>
