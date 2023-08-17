
['trigger-delete-modal'].map((item) => {

        window.addEventListener(item, e => {

               const { id, title, message, model } = e.detail;

                 Swal.fire({
                              title: title,
                              text: message,
                              icon: 'warning',
                              confirmButtonColor: '#d33',
                              denyButtonColor: '#d33',
                              showDenyButton: false,
                              showCancelButton: true,
                              confirmButtonText: 'Yes',
                              cancelButtonText: 'No'
                            })
                 .then((result) => {

                              if (result.isConfirmed) {
                                  Livewire.emit('trashDelete', { model, id });
                              }

                            })
                .catch(console.log)

        });

});


/* Toast Notification */
 window.addEventListener('toaster', event => {

    if(event.detail.status == "success") toastr.success(event.detail.message);
        else if(event.detail.status == "warning")  toastr.warning(event.detail.message);
        else if(event.detail.status == "info")  toastr.info(event.detail.message);
        else if(event.detail.status == "error")  toastr.error(event.detail.message);  
})


/* FlatPicker Date */
config = {
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        disableMobile: true,
        altFormat: "F j, Y"
}


flatpickr(".custom-date",{...config});
flatpickr(".custom-time",{ 
  noCalendar : true, 
  enableTime : true, 
  dateFormat: "H:i", 
  time_24hr: false, 
  minTime: "00:00",
  maxTime: "23:59",
  minuteIncrement: 1,
  altFormat : "h:i K",
  disable: [],
  onChange: function(selectedDates, dateStr, instance) {
    const selectedTime = selectedDates[0];

    // Reset the input and remove the background color
    instance.input.classList.remove("bg-danger");

    // Check if the selected time falls within the restricted ranges
    instance.config.disable.forEach(function(range) {
      const startTime = instance.parseDate(range.from, "H:i");
      const endTime = instance.parseDate(range.to, "H:i");

      if (selectedTime >= startTime && selectedTime <= endTime) {
        instance.input.value = "Not available";
        instance.input.classList.add("bg-danger");
      }
    });
  }
});


flatpickr(".custom-date-from-today",{...config, minDate:'today'});
flatpickr(".custom-date-range",{...config,mode: "range"});
flatpickr(".custom-datetime",{...config, enableTime: true, dateFormat : "Y-m-d H:i", altFormat: "F j, Y at h:i K", minDate: 'today'});
// flatpickr(".custom-date-from-today-range",{...config,mode: "range",minDate:'today'}); 


const inputField = document.querySelector('.validate-numbers');

inputField.addEventListener('input', (event) => {
    const input = event.target;
    const regex = /^[0-9]{0,15}$/; // allows only numbers and maximum of 15 characters
    if (!regex.test(input.value)) {
      input.value = input.value.slice(0, 15).replace(/[^0-9]/g, ''); // removes any non-numeric characters and limits to 15 characters
    }
  });

