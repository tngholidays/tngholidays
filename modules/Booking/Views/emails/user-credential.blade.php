@extends('Email::layout')
@section('content')
    <div class="b-container">
        <div class="b-panel">
            <h1>Hello {{$userData['first_name'].' '.$userData['last_name']}}</h1>

            <p>{{__('You are successfully Registered on TNG holidays.')}}</p>
            <p>{{__('You login login credentials are here. please login:')}} <a href="{{url('login')}}">{{__('Login')}}</a></p>

            <p><strong>E-Mail: {{$userData['email']}}</strong></p>
            <p><strong>Password: {{$userData['password']}}</strong></p>

            <br>
            <p>{{__('Regards')}},<br>{{setting_item('site_title')}}</p>
        </div>
    </div>
@endsection
