<script setup lang="ts">
import {computed, ref, watch} from 'vue'

const props = withDefaults(defineProps<{ factor: number }>(), {factor: 2})

const count = ref(0)
const isOdd = ref(false)

function increment() {
  count.value++
}

watch(count, (newV) => (isOdd.value = newV % 2 === 1))

const multiplied = computed(() => count.value * props.factor)
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
    {{ count }} * {{ props.factor }} = {{ multiplied }}
  </div>
</template>
