jQuery(document).ready(function ($) {

  $(document).ready(function () {
    $("#tpm-shaadi-form").on("submit", function (e) {
      e.preventDefault();

      // showing gender error
      let genderFields = document.getElementsByName('gender');
      let genderSelected = false;
      let errorElement = document.querySelector('.errors');

      for (let i = 0; i < genderFields.length; i++) {
        if (genderFields[i].checked) {
          genderSelected = true;
          break;
        }
      }

      if (!genderSelected) {
        errorElement.style.display = 'block';
        errorElement.textContent = 'Please select your gender';
        genderFields[0].focus();
        // event.preventDefault();
        return;
      } else {
        document.querySelector('.errors').style.display = 'none';
      }



      // Serialize form data
      var formData = $(this).serialize();

      // AJAX request
      $.ajax({
        type: "POST",
        url: ajax_object.ajax_url,
        data:
          formData +
          "&action=tpm_shaadi_ajax_request&security=" +
          ajax_object.security,
        success: function (response) {
          // Display success message (or handle response as needed)
          console.log(response);
          let responseObject = JSON.parse(response);
          // console.log(responseObject);

          if ('error' in responseObject) {
            errorElement.style.display = 'block';
            errorElement.textContent = responseObject.error;
          }
          else {
            errorElement.style.display = 'none';
            window.location.href = responseObject.success;
          }

        },
        error: function (xhr, ajaxOptions, thrownError) {
          // Display error message
          alert("Error: " + thrownError);
        },
      });
    });
  });



});
