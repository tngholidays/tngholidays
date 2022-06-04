@extends('Email::layout')
@section('content')

    <div class="b-container">
        <div class="b-panel">
            <h3 class="email-headline"><strong>Dear, {{@$row->name}}</strong></h3>
            <p>Good day, and I hope you are well! </p>
            <br>
            <p>Thank you for choosing TNG Holidays. Over the years, we have helped people create beautiful travel memories, just like we hope to do for you.</p>
            <br>
            <h5>Your Inquiry for Following Details:-</h5>
            <div class="b-panel">
                <div class="b-table-wrap">
                    <table class="b-table" cellspacing="0" cellpadding="0">
                        <tr class="info-first-name">
                            <td class="label">Destination </td>
                            <td class="val">{{@getLocationById(@$row->destination)->name}}</td>
                        </tr>
                        <tr class="info-first-name">
                            <td class="label">Duration </td>
                            <td class="val">{{@getDurationById(@$row->duration)->name}}</td>
                        </tr>
                        <tr class="info-first-name">
                            <td class="label">No of Person </td>
                            <td class="val">
                                <p> <strong>Adult : {{isset($row->person_types[0]['name']) ? $row->person_types[0]['number'] : 0}} x Participant</strong></p>
                                <p> <strong>Child : {{isset($row->person_types[1]['name']) ? $row->person_types[1]['number'] : 0}} x Participant</strong></p>
                                <p> <strong>Kid : {{isset($row->person_types[2]['name']) ? $row->person_types[2]['number'] : 0}} x Participant</strong></p>
                            </td>
                        </tr>
                        <tr class="info-first-name">
                            <td class="label">Approx Journey Date  </td>
                            <td class="val">{{@$row->approx_date}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <p><strong>Please do contact us if you have additional queries. Thanks again!</strong></p>
            <p><strong>Best regards</strong></p>
            <p><strong>“TNG Holidays”</strong></p>

        </div>
    </div>
@endsection

