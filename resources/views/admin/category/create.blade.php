@extends('admin.master')
@section('title', 'Category')
@section('styles')
    <style>
        .error-msg {
            color: red;
        }

        input.msg-box {
            border: 1px solid red;
        }

        .msg-hidden {
            display: none;
        }

    </style>
@endsection
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
                                    <div class="error-msg msg-hidden">Name (In English) is required.</div>
                                </div>
                                <div class="col">
                                    <label for="name-bn">Name (In Bangla)</label>
                                    <input type="text" name="name_bn" class="form-control mb-1" placeholder="Name in Bangla"
                                        autocomplete="off">
                                    <div class="error-msg msg-hidden ml-1">Name (In Bangla) is required.</div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="formSubmit" class="btn btn-primary float-right">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            const form = document.querySelector('form');
            // Get Input 
            const nameInputEn = document.querySelector('input[name="name_en"]')
            const nameInputBn = document.querySelector('input[name="name_bn"]')
            // Checked Validation Status
            let isFormValid = false;
            // Check Validation
            const validateInputs = () => {
                // Remove Invalid
                nameInputEn.classList.remove("invalid");
                nameInputBn.classList.remove("invalid");
                // Remove Error Message
                nameInputEn.nextElementSibling.classList.add("msg-hidden");
                nameInputBn.nextElementSibling.classList.add("msg-hidden");
                // Check when input is null
                if (!nameInputEn.value) {
                    nameInputEn.classList.add("invalid");
                    nameInputEn.nextElementSibling.classList.remove("msg-hidden");
                    isFormValid = false;
                } else {
                    isFormValid = true;
                }
                if (!nameInputBn.value) {
                    nameInputBn.classList.add("invalid");
                    nameInputBn.nextElementSibling.classList.remove("msg-hidden");
                    isFormValid = false;
                } else {
                    isFormValid = true;
                }
            }
            // Check Submit Event
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                validateInputs();
                console.log(isFormValid);
                if (isFormValid) {
                    form.submit();
                }
            });
            // Add Invalid Color and Necessaries
            nameInputEn.addEventListener("input", () => {
                validateInputs();
            });
            nameInputBn.addEventListener("input", () => {
                validateInputs();
            });
        });
    </script>
@endsection
