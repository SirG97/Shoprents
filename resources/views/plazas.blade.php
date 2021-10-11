@extends('layouts.base')
@section('title', 'Plazas')
@section('icon', 'fa-tachometer-a')
@section('content')
    <div class="container-fluid">

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

                                <th scope="col">Plaza name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Total shops</th>

                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody class="table-style">
                            @if(!empty($plazas) && count($plazas) > 0)
                                @foreach($plazas as $plaza)
                                    <tr>
{{--                                        <td scope="row">--}}

{{--                                            @if(\Carbon\Carbon::now() > $shop['next_payment'])--}}
{{--                                                <span class='pulse-button pulse-button-normal'></span>--}}
{{--                                                <span class="badge badge-danger">Due</span>--}}
{{--                                            @elseif($shop['next_payment'] < \Carbon\Carbon::now()->addMonth())--}}
{{--                                                <span class='pulse-button pulse-button-warn'></span>--}}
{{--                                                <span class="badge badge-warning">Almost Due</span>--}}
{{--                                            @else--}}
{{--                                                <span class="badge badge-success">Paid</span>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                        <td scope="row">{{ $plaza['name'] }}</td>

                                        <td>{{ $plaza['address'] }}</td>
                                        <td>{{ $plaza->shops_count }}</td>

                                        <td><a href="/plaza/{{ $plaza['id'] }}" class="btn btn-sm btn-primary">View shops</a></td>

                                    </tr>
                                @endforeach
                                {{--    {{ $contributions->links('views.bootstrap-4') }}--}}

                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center"> No Plazas yet</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                        {{ $plazas->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
