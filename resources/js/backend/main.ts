import '@/libs'
import * as bootstrap from 'bootstrap'

window.bootstrap = bootstrap

// Init tooltips
const tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-tooltip]'),
)

const _tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

/*
 * Set sidebar active element
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
          (sibling as HTMLElement).click()

          break
        }
        sibling = sibling.previousElementSibling
      }
    }
  })
}
