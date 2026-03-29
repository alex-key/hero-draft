import type { OxfmtConfig } from 'oxfmt'

export default {
  printWidth: 80,
  tabWidth: 2,
  useTabs: false,
  semi: false,
  singleQuote: true,
  singleAttributePerLine: false,
  htmlWhitespaceSensitivity: 'css',
  sortImports: {},
  sortTailwindcss: {
    functions: ['clsx', 'cn', 'cva'],
    stylesheet: 'resources/css/app.css',
  },
  overrides: [
    {
      files: '**/*.yml',
      options: {
        tabWidth: 2,
      },
    },
  ],
} satisfies OxfmtConfig
