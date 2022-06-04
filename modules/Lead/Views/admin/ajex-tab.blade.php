@if($tab == 'reminder')
<div class="section-reminder">
<style>
    .feed-item.adminChat {
    width: 70%;
    float: right;
    padding: 0px !important;
    padding-left: 0px;
    padding-bottom: 0px;
    border-left: 0px !important;
}
.feed-item.userChat {
    width: 70%;
    float: left;
    padding: 0px !important;
    padding-left: 0px;
    padding-bottom: 0px;
    border-left: 0px !important;
}
</style>
    <br />
    <div class="booking-review">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2"><i class="fa fa-bell"></i> Add Reminder</button>
    </div>
    <table class="table table-proposals-lead dataTable no-footer" >
        <thead>
            <tr role="row">
                <th>#id</th>
                <th>Date/Time</th>
                <th>Message</th>
                <th>Status</th>
                <th>Created At.</th>
            </tr>
        </thead>
        <tbody>
            @if(count($reminders)>0)
            @foreach($reminders as $reminder)
            <tr>
                <td>#{{$reminder->enquiry_id}}</td>
                <td>{{$reminder->date}}</td>
                <td>{{$reminder->content}}</td>
                <td>{{$reminder->status}}</td>
                <td>{{$reminder->created_at}}</td>
            </tr>
            @endforeach
            @else
                <td valign="top" colspan="4" class="dataTables_empty">
                    No entries found
                </td>
            @endif
        </tbody>
    </table>
</div>
@elseif($tab == 'activity')
<div class="section-activity">                  
    <br />
    <div class="booking-review">
        <div class="activity-feed">
            @if(count($history)>0)
            @foreach($history as $his)
            <div class="feed-item">
                <div class="date">
                    <span class="text-has-action" data-toggle="tooltip" data-title="{{date("d M Y h:i A",strtotime($his->created_at))}}" data-original-title="" title=""> {{time_elapsed_string($his->created_at)}} ({{date("d M Y h:i A",strtotime($his->created_at))}})</span>
                </div>
                <div class="text">
                    @if($his->type == 'email')
                        E-Mail Sent - {{$his->content}}
                    @elseif($his->type == 'comment')
                        Comment Added - {{$his->content}}
                    @elseif($his->type == 'whatsapp')
                        Send Whatsapp Message - {{$his->content}}
                    @elseif($his->type == 'reminder')
                        Reminder Added - {{$his->content}}
                    @endif
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@elseif($tab == 'whatsapp')
    @if(count($whatsappchat)>0)
        @foreach($whatsappchat as $his)
        <div class="feed-item  @if($his->from_id=="917737887402@c.us") adminChat @else userChat @endif">
          <div class="date">
              <span class="text-has-action" data-toggle="tooltip" data-title="{{date("d M Y h:i A",strtotime($his->created_at))}}" data-original-title="" title=""> 
                
                {{time_elapsed_string($his->created_at)}} ({{date("d M Y h:i A",strtotime($his->created_at))}})</span>
          </div>
          <div class="text">
              <strong>
               @if($his->from_id=="917737887402@c.us")
                   Admin
               @else
                  {{$row->name}} 
                @endif
              </strong>
                <br/>
              Send Whatsapp Message - {{$his->message}}
             
          </div>
        </div>
        @endforeach
    @endif
@endif