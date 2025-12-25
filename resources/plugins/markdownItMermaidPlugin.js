export function markdownItMermaidPlugin(md) {
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
