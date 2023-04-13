import { Axios } from 'axios'
import { Toast, showToast } from '../utils/toast'

declare let axios: Axios

declare global {
  interface Window {
    axios: Axios
    TOASTS: Toast[]
    showToast: typeof showToast
  }
}
