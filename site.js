(() => {
  const year = new Date().getFullYear();
  document.querySelectorAll("[data-current-year]").forEach((node) => {
    node.textContent = String(year);
  });

  const toggle = document.querySelector("[data-menu-toggle]");
  const menu = document.querySelector("[data-site-menu]");
  if (toggle && menu) {
    toggle.addEventListener("click", () => {
      const open = menu.dataset.open !== "true";
      menu.dataset.open = String(open);
      toggle.setAttribute("aria-expanded", String(open));
      toggle.textContent = open ? "Закрыть" : "Меню";
    });
  }

  const map = document.querySelector("[data-interactive-map]");
  if (!map) return;

  const pins = [...map.querySelectorAll("[data-map-target]")];
  const panels = [...map.querySelectorAll("[data-map-panel]")];

  pins.forEach((pin) => {
    pin.addEventListener("click", () => {
      const target = pin.dataset.mapTarget;
      pins.forEach((item) => item.setAttribute("aria-pressed", String(item === pin)));
      panels.forEach((panel) => {
        panel.hidden = panel.dataset.mapPanel !== target;
      });
    });
  });
})();
