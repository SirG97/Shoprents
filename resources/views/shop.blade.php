@extends('layouts.base')
@section('title', 'Shop')
@section('icon', 'fa-shop')
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
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card ">
                    <div class="d-flex justify-content-between py-2 px-3">
                        <div class="text-secondary mb-1">
                            <div class="font-weight-bold text-capitalize" style="font-size: 22px">{{$shop->name}}</div>
                            <div class="order-name text-capitalize">Address: {{$shop->address}}</div>
                            <div class="order-name text-capitalize">Phone: {{$shop->phone}}</div>
                            <div class="order-name ">Last payment: {{$shop->last_payment === null ? 'No Payment yet': \Carbon\Carbon::create($shop->last_payment)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</div>
{{--                            ->isoFormat('MMMM Do YYYY, h:mm:ss a')--}}
                            <div class="order-name">Next payment: {{$shop->next_payment === null ? 'N/A': \Carbon\Carbon::create($shop->next_payment)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</div>
{{--                            <div class="order-name text-capitalize">Next payment: {{\Carbon\Carbon::parse($shop->next_payment)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</div>--}}
                        </div>
                        <div class="font-weight-bold text-secondary mb-1 d-flex justify-content-end">
                            <div class="text-right">
                                @if($shop->next_payment == null or $shop->next_payment < \Carbon\Carbon::now())
                                    <span class='pulse-button'></span>
                                    <span class="btn btn-sm btn-danger">Payment Due</span>
                                @else
                                    <span class="btn btn-sm btn-success"> Paid </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row ">
            <div class="col-md-8">
                <div class="custom-panel card py-2">
                    <div class=" d-inline-flex justify-content-between">
                        <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                            Shop owner payments
                        </div>
                        <div class="font-weight-bold text-secondary mb-1 d-flex justify-content-end mr-1">
                            <div class="text-right">
                                    <button type="submit"
                                            class="btn btn-sm btn-primary"
                                            data-toggle="modal"
                                            data-target="#paymentModal"
                                            data-id="{{ $shop->id }}"
                                    >Mark payment</button>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead class="trx-bg-head text-secondary py-3 px-3">
                                <tr>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Due</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!empty($payments) && count($payments) > 0)
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>&#8358 {{ $payment['amount'] }}</td>
                                            <td>
                                                @if($payment['duration'] === "24")
                                                    <span>2 years</span>
                                                @elseif($payment['duration'] === "12")
                                                    <span>1 year</span>
                                                @elseif($payment['duration'] === "6")
                                                    <span>{{$payment['duration']}} months</span>
                                                @elseif($payment['duration'] === "3")
                                                    <span>{{$payment['duration']}} months</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment['last_payment'] }}</td>
                                            <td>{{ $payment['next_payment'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center">No Payments yet</div>
                                        </td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="editpaymentLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <form action="{{ route('payments.store') }}" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Mark Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ $shop->id }}">
                                <div class="col-md-12 mb-3">
                                    <label for="amount">Amount</label>
                                    <input type="text" value="" class="form-control"  name="amount" id="amount">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="duration">Duration</label>
                                    <select class="custom-select" id="duration" name="duration" >
                                        <option value=""></option>
                                        <option value="3">3 months</option>
                                        <option value="6">6 months</option>
                                        <option value="12">1 year</option>
                                        <option value="24">2 years</option>
                                    </select>
                                </div>
                            <div class="col-md-12 mb-3">
                                <label for="amount">Date of payment</label>
                                <input type="date" value="" class="form-control"  name="date" id="date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endsection()

