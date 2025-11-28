function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
}
function setCookie(name, value, days) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/`;
}
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

  function selectCategorie(){
    
  }

window.addEventListener("click", function(e) {
  if (!e.target.matches(".dropdown-button")) {
    document.querySelectorAll(".dropdown.show")
      .forEach(d => d.classList.remove("show"));
  }
});

const toggle = document.getElementById('theme-toggle');
const html = document.documentElement;
console.log('theme', theme)

// Met à jour le label du bouton
toggle.textContent = theme === 'clair' ? 'mode sombre' : 'mode clair';

console.log('cookie', document.cookie)
toggle.addEventListener('click', () => {
  // Bascule le thème
  theme = html.getAttribute('data-theme') === 'clair' ? 'sombre' : 'clair';
  html.setAttribute('data-theme', theme);
  setCookie('theme', theme, 30)

  // Met à jour le label
  toggle.textContent = theme === 'clair' ? 'mode sombre' : 'mode clair';

});
