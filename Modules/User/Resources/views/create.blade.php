@extends('layouts.app')

@section('title', tr('create_user'))

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">{{ tr('dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ tr('users') }}</a></li>
    <li class="breadcrumb-item active">{{ tr('create_user') }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
   <div class="col-lg-8 col-12">
       <div class="card card-primary">
           <div class="card-header">
               <h3 class="card-title">{{ tr('create_user') }}</h3>
           </div>
           <form method="post" action="{{ route('users.store') }}">
               @csrf
               <div class="card-body">
                   <div class="form-group">
                       <label for="exampleInputName1">{{ tr('name') }}</label>
                       <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Enter name">
                   </div>
                   <div class="form-group">
                       <label for="exampleInputName1">{{ tr('email') }}</label>
                       <input type="text" name="email" class="form-control" id="exampleInputName1" placeholder="Enter name">
                   </div>
                   <div class="form-group">
                       <label for="exampleInputName1">{{ tr('phone') }}</label>
                       <input type="text" name="phone" class="form-control" id="exampleInputName1" placeholder="Enter name">
                   </div>
                   <div class="form-group">
                       <label for="exampleSelectRounded0">{{ tr('role') }}</label>
                       <select class="custom-select rounded-0" name="role_id" id="exampleSelectRounded0">
                           <option>{{ tr('select_here') }}</option>
                           @foreach($roles as $role)
                               <option value="{{ $role->id }}">{{ $role->name }}</option>
                           @endforeach
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
