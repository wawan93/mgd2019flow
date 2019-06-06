document.addEventListener('DOMContentLoaded', () => {
  const toggleFieldsButtons = document.querySelectorAll('.collector-table__toggle-passport-button')
  const passportFields = document.querySelectorAll('.collector-table__passport input, .collector-table__passport textarea')

  if (toggleFieldsButtons.length === 0) {
    return
  }

  const updateFilledFieldsCount = () => {
    document.querySelectorAll('.collector-table tbody tr').forEach(el => {
      const toggleFieldsButton = el.querySelector('.collector-table__toggle-passport-button')
      const fields = [
        el.querySelector('input[name=surname]').value,
        el.querySelector('input[name=name]').value,
        el.querySelector('input[name=middlename]').value,
        el.querySelector('input[name=birthday]').value,
        el.querySelector('input[name=passport_number]').value,
        el.querySelector('input[name=passport_issue_date]').value,
        el.querySelector('textarea[name=passport_issued_by]').value,
        el.querySelector('textarea[name=passport_address]').value
      ]

      const nonEmptyFieldsNum = fields.filter(field => field !== '').length
      toggleFieldsButton.innerHTML = `показать (${nonEmptyFieldsNum}/${fields.length})`
    })
  }

  updateFilledFieldsCount()

  passportFields.forEach(el => {
    el.addEventListener('change', updateFilledFieldsCount)
  })

  toggleFieldsButtons.forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault()

      const fieldsDiv = el.parentNode.querySelector('.collector-table__passport-fields')
      const fieldsState = getComputedStyle(fieldsDiv).display

      if (fieldsState === 'none') {
        fieldsDiv.style.display = 'block'
      } else {
        fieldsDiv.style.display = 'none'
      }
    })
  })
});
