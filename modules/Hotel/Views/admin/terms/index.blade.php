@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Attribute: :name",['name'=>$attr->name])}}</h1>
            <div class="title-actions">
                <a class="btn btn-info btn-icon" href="{{route('hotel.admin.attribute.term.addTerm', $attr->id)}}" title="Add Term"> Add Term </a>
            </div>

        </div>
        @include('admin.message')
        <div class="row">
            <div class="col-md-12">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        @if(!empty($rows))
                            <form method="post" action="{{route('hotel.admin.attribute.term.editTermBulk')}}" class="filter-form filter-form-left d-flex justify-content-start">
                                {{csrf_field()}}
                                <select name="action" class="form-control">
                                    <option value="">{{__(" Bulk Action ")}}</option>
                                    <option value="delete">{{__(" Delete ")}}</option>
                                </select>
                                <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                            </form>
                        @endif
                    </div>
                    <div class="col-left">
                        <form method="get" action="{{ route('hotel.admin.attribute.term.index',['attr_id' => $attr->id]) }} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
                            <input type="text" name="s" value="{{ Request()->s }}" class="form-control" placeholder="{{__("Search by name")}}">
                            <button class="btn-info btn btn-icon btn_search" id="search-submit" type="submit">{{__('Search')}}</button>
                        </form>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-title">{{__("All Terms")}}</div>
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th>{{__("Name")}}</th>
                                    <th>{{__("Price")}}</th>
                                    <th>{{__("Transfer Price")}}</th>
                                    <th>{{__("Inclusions")}}</th>
                                    <th>{{__("Exlude")}}</th>
                                    <th class="date">{{__("Date")}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows) > 0)
                                    @foreach ($rows as $row)
                                        <tr>
                                            <td><input type="checkbox" class="check-item" name="ids[]" value="{{$row->id}}"></td>
                                            <td class="title">
                                                <a href="{{route('hotel.admin.attribute.term.edit', ['id' => $row->id])}}">{{$row->name}}</a>
                                            </td>
                                            <td class="title">{{format_money($row->price)}}</td>
                                            <td class="title">{{format_money($row->transfer_price)}}</td>
                                            <td class="title">
                                                @if(!empty($row->inclusions))
                                                     @foreach ($row->inclusions as $inclu)
                                                     {{ getInclusions($inclu) }},
                                                     @endforeach
                                                 @endif
                                            </td>
                                            <td class="title">{{$row->exclude}}</td>
                                            <td>{{ display_date($row->updated_at)}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">{{__("No data")}}</td>
                                    </tr>
                                @endif
                                </tbody>
                                {{$rows->appends(request()->query())->links()}}
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
