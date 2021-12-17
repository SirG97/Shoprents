@extends('layouts.base')
@section('title', 'All Shops')
@section('icon', 'fa-tachometer-a')
@section('content')
    <div class="container-fluid">
        @include('search')
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
        <div class="row print">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Plaza:  {{$plaza->name}} <br>
                        Address: {{$plaza->address}}
                        <br>
                        <h3>Total  Revenue = <span class="text-danger"> &#8358  {{ number_format($amount) }}</span></h3>
                        <div class="btn-group-sm mt-2 no-print">
                            <a href="/plaza/{{$plaza->id}}/paid" class="btn btn-success">Paid</a>
                            <a href="/plaza/{{$plaza->id}}/almostdue" class="btn btn-warning">Almost due</a>
                            <a href="/plaza/{{$plaza->id}}/expired" class="btn btn-danger">Expired</a>
                            <a href="/plaza/{{$plaza->id}}/vacant" class="btn btn-info">Vacant</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Shop number</th>
                                <th scope="col">Occupant</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Last Payment</th>
                                <th scope="col">Due by</th>
                                <th scope="col" class="no-print">Action</th>
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
                                        <td scope="row">{{ $shop['shop_number'] }}</td>
                                        <td scope="row">{{ $shop['name'] }}</td>
                                        <td scope="row">
                                            @if($shop['latestPayment'] !== null)
                                                &#8358 {{ number_format($shop['latestPayment']->amount) }}
                                            @endif
                                        </td>
                                        <td>{{ $shop['phone'] }}</td>
                                        <td>{{ $shop['last_payment'] !== null ? $shop['last_payment']->toFormattedDateString() : '' }}</td>
                                        <td>{{ $shop['next_payment'] !== null ? $shop['next_payment']->toFormattedDateString() : ''}}</td>
                                        <td class="no-print">
                                            <a href="/shop/{{ $shop['id'] }}" class="btn btn-sm btn-primary">View</a>
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#deleteShopModal"
                                                    data-id="{{ $shop['id'] }}"
                                            >Delete</button>
                                        </td>

                                    </tr>
                                @endforeach
                                {{--    {{ $contributions->links('views.bootstrap-4') }}--}}

                            @else
                                <tr>
                                    <td colspan="6">
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
    <div class="modal fade" id="deleteShopModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="shopDeleteForm" action="" method="POST">
                        <div class="col-md-12">
                            Are you sure you want to delete this shop?
                            @csrf
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteShopBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
