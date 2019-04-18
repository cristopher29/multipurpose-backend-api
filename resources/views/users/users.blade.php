@extends('layouts.backend')

@section('content')

    <div class="content">
        <div class="row">
            <div class="col">

                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">Default Table</h3>
                        <div class="block-options">
                            <div class="block-options-item">
                                <code>.table</code>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">ID</th>
                                    <th>Email</th>
                                    <th>Token</th>
                                    <th>Expires at</th>
                                    <th class="text-center" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users_data as $data)
                                <tr>
                                    <th class="text-center" scope="row">{{ $data['user']->id }}</th>
                                    <td class="font-w600 font-size-sm">
                                        {{ $data['user']->email }}
                                    </td>
                                    <td class="font-w100 font-size-sm">
                                        <code class="json hljs text-wrap">
                                            {{ $data['token'] }}
                                        </code>
                                    </td>
                                    <td class="font-w600 font-size-sm">
                                        {{ $data['time'] }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit Client">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Remove Client">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection