@extends('admin.layouts.base')
@section('title', 'Restore Authors')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-grid d-flex justify-content-between mb-3">
        <h1 class="h3 mb-2 text-gray-800 d-flex align-items-center">Restore Authors</h1>
        <div>
            <button class="btn btn-success btn-icon-split" id="authors-selected-restore-btn" data-toggle="modal">
                <span class="icon text-white-50">
                    <i class="fas fa-trash-restore"></i>
                </span>
                <span class="text">Restore Selected</span>
            </button>
            <button class="btn btn-success btn-icon-split" id="authors-restore-all-btn" data-toggle="modal">
                <span class="icon text-white-50">
                    <i class="fas fa-trash-restore"></i>
                </span>
                <span class="text">Restore All</span>
            </button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-header"></th>
                            <th>Tên tác giả</th>
                            <th>Tuổi</th>
                            <th>Ngày sinh</th>
                            <th>Ngày mất</th>
                            <th>Quốc tịch</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="checkbox" id="select-all-footer"></th>
                            <th>Tên tác giả</th>
                            <th>Tuổi</th>
                            <th>Ngày sinh</th>
                            <th>Ngày mất</th>
                            <th>Quốc tịch</th>
                            <th>Options</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($authors as $author)
                            <tr>
                                <td><input type="checkbox" name="author_ids[]" value="{{ $author->author_id }}"></td>
                                <td>{{ $author->author_name }}</td>
                                <td>{{ $author->age }}</td>
                                <td>{{ $author->birth_date }}</td>
                                <td>{{ $author->death_date ? $author->death_date : '------------' }}</td>
                                <td>{{ $author->national }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-link p-0 m-0" data-author-id="{{ $author->author_id }}" id="restore-btn">
                                            <i style="font-size: 28px; color: #18b97e;" class="fa-solid fa-trash-can-arrow-up"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex">
                    <nav>
                        {{ $authors->links('vendor.pagination.bootstrap-4') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script src="{{ asset('/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/js/demo/datatables-demo.js') }}"></script>

<script src="{{ asset('assets/js/common.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ACTION_URL = "{{ route('authors.restore-selected') }}";
        title = "Confirm Restore";
        body = "Are you sure you want to restore the selected authors?";
        method = 'PATCH';
        confirmText = "Restore";
        initializeCheckboxes('select-all-header', 'select-all-footer', 'author_ids[]', 'authors-selected-restore-btn');

        const restoreAllBtn = document.getElementById('authors-restore-all-btn');
        if (restoreAllBtn) {
            restoreAllBtn.addEventListener('click', function() {
                ACTION_URL = "{{ route('authors.restore-all') }}";
                title = "Confirm Restore";
                body = "Are you sure you want to restore all authors?";
                method = 'PATCH';
                confirmText = "Restore";

                showModalConfirmation([], ACTION_URL, title, body, method, confirmText);
            });
        }

        const restoreButtons = document.querySelectorAll('#restore-btn');
        restoreButtons.forEach(button => {
            button.addEventListener('click', function() {
                const authorId = this.getAttribute('data-author-id');
                ACTION_URL = "{{ route('authors.restore', ':id') }}".replace(':id', authorId);
                title = "Confirm Restore";
                body = "Are you sure you want to restore this author?";
                method = 'PATCH';
                confirmText = "Restore";

                showModalConfirmation([authorId], ACTION_URL, title, body, method, confirmText);
            });
        });
    });
</script>

@endsection
