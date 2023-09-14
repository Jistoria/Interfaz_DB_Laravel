let modalVisible = false;

function openModal() {
  modalVisible = true;
  var modal = document.getElementById("modal");
  modal.style.display = "block";
  console.log('si se envio')
}

function closeModal() {
  modalVisible = false;
  var modal = document.getElementById("modal");
  modal.style.display = "none";
}
