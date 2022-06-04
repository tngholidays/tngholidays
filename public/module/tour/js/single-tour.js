(function ($) {
// var component = Vue.component('testcomponent',{
//    template : '<div class="code-block"> <div class="img-block"> <i class="fa fa-gift" aria-hidden="true"></i> <span class="coupon-code">Test</span> </div> <button class="btn btn-sm btn-primary">APPLY</button> </div> <div class="note-block"> <span class="coupon-note"> note nest </span> </div>',
//    data: function() {
//       return {
//          name : "Ria"
//       }
//    },
//    methods:{
//       changename : function() {
//          this.name = "Ben";
//       },
//       originalname: function() {
//          this.name = "Ria";
//       },
//       applyCoupon: function() {
//          this.name = "Ria";
//       }
//    }
// });
Vue.component('card1', {
  template: '<div>Card:<span style="background-color:green">{{title}}</span></div>',
  props: ['title']
})

Vue.component('card2', {
  template: '<div>Card:<span style="background-color:blue">{{title}}</span></div>',
  props: ['title']
})

Vue.component('card3', {
  template: '<div>Card:<span style="background-color:yellow">{{title}}</span></div>',
  props: ['title']
})

   var vuejsArray =  new Vue({
        el:'#bravo_tour_book_app',
        data:{
            id:'',
            extra_price:[],
            person_types:[],
            default_hotels:[],
            by_default_hotels:[],
            itineraries:[],
            message:{
                content:'',
                type:false
            },
            html:'',
            onSubmit:false,
            start_date:'',
            start_date_html:'',
            step:1,
            guests:1,
            price:0,
            total_price_before_fee:0,
            total_price_before_extra:0,
            total_price_fee:0,
            max_guests:1,
            total_guests:2,
            roomadults:1,
            roomchildren:0,
            hotelrooms:[],
            currentTarget:"",
            start_date_obj:'',
            duration:0,
            allEvents:[],
			buyer_fees:[],
            modifyPrice:0,
            total_modifyPrice:0,
            modify_in:true,
            couponPrice:0,
            activityPrice:0,
            removeActivityPrice:0,
            removeTrnasferPrice:0,
            default_hotel_price:0,
            total_room_price:0,
            is_form_enquiry_and_book:false,
            enquiry_type:'book',
            enquiry_is_submit:false,
            enquiry_name:"",
            enquiry_email:"",
            enquiry_phone:"",
            enquiry_note:"",
            enterCouponCode:"",
            custom_coupons: [],
            applied_coupon: "",
        },
        watch:{
            extra_price:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            start_date(){
                this.step = 1;
            },
            guests(){
                this.step = 1;
            },
            person_types:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            default_hotels:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            by_default_hotels:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
        },
        computed:{
            total_price:function(){
                var me = this;
                this.roomPriceCalculate();
                if (me.start_date !== "") {
                    var total = 0;
                    var total_guests = 0;
                    var startDate = new Date(me.start_date).getTime();
                    for (var ix in me.allEvents) {
                        var item = me.allEvents[ix];
                        var cur_date = new Date(item.start).getTime();
                        if (cur_date === startDate) {
                            if (item.person_types != null) {
                                me.person_types = Object.assign([], item.person_types);
                            } else {
                                me.person_types = null
                            }
                            if (item.default_hotels != null) {
                                me.default_hotels = Object.assign([], item.default_hotels);
                            } else {
                                me.default_hotels = null
                            }
                            if (item.default_hotels != null) {
                                me.by_default_hotels = Object.assign([], item.default_hotels);
                            } else {
                                me.by_default_hotels = null
                            }
                            me.max_guests = parseInt(item.max_guests);
                            me.price = parseFloat(item.price);
                        }
                    }
                    // for person types
                    if (me.person_types != null) {
                        for (var ix in me.person_types) {
                            var person_type = me.person_types[ix];
                            total += parseFloat(person_type.price) * parseInt(person_type.number);
                            total_guests += parseInt(person_type.number);
                             me.total_guests = total_guests;
                        }
                    }else{
                        // for default
                        total_guests = me.guests;
                        me.total_guests = total_guests;
                        total += me.guests * me.price;
                    }
                    if (this.default_hotel_price > 0) {
                        total -= this.default_hotel_price;
                    }
                    if (this.total_room_price > 0) {
                        total += this.total_room_price;
                    }

                    me.total_price_before_extra = total;
                    if (me.couponPrice > 0) {
                       total =  total-me.couponPrice;
                    }
                    for (var ix in me.extra_price) {
                        var item = me.extra_price[ix];
                        var type_total = 0;
                        if (item.enable === true) {
                            switch (item.type) {
                                case "one_time":
                                    type_total += parseFloat(item.price);
                                    break;
                                case "per_hour":
                                    if (me.duration > 0) {
                                        type_total += parseFloat(item.price) * parseFloat(me.duration);
                                    }
                                    break;
                                case "per_day":
                                    if (me.duration > 0) {
                                        type_total += parseFloat(item.price) * Math.ceil(parseFloat(me.duration) / 24);
                                    }
                                    break;
                            }
                            if (typeof item.per_person !== "undefined") {
                                type_total = type_total * total_guests;
                            }
                            total += type_total;
                        }
                    }

                    this.total_price_before_fee = total;
                    // if (this.modify_in) {
                    //     total  = total + this.total_modifyPrice;
                    // }else {
                    //     total  = total - this.total_modifyPrice;
                    // }
                    if (this.activityPrice > 0) {
                        total  += this.activityPrice * this.total_guests;
                    }
                    if (this.removeActivityPrice > 0) {
                        total  -= this.removeActivityPrice * this.total_guests;
                    }
                    
                    var total_fee = 0;
                    for (var ix in me.buyer_fees) {
                        var item = me.buyer_fees[ix];

                        //for Fixed
                        var fee_price = parseFloat(item.price);

                        //for Percent
                        if (typeof item.unit !== "undefined" && item.unit === "percent" ) {
                            fee_price = ( total / 100 ) * fee_price;
                        }

                        if (typeof item.per_person !== "undefined") {
                            fee_price = fee_price * total_guests;
                        }
                        total_fee += fee_price;
                    }
                    total += total_fee;
                    this.total_price_fee = total_fee;
                    return total;
                }
                return 0;
            },
            total_price_html:function(){
                if(!this.total_price) return '';
                return window.bravo_format_money(this.total_price);
            },
            daysOfWeekDisabled(){
                var res = [];

                for(var k in this.open_hours)
                {
                    if(typeof this.open_hours[k].enable == 'undefined' || this.open_hours[k].enable !=1 ){

                        if(k == 7){
                            res.push(0);
                        }else{
                            res.push(k);
                        }
                    }
                }

                return res;
            },
            pay_now_price:function(){
                if(this.is_deposit_ready){
                    var total_price_depossit = 0;

                    var tmp_total_price = this.total_price;
                    var deposit_fomular = this.deposit_fomular;
                    if(deposit_fomular === "deposit_and_fee"){
                        tmp_total_price = this.total_price_before_fee;
                    }

                    switch (this.deposit_type) {
                        case "percent":
                            total_price_depossit =  tmp_total_price * this.deposit_amount / 100;
                            break;
                        default:
                            total_price_depossit =  this.deposit_amount;
                    }
                    if(deposit_fomular === "deposit_and_fee"){
                        total_price_depossit = total_price_depossit + this.total_price_fee;
                    }

                    return  total_price_depossit
                }
                return this.total_price;
            },
            pay_now_price_html:function(){
                
                return window.bravo_format_money(this.pay_now_price);
                
            },
            modify_price:function(){
                var total = 0;
                if (this.person_types != null) {
                    for (var ix in this.person_types) {
                        var person_type = this.person_types[ix];
                        total += parseFloat(this.modifyPrice) * parseInt(person_type.number);
                    }
                }else{
                    total += this.guests * this.modifyPrice;
                }
                this.total_modifyPrice = total;
                var totalM = total;
                total = window.bravo_format_money(total);
                var totalP = 0;
                if (this.modify_in) {
                    totalP = parseFloat(this.total_price_before_fee) + parseFloat(totalM);
                }else {
                    totalP = parseFloat(this.total_price_before_fee) - parseFloat(totalM);
                }
                if (this.total_price_before_fee > totalP) {
                    total  = "- "+total;
                }else{
                     total  = "+ "+total;
                }
                return total;
            },
            is_deposit_ready:function () {
                if(this.deposit && this.deposit_amount) return true;
                return false;
            },
            is_coupon_ready:function () {
                if(this.total_price_before_fee > 0) return true;
                return false;
            },
            is_modify_ready:function () {
                // if(this.modifyPrice && this.modifyPrice) return true;
                return false;
            }
        },
        created:function(){
            for(var k in bravo_booking_data){
                this[k] = bravo_booking_data[k];
            }
        },
        mounted(){
            var me = this;
            /*$(".bravo_tour_book").sticky({
                topSpacing:30,
                bottomSpacing:$(document).height() - $('.end_tour_sticky').offset().top + 40
            });*/

            var options = {
                singleDatePicker: true,
                showCalendar: false,
                sameDate: true,
                autoApply           : true,
                disabledPast        : true,
                dateFormat          : bookingCore.date_format,
                enableLoading       : true,
                showEventTooltip    : true,
                classNotAvailable   : ['disabled', 'off'],
                disableHightLight: true,
                minDate:this.minDate,
                opens: bookingCore.rtl ? 'right':'left',
                locale:{
                    direction: bookingCore.rtl ? 'rtl':'ltr',
                    firstDay:daterangepickerLocale.first_day_of_week
                },
                isInvalidDate:function (date) {
                    for(var k = 0 ; k < me.allEvents.length ; k++){
                        var item = me.allEvents[k];
                        if(item.start == date.format('YYYY-MM-DD')){
                            return item.active ? false : true;
                        }
                    }
                    return false;
                }
            };

            if (typeof  daterangepickerLocale == 'object') {
                options.locale = _.merge(daterangepickerLocale,options.locale);
            }
            this.$nextTick(function () {
                $(this.$refs.start_date).daterangepicker(options).on('apply.daterangepicker',
                    function (ev, picker) {
                        me.start_date = picker.startDate.format('YYYY-MM-DD');
                        var pathname = window.location.pathname; // Returns path only (/path/example.html)
                        var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
                        var origin   = window.location.origin;
                        var fullUrl = origin+''+pathname+'?start='+me.start_date+'&end='+me.start_date+'';
                        window.location.href = fullUrl;
                        me.couponPrice = 0;
                        me.removeApplyCoupon();
                        me.start_date = picker.startDate.format('YYYY-MM-DD');
                        me.start_date_html = picker.startDate.format(bookingCore.date_format);
                    })
                    .on('update-calendar',function (e,obj) {
                        me.fetchEvents(obj.leftCalendar.calendar[0][0], obj.leftCalendar.calendar['lastDay'])
                    });
            });
        },
        methods:{
            handleTotalPrice: function () {
            },
            fetchEvents(start,end){
                var me = this;
                var data = {
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    id:bravo_booking_data.id,
                    default_hotels:me.default_hotels,
                    tour_summary:me.default_hotels,
                    for_single:1
                };
                $.ajax({
                    url: bravo_booking_i18n.load_dates_url,
                    dataType:"json",
                    type:'get',
                    data:data,
                    beforeSend: function() {
                        $('.daterangepicker').addClass("loading");
                    },
                    success:function (json) {
                        me.allEvents = json;
                        var drp = $(me.$refs.start_date).data('daterangepicker');
                        drp.allEvents = json;
                        drp.renderCalendar('left');
                        if (!drp.singleDatePicker) {
                            drp.renderCalendar('right');
                        }
                        $('.daterangepicker').removeClass("loading");
                    },
                    error:function (e) {
                        console.log("Can not get availability");
                    }
                });
            },
            formatMoney: function (m) {
                return window.bravo_format_money(m);
            },
            validate(){
                if(!this.start_date)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_date_select;
                    return false;
                }
                return true;
            },
            addPersonType(type){
                type.number = parseInt(type.number);
                if(type.number < parseInt(type.max) || !type.max) type.number +=1;
                
            },
            minusPersonType(type){
                type.number = parseInt(type.number);
                if(type.number > type.min) type.number -=1;

            },
            changePersonType(type){
                type.number = parseInt(type.number);
                if(type.number > parseInt(type.max)){
                    type.number = type.max;
                }
                if(type.number < type.min){
                    type.number = type.min
                }
            },
            addGuestsType(){
                var me = this;
                if(me.guests < parseInt(me.max_guests) || !me.max_guests) me.guests +=1;
            },
            minusGuestsType(){
                var me = this;
                if(me.guests > 1) me.guests -=1;
            },
            addRoomPersonType(type, index){
                var me = this;
                var room = me.hotelrooms[index];
                if (type == "adults" && room.adults < 3) {
                    room.adults ++ ;
                    if (room.adults == 3) {room.children = 0;}
                    
                }
                if (type == "children" && room.children < 2 && room.adults <= 2) {
                    room.children ++;
                }
                
                // this.handleTotalPrice();
            },
            minusRoomPersonType(type, index){
                var me = this;
                var room = me.hotelrooms[index];
                switch (type){
                    case "adults":
                        if(room.adults  >=2){
                            room.adults --;
                        }
                        break;
                    case "children":
                        if(room.children  >=1){
                            room.children --;
                        }
                        break;
                }
                // this.handleTotalPrice();
            },

            addMoreRoom(){
                var me = this;
                var totalRoom = parseFloat(me.hotelrooms.length)+1;
                var room = {'adults':2,'children':0,'room':totalRoom};
                me.hotelrooms.push(room);
                // this.handleTotalPrice();
            },
            removeRoom(index){
                var me = this;
                me.hotelrooms.splice(index,1);
                // this.handleTotalPrice();
            },
            roomPriceCalculate(){
                var me = this;
                var adults = 0;
                var childs = 0;
                if (me.hotelrooms.length > 0) {
                    jQuery.each(me.hotelrooms, function(index, item) {
                        adults += item.adults;
                        childs += item.children;
                    });
                }

                if (me.person_types != null) {
                    for (var ix in me.person_types) {
                        var person_type = me.person_types[ix];
                        if (person_type.name == "Adult") {
                            person_type.number = adults;
                        }
                        if (person_type.name == "Child") {
                            person_type.number = childs;
                        }
                    }
                }

                var hotelPrice = 0;
                jQuery.each(me.by_default_hotels, function(index, item) {
                    hotelPrice += parseFloat(item.total_price);
                });

                if (adults == 1) {
                    me.default_hotel_price = hotelPrice;
                }else{
                    me.default_hotel_price = hotelPrice*adults;
                }
                if (childs > 0) {
                    var childPrice = hotelPrice / 2;
                     me.default_hotel_price += childPrice * childs;
                }

                var newHotelPrice = 0;
                jQuery.each(me.default_hotels, function(index, item) {
                    newHotelPrice += parseFloat(item.total_price);
                });

                var singleAdultPrice = newHotelPrice;
                var totalHotelPrice = 0;

                if (me.hotelrooms.length > 0) {
                    jQuery.each(me.hotelrooms, function(index, item) {

                        if (item.adults > 1) {
                            totalHotelPrice += singleAdultPrice * item.adults;
                        }else{
                            totalHotelPrice += singleAdultPrice * 2;
                        }


                        if (item.adults > 1 && item.children == 1) {
                            totalHotelPrice += (singleAdultPrice / 2);
                        }else if (item.children > 1) {
                            totalHotelPrice += singleAdultPrice;
                        }

                        item.price = totalHotelPrice;
                    });
                }
                me.total_room_price = totalHotelPrice;
                // this.handleTotalPrice();
            },
            openHotelsModel(event, index){
                $('.loading-all').show();
                var me = this;
                var current = event.currentTarget;
                me.currentTarget = current;
                var default_hotels = me.default_hotels[index];
                default_hotels['default_room_price'] = me.by_default_hotels[index].total_price;
                $.ajax({
                    url:bookingCore.url + '/getChangeHotels',
                    dataType:"HTML",
                    type:'POST',
                    data:{
                        'default_hotels':default_hotels,'total_guest':me.total_guests,'start_date':me.start_date
                    },
                    success:function (data) {
                       $('#change_booking_hotel').html(data);
                       $('#change_booking_hotel').modal('show');
                       $('.loading-all').hide();
                    },
                    error:function (e) {
                        console.log(e);
                        console.log("Can not get availability");
                    }
                });
            },
            openRoomsModel(event, index){
                console.log(this);
                $('.loading-all').show();
                var me = this;
                var current = event.currentTarget;
                me.currentTarget = current;
                var default_hotels = me.default_hotels[index];
                default_hotels['default_room_price'] = me.by_default_hotels[index].total_price;
                $.ajax({
                    url:bookingCore.url + '/getChangeRooms',
                    dataType:"HTML",
                    type:'POST',
                    data:{
                        'default_hotels':default_hotels,'total_guest':me.total_guests,'start_date':me.start_date
                    },
                    success:function (data) {
                       $('#change_booking_room').html(data);
                       $('#change_booking_room').modal('show');
                       $('#change_booking_room').find('#changeFromHotel').val('');
                       $('.loading-all').hide();
                    },
                    error:function (e) {
                        console.log(e);
                        console.log("Can not get availability");
                    }
                });
            },
            openRoomsModelJquery(event, default_hotels){
                $('.loading-all').show();
                var me = this;
                default_hotels = JSON.parse(default_hotels);
                console.log(default_hotels);
                $.ajax({
                    url:bookingCore.url + '/getChangeRooms',
                    dataType:"HTML",
                    type:'POST',
                    data:{
                        'default_hotels':default_hotels,'total_guest':me.total_guests,'start_date':me.start_date
                    },
                    success:function (data) {
                       $('#change_booking_room').html(data);
                       $('#change_booking_room').modal('show');
                       $('#change_booking_room').find('#changeFromHotel').val(JSON.stringify(default_hotels));
                       $('.loading-all').hide();
                    },
                    error:function (e) {
                        console.log(e);
                        console.log("Can not get availability");
                    }
                });
            },
            openActivityModel(event, index){
                // $('.loading-all').show();
                var me = this;
                var currentRow = me.itineraries[index];
                var current = event.currentTarget;
                me.currentTarget = current;
                var last_activity = [];
                var all_ids = [];
                var duration = 0;

                

                if (me.itineraries != null && me.itineraries.length > 0) {
                    jQuery.each(me.itineraries, function(index, item) {
                        if (item.morning_activity != null && item.morning_activity.length > 0) {
                            jQuery.each(item.morning_activity, function(index2, item2) {
                                all_ids.push(item2.id);
                            });
                        }
                        if (item.activity != null && item.activity.length > 0) {
                            jQuery.each(item.activity, function(index2, item2) {
                                all_ids.push(item2.id);
                            });
                        }
                        if (item.evening_activity != null && item.evening_activity.length > 0) {
                            jQuery.each(item.evening_activity, function(index2, item2) {
                                all_ids.push(item2.id);
                            });
                        }
                    });
                }
                if (currentRow.activity != null && currentRow.activity.length > 0) {
                    jQuery.each(currentRow.activity, function(index, item) {
                        duration += parseFloat(item.duration);
                        last_activity.push(item.id);
                    });

                }
                
                // currentRow.activity.push(currentRow.activity[0]);
                // var default_hotels = me.default_hotels[index];
                // default_hotels['default_room_price'] = me.by_default_hotels[index].total_price;
                $.ajax({
                    url:bookingCore.url + '/getTourActivities',
                    dataType:"HTML",
                    type:'POST',
                    data:{
                        'tour_id':me.id,'duration':duration,'all_ids':all_ids,'last_activity':last_activity,'location':currentRow.location_id,'attribute':currentRow.itinerary.attribute,'index':index
                    },
                    success:function (data) {
                       $('#change_tour_activity').html(data);
                       $('#change_tour_activity').modal('show');
                       // $('#change_tour_activity').find('#changeFromHotel').val('');
                       $('.loading-all').hide();
                    },
                    error:function (e) {
                        console.log(e);
                        console.log("Can not get availability");
                    }
                });
            },
            removeActivity(event, index, actIndex, timezone) {
                var me = this;
                var currentRow = me.itineraries[index];
                if (timezone == 1) {
                    var activity = currentRow.morning_activity;
                }else if(timezone == 3){
                    var activity = currentRow.evening_activity;
                }else {
                    var activity = currentRow.activity;
                }
                var price = activity[actIndex].price||0;
                var transfer_price = activity[actIndex].transfer_price||0;
                var totalP = parseFloat(price)+parseFloat(transfer_price);
                me.removeActivityPrice = parseFloat(me.removeActivityPrice) + parseFloat(totalP);
                me.removeTrnasferPrice = parseFloat(transfer_price);
                activity.splice(actIndex,1);
            },
            removeApplyCoupon() {
                $('.coupon-block').closest('.coupon-block').find('.coupon-list').removeClass('active');
                $('.coupon-block').closest('.coupon-block').find('button').text('APPLY');
            },
            applyCoupon(coupon, tourCoupon = null, event){
                var me = this;
                if (tourCoupon == "") {
                    coupon = JSON.parse(coupon);
                }
                var current = event.currentTarget;
                me.currentTarget = current;
                if ($(current).closest('.coupon-list').hasClass("active")) {
                     $(current).closest('.coupon-block').find('.coupon-list').removeClass('active');
                     $(current).closest('.coupon-block').find('button').text('APPLY');
                     me.couponPrice = 0;
                }else{
                    var flag = true;
                    var msg = "";
                    if (me.total_guests < tourCoupon.min_pax) {
                    flag = false;
                    msg += '<p>coupon apply on total guest '+tourCoupon.min_pax+'</p>';
                    }
                    if (parseFloat(me.total_price_before_extra) < parseFloat(tourCoupon.min_price)) {
                        flag = false;
                        msg += '<p>coupon apply when Billing Amount is '+tourCoupon.min_price+'</p>';
                    }
                    if (flag == true) {
                        $('.errorMsg').find('p').remove();
                        var discount = coupon.discount;
                        if (coupon.discount_type == 2) {
                            discount =  parseFloat(me.total_price_before_extra * coupon.discount)/100;
                        }
                        me.couponPrice = discount;
                        me.removeApplyCoupon();
                        $(current).text('APPLIED');
                        $(current).append('<span class="removeCoupon"><i class="fa fa-times" aria-hidden="true"></i></span>');
                        $(current).closest('.coupon-list').addClass('active');
                        me.applied_coupon = coupon;
                    }else{
                        $('.errorMsg').find('p').remove();
                        $('.errorMsg').append(msg);
                    }
                }
            },
            applyCouponByText(){
                var me = this;
                if (me.enterCouponCode == "") {
                    $('.cpnInput input').css({"color": "red", "border": "1px solid red"});
                    return false;
                }
                var flag = true;
                $(".coupon-block .coupon-list").each(function(){
                    if ($(this).find('.coupon-code').text() == me.enterCouponCode) {
                        $(this).find('button').click();
                        me.enterCouponCode = "";
                        flag = false;
                        return false;
                    }
                });
                if (flag == true) {
                    $.ajax({
                    url:bookingCore.url + '/applyCouponCode',
                    dataType:"JSON",
                    type:'POST',
                    data:{
                        'code':me.enterCouponCode
                    },
                        success:function (data) {
                            if (data == 0) {
                                $('.cpnInput input').css({"color": "red", "border": "1px solid red"});
                                return false;
                            }else{
                                $('.cpnInput input').css({"color": "", "border": ""});
                                data['couponDetail'] = JSON.stringify(data);
                                me.custom_coupons.push(data);
                                me.enterCouponCode = "";
                                setTimeout(function(){ $('.customeCouponList .code-block').find('button').click(); }, 100);
                            }
                        },
                        error:function (e) {
                            console.log(e);
                            console.log("Can not get availability");
                        }
                    });
                }
            },
            doSubmit:function (e) {
                e.preventDefault();
                if(this.onSubmit) return false;

                if(!this.validate()) return false;

                this.onSubmit = true;
                var me = this;

                this.message.content = '';

                if(this.step == 1){
                    this.html = '';
                }
                var modify_activity = {
                    'add_activity_price':this.activityPrice,
                    'remove_activity_price':this.removeActivityPrice,
                    'remove_trnasfer_price':this.removeTrnasferPrice,
                }
                $.ajax({

                    url:bookingCore.url+'/booking/addToCart',
                    data:{
                        service_id:this.id,
                        service_type:'tour',
                        start_date:this.start_date,
                        person_types:this.person_types,
                        extra_price:this.extra_price,
                        default_hotels:this.default_hotels,
                        applied_coupon:this.applied_coupon,
                        tour_summary:this.itineraries,
                        modify_activity:modify_activity,
                        default_hotel_price:this.default_hotel_price,
                        hotel_rooms:this.hotelrooms,
                        guests:this.guests
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){
                        if(!res.status){
                            me.onSubmit = false;
                        }
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if(res.step){
                            me.step = res.step;
                        }
                        if(res.html){
                            me.html = res.html
                        }

                        if(res.url){
                            window.location.href = res.url
                        }

                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        me.onSubmit = false;

                        bravo_handle_error_response(e);

                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }

                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;

                        }
                    }
                })
            },
            doEnquirySubmit:function(e){
                e.preventDefault();
                if(this.onSubmit) return false;
                if(!this.validateenquiry()) return false;
                this.onSubmit = true;
                var me = this;
                this.message.content = '';

                $.ajax({
                    url:bookingCore.url+'/booking/addEnquiry',
                    data:{
                        service_id:this.id,
                        service_type:'tour',
                        name:this.enquiry_name,
                        email:this.enquiry_email,
                        phone:this.enquiry_phone,
                        note:this.enquiry_note,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }
                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                        if(res.status){
                            me.enquiry_is_submit = true;
                            me.enquiry_name = "";
                            me.enquiry_email = "";
                            me.enquiry_phone = "";
                            me.enquiry_note = "";
                        }
                        me.onSubmit = false;

                    },
                    error:function (e) {
                        me.onSubmit = false;
                        bravo_handle_error_response(e);
                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }
                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        }
                    }
                })
            },
            validateenquiry(){
                if(!this.enquiry_name)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.name_required;
                    return false;
                }
                if(!this.enquiry_email)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.email_required;
                    return false;
                }
                return true;
            },
            openStartDate(){
                $(this.$refs.start_date).trigger('click');
            }
        }

    });

   var vuejsArray2 =  new Vue({
        el:'#bravo_tour_book_app_2',
        data:{
            default_hotels:[],
            by_default_hotels:[],
            itineraries:[],
        },
        created:function(){
            console.log(bravo_booking_data);
            for(var k in bravo_booking_data){
                this[k] = bravo_booking_data[k];
            }
        },
        mounted(){
        },
        methods:{
            handleTotalPrice: function () {
            },
            formatMoney: function (m) {
                return window.bravo_format_money(m);
            },
            openHotelsModel(event, index){
                vuejsArray.openHotelsModel(event, index);
            },
            openRoomsModel(event, index){
                vuejsArray.openRoomsModel(event, index);
            },
            openRoomsModelJquery(event, default_hotels){
                vuejsArray.openRoomsModel(event, default_hotels);
            },
            openActivityModel(event, index){
                vuejsArray.openActivityModel(event, index);
            },
            removeActivity(event, index, actIndex, timezone){
                vuejsArray.removeActivity(event, index, actIndex, timezone);
            },
        }

    });


    $(window).on("load", function () {
        var urlHash = window.location.href.split("#")[1];
        if (urlHash &&  $('.' + urlHash).length ){
            var offset_other = 70
            if(urlHash === "review-list"){
                offset_other = 330;
            }
            $('html,body').animate({
                scrollTop: $('.' + urlHash).offset().top - offset_other
            }, 1000);
        }
    });

    $(".bravo-button-book-mobile").click(function () {
        $('.bravo_single_book_wrap').modal('show');
    });
    jQuery(document).on("click", ".changeRoomFromHotel", function () {
        var roomEvent = $(vuejsArray.currentTarget).closest('.group-btns').find('.change-room');
        var index = $(vuejsArray.currentTarget).closest('.form-group').attr('data-index');
        var default_hotels = $(this).closest('li').find('.default_hotels').val();
        vuejsArray.openRoomsModelJquery(roomEvent, default_hotels);
    });
    jQuery(document).on("click", ".changeRoomNow", function () {
        var hotelDetail = $(vuejsArray.currentTarget).closest('.form-group').find('.hotelDetails');
        var dataIndex = $(vuejsArray.currentTarget).closest('.form-group').attr('data-index');
        var hotelDetail = $(this).closest('.makeFlex').find('.default_hotels').val();
        hotelDetail = JSON.parse(hotelDetail);
        var default_hotels = vuejsArray.default_hotels[dataIndex];
        console.log(default_hotels);
         var  changeFromHotel = $('#change_booking_room').find('#changeFromHotel').val();
         if (changeFromHotel != "") {
             default_hotels['hotel'] = hotelDetail.hotel;
             default_hotels['hotel_img'] = hotelDetail.hotel_img;
             default_hotels['hotel_name'] = hotelDetail.hotel_name;
         }
         
         default_hotels['room'] = hotelDetail.room;
         default_hotels['room_name'] = hotelDetail.room_name;
         default_hotels['room_price'] = hotelDetail.room_price;
         default_hotels['total_price'] = hotelDetail.total_price;
         default_hotels['diff_price'] = hotelDetail.totalDiffPrice;
         default_hotels['modify_is'] = true;
         if (hotelDetail.rateFlag) { 
            default_hotels['modify_in'] = true;
         }else{
            default_hotels['modify_in'] = false;
         }
         $('#change_booking_hotel').modal('hide');
         $('#change_booking_room').modal('hide');
         updateHotels(vuejsArray);
         totalPrice(vuejsArray, hotelDetail.totalDiffPrice, hotelDetail.rateFlag);
    });

    jQuery(document).on("click", ".changeHotelNow", function () {
         var dataIndex = $(vuejsArray.currentTarget).closest('.form-group').attr('data-index');
         var hotelDetail = $(this).closest('.makeFlex').find('.default_hotels').val();
         hotelDetail = JSON.parse(hotelDetail);
         var default_hotels = vuejsArray.default_hotels[dataIndex];
         default_hotels['hotel'] = hotelDetail.hotel;
         default_hotels['hotel_img'] = hotelDetail.hotel_img;
         default_hotels['hotel_name'] = hotelDetail.hotel_name;
         default_hotels['room'] = hotelDetail.room
         default_hotels['room_name'] = hotelDetail.room_name
         default_hotels['room_price'] = hotelDetail.room_price
         default_hotels['total_price'] = hotelDetail.total_price
         default_hotels['diff_price'] = hotelDetail.totalDiffPrice
         default_hotels['modify_is'] = true;
         if (hotelDetail.rateFlag) { 
            default_hotels['modify_in'] = true;
         }else{
            default_hotels['modify_in'] = false;
         }
         $('#change_booking_hotel').modal('hide');
         updateHotels(vuejsArray);
         totalPrice(vuejsArray, hotelDetail.totalDiffPrice, hotelDetail.rateFlag);
        
    });
    $('#change_booking_room').on('hidden.bs.modal', function () {
      if ($('#change_booking_hotel').hasClass("show")) {
        $('body').addClass('modal-open');
      }
    })
    jQuery(document).on("click", ".changeActivity", function () {
        var price = $(this).data('price');
        var index = $(this).data('index');
        var timezone = $(this).data('timezone');
        vuejsArray.activityPrice =  parseFloat(vuejsArray.activityPrice) + Math.abs(price);
        // if (vuejsArray.removeActivityPrice > vuejsArray.activityPrice) {
        //     vuejsArray.removeActivityPrice = vuejsArray.removeActivityPriceremoveActivityPrice - Math.abs(price);
        // }
        
        var currentRow = vuejsArray.itineraries[index];
        var term = $(this).closest('.makeFlex').find('.json_input').val();
        term = JSON.parse(term);
        if (timezone == 1) {
            if (currentRow.morning_activity == null) {
                currentRow.morning_activity = [];
            }
            currentRow.morning_activity.push(term);
        }else if(timezone == 3){
            if (currentRow.evening_activity == null) {
                currentRow.evening_activity = [];
            }
            currentRow.evening_activity.push(term);
        }else {
            if (currentRow.activity == null) {
                currentRow.activity = [];
            }
            currentRow.activity.push(term);
        }
        
        // vuejsArray
        // console.log(currentRow);
        $('#change_tour_activity').modal('hide');
        // var roomEvent = $(vuejsArray.currentTarget).closest('.group-btns').find('.change-room');
        // var index = $(vuejsArray.currentTarget).closest('.form-group').attr('data-index');
        
        // vuejsArray.openRoomsModelJquery(roomEvent, default_hotels);
    });

    $(".bravo_detail_tour .g-faq .item .header").click(function () {
        $(this).parent().toggleClass("active");
    });


    $(".bravo_detail_tour .g-itinerary").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 3,
            loop: true,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    });

})(jQuery);
function updateHotels(vuejsArray) {
    console.log(vuejsArray.itineraries);
        var ii = 0;
        jQuery.each(vuejsArray.itineraries, function(index, item) {
            if (item.hotel && item.hotel != 'null') {
                
                 var default_hotel = vuejsArray.default_hotels[ii];
                 vuejsArray.itineraries[index].hotel['hotel'] = default_hotel.hotel;
                 vuejsArray.itineraries[index].hotel['hotel_img'] = default_hotel.hotel_img;
                 vuejsArray.itineraries[index].hotel['hotel_name'] = default_hotel.hotel_name;
                 vuejsArray.itineraries[index].hotel['room'] = default_hotel.room
                 vuejsArray.itineraries[index].hotel['room_name'] = default_hotel.room_name
                 vuejsArray.itineraries[index].hotel['room_price'] = default_hotel.room_price
                 vuejsArray.itineraries[index].hotel['total_price'] = default_hotel.total_price
                 vuejsArray.itineraries[index].hotel['modify_is'] = default_hotel.modify_is;
                 vuejsArray.itineraries[index].hotel['modify_in'] = default_hotel.modify_in;

                 ii += 1;
            }
        });
}
function totalPrice(vuejsArray, totalRoomPrice, rateFlag) {
    var sale_price = $('#display_price').val();
    if (rateFlag) {
        var total_price = parseFloat(sale_price) + parseFloat(totalRoomPrice);
    }else{
        var total_price = parseFloat(sale_price) - parseFloat(totalRoomPrice);
    }
    $('#display_price').val(total_price);
    var total = 0;
    jQuery.each(vuejsArray.default_hotels, function(index, item) {
        if (item['diff_price'] > 0 && item['modify_is']) {
            if (item['modify_in'] == true) {
                total += parseFloat(item['diff_price']);
            }else{
                total -= parseFloat(item['diff_price']);
            }
        }
        
    });
    if (total < 0) {
        vuejsArray.modify_in = false;
    }else {
        vuejsArray.modify_in = true;
    }
    vuejsArray.modifyPrice = Math.abs(total);
    
    if (vuejsArray.modifyPrice == 0) {
        vuejsArray.total_modifyPrice = 0;
    }
    // $('.price .value .text-lg').text('₹'+total_price);
    // var me = vuejsArray;
    // if (me.start_date !== "") {
    //     for (var ix in me.person_types) {
    //         var person_type = me.person_types[ix];
    //         person_type.price = total_price;
    //     }
    // }
}