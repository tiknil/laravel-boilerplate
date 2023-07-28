<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'CounterOptions',
  props: {
    factor: {
      type: Number,
      default: 2,
    },
  },
  data: function () {
    return {
      count: 0,
      isOdd: false,
    }
  },
  watch: {
    count: function (newV) {
      this.isOdd = newV % 2 === 1
    },
  },
  computed: {
    multiplied: function () {
      return this.count * this.factor
    },
  },
  methods: {
    increment: function () {
      this.count++
    },
  },
})
</script>

<template>
  <div>
    <button
      @click="increment"
      class="btn btn-sm me-2"
      :class="{ 'btn-outline-primary': isOdd, 'btn-outline-success': !isOdd }"
    >
      <i class="bi bi-plus"></i>
    </button>
    {{ count }} * {{ factor }} = {{ multiplied }}
  </div>
</template>

<style scoped></style>
