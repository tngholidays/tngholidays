@foreach ($attributes as $attribute)
    <?php
        $flag = false;
        if($attribute->type == 1 || $attribute->type == 3 || $attribute->type == 5){
            $flag = true;
        }
    ?>
    <div class="panel">
        <div class="panel-title"><strong>{{__('Attribute: :name',['name'=>$attribute->name])}}</strong></div>
        <div class="panel-body">
            <div class="terms-scrollable">
                @foreach($attribute->terms as $term)
                <?php 
                    $transfer_price = ($term->transfer_price > 0) ? floatval($term->transfer_price) : 0;
                    $term_price = ($term->price > 0) ? floatval($term->price) : 0;
                ?>
                    <label class="term-item">
                        <input @if(!empty($selected_terms) and $selected_terms->contains($term->id)) checked @endif price="{{$term_price}}" transfer="{{$transfer_price}}" type="checkbox" name="terms[]" @if($flag) class="SightSeeing" @endif value="{{$term->id}}">
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