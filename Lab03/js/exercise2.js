addBtn = document.querySelector(".btn-success");
resetBtn = document.querySelector(".btn-outline-primary");

addBtn.addEventListener("click", (e) => {
  const firstName = document.getElementById("firstname").value.trim();
  const lastName = document.getElementById("lastname").value.trim();
  const email = document.getElementById("email").value.trim();

  if (!firstName || !lastName || !email) {
    alert("Please fill out all fields");
    return;
  }
  const table = document.querySelector("tbody");
  const newRow = table.insertRow(-1);
  newRow.innerHTML = `
            <td>${firstName}</td>
            <td>${lastName}</td>
            <td>${email}</td>
            <td><button class="btn btn-danger btn-sm">Delete</button></td>
        `;
  document.getElementById("firstname").value = "";
  document.getElementById("lastname").value = "";
  document.getElementById("email").value = "";

  // Remove student when delete button is clicked
  document.querySelector("tbody").addEventListener("click", function (e) {
    if (e.target.classList.contains("btn-danger")) {
      const row = e.target.closest("tr");
      row.remove();
    }
  });
});

resetBtn.addEventListener("click", (e) => {
  document.getElementById("firstname").value = "";
  document.getElementById("lastname").value = "";
  document.getElementById("email").value = "";
});
