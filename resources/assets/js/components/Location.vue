<template>
  <div>
    <v-container fluid grid-list-md>
      <v-layout row wrap>
        <v-flex xs12 sm5>
          <v-card>
            <v-card-media class="white--text" style="background-color:green">
              <v-container fill-height fluid>
                <v-layout fill-height class="mt-1">
                  <v-flex xs12 align-end flexbox>
                    <span class="headline">Markets</span>
                  </v-flex>
                </v-layout>
                <v-spacer></v-spacer>
                <v-btn fab dark small color="light green">
                  <v-icon dark>add</v-icon>
                </v-btn>
              </v-container>
            </v-card-media>
            <markets-data-table></markets-data-table>
          </v-card>
        </v-flex>
        <v-flex xs12 sm7>
          <v-card>
            <v-card-media class="white--text" style="background-color:green">
              <v-container fill-height fluid>
                <v-layout fill-height class="mt-1">
                  <v-flex xs12 align-end flexbox>
                    <span class="headline">Postcodes</span>
                  </v-flex>
                </v-layout>
                <v-spacer></v-spacer>
                <v-btn fab dark small color="light green">
                  <v-icon dark>add</v-icon>
                </v-btn>
              </v-container>
            </v-card-media>
            <postcodes-data-table></postcodes-data-table>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Location mounted.")
  }
}
</script>
