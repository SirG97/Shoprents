@extends('layouts.base')
@section('title', 'All Shops')
@section('icon', 'fa-tachometer-a')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                      Plaza:  {{$plaza->name}} <br>
                        Address: {{$plaza->address}}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Shop name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Last Payment</th>
                                <th scope="col">Due by</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody class="table-style">
                            @if(!empty($shops) && count($shops) > 0)
                                @foreach($shops as $shop)
                                    <tr>
                                        <td scope="row">
                                            @if($shop['vacant_status'] == "0")
                                                @if(\Carbon\Carbon::now() > $shop['next_payment'])
                                                    <span class='pulse-button pulse-button-normal'></span>
                                                    <span class="badge badge-danger">Due</span>
                                                @elseif($shop['next_payment'] < \Carbon\Carbon::now()->addMonth())
                                                    <span class='pulse-button pulse-button-warn'></span>
                                                    <span class="badge badge-warning">Almost Due</span>
                                                @else
                                                    <span class="badge badge-success">Paid</span>
                                                @endif
                                            @else
                                                <span class="badge badge-info">Vacant</span>
                                            @endif
                                        </td>
                                        <td scope="row">{{ $shop['name'] }}</td>
                                        <td>{{ $shop['phone'] }}</td>
                                        <td>{{ $shop['address'] }}</td>
                                        <td>{{ $shop['last_payment'] }}</td>
                                        <td>{{ $shop['next_payment'] }}</td>
                                        <td><a href="/shop/{{ $shop['id'] }}" class="btn btn-sm btn-primary">View</a></td>

                                    </tr>
                                @endforeach
                                {{--    {{ $contributions->links('views.bootstrap-4') }}--}}

                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center"> No Shops yet</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                        {{ $shops->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
