import * as bootstrap from 'bootstrap'
import { showToast } from '@/utils/toast'
import '@/components/multi-select'

window.bootstrap = bootstrap

/*
 * TOASTS
 */
window.TOASTS.forEach((t) => showToast(t.type, t.message))

/*
 * TOOLTIPS
 */

const tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-tooltip]'),
)

const _tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
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
        if (
          sibling.classList.contains('nav-title') &&
          sibling.classList.contains('collapsed')
        ) {
          ;(sibling as HTMLElement).click()

          break
        }
        sibling = sibling.previousElementSibling
      }
    }
  })
}
