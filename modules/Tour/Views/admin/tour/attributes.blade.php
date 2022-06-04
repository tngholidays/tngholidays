@foreach ($attributes as $attribute)
    <div class="panel">
        <div class="panel-title"><strong>{{__('Attribute: :name',['name'=>$attribute->name])}}</strong></div>
        <div class="panel-body">
            <div class="terms-scrollable">
                @foreach($attribute->terms as $term)
                    <label class="term-item">
                        <input @if(!empty($selected_terms) and $selected_terms->contains($term->id)) checked @endif price="{{$term->price}}" transfer="{{$term->transfer_price}}" type="checkbox" name="terms[]" class="SightSeeing" value="{{$term->id}}">
                        <span class="term-name">
                            {{$term->name}} 
                            @if(!empty($term->price)) Sightseen: ({{format_money($term->price)}}) @endif
                            @if(!empty($term->transfer_price)) Transfer: ({{format_money($term->transfer_price)}}) @endif
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
@endforeach