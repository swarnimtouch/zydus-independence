@extends('admin.layout')

@section('title', 'Zydus Admin Users')
@section('page_title', 'Users')
@section('page_subtitle', 'Registration listing with certificate download and S3-safe delete.')

@push('head')
  <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('page_actions')
  <a class="admin-btn admin-btn-green" href="{{ route('admin.export') }}">Export Excel</a>
@endsection

@section('content')
  <section class="admin-card">
    <div class="admin-card-body">
      <div class="admin-table-wrap">
        <table id="registrationsTable" class="table table-striped table-bordered align-middle">
          <thead>
            <tr>
              <th>Sr No</th>
              <th>Name</th>
              <th>BO Code</th>
              <th>Doctor Code</th>
              <th>Certificate</th>
              <th>Registered At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $index => $user)
              <tr>
                <td class="serial-cell">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->bo_code }}</td>
                <td>{{ $user->doctor_code }}</td>
                <td>
                  @if($user->certificate_path)
                    <a class="admin-certificate-link" href="{{ route('admin.certificate.download', $user) }}">Download</a>
                  @else
                    <span class="text-muted">Pending</span>
                  @endif
                </td>
                <td data-order="{{ optional($user->created_at)->timestamp }}">{{ optional($user->created_at)->format('d M Y, h:i A') }}</td>
                <td>
                  <form class="delete-user-form" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                    @csrf
                    @method('DELETE')
                    <button class="admin-btn admin-btn-danger btn-sm" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function () {
      const registrationsTable = $('#registrationsTable').DataTable({
        pageLength: 25,
        order: [[5, 'desc']],
        columnDefs: [
          { orderable: false, targets: [0, 4, 6] }
        ],
        scrollX: true
      });

      registrationsTable.on('order.dt search.dt draw.dt', function () {
        const info = registrationsTable.page.info();

        registrationsTable
          .column(0, { search: 'applied', order: 'applied', page: 'current' })
          .nodes()
          .each(function (cell, index) {
            cell.innerHTML = info.start + index + 1;
          });
      }).draw();

      $('.delete-user-form').on('submit', function (event) {
        event.preventDefault();
        const form = this;

        Swal.fire({
          title: 'Delete registration?',
          text: 'This will delete the record and S3 certificate/photo files.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#64748b',
          confirmButtonText: 'Yes, delete'
        }).then(function (result) {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
@endpush
