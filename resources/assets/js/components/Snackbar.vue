<template>
    <v-snackbar :timeout="timeout" :top="y === 'top'" :bottom="y === 'bottom'" :right="x === 'right'" :left="x === 'left'" :multi-line="mode === 'multi-line'" :vertical="mode === 'vertical'" v-model="snackbar">
        {{ text }}
        <v-btn flat color="pink" @click.native="snackbar = false">Close</v-btn>
    </v-snackbar>
</template>

<script>
export default {
  props: ["text"],
  data() {
    return {
      snackbar: false,
      y: "top",
      x: null,
      mode: "",
      timeout: 3000,
      text: this.text
    }
  }
}
</script>
