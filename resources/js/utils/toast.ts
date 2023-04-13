export type Toast = {
  message: string
  type: 'error' | 'danger' | 'info' | 'warning' | 'success' | 'dark' | 'light'
}

export const showToast = (type: Toast['type'], message: Toast['message']) => {
  const toastWrapper = document.getElementById('toastes')

  if (!toastWrapper) return
  let bootstrapClass: string = type
  let textClass = 'white'
  switch (type) {
    case 'error':
      bootstrapClass = 'danger'
      break
    case 'info':
      bootstrapClass = 'primary'
      break
    case 'light':
      textClass = 'dark'
      break
  }
  const toastEl = document.createElement('div')
  toastEl.classList.add('toast', `text-${textClass}`, `bg-${bootstrapClass}`)

  toastEl.innerHTML = `<div class="d-flex">
        <div class="toast-body">${message}</div>
        <button
          type="button"
          class="btn-close btn-close-${textClass} me-1 m-auto"
          data-bs-dismiss="toast"
          aria-label="Close"
        ></button>
    </div>`

  toastWrapper.append(toastEl)
  window.bootstrap.Toast.getOrCreateInstance(toastEl).show()
}

export const toastsFromResponse = (responseData: any): number => {
  let n = 0
  if (responseData && responseData.meta && responseData.meta.toasts) {
    responseData.meta.toasts.forEach((item) => {
      showToast(item.type, item.message)
      n++
    })
  }
  return n
}

window.showToast = showToast
