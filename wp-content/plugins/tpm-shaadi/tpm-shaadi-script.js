jQuery(document).ready(function ($) {




    
  $(document).ready(function () {
    $("#tpm-shaadi-form").on("submit", function (e) {
      e.preventDefault();

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
        },
        error: function (xhr, ajaxOptions, thrownError) {
          // Display error message
          alert("Error: " + thrownError);
        },
      });
    });
  });
});
