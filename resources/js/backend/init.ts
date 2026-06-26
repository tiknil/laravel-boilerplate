import * as bootstrap from 'bootstrap'
import { showToast } from '@/utils/toast'

window.bootstrap = bootstrap

/*
 * TOASTS
 */
window.TOASTS.forEach((t) => showToast(t.type, t.message))

/*
 * TOOLTIPS
 */
/*
 * TOOLTIPS
 */
function initTooltips() {
  const els = document.querySelectorAll('[data-bs-tooltip]')
  els.forEach((el) => {
    const inst = bootstrap.Tooltip.getInstance(el)
    if (inst) inst.dispose()
    new bootstrap.Tooltip(el)
  })
}

document.addEventListener('DOMContentLoaded', () => {
  initTooltips()

  if (typeof window.Livewire !== 'undefined') {
    window.Livewire.hook('morphed', () => {
      initTooltips()
    })
  }
})

/*
 * SIDEBAR
 */
const sidebar = document.querySelector('.sidebar')

if (sidebar) {
  const currentUrl = window.location.origin + window.location.pathname

  sidebar.querySelectorAll('a.nav-link').forEach((navLink) => {
    if ((navLink as HTMLLinkElement).href === currentUrl) {
      navLink.classList.add('active')

      const collapseParent = navLink.closest('.collapse')

      if (collapseParent == null) return

      let sibling = collapseParent.previousElementSibling

      while (sibling != null) {
        if (sibling.classList.contains('nav-title') && sibling.classList.contains('collapsed')) {
          ;(sibling as HTMLElement).click()

          break
        }
        sibling = sibling.previousElementSibling
      }
    }
  })
}
