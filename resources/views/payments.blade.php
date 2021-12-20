@extends('layouts.base')
@section('title', 'Payment History')
@section('icon', 'fa-tachometer-a')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        All Payments
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">S/N</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Bal</th>
                                <th scope="col">BBF</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Paid on</th>
                                <th scope="col">Due by</th>
                                <th scope="col">Bal Paid on</th>
                                <th scope="col">Bal due by</th>



                            </tr>
                            </thead>
                            <tbody class="table-style">
                            @if(!empty($payments) && count($payments) > 0)
                                @foreach($payments as $payment)
                                    <tr>

                                        <td scope="row">{{ $payment->shop['shop_number'] }}</td>
                                        <td>
                                            @if($payment['amount'] != false)
                                                ₦{{ number_format($payment['amount'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment['paid'] != false)
                                                ₦{{ number_format($payment['paid'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment['balance'] != false)
                                                ₦{{ number_format($payment['balance'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment['bal_brought_fwd'] != false)
                                                ₦{{ number_format($payment['bal_brought_fwd'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment['duration'] === "3")
                                                3 months
                                            @elseif($payment['duration'] === "6")
                                                6 months
                                            @elseif($payment['duration'] === "12")
                                                1 year
                                            @elseif($payment['duration'] === "24")
                                                2 years
                                            @elseif($payment['duration'] === "0")
                                                <span>Balance</span>

                                            @endif
                                        </td>

                                        <td>{{ $payment['last_payment'] !== null ? $payment['last_payment']->toFormattedDateString() : '' }}</td>
                                        <td>{{ $payment['next_payment'] !== null ? $payment['next_payment']->toFormattedDateString() : ''}}</td>
                                        <td>{{ $payment['last_bal_payment'] !== null ? $payment['last_bal_payment']->toFormattedDateString() : ''}}</td>
                                        <td>{{ $payment['next_bal_payment'] !== null ? $payment['next_bal_payment']->toFormattedDateString() : ''}}</td>



                                    </tr>
                                @endforeach
                                {{--    {{ $contributions->links('views.bootstrap-4') }}--}}

                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center"> No payments yet</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                            {{ $payments->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
