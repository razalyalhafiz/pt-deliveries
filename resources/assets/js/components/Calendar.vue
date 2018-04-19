<style scoped>
/* Remove that awful yellow color and border from today in Schedule */
.fc-state-highlight {
  opacity: 0;
  border: none;
}

/* Styling for each event from Schedule */
.fc-time-grid-event.fc-v-event.fc-event {
  border-radius: 4px;
  border: none;
  padding: 5px;
  opacity: 0.65;
  left: 5% !important;
  right: 5% !important;
}

/* Bolds the name of the event and inherits the font size */
.fc-event {
  font-size: inherit !important;
  font-weight: bold !important;
}

/* Remove the header border from Schedule */
.fc td,
.fc th {
  border-style: none !important;
  border-width: 1px !important;
  padding: 0 !important;
  vertical-align: top !important;
}

/* Inherits background for each event from Schedule. */
.fc-event .fc-bg {
  z-index: 1 !important;
  background: inherit !important;
  opacity: 0.25 !important;
}

/* Normal font weight for the time in each event */
.fc-time-grid-event .fc-time {
  font-weight: normal !important;
}

/* Apply same opacity to all day events */
.fc-ltr .fc-h-event.fc-not-end,
.fc-rtl .fc-h-event.fc-not-start {
  opacity: 0.65 !important;
  margin-left: 12px !important;
  padding: 5px !important;
}

/* Apply same opacity to all day events */
.fc-day-grid-event.fc-h-event.fc-event.fc-not-start.fc-end {
  opacity: 0.65 !important;
  margin-left: 12px !important;
  padding: 5px !important;
}

/* Material design button */
.fc-button {
  display: inline-block;
  position: relative;
  cursor: pointer;
  min-height: 36px;
  min-width: 88px;
  line-height: 36px;
  vertical-align: middle;
  -webkit-box-align: center;
  -webkit-align-items: center;
  align-items: center;
  text-align: center;
  border-radius: 2px;
  box-sizing: border-box;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  outline: none;
  border: 0;
  padding: 0 6px;
  margin: 6px 8px;
  letter-spacing: 0.01em;
  background: transparent;
  color: currentColor;
  white-space: nowrap;
  text-transform: uppercase;
  font-weight: 500;
  font-size: 14px;
  font-style: inherit;
  font-variant: inherit;
  font-family: inherit;
  text-decoration: none;
  overflow: hidden;
  -webkit-transition: box-shadow 0.4s cubic-bezier(0.25, 0.8, 0.25, 1),
    background-color 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  transition: box-shadow 0.4s cubic-bezier(0.25, 0.8, 0.25, 1),
    background-color 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.fc-button:hover {
  background-color: rgba(158, 158, 158, 0.2);
}

.fc-button:focus,
.fc-button:hover {
  text-decoration: none;
}

/* The active button box is ugly so the active button will have the same appearance of the hover */
.fc-state-active {
  background-color: rgba(158, 158, 158, 0.2);
}

/* Not raised button */
.fc-state-default {
  box-shadow: None;
}
</style>

<template>
    <div class="mt-3">
        <full-calendar :config="config" :events="events" />
    </div>
</template>

<script>
import Moment from "moment"
import { FullCalendar } from "vue-full-calendar"

// CalendarEvent class
class CalendarEvent {
    constructor(title, start, end) {
        this.title = title
        this.start = start
        this.end = end
    }
}

export default {
  components: {
    FullCalendar
  },

  data: () => ({
    events: [],
    deliveries: [],
    config: {
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listDay,listWeek,month'
      },
      // customize the button names,
      // otherwise they'd all just say "list"
      views: {
        listDay: { buttonText: 'list day' },
        listWeek: { buttonText: 'list week' }
      },
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      handleWindowResize: true,
      defaultView: "listWeek",
      timeFormat: 'h:mma',
      minTime: "11:00:00",
      maxTime: "20:00:00",
      eventRender: function(event, element) {
        //console.log(event)
      }
    }
  }),

  created() {
    this.initialize()
  },

  mounted() {
    console.log("Calendar mounted.")
  },

  methods: {
    initialize() {
      // Set params
      var params = {
          shop_id: this.$cookie.get('ptdeliveries_shop_id'),
          market_id: this.$cookie.get("ptdeliveries_market_id")
      }

      var esc = encodeURIComponent
      var query = Object.keys(params)
          .map(k => esc(k) + "=" + esc(params[k]))
          .join("&")

      // Get deliveries
      fetch("api/deliveries?" + query)
        .then(res => res.json())
        .then(res => {
            this.deliveries = res.data
            this.deliveries.forEach(delivery => {                    
                this.setStartAndEndTime(delivery)             
            })
        })
        .catch(err => console.log(err))
    },

    setStartAndEndTime(delivery) {
      let startAndEndTime = delivery.delivery_time.split('-')
      if (startAndEndTime.length == 0) {
        return
      }

      let startTime = Moment(startAndEndTime[0].trim(), 'h:mma')
      let endTime = Moment(startAndEndTime[1].trim(), 'h:mma')
      let start = Moment(delivery.delivery_date, 'ddd, DD/MM/YYYY')
      let end = Moment(delivery.delivery_date, 'ddd, DD/MM/YYYY')
      
      start.set({
        hour: startTime.get('hour'),
        minute: startTime.get('minute')
      })

      end.set({
        hour: endTime.get('hour'),
        minute: endTime.get('minute')
      })

      console.log('Start:' + start)
      console.log('End:' + end)

      let titleElements = ['#' + delivery.order_id, delivery.status, delivery.customer, delivery.phone, delivery.address]
      let title = titleElements.join(' | ')
      let event = new CalendarEvent(title, start, end)
      this.events.push(event)    
    }
  }
}
</script>
