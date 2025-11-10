function mostrarLoader() {
  const loader = document.getElementById("loaderOverlay");
  loader.style.display = "flex";
  loader.style.opacity = "1";
}

function ocultarLoader() {
  const loader = document.getElementById("loaderOverlay");
  loader.style.opacity = "0";
  setTimeout(() => (loader.style.display = "none"), 300);
}
