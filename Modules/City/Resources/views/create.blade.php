@extends('easy-build::layouts.app')

@section('title', 'Create city')

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Cities</a></li>
    <li class="breadcrumb-item active">Create city</li>
@endsection

@section('content')
<div class="row justify-content-center">
   <div class="col-8">
       <div class="card card-primary">
           <div class="card-header">
               <h3 class="card-title">Create new city</h3>
           </div>
           <form method="post" action="{{ route('cities.store') }}">
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
</div>
@endsection

@push('js')

@endpush
