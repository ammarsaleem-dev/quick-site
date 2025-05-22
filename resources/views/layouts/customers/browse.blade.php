@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row text-center">
            <h3>Customers</h3>
        </div>

        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('customers.create') }}" class="btn btn-danger">Add New</a>
            </div>
            {{-- <div class="col">
                <input type="text" id="searchInput" class="form-control" placeholder="Search customers...">
            </div> --}}
        </div>

        @if (isset($customers) && count($customers) >= 1)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="customersTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>User</th>
                            <th>Customer Type</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->user->name }}</td>
                                <td>{{ $customer->customer_type }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>
                                    <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}"
                                        class="btn btn-secondary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $customer->id }}"
                                        data-customer="{{ $customer->name }}">
                                        Delete
                                    </button>
                                    @include('components.modal', [
                                        'id' => $customer->id,
                                        'name' => $customer->name,
                                        'root' => 'customers.destroy',
                                        'model_name' => 'customer',
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $customers->links('pagination::bootstrap-4') }}
        @else
            @include('components.no-data')
        @endif
    </div>
    {{--
    @push('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                let input = this.value.toLowerCase();
                let table = document.getElementById('customersTable');
                let rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    let cells = rows[i].getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        let cell = cells[j];
                        if (cell) {
                            let text = cell.textContent || cell.innerText;
                            if (text.toLowerCase().indexOf(input) > -1) {
                                found = true;
                                break;
                            }
                        }
                    }

                    rows[i].style.display = found ? '' : 'none';
                }
            });
        </script>
    @endpush --}}
@endsection
