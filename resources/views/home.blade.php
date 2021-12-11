@extends('layouts.base')
@section('title', 'Dashboard')
@section('icon', 'fa-tachometer-a')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Total Shops</h6>
                        <h5 class="text-right">
                            <i class="fas fa-users  float-left"></i>
                            <span>
                              {{$total_shops}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Expired Shops</h6>
                        <h5 class="text-right">
                            <i class="fas fa-money-bill  float-left"></i>
                            <span>
                                  {{$expired_shops}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Expire in < 1month</h6>
                        <h5 class="text-right">
                            <i class="fas fa-user-shield  float-left"></i>
                            <span>
                                {{$expire_in_one_month}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Vacant Shops</h6>
                        <h5 class="text-right">
                            <i class="fas fa-coins  float-left"></i>
                            <span>
                                &#8358; {{$vacant}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Expired / Expiring in < 1 month
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Shop number</th>
                                <th scope="col">Occupant</th>
                                <th scope="col">Phone</th>
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
                                                    <span class='pulse-button pulse-button-normal'></span> &nbsp
                                                    <span class="badge badge-danger">Due</span>
                                                @elseif($shop['next_payment'] < \Carbon\Carbon::now()->addMonth())
                                                    <span class='pulse-button pulse-button-warn'></span>&nbsp
                                                    <span class="badge badge-warning">Almost Due</span>
                                                @else
                                                    <span class="badge badge-success">Paid</span>
                                                @endif
                                            @else
                                                <span class="badge badge-info">Vacant</span>
                                            @endif
                                                @if($shop['is_owing_bal'] == 1)
                                                    @if(\Carbon\Carbon::now() > $shop['next_bal_payment'])
                                                        <span class='pulse-button pulse-button-normal'></span>
                                                        <span class="badge badge-danger">Balance Due</span>
                                                    @elseif($shop['next_bal_payment'] < \Carbon\Carbon::now()->addMonth())
                                                        <span class='pulse-button pulse-button-warn'></span>
                                                        <span class="badge badge-warning">Balance Almost Due</span>
                                                    @endif
                                                @endif
                                        </td>
                                        <td scope="row">{{ $shop['shop_number'] }}</td>
                                        <td>{{ $shop['name'] }}</td>
                                        <td>{{ $shop['phone'] }}</td>

                                        <td>{{ $shop['last_payment'] !== null ? $shop['last_payment']->toFormattedDateString() : '' }}</td>
                                        <td>{{ $shop['next_payment'] !== null ? $shop['next_payment']->toFormattedDateString() : ''}}</td>
                                        <td><a href="/shop/{{ $shop['id'] }}" class="btn btn-sm btn-primary">View</a></td>

                                    </tr>
                                @endforeach
                                {{--    {{ $contributions->links('views.bootstrap-4') }}--}}

                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center"> No Expired Shops yet</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                        <a href="/shops" class="btn btn-primary btn-sm px-3">View more</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
