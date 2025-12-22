class SKatex extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this._observer = new MutationObserver(() => this._renderMath());
  }

  connectedCallback() {
    this._observer.observe(this, {
      childList: true,
      characterData: true,
      subtree: true
    });
    this._renderMath();
  }

  disconnectedCallback() {
    this._observer.disconnect();
  }

  _renderMath() {
    const raw = this.textContent?.trim() || '';
    const katex = window.katex;
    if (!katex || !this.shadowRoot) {
      console.warn('KaTeX is not loaded yet.');
      return;
    }

    try {
      this.shadowRoot.innerHTML = '';
      const span = document.createElement('span');
      katex.render(raw, span, {
        throwOnError: false,
        displayMode: this.hasAttribute('display-mode')
      });
      this.shadowRoot.appendChild(span);
    } catch (e) {
      this.shadowRoot.innerHTML = `<span style="color: red;">${e.message}</span>`;
    }
  }
}

customElements.define('s-katex', SKatex);
