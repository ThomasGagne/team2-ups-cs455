function passwordsMatch() {
  var input1 = document.getElementById("passwordEntry1");
  var input2 = document.getElementById("passwordEntry2");
  var status = document.getElementById("passwordStatus");
  var submitButton = document.getElementById("submitButton");

  if(input1.value === "" && input2.value === "") {
    status.style.color = "#f00";
    status.innerHTML = "Password cannot be empty!";
    submitButton.disabled = true;
  } else if(input1.value !== input2.value) {
    status.style.color = "#f00";
    status.innerHTML = "Passwords do not match!";
    submitButton.disabled = true;
  } else {
    status.style.color = "#0d0";
    status.innerHTML = "Passwords match :)";
    submitButton.disabled = false;
  }
}
