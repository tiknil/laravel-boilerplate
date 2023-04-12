import { Axios } from 'axios'

declare let axios: Axios

declare global {
  interface Window {
    axios: Axios
  }
}
