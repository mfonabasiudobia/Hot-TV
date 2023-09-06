<section>
    <div id="calendar"></div>

    @livewire("admin.calendar.modal.show")
</section>

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
       var calendar = $('#calendar').fullCalendar({
            editable: true,
            defaultView: 'agendaWeek',
            allDaySlot: false,
            editable: false,
            timeFormat: 'h:mm A',
            slotEventOverlap: true,
            eventOverlap: true,
            columnFormat: 'ddd M/D',
            slotDuration: '00:05:00',
            lotMaxTime: '23:59:00',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'agendaWeek'
                // right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            // eventRender: function(eventObj, $el) {
            
            //     // $el.find(".fc-title").prepend(" - ");

            //     // alert(JSON.stringify(eventObj));
                
            //     $el.popover({
            //         title: eventObj.title,
            //         // content: `
            //         //     <div>Start Time: ${moment(eventObj.start).format('DD MMMM, YYYY HH:mm A')}</div>
            //         //     <div>End Time: ${moment(eventObj.end).format('DD MMMM, YYYY HH:mm A')}</div>`,
            //         trigger: 'hover',
            //         html: true,
            //         placement: 'top',
            //         trigger : 'hover',
            //         animation : true,
            //         container: 'body'
            //     });
            // },
            events: @json($stream),
            eventClick: function(info) {
                const customEvent = new CustomEvent('trigger-show-stream-modal', {
                    detail : info
                });

                window.dispatchEvent(customEvent);
            }
        })
    </script>
@endpush

@push('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
@endpush

