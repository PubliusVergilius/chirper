<!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
<div class="bg-base-100 mt-2">
    <form method="GET" action="/search">
        @csrf
        <div class="form-control w-full search-box">
            <textarea
                name="search"
                value="{{ request('search') }}"
                placeholder="Search chirps..."
                class="textarea textarea-bordered w-full resize-none"
                rows="1"
                maxlength="255"
                required
            >
                {{ old('message') }}
            </textarea>
        @error('message')
            <div class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </div>
        @enderror
        </div>

        <div class="mt-4 flex items-center justify-end">
            <button type="submit" class="btn btn-primary btn-sm">
                Search
            </button>
        </div>
    </form>
</div>

