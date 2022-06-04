@extends('layouts.user')
@section('head')
@endsection
@section('content')
    <h2 class="title-bar">
        {{__("Add Guest Details")}}
    </h2>
    @include('admin.message')
         <form action="{{route('user.booking.storeGuestDetails',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
            <input type="hidden" name="booking_id" value="{{$booking->id}}">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('Report::admin/booking/guest-form')
            </div>
        @if($row->status != "publish")
            <div class="col-md-12">
                <hr>
                <input type="submit" class="btn btn-primary" value="{{__("Save")}}">
            </div>
        @endif
        </div>
    </form>
@endsection
@section('footer')

@endsection
