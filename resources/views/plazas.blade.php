@extends('layouts.base')
@section('title', 'Plazas')
@section('icon', 'fa-tachometer-a')
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

                                        <td>
                                            <a href="/plaza/{{ $plaza['id'] }}" class="btn btn-sm btn-primary">View shops</a>
                                            <a href="#" class="btn btn-sm btn-warning"
                                               data-toggle="modal"
                                               data-target="#editPlazaModal"
                                               data-id="{{ $plaza->id }}"
                                               data-name="{{ $plaza->name }}"
                                               data-address="{{ $plaza->address }}"
                                            >Edit</a>
                                        </td>

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

    <div class="modal fade bd-example-modal-lg" id="editPlazaModal" tabindex="-1" role="dialog" aria-labelledby="editPlazaLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="{{ route('plaza.edit') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Plaza details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                            <div class="col-md-12 mb-3">
                                <label for="balance">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="balance_due">Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="editPlazaBtn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
