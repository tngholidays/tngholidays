@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        @include('admin.message')
        <div class="lang-content-box">
            <div class="row">
                <div class="col-md-7">
					<div class="panel">

					    <div class="panel-body">
					    	<?php $version = "?var=".rand(); ?>
					    	<iframe src="{{ asset('voucher/proposalPDF.pdf') }}{{$version}}" width="100%" height="450px" title="voucher.pdf"></iframe>
						</div>
					</div>
                </div>
                <div class="col-md-5">
					<div class="panel">
					    <div class="panel-title">
					    	<strong>Mail</strong>
					    </div>

					    <div class="panel-body">
						    <form action="{{route('report.admin.viewProposal',['id'=>$enquiry->id,'action'=>'send_mail'])}}" method="post">
                  @csrf
						    	<table style="width: 100%;" cellpadding="0" cellspacing="0">
								    <tbody>
								    	<tr>
								            <td colspan="2">
								                <p>To:
								                <strong>{{$enquiry->email}}</strong>
								                </p>
								            </td>
								        </tr>
								        <tr>
								            <td>
								                <p>Person Name</p>
								                <p> <strong>{{$row->name}}</strong></p>
								            </td>
								            <td>
								                <p>Package Name</p>
								                <p> <strong>{{$tour->title}}</strong></p>
								            </td>
								        </tr>

								    </tbody>
								</table>
								<button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> {{__('Send Mail')}}</button>
							</form>

						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
