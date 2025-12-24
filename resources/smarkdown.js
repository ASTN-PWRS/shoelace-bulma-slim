// s-markdown.js
function markdownItMermaid(md) {
  const defaultFence =
    md.renderer.rules.fence ||
    function (tokens, idx, options, env, self) {
      return self.renderToken(tokens, idx, options);
    };

  md.renderer.rules.fence = function (tokens, idx, options, env, self) {
    const token = tokens[idx];
    if (token.info.trim() === "mermaid") {
      return `<div class="mermaid">${token.content.trim()}</div>`;
    }
    return defaultFence(tokens, idx, options, env, self);
  };
}

class SMarkdown extends HTMLElement {
  static get observedAttributes() {
    return ["src"];
  }

  constructor() {
    super();
    this.md = window.markdownit({ html: true });
    // markdown-it の初期化
    this.md = window.markdownit({ html: true });

    // 対応したいアドモニションの種類
    const types = [
      "note",
      "info",
      "tip",
      "success",
      "warning",
      "danger",
      "error",
    ];

    types.forEach((type) => {
      this.md.use(window.markdownitContainer, type, {
        validate: function (params) {
          return params.trim().startsWith(type);
        },
        render: function (tokens, idx) {
          if (tokens[idx].nesting === 1) {
            const title = type.charAt(0).toUpperCase() + type.slice(1);

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

    markdownItMermaid(this.md);
  }

  connectedCallback() {
    if (this.hasAttribute("src")) {
      this.loadFromSrc(this.getAttribute("src"));
    } else {
      this.renderMarkdown(this.textContent);
    }
  }

  attributeChangedCallback(name, oldVal, newVal) {
    if (name === "src" && newVal) {
      this.loadFromSrc(newVal);
    }
  }

  async loadFromSrc(url) {
    try {
      const res = await fetch(url);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const text = await res.text();
      this.renderMarkdown(text);
    } catch (err) {
      this.innerHTML = `<p style="color:red;">読み込みエラー: ${err.message}</p>`;
    }
  }

  renderMarkdown(markdown) {
    const html = this.md.render(markdown);
    this.innerHTML = html;

    // Mermaid の描画（ライト DOM なのでそのまま使える！）
    requestAnimationFrame(() => {
      try {
        window.mermaid.initialize({ startOnLoad: false });
        const mermaidBlocks = this.querySelectorAll(".mermaid");
        mermaidBlocks.forEach((el) => {
          if (el && el.textContent.trim()) {
            window.mermaid.init(undefined, el);
          }
        });
      } catch (err) {
        console.error("❌ Mermaid 描画エラー:", err);
      }
    });
  }
}

customElements.define("s-markdown", SMarkdown);
