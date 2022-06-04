@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        @include('admin.message')
        <div class="lang-content-box">
            <div class="row">
                <div class="col-md-12">
					<div class="panel">
						 <div class="panel-title">
					    	<strong>Documents</strong>
					    </div>
					    <div class="panel-body">
							<form action="{{route('report.admin.storeDocuments',['id'=>$booking->id,'lang'=>request()->query('lang')])}}" method="post" enctype="multipart/form-data">
        						@csrf
        						<div class="row">
	<!-- 							    <div class="col-lg-12">
								        <div class="form-group">
								        	<input type="file" id="documentsUpload" name="file" class="form-control" multiple />
								        </div>
								    </div> -->
								    <div class="form-group">
									    <label>Upload Documents</label>
									    <div class="dungdt-upload-box dungdt-upload-box-normal" data-val="">
									        <div class="upload-box" v-show="!value">
									            <input type="hidden" name="image_id" v-model="value" value="" />
									            <div class="text-center"></div>
									            <div class="text-center">
									                <input type="file" id="documentsUpload" name="file[]" class="form-control" multiple />
									            </div>
									        </div>
									        <div class="attach-demo" title="Change file"></div>
									        <div class="upload-actions justify-content-between" v-show="value">
									            <span></span>
									            <a class="delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
									        </div>
									    </div>
									</div>
								    <div class="col-lg-12">
								    	<div class="form-group ImageeSction">
								    		<ul id="adminDoc">
								    			@if(!empty($booking->documents))
									    			@foreach(json_decode($booking->documents) as $doc)
									    			<?php
									    				$ext = pathinfo($doc, PATHINFO_EXTENSION);
									    				$img = asset('uploads/booking_docs/'.$doc);
									    				if ($ext == 'pdf') {
				                                          $img = URL::asset('uploads/pdf_icon.png');
				                                        }
									    			?>
									    				<li class="old">
									    					<img id="blah" width="100" class="old" src="{{ $img }}" alt="your image" />
									    					<input type="hidden" name="old_file[]" value="{{$doc}}">
									    					<span class="fileDelete"><i class="fa fa-times" aria-hidden="true"></i></span>
									    					<a href="{{asset('uploads/booking_docs/'.$doc)}}" class="btn btn-primary btn-sm" download=""><i class="fa fa-download" aria-hidden="true"></i></a>
									    				</li>
									    			@endforeach
								    			@endif
								    		</ul>
									    </div>
								    </div>
								    <div class="col-lg-12">
		                                <button class="btn btn-primary" type="submit">Save</button>
		                            </div>
								</div>
        					</form>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
