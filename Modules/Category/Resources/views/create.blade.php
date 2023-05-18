@extends('layouts.app')

@section('title', tr('create_category'))

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">{{ tr('dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ tr('categories') }}</a></li>
    <li class="breadcrumb-item active">{{ tr('create_category') }}</li>
@endsection

@section('content')
<div class="row">
   <div class="col-md-8 col-12">
       <div class="card card-primary">
           <div class="card-header">
               <h3 class="card-title">{{ tr('general') }}</h3>
           </div>
           <form method="post" action="{{ route('categories.store') }}">
               @csrf
               <div class="card-body">
                   <div class="form-group">
                       <label for="exampleInputName1">Name</label>
                       <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Enter name">
                   </div>
                   <div class="form-group">
                       <label for="exampleSelectRounded0">Status</label>
                       <select class="custom-select rounded-0" id="exampleSelectRounded0">
                           <option>Enabled</option>
                           <option>Disabled</option>
                       </select>
                   </div>
                   <div class="form-check">
                       <input type="checkbox" class="form-check-input" id="exampleCheck1">
                       <label class="form-check-label" for="exampleCheck1">Check me out</label>
                   </div>
               </div>

               <div class="card-footer">
                   <button type="submit" class="btn btn-primary">Submit</button>
               </div>
           </form>
       </div>
   </div>
   <div class="col-md-4 col-12">
       <div class="card card-danger">
           <div class="card-header">
               <h3 class="card-title">{{ tr('thumbnail_image') }}</h3>
           </div>
           <div class="card-body text-center pt-0">
               <div class="">
                   <img src="{{ asset('thumbnail.jpg') }}" alt="" class="img-fluid img-thumbnail rounded loadImageSingle">
               </div>
               <input name="image_file" type="file" class="mt-3 browseSingle" accept=".jpg, .png, .jpeg, .gif" style="display: none">
               <input name="" type="button" class="btn btn-info upImageSingle btn-block mt-3" value="{{ tr('upload_image') }}">
           </div>
       </div>
   </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).on('change', '.browseSingle',function () {
        readURL(this);
    });
    $(document).on('click', '.upImageSingle', function () {
        $(this).siblings('.browseSingle').click();
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.loadImageSingle').attr('src', e.target.result);
            };
        }
    }
</script>
@endpush
