@extends('layouts.backend')

@section('content')

    <div class="content">
        <div class="row">
            <div class="col">
                <h2>{{ $user->email }}</h2>
                @foreach($users as $user)
                    <p>{{$user->email}}</p>
                @endforeach
            </div>
        </div>
    </div>

@endsection