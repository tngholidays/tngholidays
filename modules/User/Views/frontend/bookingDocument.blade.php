@extends('layouts.user')
@section('head')
@endsection
@section('content')
    <h2 class="title-bar">
        {{__("Documents")}}
    </h2>
    @include('admin.message')
         
        <div class="row">
            @if(!empty($booking->documents))
            @foreach(json_decode($booking->documents) as $doc)
            <?php
                $ext = pathinfo($doc, PATHINFO_EXTENSION);
                $img = asset('uploads/booking_docs/'.$doc);
                if ($ext == 'pdf') {
                  $img = URL::asset('uploads/pdf_icon.png');
                }
            ?>
                <div class="col-md-3">
                    <div class="bookingDoc">
                        <img  width="100%" class="old" src="{{ $img }}" alt="{{$doc}}" />
                    <a href="{{ asset('uploads/booking_docs/'.$doc) }}" class="btn btn-primary btn-sm" download><i class="fa fa-download" aria-hidden="true"></i></a>
                    </div>
                </div>
            @endforeach
            @else 
            <div class="NotAvailable">
            <h1 class="NotAvailable12"> Documents are not Available </h1>
            </div>
            @endif
        </div>
@endsection
@section('footer')

@endsection
