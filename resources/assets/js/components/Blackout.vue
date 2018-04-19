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
                <v-spacer></v-spacer>
                <v-btn fab dark small color="light green">
                  <v-icon dark>add</v-icon>
                </v-btn>
              </v-container>
            </v-card-media>
            <v-tabs color="cyan" dark slider-color="yellow" v-model="selected_tab">
              <v-tab>Upcoming</v-tab>
              <v-tab>Past</v-tab>
              <v-tab-item>
                <v-card flat>
                  <blackout-data-table v-bind:blackoutDays="upcomingDays"></blackout-data-table>
                </v-card>
              </v-tab-item>
              <v-tab-item>
                <v-card flat>
                  <blackout-data-table v-bind:blackoutDays="pastDays"></blackout-data-table>
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
import Moment from 'moment'

export default {
  data: () => ({
    subheader: "Blackout Days",
    upcomingDays: [],
    pastDays: [],
    selected_tab: null
  }),

  created() {
    this.initialize()
  },

  mounted() {
    console.log("Blackout mounted.")
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

      // Get blackout days
      fetch("api/blackouts?" + query)
        .then(res => res.json())
        .then(res => {
          let today = new Date()
          res.data.forEach(day => {
            if (Moment(day.date) >= today) {
              this.upcomingDays.push(day)
            } else {
              this.pastDays.push(day)     
            }
          })
        })
        .catch(err => console.log(err))
    }
  }
}
</script>
