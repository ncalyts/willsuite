<template>
  <NotesDashboard />
</template>

<script>
import NotesDashboard from './components/NotesDashboard.vue'

export default {
  name: 'WillSuite Notes',
  components: {
    NotesDashboard
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
