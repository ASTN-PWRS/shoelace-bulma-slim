export function markdownItLinkDefaults(md) {
  const defaultRender =
    md.renderer.rules.link_open ||
    function (tokens, idx, options, env, self) {
      return self.renderToken(tokens, idx, options);
    };

  md.renderer.rules.link_open = function (tokens, idx, options, env, self) {
    const token = tokens[idx];

    const hasTarget = token.attrIndex("target") !== -1;
    const hasRel = token.attrIndex("rel") !== -1;

    // すでに target や rel が指定されていなければ追加
    if (!hasTarget) {
      token.attrPush(["target", "_blank"]);
    }

    if (!hasRel) {
      token.attrPush(["rel", "noopener"]);
    }

    return defaultRender(tokens, idx, options, env, self);
  };
}
