module.exports = {
  extends: [
    'plugin:@typescript-eslint/eslint-recommended',
    'plugin:@typescript-eslint/recommended',
  ],
  parserOptions: {
    parser: '@typescript-eslint/parser',
    sourceType: 'module',
    ecmaVersion: 2015,
  },
  plugins: ['prettier', '@typescript-eslint'],
  rules: {
    'prettier/prettier': [
      'warn',
      {
        singleQuote: true,
        trailingComma: 'all',
        semi: false,
        maxWidth: 120,
      },
    ],
    semi: ['warn', 'never'],
    'max-len': ['warn', { code: 120 }],
    'no-undef': ['off'],
    '@typescript-eslint/no-non-null-assertion': ['off'],
  },
  ignorePatterns: ['public/**/*'],
}
