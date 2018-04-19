<template>
  <div>
    <navbar></navbar>
    <div class="container mt-5">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("App mounted.")
  }
}
</script>

