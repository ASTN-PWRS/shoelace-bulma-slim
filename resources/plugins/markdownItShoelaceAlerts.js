export function markdownItShoelaceAlerts(md) {
  const types = [
    "note",
    "info",
    "tip",
    "success",
    "warning",
    "danger",
    "error",
  ];

  const variantMap = {
    note: "primary",
    info: "primary",
    tip: "success",
    success: "success",
    warning: "warning",
    danger: "danger",
    error: "danger",
  };

  const iconMap = {
    note: "info-circle",
    info: "info-circle",
    tip: "lightbulb",
    success: "check-circle",
    warning: "exclamation-triangle",
    danger: "exclamation-octagon",
    error: "exclamation-octagon",
  };

  types.forEach((type) => {
    md.use(window.markdownitContainer, type, {
      validate: (params) => params.trim().startsWith(type),
      render: (tokens, idx) => {
        if (tokens[idx].nesting === 1) {
          const title = type.charAt(0).toUpperCase() + type.slice(1);
          const variant = variantMap[type] || "neutral";
          const icon = iconMap[type] || "info-circle";

          return `<sl-alert variant="${variant}" open>
                    <sl-icon slot="icon" name="${icon}"></sl-icon>
                    <strong>${title}</strong><br>`;
        } else {
          return "</sl-alert>";
        }
      },
    });
  });
}
