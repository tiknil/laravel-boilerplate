import { debounce } from '@/utils/dom.ts'

class SearchSelect {
  rootEl: Element

  /* Dropdown elements */
  dropdown: HTMLElement
  dropdownSearch: HTMLInputElement
  dropdownOptions: Map<string, HTMLElement> = new Map()

  /* UI base elements */
  uiBox: HTMLElement
  placeholder: HTMLSpanElement
  valueLabel: HTMLSpanElement

  // Select element, hidden from the UI
  select: HTMLSelectElement

  // The current known value of the select
  current: string

  get emptyValue(): string {
    return (this.select.firstElementChild as HTMLOptionElement).value
  }

  constructor(rootEl: Element) {
    this.rootEl = rootEl

    this.dropdown = rootEl.querySelector('.ss-dropdown')!
    this.dropdownSearch = this.dropdown.querySelector(
      '.ss-dropdown-search input',
    )!

    this.uiBox = rootEl.querySelector('.ss-box')!

    this.placeholder = this.uiBox.querySelector('.ss-placeholder')!
    this.valueLabel = this.uiBox.querySelector('.ss-value-label')!

    this.select = rootEl.querySelector('.ss-ghost-select')!

    this.current = this.select.value

    this.init()
  }

  init = () => {
    this.populateDropdown()

    this.uiBox.addEventListener('click', () => this.toggle())

    document.addEventListener('click', (e) => {
      if (!this.rootEl.contains(e.target as Node)) {
        this.close()
      }
    })

    document.addEventListener('keyup', (e) => {
      if (e.key === 'Escape') {
        this.close()
      }
    })

    this.dropdownSearch.addEventListener('input', () =>
      debounce(this.search, 250)(),
    )

    this.dropdown.addEventListener('click', (event) => {
      const target = event.target as HTMLElement

      if (target.classList.contains('ss-remove-icon')) {
        this.onOptionSelected(this.emptyValue)
        this.close()
      } else if (target.classList.contains('ss-option')) {
        this.onOptionSelected(target.getAttribute('data-key'))
        this.close()
      }
    })

    this.select.addEventListener('change', this.update)

    this.update()

    this.initLivewire()
  }

  initLivewire = () => {
    if (!window['Livewire']) return

    window['Livewire'].hook('morph.updated', ({ el }) => {
      if (el !== this.select) {
        return
      }

      if (this.current !== this.select.value) {
        this.update()
      }

      setTimeout(() => this.populateDropdown(), 50)
    })
  }

  open = () => {
    this.dropdown.classList.remove('hidden')
    this.dropdownSearch.focus()
  }

  close = () => {
    this.dropdown.classList.add('hidden')

    this.dropdownSearch.value = ''
    this.dropdownSearch.dispatchEvent(new Event('input'))
  }

  toggle = () => {
    this.dropdown.classList.contains('hidden') ? this.open() : this.close()
  }

  search = () => {
    const s = this.dropdownSearch.value

    for (const [, opt] of this.dropdownOptions) {
      if (s === '') {
        opt.classList.remove('hidden')
      } else if (opt.innerText.includes(s)) {
        opt.classList.remove('hidden')
      } else {
        opt.classList.add('hidden')
      }
    }
  }

  populateDropdown = () => {
    const existingValues = new Set(this.dropdownOptions.keys())

    const template = this.rootEl.querySelector(
      '.ss-option-template',
    ) as HTMLTemplateElement

    const optionsWrapper = this.dropdown.querySelector('.ss-options')!

    this.select.querySelectorAll('option').forEach((option) => {
      if (option.value === this.emptyValue) return

      if (this.dropdownOptions.has(option.value)) {
        existingValues.delete(option.value)

        this.dropdownOptions
          .get(option.value)!
          .querySelector('span')!.innerText = option.innerText
        return
      }

      const dropdownOption = (template.content.cloneNode(true) as HTMLElement)
        .firstElementChild as HTMLElement

      console.log(dropdownOption)

      dropdownOption.setAttribute('data-key', option.value)
      dropdownOption.querySelector('span')!.innerText = option.label

      optionsWrapper.appendChild(dropdownOption)

      this.dropdownOptions.set(option.value, dropdownOption)
    })

    existingValues.forEach((val) => {
      this.dropdownOptions.get(val)?.remove()

      this.dropdownOptions.delete(val)
    })
  }

  onOptionSelected = (key: string | null) => {
    if (key == null) {
      key = this.emptyValue
    }

    this.select.value = key

    // Dispatch the event insted of calling update() so other listeners are notified
    // e.g. Livewire
    this.select.dispatchEvent(new Event('change'))
  }

  update = () => {
    this.current = this.select.value

    this.dropdown
      .querySelectorAll('.ss-option.selected')
      .forEach((opt) => opt.classList.remove('selected'))

    let label = ''

    if (this.current !== this.emptyValue) {
      const dropdownOpt = this.dropdownOptions.get(this.current)

      if (dropdownOpt) {
        dropdownOpt.classList.add('selected')

        label = dropdownOpt.innerText ?? ''
      }
    }

    if (label !== '') {
      this.valueLabel.innerHTML = label
      this.valueLabel.style.display = 'block'
      this.placeholder.style.display = 'none'
    } else {
      this.placeholder.style.display = 'block'
      this.valueLabel.style.display = 'none'
    }
  }
}

document
  .querySelectorAll('div.ss-wrapper')
  .forEach((el) => new SearchSelect(el))
