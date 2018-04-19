<style scoped>
/* Hide horizontal scrollbar */
.table__overflow {
  overflow-x: hidden !important;
}
</style>

<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <!-- <v-btn color="primary" dark slot="activator" class="mb-2">Add timeslot</v-btn> -->
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md4>
                <v-menu lazy :close-on-content-click="false" v-model="menu_time_from" transition="scale-transition" offset-y :nudge-left="40">
                  <v-text-field slot="activator" label="Time from" v-model="editedItem.time_from" prepend-icon="access_time" readonly></v-text-field>
                  <v-time-picker v-model="editedItem.time_from" autosave format="24hrs"></v-time-picker>
                </v-menu>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-menu lazy :close-on-content-click="false" v-model="menu_time_to" transition="scale-transition" offset-y :nudge-left="40">
                  <v-text-field slot="activator" label="Time to" v-model="editedItem.time_to" prepend-icon="access_time" readonly></v-text-field>
                  <v-time-picker v-model="editedItem.time_to" autosave format="24hrs"></v-time-picker>
                </v-menu>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-text-field label="Slot limit" v-model="editedItem.slot_limit"></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
          <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <div class="container mt-3">
      <v-data-table :headers="headers" :items="dailyTimeslots" hide-actions class="elevation-2 mt-3">
        <template slot="items" slot-scope="props">
          <td>
            <v-icon class="mr-1 mb-1">schedule</v-icon>{{ props.item.time_from }}</td>
          <td>
            <v-icon class="mr-1 mb-1">schedule</v-icon>{{ props.item.time_to }}</td>
          <td>{{ props.item.slot_limit }}</td>
          <td class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="editItem(props.item)">
              <v-icon color="teal">edit</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="deleteItem(props.item)">
              <v-icon color="pink">delete</v-icon>
            </v-btn>
          </td>
        </template>
        <template slot="no-data">
          <v-alert :value="true" color="error" icon="warning">
            No timeslot configured.
          </v-alert>
        </template>
      </v-data-table>
    </div>
    <v-snackbar :timeout="timeout" :top="y === 'top'" :bottom="y === 'bottom'" :right="x === 'right'" :left="x === 'left'" :multi-line="mode === 'multi-line'" :vertical="mode === 'vertical'" v-model="snackbar">
      {{ snackbarText }}
      <v-btn flat color="pink" @click.native="snackbar = false">X</v-btn>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  props: ["currentDay"],
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "From",
        align: "left",
        sortable: false,
        value: "name"
      },
      {
        text: "To",
        align: "left",
        sortable: false,
        value: "name"
      },
      {
        text: "Slot Limit",
        align: "left",
        sortable: false,
        value: "name"
      },
      {
        text: "Actions",
        value: "name",
        align: "center",
        sortable: false
      }
    ],
    dailyTimeslots: [],
    menu_time_from: false,
    menu_time_to: false,
    editedIndex: -1,
    editedItem: {
      time_from: null,
      time_to: null,
      slot_limit: "",
      day: this.currentDay
    },
    // Snackbar props
    snackbar: false,
    y: "top",
    x: null,
    mode: "",
    timeout: 3000,
    snackbarText: ""
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New timeslot " : "Edit timeslot"
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  created() {
    this.initialize()
  },

  mounted() {
    //this.$el.querySelector(".input-group__details").hide()
    console.log("DeliveryHoursDataTable mounted.")
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

      // Get daily timeslots
      fetch("api/delivery-hours/" + this.currentDay + "?" + query)
        .then(res => res.json())
        .then(res => {
          this.dailyTimeslots = res.data
        })
        .catch(err => console.log(err))
    },

    editItem(item) {
      this.editedIndex = this.dailyTimeslots.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem(item) {
      const index = this.dailyTimeslots.indexOf(item)
      confirm("Are you sure you want to delete this timeslot?") &&
        this.dailyTimeslots.splice(index, 1)
    },

    close() {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)

      this.snackbarText = "Timeslot saved."
      this.snackbar = true
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.dailyTimeslots[this.editedIndex], this.editedItem)
      } else {
        this.dailyTimeslots.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>
