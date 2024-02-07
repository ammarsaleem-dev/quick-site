{{-- <div class="invalid-feedback"> --}}
    @error($variable)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
{{-- </div> --}}
