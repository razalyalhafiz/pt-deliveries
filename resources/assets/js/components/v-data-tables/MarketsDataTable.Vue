<template>
  <div class="pl-3 pr-3 pb-3">
    <v-dialog v-model="dialog" max-width="500px">
      <!-- <v-btn color="primary" dark slot="activator" class="ml-0 mb-2">Add market</v-btn> -->
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md6>
                <v-text-field label="Market Name" v-model="editedItem.market_name"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md6>
                <v-text-field label="Lead Time Offset (mins)" v-model="editedItem.lead_offset"></v-text-field>
              </v-flex>
              <v-flex xs12 sm12 md12>
                <v-text-field label="Postcode" v-model="editedItem.postcode"></v-text-field>
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
    <v-data-table :headers="headers" :items="markets">
      <template slot="items" slot-scope="props">
        <td>{{ props.index + 1 }}</td>
        <td>
          <v-edit-dialog :return-value.sync="props.item.market_name" lazy> {{ props.item.market_name }}
            <v-text-field slot="input" label="Edit" v-model="props.item.market_name" single-line counter></v-text-field>
          </v-edit-dialog>
        </td>
        <td>
          <v-edit-dialog :return-value.sync="props.item.lead_offset" lazy> {{ props.item.lead_offset }}
            <v-text-field slot="input" label="Edit" v-model="props.item.lead_offset" single-line counter></v-text-field>
          </v-edit-dialog>
        </td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
        </td>
      </template>
      <template slot="no-data">
        <v-alert :value="true" color="error" icon="warning">
          No market configured.
        </v-alert>
      </template>
    </v-data-table>
  </div>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "#",
        align: "center",
        sortable: false,
        value: "name",
        width: "5%"
      },
      {
        text: "Market Name",
        value: "market_name"
      },
       {
        text: "Offset (mins)",
        sortable: false,
        value: "lead_offset",
        width: "10%"
      },
      {
        text: "Actions",
        align: "center",
        value: "name",
        sortable: false
      }
    ],
    markets: [],
    editedIndex: -1,
    editedItem: {
      market_name: "",
      lead_offset: ""
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New market " : "Edit market"
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
    console.log("MarketsDataTable mounted.")
  },

  methods: {
    initialize() {
      // Get markets
      fetch("api/markets/" + this.$cookie.get('ptdeliveries_shop_id'))
        .then(res => res.json())
        .then(res => {
          this.markets = res.data
        })
        .catch(err => console.log(err))
    },

    // editItem(item) {
    //   this.editedIndex = this.markets.indexOf(item)
    //   this.editedItem = Object.assign({}, item)
    //   this.dialog = true
    // },

    deleteItem(item) {
      const index = this.markets.indexOf(item)
      confirm("Are you sure you want to delete this market?") &&
        this.markets.splice(index, 1)
    },

    close() {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.markets[this.editedIndex], this.editedItem)
      } else {
        this.markets.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>
