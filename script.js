const dropdown = document.querySelector(".dropdown-content");

function toggleDropdown() {
  const parent = document.querySelector(".dropdown");
  parent.classList.toggle("show");

  if (parent.classList.contains("show")) {
    // ouverture
    dropdown.style.height = dropdown.scrollHeight + "px";
  } else {
    // fermeture
    dropdown.style.height = "0px";
  }
}

window.addEventListener("click", function(e) {
  if (!e.target.matches(".dropdown-button")) {
    document.querySelectorAll(".dropdown.show")
      .forEach(d => d.classList.remove("show"));
  }
});