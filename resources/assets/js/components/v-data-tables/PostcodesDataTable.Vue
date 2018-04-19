<template>
  <div class="container pt-0">
    <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search"></v-text-field>
    <v-data-table :headers="headers" :items="postcodes" :search="search">
      <template slot="items" slot-scope="props">
        <td class="text-xs-center">{{ props.item.id }}</td>
        <td>
          <v-edit-dialog :return-value.sync="props.item.postcode" lazy> {{ props.item.postcode }}
            <v-text-field slot="input" label="Edit" v-model="props.item.postcode" single-line counter :rules="[max5chars]"></v-text-field>
          </v-edit-dialog>
        </td>
        <td>
          <v-edit-dialog :return-value.sync="props.item.market_name" lazy> {{ props.item.market_name }}
            <v-text-field slot="input" label="Edit" v-model="props.item.market_name" single-line counter></v-text-field>
          </v-edit-dialog>
        </td>
        <td>
          <v-edit-dialog :return-value.sync="props.item.area" lazy> {{ props.item.area }}
            <v-text-field slot="input" label="Edit" v-model="props.item.area" single-line counter></v-text-field>
          </v-edit-dialog>
        </td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
        </td>
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
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    max5chars: v => v.length <= 5 || "Invalid postcode",
    search: "",
    headers: [
      {
        text: "#",
        align: "center",
        sortable: false,
        value: "id"
      },
      { text: "Postcode", value: "postcode" },
      { text: "Market Name", value: "market_name" },
      { text: "Area", value: "area" },
      {
        text: "Actions",
        align: "center",
        value: "name",
        sortable: false
      }
    ],
    postcodes: [],
    editedIndex: -1,
    editedItem: {
      market_name: "",
      postcode: "",
      area: ""
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New postcode " : "Edit postcode"
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
    console.log("PostcodesDataTable mounted.")
  },

  methods: {
    initialize() {
      // Get postcodes
      fetch("api/postcodes/" + this.$cookie.get('ptdeliveries_shop_id'))
        .then(res => res.json())
        .then(res => {
          this.postcodes = res.data
        })
        .catch(err => console.log(err))
    },

    deleteItem(item) {
      const index = this.postcodes.indexOf(item)
      confirm("Are you sure you want to delete this postcode?") &&
        this.postcodes.splice(index, 1)
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
        Object.assign(this.postcodes[this.editedIndex], this.editedItem)
      } else {
        this.postcodes.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>
