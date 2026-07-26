(() => {
  const year = new Date().getFullYear();
  document.querySelectorAll("[data-current-year]").forEach((node) => {
    node.textContent = String(year);
  });

  const toggle = document.querySelector("[data-menu-toggle]");
  const menu = document.querySelector("[data-site-menu]");
  if (!toggle || !menu) return;

  toggle.addEventListener("click", () => {
    const open = menu.dataset.open !== "true";
    menu.dataset.open = String(open);
    toggle.setAttribute("aria-expanded", String(open));
    toggle.textContent = open ? "Закрыть" : "Меню";
  });
})();
