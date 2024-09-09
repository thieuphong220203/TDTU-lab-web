document.addEventListener("DOMContentLoaded", function () {
  const messageInput = document.getElementById("message");
  const colorSelect = document.getElementById("color");
  const boldCheckbox = document.getElementById("bold");
  const italicCheckbox = document.getElementById("italic");
  const underlineCheckbox = document.getElementById("underline");
  const restoreBtn = document.querySelector(".btn-success");
  const alertBox = document.querySelector(".alert");

  function updateBox() {
    const message = messageInput.value;
    const color = colorSelect.value.toLowerCase();
    const bold = boldCheckbox.checked;
    const italic = italicCheckbox.checked;
    const underline = underlineCheckbox.checked;

    alertBox.textContent = message;
    alertBox.style.color = color;

    alertBox.style.fontWeight = bold ? "bold" : "normal";
    alertBox.style.fontStyle = italic ? "italic" : "normal";
    alertBox.style.textDecoration = underline ? "underline" : "none";
  }

  messageInput.addEventListener("input", updateBox);
  colorSelect.addEventListener("change", updateBox);
  boldCheckbox.addEventListener("change", updateBox);
  italicCheckbox.addEventListener("change", updateBox);
  underlineCheckbox.addEventListener("change", updateBox);

  restoreBtn.addEventListener("click", function () {
    messageInput.value = "";
    colorSelect.value = "Black";
    boldCheckbox.checked = false;
    italicCheckbox.checked = false;
    underlineCheckbox.checked = false;
    updateBox();
    alertBox.textContent =
      "This text will be changed immediately when typing new text.";
  });

  updateBox();
});
