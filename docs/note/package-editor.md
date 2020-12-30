# 编辑器

## 主题配色
[Dracula](https://draculatheme.com/)各类工具的吸血鬼色调主题网站

## vscode常用配置
```json
{
  // 字体首选firacode,次选雅黑
  "editor.fontFamily": "Fira Code Retina, Microsoft Yahei UI",
  // vim配置
  "vim.leader": "<space>",
  "vim.easymotion": true,
  "vim.normalModeKeyBindingsNonRecursive": [
    {
      "before": ["<leader>", "k"],
      "after": ["<leader>", "<leader>", "k"]
    },
    {
      "before": ["<leader>", "j"],
      "after": ["<leader>", "<leader>", "j"]
    },
    {
      "before": ["<leader>", "f"],
      "after": ["<leader>", "<leader>", "f"]
    },
    {
      "before": ["<leader>", "F"],
      "after": ["<leader>", "<leader>", "F"]
    },
  ],
  // eslint保存验证
  "editor.codeActionsOnSave": {
    "source.fixAll.eslint": true
  },
  // 触发eslint验证的文件类型
  "eslint.validate": [
    "javascript",
    "javascriptreact",
    "typescript",
    "typescriptreact",
    "vue",
    "html",
    "css",
  ],
  // 把xx文件视为yy文件（常用于小程序）
 "files.associations": {
    "*.wxss": "css",
    "*.wxs": "javascript",
    "*.acss": "css",
    "*.axml": "html",
    "*.wxml": "html",
    "*.swan": "html"
  },
}
```