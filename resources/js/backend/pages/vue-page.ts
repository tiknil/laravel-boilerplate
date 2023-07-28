import { createApp } from 'vue'
import CounterComposition from '../../vue/CounterComposition.vue'
import CounterOptions from '../../vue/CounterOptions.vue'

const initVuePage = () => {
  const page = document.getElementById('vue-page')

  if (page === null) return

  const compApp = createApp(CounterComposition, { factor: 4 }).mount(
    '#counter-composition',
  )

  const optApp = createApp(CounterOptions).mount('#counter-options')
}

initVuePage()
