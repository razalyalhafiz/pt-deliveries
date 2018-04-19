/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap")
window.Vue = require("vue")

// Libs
import Moment from 'moment'
import Vue from "vue"
import VueCookie from "vue-cookie"
//import VueLoader from 'vue-loader'
import VueRouter from "vue-router"
import Vuetify from "vuetify"
// import 'babel-polyfill'

// Styles
import "fullcalendar/dist/fullcalendar.min.css";
// import 'vuetify/dist/vuetify.min.css'

// Components
import App from "./views/App"
import Blackout from "./components/Blackout"
import BlackoutDataTable from "./components/v-data-tables/BlackoutDataTable"
import Calendar from "./components/Calendar"
import DailyQueueDataIterator from "./components/v-data-tables/DailyQueueDataIterator"
import Deliveries from "./components/Deliveries"
import DeliveriesDataTable from "./components/v-data-tables/DeliveriesDataTable"
import DeliveryHoursDataTable from "./components/v-data-tables/DeliveryHoursDataTable"
import Location from "./components/Location"
import MarketsDataTable from "./components/v-data-tables/MarketsDataTable"
import Navbar from "./components/Navbar"
import PostcodesDataTable from "./components/v-data-tables/PostcodesDataTable"
import Snackbar from "./components/Snackbar"
import Timeslots from "./components/Timeslots"

Vue.use(VueCookie)
//Vue.use(VueLoader)
Vue.use(VueRouter)
Vue.use(Vuetify)

// Set date/time formatters
Vue.filter('formatLongDate', function(value) {
  if (value) {
    return Moment(String(value)).format('ddd, D MMM YYYY')
  }
})

Vue.component("BlackoutDataTable", BlackoutDataTable)
Vue.component("DailyQueueDataIterator", DailyQueueDataIterator)
Vue.component("DeliveriesDataTable", DeliveriesDataTable)
Vue.component("DeliveryHoursDataTable", DeliveryHoursDataTable)
Vue.component("MarketsDataTable", MarketsDataTable)
Vue.component("Navbar", Navbar)
Vue.component("PostcodesDataTable", PostcodesDataTable)
Vue.component("Snackbar", Snackbar)

// Define routes
const routes = [
  {
    path: "/",
    name: "home",
    component: Deliveries
  },
  {
    path: "/blackout-days",
    name: "blackout",
    component: Blackout
  },
  {
    path: "/calendar",
    name: "calendar",
    component: Calendar
  },
  {
    path: "/deliveries",
    name: "deliveries",
    component: Deliveries
  },
  {
    path: "/markets",
    name: "location",
    component: Location
  },
  {
    path: "/timeslots",
    name: "timeslots",
    component: Timeslots
  }
]

// Initialize router
const router = new VueRouter({
  mode: "history",
  base: __dirname,
  routes: routes
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: "#app",
  components: { App },
  router
})
