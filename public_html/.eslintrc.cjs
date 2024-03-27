module.exports = {
    "env": {
        "browser": true,
        "es2021": true,
        node: true,
        "jquery": true
    },
    "extends": "eslint:recommended",
    "overrides": [
    ],
    "parserOptions": {
        "ecmaVersion": "latest",
        "sourceType": "module"
    },
    "rules": {
        "prefer-const": "warn",
        "max-len": ["warn", { "code": 120, "ignoreUrls": true }],
        "semi": "warn"
    }
};
