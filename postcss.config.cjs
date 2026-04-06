const prefixer = require('postcss-prefix-selector');

module.exports = {
  plugins: [
    require('@tailwindcss/postcss'),
    prefixer({
      prefix: '.w4-scope',
      transform(prefix, selector, prefixedSelector) {
        if (selector.startsWith('@')) {
          return selector;
        }
        if (selector.startsWith(':root') || selector.startsWith('html') || selector.startsWith('body')) {
          return prefix;
        }
        if (selector.startsWith(prefix)) {
          return selector;
        }
        return prefixedSelector;
      },
    }),
  ],
};
