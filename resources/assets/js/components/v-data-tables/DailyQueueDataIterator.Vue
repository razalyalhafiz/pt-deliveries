<template>
  <div>
    <v-container fluid grid-list-md>
      <v-data-iterator content-tag="v-layout" row wrap :items="deliveries" :rows-per-page-items="rowsPerPageItems" :pagination.sync="pagination">
        <v-flex slot="item" slot-scope="props" xs12 sm6 md4 lg3>
          <v-card>
            <v-card-title v-if="props.item.status == 'open'" class="red lighten-3">
              <h4>#{{ props.item.order_id }}</h4>
            </v-card-title>
            <v-card-title v-else class="green lighten-4">
              <h4>#{{ props.item.order_id }}</h4>
            </v-card-title>
            <v-divider></v-divider>
            <v-list dense>
              <v-list-tile>
                <v-list-tile-content>Status:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.status }}</v-list-tile-content>
              </v-list-tile>
              <v-list-tile>
                <v-list-tile-content>Delivery Time:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.delivery_time }}</v-list-tile-content>
              </v-list-tile>
              <v-list-tile>
                <v-list-tile-content>Assignee:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.assignee }}</v-list-tile-content>
              </v-list-tile>
              <v-list-tile>
                <v-list-tile-content>Completed Time:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.completed_time }}</v-list-tile-content>
              </v-list-tile>
            </v-list>
            <v-divider></v-divider>
            <v-list dense>
              <v-list-tile>
                <v-list-tile-content>Customer:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.customer }}</v-list-tile-content>
              </v-list-tile>
              <v-list-tile>
                <v-list-tile-content>Phone:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.phone }}</v-list-tile-content>
              </v-list-tile>
              <v-list-tile>
                <v-list-tile-content>{{ props.item.address }}</v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-card>
        </v-flex>
        <template slot="no-data">
          <v-alert :value="true" color="info" icon="info">
            No deliveries scheduled on this date.
          </v-alert>
        </template>
      </v-data-iterator>
    </v-container>
  </div>
</template>
<script>
export default {
  props: ["deliveries"],
  data: () => ({
    rowsPerPageItems: [3, 6, 9],
    pagination: {
      sortBy: 'order_id', 
      descending: false,
      rowsPerPage: 3
    }
  }),

  mounted() {
    console.log("DailyQueueDataIterator mounted.")
  }
}
</script>
