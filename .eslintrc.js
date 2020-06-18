module.exports = {
    root: true,
    "env": {
        "browser": true,
        "commonjs": true,
        "es6": true,
        "node": true
    },
    "extends": ["plugin:prettier/recommended"],
    "globals": {
        "Atomics": "readonly",
        "SharedArrayBuffer": "readonly"
    },
    "parserOptions": {
        "ecmaVersion": 2018
    },
    "rules": {
        'no-unused-vars': 'error',
        'prettier/prettier': [
            'error',
            {
                semi: false,
                singleQuote: true,
                tabWidth: 2,
                useTabs: false,
                bracketSpacing: true,
                tslintIntegration: false,
            },
        ],
    }
};