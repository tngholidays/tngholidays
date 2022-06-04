(function ($) {
    new Vue({
        el:'#bravo_event_book_app',
        data:{
            id:'',
            extra_price:[],
            ticket_types:[],
            message:{
                content:'',
                type:false
            },
            html:'',
            onSubmit:false,
            start_date:'',
            start_date_html:'',
            step:1,

            total_price_before_fee:0,
            total_price_fee:0,
            start_date_obj:'',
            duration:0,
            allEvents:[],
            all_tickets:[],
            selected_tickets:[],
            buyer_fees:[],
            display_price:0,
            event_sale_price:0,

            is_form_enquiry_and_book:false,
            enquiry_type:'book',
            enquiry_is_submit:false,
            enquiry_name:"",
            enquiry_email:"",
            enquiry_phone:"",
            enquiry_note:"",
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
            ticket_types:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            all_tickets:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            selected_tickets:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
        },
        computed:{
            total_price:function(){
                var me = this;
                if (me.start_date !== "") {
                    var total = 0;
                    var total_tickets = 0;
                    var startDate = new Date(me.start_date).getTime();
                    for (var ix in me.allEvents) {
                        var item = me.allEvents[ix];
                        var cur_date = new Date(item.start).getTime();
                        if (cur_date === startDate) {
                            if (item.ticket_types != null) {
                                me.ticket_types = Object.assign([], item.ticket_types);
                            } else {
                                me.ticket_types = null
                            }
                        }
                    }
                    // for ticket types
                    // if (me.ticket_types != null) {
                    //     for (var ix in me.ticket_types) {
                    //         var person_type = me.ticket_types[ix];
                    //         total += parseFloat(person_type.price) * parseInt(person_type.number);
                    //         total_tickets += parseInt(person_type.number);
                    //     }
                    // }

                    if (me.selected_tickets.length > 0) {
                         jQuery.each(me.selected_tickets, function(index, ticket) {
                            var adult_price = parseFloat(ticket.adult_price) * parseInt(ticket.adult_ticket);
                            var child_price = parseFloat(ticket.child_price) * parseInt(ticket.child_ticket);
                            total += parseFloat(adult_price) + parseInt(child_price);
                            total_tickets += parseInt(ticket.adult_ticket);
                            total_tickets += parseInt(ticket.child_ticket);
                        });
                    }
                    // console.log('total_tickets', total_tickets);
                    if(total_tickets <= 0) return 0;

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
                            }
                            if (typeof item.per_ticket !== "undefined") {
                                // console.log('type_total', type_total);
                                type_total = type_total * total_tickets;
                            }
                            total += type_total;
                        }
                    }

                    this.total_price_before_fee = total;

                    var total_fee = 0;
                    for (var ix in me.buyer_fees) {
                        var item = me.buyer_fees[ix];

                        //for Fixed
                        var fee_price = parseFloat(item.price);

                        //for Percent
                        if (typeof item.unit !== "undefined" && item.unit === "percent" ) {
                            fee_price = ( total / 100 ) * fee_price;
                        }

                        if (typeof item.per_ticket !== "undefined") {
                            fee_price = fee_price * total_tickets;
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
            is_deposit_ready:function () {
                if(this.deposit && this.deposit_amount) return true;
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
                        me.start_date_html = picker.startDate.format(bookingCore.date_format);
                    })
                    .on('update-calendar',function (e,obj) {
                        me.fetchEvents(obj.leftCalendar.calendar[0][0], obj.leftCalendar.calendar[5][6])
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
                    for_single:1
                };
                console.log(data);

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
                        console.log(e);
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
                if(type.number < parseInt(type.max)) type.number +=1;
                console.log(this);
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
            openPersonPicker(event){
                 var current = event.currentTarget;
                 $(current).closest('.ticketsBox').find('.personPicker').toggle();
            },
            selectTicket(index, event){

                me = this;
                me.selected_tickets = [];
                var current = event.currentTarget;
                var is_checked = $(current).attr('is_checked');
        
                if (is_checked == 'true') {
                    me.selected_tickets = [];
                    $(current).attr('is_checked', 'false');
                    $(current).prop("checked", false);
                }else{
                    me.selected_tickets.push(me.all_tickets[index]);
                    $('.radio-button .form-check-input').attr("is_checked", 'false');
                    $(current).attr('is_checked', 'true');
                    
                    if ($('.bravo-more-book-mobile').is(':hidden') == false) {
                        $('.bravo-more-book-mobile .bravo-button-book-mobile').click();
                    }

                }

                if(me.selected_tickets.length > 0) {
                    me.display_price = window.bravo_format_money(me.selected_tickets[0].adult_price);
                }else{
                     me.display_price = window.bravo_format_money(me.event_sale_price);
                }
                $(current).closest('.ticket-row').find('.collapseButton').click();
                
            },
            addPersonTicket(ticket, index, type){
                // if (ticket.timeslot_id == null) {
                //     alert('please select time slot');
                //     return false;
                // }
                if (type == "adult") {
                    ticket.adult_ticket = parseInt(ticket.adult_ticket);
                    if(ticket.adult_ticket < 15) ticket.adult_ticket +=1;
                }
                if (type == "child") {
                    ticket.child_ticket = parseInt(ticket.child_ticket);
                    if(ticket.child_ticket < 15) ticket.child_ticket +=1;
                }
            },
            minusPersonTicket(ticket, index, type){
                // if (ticket.timeslot_id == null) {
                //     alert('please select time slot');
                //     return false;
                // }
                if (type == "adult") {
                    ticket.adult_ticket = parseInt(ticket.adult_ticket);
                    if(ticket.adult_ticket > 0) ticket.adult_ticket -=1;
                }
                if (type == "child") {
                    ticket.child_ticket = parseInt(ticket.child_ticket);
                    if(ticket.child_ticket > 0) ticket.child_ticket -=1;
                }
            },

            selectTimeSlot(ticket, e){
                var me = this;
                 var id = e.target.value;
                // var name = e.target.options[e.target.options.selectedIndex].text;
                var index = e.target.selectedIndex; // this selectedIndex is from event.

               
                if (index != "")  { 
                    index = parseInt(index)-1;
                    ticket.timeslot_id = id;
                    timeslot = ticket.timeslots[index];
                    ticket.adult_price = timeslot.adult_price
                    ticket.child_price = timeslot.child_price
                    
                }else{
                    ticket.timeslot_id = null;
                    ticket.adult_price = ticket.sale_price
                    ticket.child_price = ticket.sale_price
                }

                if(me.selected_tickets.length > 0) {
                    me.display_price = window.bravo_format_money(ticket.adult_price);
                }else{
                     me.display_price = window.bravo_format_money(me.event_sale_price);
                }
            },
            closePersonPicker(event){
                 var current = event.currentTarget;
                 $(current).closest('.ticketsBox').find('.personPicker').hide();
            },
            onHideShow(event){
                 var current = event.currentTarget;

                 if ($(current).text() == "Hide Details")
                   $(current).text("Show Details")
                else
                 $(current).text('Hide Details');
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

                $.ajax({
                    url:bookingCore.url+'/booking/addToCart',
                    data:{
                        service_id:this.id,
                        service_type:'event',
                        start_date:this.start_date,
                        ticket_types:this.ticket_types,
                        selected_tickets:this.selected_tickets,
                        extra_price:this.extra_price,
                        step:this.step,
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
                        service_type:'event',
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

    $(".bravo_detail_event .g-faq .item .header").click(function () {
        $(this).parent().toggleClass("active");
    });

    $(".top-bar-item").click(function() {
        $(this).parent().find('.top-bar-item').removeClass('top-bar-item-active');
        $(this).addClass('top-bar-item-active');
        var section = $(this).find('button').data('section');
        $('html, body').animate({
            scrollTop: $("#section_"+section).offset().top-50
        }, 500);
    });
    $(document).ready(function(){
        $(".description .aboutDiv").children().not(':first').addClass('moretext');
      
    });
    $(".moreless-button").click(function () {
        var text = $(this).text();
        $('.moretext').slideToggle();
        if (text == "Read More") {
          $(this).text("Read Less")
        } else {
           $(this).text("Read More")
        }
    });
})(jQuery);
