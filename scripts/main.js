function showAlert(title,msg) {
  $("#dialog-message p").text(msg);
  $("#dialog-message").dialog({
    modal: true,
    title: title,
    buttons: {
      Ok: function() {
        $(this).dialog("close");
      }
    }
  });
};

function showActionAlert(title,msg) {
  $("#dialog-message p").text(msg);
  $("#dialog-message").dialog({
    modal: true,
    title: title,
    buttons: {
      Ok: function() {
        $(this).dialog("close");
        window.location.reload(true);
      }
    }
  });
};

function confirmDelete(e, url) {
  $( "#dialog-confirm" ).dialog({
    autoOpen: true,
    height: "auto",
    width: 350,
    modal: true,
    buttons: {
      "Continue": function() {          
        const id = $(e).parent()[0].dataset.id;
        $.post(url, {id:id}, (d, status, xhr) => {
          if (status == 'success') {
            console.log(d);
            const data = JSON.parse(d);
            console.log(data);
            if (data.status == 'success') {
              console.log("success");
              showActionAlert("Success", "Record successfully deleted");
            }else{
              console.log("error");
              showAlert("Error", "Error deleting record");
            }
          }
        })
        $(this).dialog("close");
        return true;
      },
      Cancel: function() {
        $(this).dialog("close");
        return false;
      }
    },
    close: function() {
      // form[ 0 ].reset();
      // allFields.removeClass( "ui-state-error" );
      return false;
    }
  });
}