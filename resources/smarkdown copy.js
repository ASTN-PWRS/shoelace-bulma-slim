// s-markdown.js
import {
  markdownItMermaidPlugin,
  markdownItShoelaceAlerts,
  markdownItCustomAttrs,
  markdownItLinkDefaults,
} from "./plugins/index";

class SMarkdown extends HTMLElement {
  static get observedAttributes() {
    return ["src"];
  }

  constructor() {
    super();
    // markdown-it の初期化
    this.md = window.markdownit({ html: true });
    this.md.use(markdownItMermaidPlugin);
    this.md.use(markdownItShoelaceAlerts);
    this.md.use(markdownItCustomAttrs);
    this.md.use(markdownItLinkDefaults);
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

    // Shoelace dialog を一度だけ追加
    if (!document.querySelector("#mermaid-zoom-dialog")) {
      const dialog = document.createElement("sl-dialog");
      dialog.id = "mermaid-zoom-dialog";
      dialog.label = "Mermaid Zoom View";
      dialog.style.setProperty("--width", "90vw");
      dialog.innerHTML = `
      <div id="dialog-svg-container" style="width:100%; height:80vh; overflow:hidden;"></div>
      <sl-button slot="footer" variant="primary" onclick="this.closest('sl-dialog').hide()">閉じる</sl-button>
    `;
      document.body.appendChild(dialog);
    }

    // Mermaid の描画
    requestAnimationFrame(() => {
      try {
        window.mermaid.initialize({ startOnLoad: false });
        const mermaidBlocks = this.querySelectorAll(".mermaid");

        mermaidBlocks.forEach((el, index) => {
          const graphDef = el.textContent.trim();
          if (!graphDef) return;

          // Mermaid描画
          window.mermaid.render(`mmd-${index}`, graphDef, (svgCode) => {
            el.innerHTML = svgCode;

            // クリックでダイアログ表示
            el.style.cursor = "zoom-in";
            el.addEventListener("click", () => {
              const dialog = document.querySelector("#mermaid-zoom-dialog");
              const container = dialog.querySelector("#dialog-svg-container");
              container.innerHTML = ""; // 前回の内容をクリア

              // 再描画して挿入
              window.mermaid.render(
                `dialog-mmd-${index}`,
                graphDef,
                (dialogSvg) => {
                  container.innerHTML = dialogSvg;

                  const svg = container.querySelector("svg");
                  if (svg) {
                    panzoom(svg, {
                      maxScale: 5,
                      minScale: 1,
                      contain: "outside",
                      zoomSpeed: 0.065,
                    });
                  }

                  dialog.show();
                }
              );
            });
          });
        });
      } catch (err) {
        console.error("❌ Mermaid 描画エラー:", err);
      }
    });
  }
  // renderMarkdown(markdown) {
  //   const html = this.md.render(markdown);
  //   this.innerHTML = html;

  //   // Mermaid の描画（ライト DOM なのでそのまま使える！）
  //   requestAnimationFrame(() => {
  //     try {
  //       window.mermaid.initialize({ startOnLoad: false });
  //       const mermaidBlocks = this.querySelectorAll(".mermaid");
  //       mermaidBlocks.forEach((el) => {
  //         if (el && el.textContent.trim()) {
  //           window.mermaid.init(undefined, el);
  //         }
  //       });
  //     } catch (err) {
  //       console.error("❌ Mermaid 描画エラー:", err);
  //     }
  //   });
  // }
}

customElements.define("s-markdown", SMarkdown);
