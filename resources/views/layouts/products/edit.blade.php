@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-header">
                        Product Edit
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('products.update', ['product' => $product->id]) }}">
                            @method('PUT')
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Name</span>
                                <input type="text" class="form-control" id="name" placeholder="Enter name"
                                    value="{{ $product->name }}" name="name" autofocus>
                                {{-- Error --}}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Price</span>
                                <input type="text" class="form-control" id="price" placeholder="Enter price"
                                    name="price" autofocus value="{{ $product->price }}">
                                {{-- Error --}}
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">WSPrice</span>
                                <input type="text" class="form-control" id="wsprice" placeholder="Enter price"
                                    name="wsprice" autofocus value="{{ $product->wsprice }}">
                                {{-- Error --}}
                                @error('wsprice')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Category</span>
                                <select type="text" class="form-control" id="form-control" name="category_id"
                                    autocomplete="off" placeholder="How cool is this?" tabindex="-1"
                                    value="{{ $product->category_id }}">
                                    <option value="" selected>None</option>
                                    @foreach ($categories as $category)
                                        @if ($product->category_id == $category->id)
                                            <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                {{-- Error --}}
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">User Type</span>
                                <select type="text" class="form-control" id="form-control" name="user_type_product"
                                    autocomplete="off" placeholder="How cool is this?" tabindex="-1"
                                    value="{{ $product->user_type_product }}">
                                    <option value="" selected>None</option>
                                    <option @selected($product->user_type_product === 'user') value="user">User</option>
                                    <option @selected($product->user_type_product === 'moderator') value="moderator">Moderator</option>
                                    <option @selected($product->user_type_product === 'admin') value="admin">Admin</option>
                                </select>

                                {{-- Error --}}
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Description</span>
                                <textarea class="form-control" placeholder="Descripe this product" id="description" name="description"
                                    style="height: 30px">{{ $product->description }}</textarea>
                                {{-- Error --}}
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>
                            {{-- Image --}}
                            <div class="input-group mb-3">
                                <input type="file" name="image" class="form-control" id="image" accept="image/*"
                                    alt="no image" value="{{ $product->image }}" onchange="doSomeChanges(this);" />
                                <label for="image" class="input-group-text">Upload</label>
                            </div>
                            <div class="img-wrap mb-3" style="border: 1px dotted">
                                <button type="button" class="btn-close close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <img id="blah" class="rounded" style="object-fit: contain;" width="400"
                                    height="256" src="{{ asset('storage/products/' . $product->image) }}"
                                    alt="@if (isset($product)) {{ $product->image }}@else {{ old('image') }} @endif" />
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        new TomSelect('#form-control', {
            allowEmptyOption: false,
            plugins: ['dropdown_input'],
        });
    </script>
    <script>
        function doSomeChanges(v) {
            $('.img-wrap').show();
            var a = document.getElementById('image');
            var aa = a.value.replace(/C:\\fakepath\\/i, '');
            var aaa = a.value.split('.').pop();
            var nf = 'UploadedImage' + '_' + Date.now() + '.' + aaa;
            // document.getElementById('productImageLabel').textContent = nf;
            document.getElementById('blah').src = window.URL.createObjectURL(v.files[0]);

            // document.getElementById('input:[t').attr('value',nf);
        }

        $('.img-wrap .close').on('click', function() {
            var r = confirm("Are you sure to delete image ?");
            if (r == true) {
                var name = $('#blah').attr('src');
                var filtered = name.split('/').pop().trim();
                var id = $("#blah").attr('alt');
                $.ajax({
                    type: 'get',
                    url: "{{ route('deleteImage') }}",
                    data: {
                        'product_id': @json($product['id']),
                    },
                    success: function(data) {
                        $('.img-wrap').hide();
                        console.log(data);

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }

                });
            }
        });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection
