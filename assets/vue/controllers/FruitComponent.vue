<template>
  <div>
    {{ fruit.name }}
  </div>
</template>

<script>
export default {
  props: {
    fruit: {
      required: true,
      type: Object
    }
  },
  mounted() {
    console.log(this.fruit)
  }
}
</script>