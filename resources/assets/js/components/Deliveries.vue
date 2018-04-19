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
            <v-tabs color="cyan" dark slider-color="yellow" v-model="selectedTab">
              <v-tab v-if="this.openDeliveriesCount > 0">
                <v-badge color="red">
                  <span slot="badge">{{ this.openDeliveriesCount }}</span> Daily Queue </v-badge>
              </v-tab>
              <v-tab v-else> Daily Queue </v-tab>
              <v-tab> Datepicker </v-tab>
              <v-tab> All </v-tab>
              <v-tab-item>
                <v-card flat>
                  <daily-queue-data-iterator v-bind:deliveries="dailyDeliveries"></daily-queue-data-iterator>
                </v-card>
              </v-tab-item>
              <v-tab-item>
                <v-card flat>
                  <v-menu class="pl-2 pt-2" ref="menu" lazy :close-on-content-click="false" v-model="menu" transition="scale-transition" offset-y :nudge-right="20" min-width="290px" :return-value.sync="date">
                    <v-text-field slot="activator" label="Select date" v-model="selectedDate" prepend-icon="event" readonly></v-text-field>
                    <v-date-picker v-model="selectedDate" no-title scrollable>
                      <v-spacer></v-spacer>
                      <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                      <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                    </v-date-picker>
                  </v-menu>
                  <daily-queue-data-iterator v-bind:deliveries="specificDayDeliveries"></daily-queue-data-iterator>
                </v-card>
              </v-tab-item>
              <v-tab-item>
                <v-card flat>
                  <deliveries-data-table v-bind:deliveries="deliveries"></deliveries-data-table>
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
import Moment from "moment"

export default {
  data: () => ({
    subheader: "Deliveries",
    selectedTab: null,
    selectedDate: null,
    menu: false,   
    openDeliveriesCount: 0,
    dailyDeliveries: [],
    specificDayDeliveries: [],
    deliveries: []
  }),

  created() {
    this.initialize()
  },

  mounted() {
    console.log("Deliveries mounted.")
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

          var today = Moment(new Date()).format("ddd, DD/MM/YYYY")
          this.dailyDeliveries = this.deliveries.filter(delivery => {
            return delivery.delivery_date == today
          })

          this.openDeliveriesCount = this.dailyDeliveries.filter(delivery => {
            return delivery.status == "open"
          }).length
        })
        .catch(err => console.log(err))
    }
  }
}
</script>