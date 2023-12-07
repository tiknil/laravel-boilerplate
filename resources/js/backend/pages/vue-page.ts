import { createApp } from 'vue'
import Counter from '@/vue/Counter.vue'

const initVuePage = () => {
  const page = document.getElementById('vue-page')

  if (page === null) return

  const compApp = createApp(Counter, { factor: 4 }).mount(
    '#counter-composition',
  )
}

initVuePage()
