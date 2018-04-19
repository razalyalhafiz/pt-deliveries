<style scoped>
/* Hide horizontal scrollbar */
.table__overflow {
  overflow-x: hidden !important;
}
</style>

<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <!-- <v-btn color="primary" dark slot="activator" class="mb-2">Add blackout day</v-btn> -->
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md4>
                <v-menu lazy :close-on-content-click="false" v-model="start_date" transition="scale-transition" offset-y :nudge-left="40">
                  <v-text-field slot="activator" label="Time from" v-model="editedItem.start_date" prepend-icon="access_time" readonly></v-text-field>
                  <v-date-picker v-model="editedItem.start_date" autosave></v-date-picker>
                </v-menu>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-menu lazy :close-on-content-click="false" v-model="menu_end_date" transition="scale-transition" offset-y :nudge-left="40">
                  <v-text-field slot="activator" label="Time to" v-model="editedItem.end_date" prepend-icon="access_time" readonly></v-text-field>
                  <v-date-picker v-model="editedItem.end_date" autosave></v-date-picker>
                </v-menu>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-text-field label="Name" v-model="editedItem.name"></v-text-field>
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
    <div class="container pt-0">
      <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search"></v-text-field>
      <v-data-table :headers="headers" :items="blackoutDays">
        <template slot="items" slot-scope="props">
          <td>
            <v-icon class="mr-1 mb-1">today</v-icon>{{ props.item.start_date | formatLongDate }}</td>
          <td>
            <v-icon class="mr-1 mb-1">event</v-icon>{{ props.item.end_date | formatLongDate }}</td>
          <td>{{ props.item.name }}</td>
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
            No blackout day configured.
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
  props: ["blackoutDays"],
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "From",
        align: "left",
        value: "start_date",
        width: "25%"
      },
      {
        text: "To",
        align: "left",
        value: "end_date",
        width: "25%"
      },
      {
        text: "Name",
        align: "left",
        value: "name"
      },
      {
        text: "Actions",
        value: "name",
        align: "center",
        sortable: false
      }
    ],
    menu_start_date: false,
    menu_end_date: false,
    editedIndex: -1,
    editedItem: {
      start_date: null,
      end_date: null,
      name: ""
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
      return this.editedIndex === -1 ? "New blackout day" : "Edit blackout day"
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  mounted() {
    console.log("BlackoutDataTable mounted.")
  },

  methods: {
    editItem(item) {
      this.editedIndex = this.blackoutDays.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem(item) {
      const index = this.blackoutDays.indexOf(item)
      confirm("Are you sure you want to delete this blackout day?") &&
        this.blackoutDays.splice(index, 1)
    },

    close() {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)

      this.snackbarText = "Blackout saved."
      this.snackbar = true
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.blackoutDays[this.editedIndex], this.editedItem)
      } else {
        this.blackoutDays.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>
