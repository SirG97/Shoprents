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
        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        All shops
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Plaza</th>
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
                                            @if($shop['is_owing_bal'] == 1)
                                                @if(\Carbon\Carbon::now() > $shop['next_bal_payment'])
                                                    <span class='pulse-button pulse-button-normal'></span>
                                                    <span class="badge badge-danger">Balance Due</span>
                                                @elseif($shop['next_bal_payment'] < \Carbon\Carbon::now()->addDays(7))
                                                    <span class='pulse-button pulse-button-warn'></span>
                                                    <span class="badge badge-warning">Balance Almost Due</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td scope="row">{{ $shop->plaza['name'] }}</td>
                                        <td scope="row">{{ $shop['shop_number'] }}</td>
                                        <td>{{ $shop['name'] }}</td>
                                        <td>{{ $shop['phone'] }}</td>

                                        <td>{{ $shop['last_payment'] !== null ? $shop['last_payment']->toFormattedDateString() : '' }}</td>
                                        <td>{{ $shop['next_payment'] !== null ? $shop['next_payment']->toFormattedDateString() : ''}}</td>
                                        <td><a href="/shop/{{ $shop['id'] }}" class="btn btn-sm btn-primary">View</a>
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#deleteShopModal"
                                                    data-id="{{ $shop->id }}"
                                            >Delete</button>
                                        </td>

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
