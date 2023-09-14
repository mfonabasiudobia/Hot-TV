<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Show Categories</h1>

        <a href="{{ route('admin.show-category.create') }}" class="bg-primary action-btn">Add Show Category</a>
    </section>
    {{-- @livewire('admin.show-category.tables.home', key($key)) --}}


    <table class="w-full text-left">
       <thead>
            <tr>
                <th>SNO</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
       </thead>
       <tbody>
            @foreach (\App\Models\ShowCategory::all() as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.show-category.edit', ['id' => $item->id ]) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
       </tbody>
    </table>
</section>