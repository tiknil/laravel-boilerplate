import { Axios } from 'axios'
import { Toast, showToast } from '../utils/toast'
import Bootstrap from 'bootstrap'
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm'

declare let axios: Axios

declare global {
  interface Window {
    axios: Axios
    TOASTS: Toast[]
    bootstrap: typeof Bootstrap
    showToast: typeof showToast
    Livewire: Livewire
  }
}
