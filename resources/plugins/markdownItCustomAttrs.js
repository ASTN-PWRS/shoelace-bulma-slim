export function markdownItCustomAttrs(md) {
  const attrRegex = /^\s*\{([^}]+)\}\s*$/;

  md.core.ruler.after("inline", "custom_attrs", function (state) {
    const tokens = state.tokens;
    for (let i = 0; i < tokens.length - 1; i++) {
      const token = tokens[i];
      const next = tokens[i + 1];

      if (next.type === "text" && attrRegex.test(next.content)) {
        const match = next.content.match(attrRegex);
        if (!match) continue;

        const attrString = match[1];
        const attrs = parseAttrs(attrString);

        if (!token.attrs) token.attrs = [];

        for (const [key, val] of attrs) {
          if (key === "class") {
            const existing = token.attrs.find(([k]) => k === "class");
            if (existing) {
              existing[1] += " " + val;
            } else {
              token.attrs.push(["class", val]);
            }
          } else {
            token.attrs.push([key, val]);
          }
        }

        // 属性トークンを削除
        tokens.splice(i + 1, 1);
      }
    }
  });

  function parseAttrs(str) {
    const result = [];
    const parts = str.match(/(?:[.#][\w-]+|\w+="[^"]+"|\w+='[^']+'|\w+=\S+)/g);
    if (!parts) return result;

    for (const part of parts) {
      if (part.startsWith(".")) {
        result.push(["class", part.slice(1)]);
      } else if (part.startsWith("#")) {
        result.push(["id", part.slice(1)]);
      } else {
        const [key, val] = part.split("=");
        result.push([key, val.replace(/^['"]|['"]$/g, "")]);
      }
    }
    return result;
  }
}
