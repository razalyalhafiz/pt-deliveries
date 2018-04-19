<template>
  <v-toolbar dark color="green accent-4" fixed style="z-index:5">
    <v-toolbar-items>
      <v-btn :to="{ name: 'calendar' }" flat>
        <v-icon class="mb-1 mr-2">fas fa-calendar-alt</v-icon>
        Calendar
      </v-btn>
      <v-btn :to="{ name: 'deliveries' }" flat>
        <v-icon class="mb-1 mr-2">fas fa-tasks</v-icon>
        Deliveries
      </v-btn>
      <v-btn :to="{ name: 'timeslots' }" flat>
        <v-icon class="mb-1 mr-2">fas fa-clock</v-icon>
        Timeslots
      </v-btn>
      <v-btn :to="{ name: 'blackout' }" flat>
        <v-icon class="mb-1 mr-2">fas fa-calendar-times</v-icon>
        Blackout Days
      </v-btn>
      <v-btn :to="{ name: 'location' }" flat>
        <v-icon class="mb-1 mr-2">fa-location-arrow</v-icon>
        Location
      </v-btn>
    </v-toolbar-items>
    <v-spacer></v-spacer>
    <v-select v-model="selectedMarket" class="pt-4" :items="markets" @change="onChange" item-text="market_name" item-value="id" single-line auto prepend-icon="fa-map-marker-alt"></v-select>
  </v-toolbar>
</template>

<script>
export default {
  data: () => ({
    selectedMarket: "",
    markets: []
  }),

  created() {
    this.initialize()
  },

  mounted() {
    console.log("Navbar mounted.")
  },

  methods: {
    initialize() {
      // Get markets
      fetch("api/markets/" +  this.$cookie.get('ptdeliveries_shop_id'))
        .then(res => res.json())
        .then(res => {
          this.markets = res.data
          var market_id = this.$cookie.get('ptdeliveries_market_id') ? this.$cookie.get('ptdeliveries_market_id') : this.markets[0].id
          this.selectedMarket = this.markets.find(x => x.id == market_id)
          if (!this.selectedMarket) {
            this.selectedMarket = this.markets[0]
          }
          this.$cookie.set('ptdeliveries_market_id', this.selectedMarket.id, { expires: '3M' })
        })
        .catch(err => console.log(err))
    },

    onChange: function(value) {
      this.$cookie.set('ptdeliveries_market_id', value, { expires: '3M' })
      location.reload()
    }
  }
}
</script>
