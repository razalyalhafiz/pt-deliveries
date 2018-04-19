<template>
  <div>
    <v-container fluid grid-list-md>
      <v-layout row wrap>
        <v-flex>
          <v-card>
            <v-card-media class="white--text" style="background-color:green">
              <v-container fill-height fluid>
                <v-layout fill-height class="mt-1">
                  <v-flex xs12 align-end flexbox>
                    <span class="headline">{{ subheader }}</span>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-media>
            <v-tabs color="cyan" dark grow slider-color="yellow" v-model="selected_tab">
              <v-tab v-for="day in delivery_days" :key="day.id" :href="'#tab-' + day.day" ripple>
                {{ day.day }}
              </v-tab>
              <v-tab-item v-for="day in delivery_days" :key="day.id" :id="'tab-' + day.day" :name="'tab-' + day.day">
                <v-card flat>
                  <v-container>                 
                    <v-flex xs12 align-end flexbox mt-1 style="float:left; width:50%" >
                      <v-switch :label="`Deliver on this day`" v-model="day.active"></v-switch>
                    </v-flex>
                    <div style="float:right" >
                      <span style="color: rgba(0,0,0,.54);font-size: 16px;">Add timeslot</span>
                      <v-btn fab dark small color="blue">
                        <v-icon dark>add</v-icon>
                      </v-btn>
                    </div>
                  </v-container>
                  <delivery-hours-data-table v-bind:currentDay="day.day"></delivery-hours-data-table>
                </v-card>
              </v-tab-item>
            </v-tabs>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    subheader: "Timeslots",
    day_enabled: false,
    delivery_days: [],
    valid: true
  }),

  created() {
    this.initialize()
  },

  computed: {
    selected_tab() {
      var today = this.getDayName("en-SG").toLowerCase()
      return "tab-" + today
    }

    // selected_tab: {
    //   get: () => {
    //     return "tab-" + this.getDayName("en-SG").toLowerCase()
    //   },

    //   set: value => {
    //     this.selected_tab = value
    //   }
    // }
  },

  mounted() {
    console.log("Timeslots mounted.")
  },

  methods: {
    initialize() {
      // Set params
      var params = {
        shop_id: this.$cookie.get('ptdeliveries_shop_id'),
        market_id: this.$cookie.get('ptdeliveries_market_id')
      }

      var esc = encodeURIComponent;
      var query = Object.keys(params)
        .map(k => esc(k) + "=" + esc(params[k]))
        .join("&")

      // Get delivery days
      fetch("api/days?" + query)
        .then(res => res.json())
        .then(res => {
          this.delivery_days = res.data
        })
        .catch(err => console.log(err))

      // Hide white space
      document.querySelector(".input-group__details").css('display', 'none')
    },

    getDayName(locale) {
      var date = new Date()
      return date.toLocaleDateString(locale, { weekday: "long" })
    }
  }
}
</script>
