document.addEventListener('DOMContentLoaded', () => {
  const newEventModal = document.querySelector('.new-event-modal')

  if(newEventModal === null) {
    return
  }

  $('.new-event-modal__collectors').select2({
    theme: 'bootstrap4',
    multiple: true,
    allowClear: true
  })

  $('.events__collectors-select').select2({
    theme: 'bootstrap4',
    multiple: true,
    allowClear: true
  })
})
