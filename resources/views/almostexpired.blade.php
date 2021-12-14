@extends('layouts.base')
@section('title', 'Almost Due Shops')
@section('icon', 'fa-tachometer-a')
@section('content')
    <div class="container-fluid">
        @include('search')
        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Almost due shops
                        <p>Expected amount : &#8358  {{ number_format($amount_due) }}</p>
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
                                            <span class="badge badge-warning">Almost due</span>
                                        </td>
                                        <td>{{ $shop->plaza['name'] }}</td>
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
                                        <div class="d-flex justify-content-center"> No Shops about to expire yet</div>
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
