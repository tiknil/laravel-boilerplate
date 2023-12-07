export function initMultiSelect(rootEl: Element) {
  const isMultiple = rootEl.hasAttribute('data-multiple')

  const formField = rootEl.querySelector('.ms-form-field') as HTMLElement

  const badgeTemplate = rootEl.querySelector(
    'template.ms-badge-template',
  ) as HTMLTemplateElement
  const hiddenInputTemplate = rootEl.querySelector(
    'template.ms-input-template',
  ) as HTMLTemplateElement

  const ghostInput = rootEl.querySelector(
    'input.ms-ghost-input',
  ) as HTMLInputElement

  const fakeInput = rootEl.querySelector(
    'input.ms-hidden-fake-input',
  ) as HTMLInputElement

  const optionDropwdown = rootEl.querySelector(
    '.ms-options',
  ) as HTMLUListElement

  const optionElements: Record<string, HTMLLIElement> = {}
  optionDropwdown
    .querySelectorAll('.ms-options .ms-option')
    .forEach((optionEl: Element) => {
      const elValue = optionEl.getAttribute('data-value') ?? ''
      optionElements[elValue] = optionEl as HTMLLIElement

      optionEl.addEventListener('click', () => {
        if (selected[elValue] === undefined) {
          selectOption(elValue)
        } else {
          removeOption(elValue)
        }
      })
    })

  const emptyOption = optionDropwdown.querySelector(
    '.ms-empty-option',
  ) as HTMLElement

  /*
   * Gestione visualizzazione del dropdown
   */
  ghostInput.addEventListener('focus', () =>
    optionDropwdown.classList.add('open'),
  )

  formField.addEventListener('click', () => ghostInput.focus())

  document.addEventListener('click', (e) => {
    if (!rootEl.contains(e.target as Node)) {
      optionDropwdown.classList.remove('open')
    }
  })

  const selected: Record<string, string> = {}

  const fakeInputUpdate = () => {
    fakeInput.value = Object.keys(selected).join(',')
  }

  const selectOption = (value: string, addHiddenInput: boolean = true) => {
    if (selected[value] !== undefined) {
      return
    }

    if (!isMultiple) {
      Object.keys(selected).forEach(removeOption)
    }

    const label = optionElements[value]?.innerText.trim()

    selected[value] = label

    fakeInputUpdate()

    // Aggiunta input nascosto

    if (addHiddenInput) {
      const hiddenInputFragment = hiddenInputTemplate.content.cloneNode(
        true,
      ) as DocumentFragment
      const newHiddenInput =
        hiddenInputFragment.firstElementChild as HTMLInputElement
      newHiddenInput.value = value

      rootEl.appendChild(newHiddenInput)
    }

    // Aggiungo badge

    const newBadge = badgeTemplate.content.cloneNode(true) as HTMLSpanElement

    newBadge.firstElementChild?.setAttribute('data-value', value)
    ;(newBadge.querySelector('.ms-badge-label') as HTMLSpanElement).innerText =
      label
    ;(newBadge.querySelector('.ms-remove-btn') as HTMLElement).addEventListener(
      'click',
      (e) => {
        e.stopPropagation()
        removeOption(value)
      },
    )

    formField.insertBefore(newBadge, ghostInput)

    // Visualizzo il check nel dropdown
    optionElements[value]?.classList.add('selected')
  }

  const removeOption = (value: string) => {
    if (selected[value] === undefined) {
      return
    }

    delete selected[value]

    fakeInputUpdate()

    // Rimuovi input nascosto

    formField.querySelectorAll('input.ms-input-hidden').forEach((inputEl) => {
      const elValue = (inputEl as HTMLInputElement).value
      if (value === elValue) {
        inputEl.remove()
      }
    })

    // Rimuovo badge

    formField.querySelectorAll('.ms-badge').forEach((badgeEl) => {
      const badgeValue = (badgeEl as HTMLSpanElement).getAttribute('data-value')
      if (value === badgeValue) {
        badgeEl.remove()
      }
    })

    // Nascondo il check nel dropdown
    optionElements[value]?.classList.remove('selected')
  }

  const onSearch = (searched: string) => {
    searched = searched.toLowerCase().trim()

    let hasVisibleOptions = false

    if (searched === '') {
      optionDropwdown
        .querySelectorAll('.ms-options .ms-option.hidden')
        .forEach((optionEl) => optionEl.classList.remove('hidden'))

      hasVisibleOptions = Object.keys(optionElements).length > 0
    } else {
      Object.values(optionElements).forEach((optionEl) => {
        const label = optionEl.innerText.trim().toLowerCase()

        if (label.includes(searched)) {
          optionEl.classList.remove('hidden')
          hasVisibleOptions = true
        } else {
          optionEl.classList.add('hidden')
        }
      })
    }

    hasVisibleOptions
      ? emptyOption.classList.add('hidden')
      : emptyOption.classList.remove('hidden')
  }

  /*
   * Inizializzo i dati dei selezionati
   */

  rootEl.querySelectorAll('input.ms-input-hidden').forEach((inputEl) => {
    const value = (inputEl as HTMLInputElement).value
    selectOption(value, false)
  })

  ghostInput.addEventListener('input', () => onSearch(ghostInput.value))

  onSearch(ghostInput.value)
}

document.querySelectorAll('div.ms-wrapper').forEach(initMultiSelect)
