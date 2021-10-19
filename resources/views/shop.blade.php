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
                            <div class="font-weight-bold text-capitalize" style="font-size: 22px">{{$shop->shop_number}}</div>
                            <div class="order-name text-capitalize">Occupant: {{$shop->name}}</div>
                            <div class="order-name text-capitalize">Phone: {{$shop->phone}}</div>
                            <div class="order-name ">Last payment: {{$shop->last_payment == null ? 'No Payment yet': $shop->last_payment->isoFormat('MMMM Do YYYY')}}</div>
{{--                            ->isoFormat('MMMM Do YYYY, h:mm:ss a')--}}
                            <div class="order-name">Next payment: {{$shop->next_payment == null ? 'N/A': $shop->next_payment->isoFormat('MMMM Do YYYY')}}</div>
                            <div class="order-name text-capitalize">Owing Balance: {{$shop->is_owing_bal == 0 ? 'No':'Yes'}}</div>
                            <div class="order-name ">Last Balance payment: {{$shop->last_bal_payment == null ? 'N/A': $shop->last_bal_payment->isoFormat('MMMM Do YYYY')}}</div>
                            {{--                            ->isoFormat('MMMM Do YYYY, h:mm:ss a')--}}
                            <div class="order-name">Next Balance payment: {{$shop->next_bal_payment == null ? 'N/A': $shop->next_bal_payment->isoFormat('MMMM Do YYYY')}}</div>

                                <button type="submit"
                                        class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#occupyModal"
                                        data-id="{{ $shop->id }}"
                                >Update shop</button>


                            {{--                            <div class="order-name text-capitalize">Next payment: {{\Carbon\Carbon::parse($shop->next_payment)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</div>--}}
                        </div>
                        <div class="font-weight-bold text-secondary mb-1 d-flex justify-content-end">
                            <div class="text-right">
                                @if($shop['vacant_status'] == "0")
                                    @if($shop->next_payment == null or $shop->next_payment < \Carbon\Carbon::now())
                                        <span class='pulse-button'></span>
                                        <span class="btn btn-sm btn-danger">Payment Due</span>
                                    @else
                                        <span class="btn btn-sm btn-success"> Paid </span>
                                    @endif
                                @else
                                    <span class="btn btn-sm btn-info">Vacant</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row ">
            <div class="col-md-12">
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
                                <button type="submit"
                                        class="btn btn-sm btn-secondary"
                                        data-toggle="modal"
                                        data-target="#balanceModal"
                                        data-id="{{ $shop->id }}"
                                >Pay Balance</button>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead class="trx-bg-head text-secondary py-3 px-3">
                                <tr>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Paid</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">BBF</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Paid on</th>
                                    <th scope="col">Due by</th>
                                    <th scope="col">Balance Paid on</th>
                                    <th scope="col">Balance due by</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!empty($payments) && count($payments) > 0)
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>&#8358 {{ $payment['amount'] }}</td>
                                            <td>&#8358 {{ $payment['paid'] }}</td>
                                            <td>&#8358 {{ $payment['balance'] }}</td>
                                            <td>&#8358 {{ $payment['bal_brought_fwd'] }}</td>
                                            <td>
                                                @if($payment['duration'] === "24")
                                                    <span>2 years</span>
                                                @elseif($payment['duration'] === "12")
                                                    <span>1 year</span>
                                                @elseif($payment['duration'] === "6")
                                                    <span>{{$payment['duration']}} months</span>
                                                @elseif($payment['duration'] === "3")
                                                    <span>{{$payment['duration']}} months</span>
                                                @elseif($payment['duration'] === "0")
                                                    <span>Balance</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment['last_payment'] !== null ? $payment['last_payment']->toFormattedDateString() : '' }}</td>
                                            <td>{{ $payment['next_payment'] !== null ? $payment['next_payment']->toFormattedDateString() : ''}}</td>
                                            <td>{{ $payment['last_bal_payment'] !== null ? $payment['last_bal_payment']->toFormattedDateString() : ''}}</td>
                                            <td>{{ $payment['next_bal_payment'] !== null ? $payment['next_bal_payment']->toFormattedDateString() : ''}}</td>
                                            <td>

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        data-toggle="modal"
                                                        data-target="#deletePaymentModal"
                                                        data-id="{{ $payment->id }}"
                                                >Delete</button></td>
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
        <div class="modal fade bd-example-modal-lg" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentLabel" aria-hidden="true">
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
                                    <label for="amount">Amount to be paid<span style="color:red">*</span></label>
                                    <input type="text" value="" class="form-control"  name="amount" id="amount" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="amount">Amount paid<span style="color:red">*</span></label>
                                    <input type="text" value="" class="form-control"  name="paid" id="paid" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="duration">Duration<span style="color:red">*</span></label>
                                    <select class="custom-select" id="duration" name="duration" required>
                                        <option value=""></option>
                                        <option value="3">3 months</option>
                                        <option value="6">6 months</option>
                                        <option value="12">1 year</option>
                                        <option value="24">2 years</option>
                                    </select>
                                </div>
                            <div class="col-md-12 mb-3">
                                <label for="amount">Date of payment<span style="color:red">*</span></label>
                                <input type="date" value="" class="form-control"  name="date" id="date" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="balance">Balance owned</label>
                                <input type="text" value="0" class="form-control"  name="balance" id="balance">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="balance_due">Balance due</label>
                                <input type="date" value="" class="form-control"  name="balance_due" id="balance_due">
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
    <div class="modal fade bd-example-modal-lg" id="balanceModal" tabindex="-1" role="dialog" aria-labelledby="editbalanceLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="{{ route('balance.pay') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pay Balance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $shop->id }}">
                        <div class="col-md-12 mb-3">
                            <label for="amount">Amount<span style="color:red">*</span></label>
                            <input type="text" value="" class="form-control"  name="amount" id="amount" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="balance_due_by">Date due</label>
                            <input type="date" value="" class="form-control"  name="balance_due_by" id="balance_due_by" >
                            <small class="help-text" style="color:red">Please select another due date ONLY if full balance is not being paid</small>
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

    <div class="modal fade bd-example-modal-lg" id="occupyModal" tabindex="-1" role="dialog" aria-labelledby="occupyLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="{{ route('occupied') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Shop</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $shop->id }}">
                        <div class="col-md-12 mb-3">
                            <label for="name">Plaza<span style="color:red">*</span></label>
                            <select class="custom-select" name="plaza" required>
                                @if(!empty($plazas) && count($plazas) > 0)
                                    <option value="">Select a Plaza</option>
                                    @foreach($plazas as $plaza)
                                        <option value="{{$plaza->id}}" {{$plaza->id == $shop->plaza_id ? 'selected': ''}}> {{$plaza->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="name">Occupant name<span style="color:red">*</span></label>
                            <input type="text" class="form-control" value="{{ $shop->name }}"  name="name" id="name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="name">Shop number<span style="color:red">*</span></label>
                            <input type="text" class="form-control" value="{{ $shop->shop_number }}" name="number" id="number">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="phone">Occupant Phone Number<span style="color:red">*</span></label>
                            <input type="text" class="form-control" value="{{ $shop->phone }}"  name="phone" id="phone">
                        </div>
{{--                        <div class="col-md-12 mb-3">--}}
{{--                            <label for="address">Address<span style="color:red">*</span></label>--}}
{{--                            <input class="form-control" value="{{ $shop->address }}" id="address" name="address" required>--}}
{{--                        </div>--}}

                        <div class="col-md-12 mb-3">
                            <label for="name">Is shop vacant<span style="color:red">*</span></label>
                            <select class="custom-select" name="vacant" required>
                                <option value="0" {{$shop->vacant_status == 0 ? 'selected': ''}}>No</option>
                                <option value="1" {{$shop->vacant_status == 1 ? 'selected': ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletePaymentModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="paymentDeleteForm" action="" method="POST">
                        <div class="col-md-12">
                            Are you sure you want to delete this payment?
                            @csrf
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deletePaymentBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endsection()

