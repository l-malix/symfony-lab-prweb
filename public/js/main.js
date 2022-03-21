function returnBorrow(buttonRef, borrowId) {
  if (borrowId > 0) {
    $.ajax({
      url: "/returnBorrow",
      method: "POST",
      data: {
        id: borrowId,
      },
      success: function (theResults) {
        if (buttonRef !== null) {
          var refDIV = buttonRef.parentElement;
          var refTD = refDIV.parentElement;

          if (refTD !== null) {
            refTD.removeChild(refDIV);

            var currentDate = new Date(Date(theResults.returnedValue));
            var currentDateStr = currentDate.toLocaleDateString();
            var text = document.createTextNode(currentDateStr);
            refTD.appendChild(text);
          }
        }
      },
      error: function (theResults, theStatus, theError) {
        console.log(theStatus + " - " + theError);
      },
    });
  }
}
