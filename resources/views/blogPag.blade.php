@if($blogs)
    <table id="manage_all" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Category</th>
            <th>Created</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->category }}</td>
                <td>{{ $blog->created_at }}</td>
                <td>{{ $blog->status }}</td>
                <td>
                    <a data-toggle='tooltip' href="{{ URL :: to('/blogs/'.$blog->id) }}"
                       class='btn btn-info btn-xs view' title='View'> <i
                            class='fa fa-eye'></i></a>
                    <a data-toggle='tooltip' href="{{ URL :: to('/blogs/'.$blog->id) .'/edit' }}"
                       class='btn btn-primary btn-xs edit' title='Edit'> <i
                            class='fa fa-pencil-square-o'></i></a>
                    <a data-toggle='tooltip' class='btn btn-danger btn-xs  delete' id='{{$blog->id}}' title='Delete'> <i
                            class='fa fa-trash-o'></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif