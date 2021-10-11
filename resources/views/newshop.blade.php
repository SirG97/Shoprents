@extends('layouts.base')
@section('title', 'Add New Shop')
@section('icon', 'fa-paper-plane')
@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row" style="margin:auto">
            <div class="offset-md-2"></div>
            <div class="col-md-8">
                <div class="custom-panel card pt-2">
                    <div class="font-weight-bold text-secondary py-3 px-3 cool-border-bottom">
                        Add new Shop
                    </div>
                    <div class="full-details">
                        <form action="{{url('/shops/add')}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Plaza<span style="color:red">*</span></label>
                                        <select class="custom-select" name="plaza" required>
                                            @if(!empty($plazas) && count($plazas) > 0)
                                                <option value="0" selected>Select a Plaza</option>
                                                @foreach($plazas as $plaza)
                                                    <option value={{$plaza->id}}> {{$plaza->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Shop name<span style="color:red">*</span></label>
                                        <input type="text" class="form-control"  name="name" id="name">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Shop number<span style="color:red">*</span></label>
                                        <input type="text" class="form-control"  name="number" id="number">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="phone">Occupant Phone Number<span style="color:red">*</span></label>
                                        <input type="text" class="form-control"  name="phone" id="phone">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="address">Address<span style="color:red">*</span></label>
                                        <input class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Is shop vacant<span style="color:red">*</span></label>
                                        <select class="custom-select" name="vaccant" required>
                                                <option value="0" selected>No</option>
                                                <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row float-right mb-3">
                                    <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection()



