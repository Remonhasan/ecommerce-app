@extends('admin.master')
@section('title', 'Category')
@push('css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endpush
@section('admin')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-active">{{ __('Categories') }}</span>
        <span>
            <a href="{{ route('admin.create', app()->getLocale()) }}" class="btn btn-info text-active float-right">
                <i class="bx bx-plus"></i>
                {{ __('Add') }}</a>
        </span>
    </h4>
    

    @if( ! $allCategories->isEmpty() || filter_input(INPUT_GET, 'filter') )
    @include('admin.category.search')
    @endif

    @if (!$allCategories->isEmpty())
        <div class="card shadow">
            <div class="card-datatable table-responsive">
                <table class="datatables-basic table border-top">
                    <thead>
                        <tr class="text-white"">
                            <th>{{ __('SL') }}</th>
                            <th>{{ __('Name (In English)') }}</th>
                            <th>{{ __('Name (In Bangla)') }}</th>
                            <th>{{ __('Is Active') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                              @foreach ($allCategories as $key=> $category)
                        <tr>
                            <td>{{ translateString($key + 1) }}</td>
                            <td>{{ $category->name_en }}</td>
                            <td>{{ !empty($category->name_bn) ? $category->name_bn : '-' }}</td>
                            <td>
                                @if (1 === $category->is_active)
                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                @elseif(0 === $category->is_active)
                                    <span class="badge badge-danger"> {{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                {{ displayDateTime($category->created_at) }}<br>
                                {{ displayDateTime($category->created_at, 'h:i a') }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('Actions') }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">

                                        <a href="{{ route('admin.category.edit', $category->id)}}" class="dropdown-item">
                                            <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                                        </a>


                                        <div class="dropdown-divider"></div>

                                        <form action="" method="POST">
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="delete-user btn btn-link text-danger dropdown-item">
                                                <i class="icon-trash" aria-hidden="true"></i> {{ __('Delete') }}
                                            </button>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                  @endforeach
               </tbody>
            <tfoot>
                <tr class="text-white"">
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Name (In English)') }}</th>
                    <th>{{ __('Name (In Bangla)') }}</th>
                    <th>{{ __('Is Active') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </tfoot>

                    </table>
                </div>
            </div>

            {!! gridFooter($allCategories, $itemsPerPage) !!}

        @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('Sorry! No data found to display') }}
        </div>

        @endif
             
        @endsection
        @push('js')
            <!-- Vendors JS -->
            <script src="{{ asset('admin/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-buttons/datatables-buttons.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/jszip/jszip.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/pdfmake/pdfmake.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-buttons/buttons.html5.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-buttons/buttons.print.js') }}"></script>
            <!-- Flat Picker -->
            <script src="{{ asset('admin/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
            <script src="{{ asset('admin/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
            <script src="{{ asset('admin/vendor/libs/select2/select2.js') }}"></script>
            <!-- Row Group JS -->
            <script src="{{ asset('admin/assets/vendor/libs/datatables-rowgroup/datatables.rowgroup.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.js') }}"></script>
            <!-- Form Validation -->
            <script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

            <!-- Main JS -->
            <script src="{{ asset('admin/assets/js/main.js') }}"></script>
            <!-- Page JS -->
        @endpush
