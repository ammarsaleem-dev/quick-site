@extends('layouts.app')
@section('style')
    <style>
        #card {
            overflow-y: scroll;
            position: relative;
        }

        .card-body {
            max-height: calc(100vh - 220px);
        }

        .category-chips {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 0.5rem;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            white-space: nowrap; /* Prevent chips from breaking words into new lines */
        }

        .category-chip {
            white-space: nowrap; /* Ensure the chip text stays on one line */
        }

        .category-chip {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            cursor: pointer;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .category-chip.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection
@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('orders.storeProducts') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Order Create</span>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" class="form-control" id="searchInput"
                                    placeholder="Search products...">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="category-chips">
                            <div class="category-chip active" data-category="all">All</div>
                            @foreach ($categories as $category)
                                <div class="category-chip" data-category="{{ $category->id }}">
                                    {{ $category->name }}
                                </div>
                            @endforeach
                        </div>
                        <div id="card" class="card-body">
                            @csrf
                            <!--=============================== Products =============================-->
                            @foreach ($products as $product)
                                <div class="card mb-3 shadow-sm product-card" data-category="{{ $product->category_id }}">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img class="img-fluid rounded-start"
                                                style="object-fit:contain; width: 200px; height: 200px;"
                                                src="@if ($product->image != '') {{ asset("storage/products/$product->image") }} @endif"
                                                alt="{{ $product->image }}" />
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-header bg-transparent border-0">
                                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-primary">Price:
                                                    {{ number_format($product->price, 2) }} - IQD </h6>
                                                <p class="card-text text-muted">{{ $product->description }}</p>
                                            </div>
                                            <div class="card-footer bg-transparent">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-outline-success btn-sm"
                                                            onclick="updateValue('{{ $product->id }}','increment')">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col">
                                                        <input name="products[{{ $product->id }}][quantity]"
                                                            type="number" id="{{ $product->id }}"
                                                            class="form-control form-control-sm text-center"
                                                            value="{{ $currentValue }}" min="0">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="updateValue('{{ $product->id }}','decrement')">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-3">
                                                        <input name="products[{{ $product->id }}][gift]" type="number"
                                                            class="form-control form-control-sm text-center" value="0"
                                                            placeholder="Gift" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary ">ReviewOrder</button>
                        </div>
                    </div> <!-- end of card -->
                </div>
            </div>
        </div>

    </form>

    <script src="{{ asset('js/my-js/tom-select.js') }}"></script>
    <script>
        function updateValue(columnName, action) {
            var currentInput = document.getElementById(columnName);
            var currentValue = parseInt(currentInput.value) || 0; // Default to 0 if the value is not a number

            if (action === 'increment') {
                currentValue++;
            } else if (action === 'decrement') {
                if (!currentValue == 0) {
                    currentValue--;
                }
            }

            currentInput.value = currentValue;
        }

        // Add new filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const categoryChips = document.querySelectorAll('.category-chip');
            const productCards = document.querySelectorAll('.product-card');
            const searchInput = document.getElementById('searchInput');

            function filterProducts(category, searchTerm = '') {
                productCards.forEach(card => {
                    const productCategory = card.dataset.category;
                    const productName = card.querySelector('.card-title').textContent.toLowerCase();
                    const matchesCategory = category === 'all' || productCategory === category;
                    const matchesSearch = productName.includes(searchTerm.toLowerCase());

                    card.style.display = (matchesCategory && matchesSearch) ? 'block' : 'none';
                });
            }

            categoryChips.forEach(chip => {
                chip.addEventListener('click', () => {
                    // Remove active class from all chips
                    categoryChips.forEach(c => c.classList.remove('active'));
                    // Add active class to clicked chip
                    chip.classList.add('active');
                    // Filter products
                    filterProducts(chip.dataset.category, searchInput.value);
                });
            });

            searchInput.addEventListener('input', (e) => {
                const activeCategory = document.querySelector('.category-chip.active').dataset.category;
                filterProducts(activeCategory, e.target.value);
            });
        });
    </script>
@endsection
