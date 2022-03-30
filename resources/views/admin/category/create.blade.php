@extends('admin.master')
@section('title', 'Category')
@push('styles')
@endpush
@section('admin')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-active fw-light">Create New Category</span>
        <span>
            <a href="{{ route('admin.category') }}" class="btn btn-info text-active float-right">
                <i class="bx bx-plus"></i>
                List</a>
        </span>
    </h4>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-body shadow">
                    <form action="{{ route('admin.category.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="name-en">Name (In English)</label>
                                    <input type="text" name="name_en" class="form-control mb-1"
                                        placeholder="Name in English" autocomplete="off">
                                    <div class="error-msg msg-hidden">Name is required.</div>
                                </div>
                                <div class="col">
                                    <label for="name-bn">Name (In Bangla)</label>
                                    <input type="text" name="name_bn" class="form-control mb-1"
                                        placeholder="Name in Bangla" autocomplete="off">
                                    <div class="error-msg msg-hidden ml-1">Name is required.</div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="hello" class="btn btn-primary float-right">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@push('scripts')
<script src="{{ asset('admin/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script>
  $(document).ready(function(){
      const    
  });
  </script>

@endpush
