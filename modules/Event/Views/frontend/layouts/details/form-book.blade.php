<div class="bravo_single_book_wrap @if(setting_item('event_enable_inbox')) has-vendor-box @endif">
    <div class="bravo_single_book">
        <div>
            @if($row->discount_percent)
                <!-- <div class="tour-sale-box">
                    <span class="sale_class box_sale sale_small">{{$row->discount_percent}}</span>
                </div> -->
            @endif
            <div class="form-head">
                <div class="price">
                    <span class="label">
                        {{__("from")}}
                    </span>
                    <span class="value">
                        <!-- <span class="onsale">{{ $row->display_sale_price }}</span> -->
                        <span class="text-lg">@{{display_price}}</span>
                    </span>
                </div>
            </div>
            <div class="nav-enquiry" v-if="is_form_enquiry_and_book">
                <div class="enquiry-item active" >
                    <span>{{ __("Book") }}</span>
                </div>
                <div class="enquiry-item" data-toggle="modal" data-target="#enquiry_form_modal">
                    <span>{{ __("Enquiry") }}</span>
                </div>
            </div>
            <div class="form-book" :class="{'d-none':enquiry_type!='book'}">
                <div class="form-content">
                   
                    <div class="form-group form-date-field form-date-search clearfix " data-format="{{get_moment_date_format()}}">
                        <div class="date-wrapper clearfix" @click="openStartDate">
                            <div class="check-in-wrapper">
                                <label>{{__("Start Date")}}</label>
                                <div class="render check-in-render">@{{start_date_html}}</div>
                            </div>
                            <i class="fa fa-angle-down arrow"></i>
                        </div>
                        <input type="text" class="start_date" ref="start_date" style="height: 1px; visibility: hidden">
                    </div>
                     <?php /*
                    <div class="" v-if="ticket_types">
                        <div class="form-group form-guest-search" v-for="(type,index) in ticket_types">
                            <div class="guest-wrapper d-flex justify-content-between align-items-center" :class="{'item-disable':type.max==0}">
                                <div class="flex-grow-1">
                                    <label>@{{type.name}}</label>
                                    <div class="render check-in-render">@{{type.desc}}</div>
                                    <div class="render check-in-render">@{{type.display_price}} {{__("per ticket")}}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="input-number-group">
                                        <i class="icon ion-ios-remove-circle-outline" @click="minusPersonType(type)"></i>
                                        <span class="input"><input type="number" v-model="type.number" min="1" @change="changePersonType(type)"/></span>
                                        <i class="icon ion-ios-add-circle-outline" @click="addPersonType(type)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> */ ?>

                    <div class="ticketsBox" v-if="selected_tickets">

                        <div class="select-ticket-row" v-for="(ticket,ticketIndex) in selected_tickets">
                            <div class="form-group">
                                <div class="form-guest-search">
                                    <div class="guest-wrapper d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <label>@{{ticket.title}}</label>
                                        </div>
                                        
                                        <i class="fa fa-angle-down arrow" @click="openPersonPicker($event)"></i>
                                        <br>

                                    </div>
                                </div>
                                
                                <div class="person-details" v-if="ticket.adult_ticket > 0 || ticket.child_ticket > 0">
                                    <div class="extra-price-wrap d-flex justify-content-between" v-if="ticket.adult_ticket > 0">
                                        <div class="flex-grow-1"><label>Adult x @{{ticket.adult_ticket}}</label></div>
                                        <div class="flex-shrink-0">@{{formatMoney(ticket.adult_price*ticket.adult_ticket)}}</div>
                                    </div>
                                    <div class="extra-price-wrap d-flex justify-content-between" v-if=" ticket.child_ticket > 0">
                                        <div class="flex-grow-1"><label>Adult x @{{ticket.child_ticket}}</label></div>
                                        <div class="flex-shrink-0">@{{formatMoney(ticket.child_price*ticket.child_ticket)}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="booking-details__rooms-wrap animated animated-fast fadeIn personPicker">
                                <div class="booking-details__rooms-text">Select Passengers
                                    <button class="booking-details__close-rooms-dropdown" type="button" @click="closePersonPicker($event)">Done</button>
                                </div>
                               <div class="form-group" v-if="ticket.timeslots">
                                  <select class="form-control" id="sel1" @change="selectTimeSlot(ticket, $event)">
                                    <!-- <option value="">Select Time Slot</option> -->
                                    <option v-for="(slot,slotIndex) in ticket.timeslots" v-bind:value="slot.id">
                                         @{{slot.time}}
                                    </option>
                                  </select>
                                </div>

                                <div class="booking-details__rooms-table">
                                    <div class="inventory">
                                        <div class="inventory__name-and-pricing-wrap">
                                            <div class="inventory__name">Adult</div>
                                            <div class="inventory__pricing">
                                                <div class="inventory__strike-through-amount">₹ @{{ticket.price}}</div>
                                                <div class="inventory__current-amount">₹  @{{ticket.adult_price}}</div>
                                            </div>
                                        </div>
                                        <div class="inventory__counter">
                                            <button type="button" class="inventory__counter-btn" @click="minusPersonTicket(ticket, ticketIndex, 'adult')">-</button>
                                            <span class="inventory__quantity">@{{ticket.adult_ticket}}</span>
                                            <button type="button" class="inventory__counter-btn" @click="addPersonTicket(ticket, ticketIndex, 'adult')">+</button>
                                        </div>
                                    </div>

                                    <div class="inventory">
                                        <div class="inventory__name-and-pricing-wrap">
                                            <div class="inventory__name">Child</div>
                                            <div class="inventory__pricing">
                                                <div class="inventory__strike-through-amount">₹ @{{ticket.price}}</div>
                                                <div class="inventory__current-amount">₹ @{{ticket.child_price}}</div>
                                            </div>
                                        </div>
                                        <div class="inventory__counter">
                                             <button type="button" class="inventory__counter-btn" @click="minusPersonTicket(ticket, ticketIndex, 'child')">-</button>
                                            <span class="inventory__quantity">@{{ticket.child_ticket}}</span>
                                            <button type="button" class="inventory__counter-btn" @click="addPersonTicket(ticket, ticketIndex, 'child')">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section-group form-group" v-if="extra_price.length">
                        <h4 class="form-section-title">{{__('Extra prices:')}}</h4>
                        <div class="form-group" v-for="(type,index) in extra_price">
                            <div class="extra-price-wrap d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <label><input type="checkbox" v-model="type.enable"> @{{type.name}}</label>
                                    <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                                </div>
                                <div class="flex-shrink-0">@{{type.price_html}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section-group form-group-padding" v-if="buyer_fees.length">
                        <div class="extra-price-wrap d-flex justify-content-between" v-for="(type,index) in buyer_fees">
                            <div class="flex-grow-1">
                                <label>@{{type.type_name}}
                                    <i class="icofont-info-circle" v-if="type.desc" data-toggle="tooltip" data-placement="top" :title="type.type_desc"></i>
                                </label>
                                <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="unit" v-if='type.unit == "percent"'>
                                    @{{ type.price }}%
                                </div>
                                <div class="unit" v-else >
                                    @{{ formatMoney(type.price) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="form-section-total list-unstyled" v-if="total_price > 0">
                    <li>
                        <label>{{__("Total")}}</label>
                        <span class="price">@{{total_price_html}}</span>
                    </li>
                    <li v-if="is_deposit_ready">
                        <label for="">{{__("Pay now")}}</label>
                        <span class="price">@{{pay_now_price_html}}</span>
                    </li>
                </ul>
                <div v-html="html"></div>
                <div class="submit-group" v-if="ticket_types">
                    <a class="btn btn-large" @click="doSubmit($event)" :class="{'disabled':onSubmit,'btn-success':(step == 2),'btn-primary':step == 1}" name="submit">
                        <span>{{__("BOOK NOW")}}</span>
                        <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                    </a>
                    <div class="alert-text mt10" v-show="message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></div>
                </div>
            </div>
            <div class="form-send-enquiry" v-show="enquiry_type=='enquiry'">
                <button class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">
                    {{ __("Contact Now") }}
                </button>
            </div>
        </div>
    </div>
</div>
@include("Booking::frontend.global.enquiry-form",['service_type'=>'event'])
