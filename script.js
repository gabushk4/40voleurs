function toggleDropdown() {
  document.querySelector(".dropdown").classList.toggle("show");
}

window.addEventListener("click", function(e) {
  if (!e.target.matches(".dropdown-button")) {
    document.querySelectorAll(".dropdown.show")
      .forEach(d => d.classList.remove("show"));
  }
});