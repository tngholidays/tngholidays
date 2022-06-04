@extends ('layouts.app')
@section ('content')
    @if($row->template_id)
        <div class="container" @if(!empty($translation->content))style="padding-top: 40px;padding-bottom: 40px;" @endif>
            <div class="blog-content">
                {!! $translation->content !!}
            </div>
        </div>
        <div class="page-template-content">
            {!! $row->getProcessedContent() !!}
        </div>
    @else

        <div class="container @if(empty($translation->content)) ReadMoreData @endif" style="padding-top: 40px;padding-bottom: 40px;">
            <h1>{!! clean($translation->title) !!}</h1>
            <div class="blog-content">
                {!! $translation->content !!}
            </div>
        </div>
    @endif
  @if(Route::currentRouteName() == null)
    <div class="modal fade" role="dialog" id="enquiryModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Do you have any enquiry ?</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <iframe loading="lazy" width="100%" height="650" src="https://tngholidays.com/embed_enquiry" frameborder="0" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
</div>
<div id="tng-widget"></div>
@endif

@endsection
