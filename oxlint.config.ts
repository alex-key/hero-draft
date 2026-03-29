import type { Oxlintrc } from 'oxlint'

export default {
  plugins: ['vue', 'typescript'],
  env: {
    browser: true,
    es2022: true,
  },
  ignorePatterns: [
    'vendor',
    'node_modules',
    'public',
    'bootstrap/ssr',
    'tailwind.config.js',
    'vite.config.ts',
    'resources/js/components/ui/*',
  ],
  rules: {
    'vue/multi-word-component-names': 'off',
    'typescript/no-explicit-any': 'off',
    'typescript/consistent-type-imports': [
      'error',
      {
        prefer: 'type-imports',
        fixStyle: 'separate-type-imports',
      },
    ],
  },
} satisfies Oxlintrc
