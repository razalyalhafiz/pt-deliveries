<template>
  <div>
    <!-- <v-dialog v-model="dialog" max-width="500px">
      <v-btn color="primary" dark slot="activator" class="mb-2">Add timeslot</v-btn>
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
    </v-dialog> -->
    <div class="container pt-0">
      <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search"></v-text-field>
      <v-data-table :headers="headers" :items="deliveries" :search="search" v-bind:pagination.sync="pagination">
        <template slot="items" slot-scope="props">
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.order_id }}</td>
          <td>{{ props.item.status }}</td>
          <td>{{ props.item.delivery_date }}</td>
          <td>{{ props.item.delivery_time }}</td>
          <td>{{ props.item.customer }}</td>
          <td>{{ props.item.phone }}</td>
          <td>{{ props.item.address }}</td>
          <td>{{ props.item.assignee }}</td>
          <td>{{ props.item.completed_time }}</td>
        </template>
        <template slot="no-results">
          <v-alert :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
          </v-alert>
        </template>
        <template slot="no-data">
          <v-alert :value="true" color="error" icon="warning">
            No deliveries found.
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
  props: ["deliveries"],
  data: () => ({
    dialog: false,
    search: "",
    headers: [
      {
        text: "ID",
        value: "id",
        width: "5%"
      },
      {
        text: "Order No.",
        value: "order_id",
        width: "7%"
      },
      {
        text: "Status",
        value: "status"
      },
      {
        text: "Delivery Date",
        value: "delivery_date"
      },
      {
        text: "Delivery Time",
        value: "delivery_time"
      },
      {
        text: "Customer",
        value: "customer"
      },
      {
        text: "Phone",
        value: "phone"
      },
      {
        text: "Address",
        value: "address"
      },
      {
        text: "Assignee",
        value: "assignee"
      },
      {
        text: "Completed Time",
        value: "completed_time"
      }
    ],
    pagination: { sortBy: "order_id", descending: true },
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
      return this.editedIndex === -1 ? "New delivery " : "Edit delivery"
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  mounted() {
    console.log("DeliveriesDataTable mounted.")
  },

  methods: {
    editItem(item) {
      this.editedIndex = this.deliveries.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem(item) {
      const index = this.deliveries.indexOf(item)
      confirm("Are you sure you want to delete this delivery?") &&
        this.deliveries.splice(index, 1)
    },

    close() {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)

      this.snackbarText = "Delivery saved."
      this.snackbar = true
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.deliveries[this.editedIndex], this.editedItem)
      } else {
        this.deliveries.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>
