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