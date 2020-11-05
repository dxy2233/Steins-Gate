# powershell

## 美化
- 确保是新版powershell
  - gitlog信息无法正确显示中文的解决办法:

    系统环境变量中添加变量LESSCHARSET为utf-8
    ```
    git config --global core.quotepath false
    git config --global gui.encoding utf-8
    git config --global i18n.commit.encoding utf-8
    git config --global i18n.logoutputencoding utf-8
    $env:LESSCHARSET='utf-8'
    ```

- 字体:
  - [Fira Code](https://github.com/tonsky/FiraCode)

- git美化 `Install-Module posh-git -Scope CurrentUser`

- 主题库 `Install-Module oh-my-posh -Scope CurrentUser`
  - [官方库](https://github.com/ohmyzsh/ohmyzsh/tree/master/themes)

- 安装vscode后输入`code $profile`打开powershell初始化配置
  ```
  Import-Module posh-git
  Import-Module oh-my-posh
  Set-Theme Paradox
  ```

- 使用Terminal 
  - 添加powershell对象
    ```json
    {
      "guid": "{dcec86a8-ddc6-8d3c-e7a7-384e218d8f0f}",
      "hidden": false,
      "name": "pwsh",
      "commandline": "D:/powershell/7/pwsh.exe -nologo",
      "icon": "D:/powershell/7/assets/Powershell_av_colors.ico",
      "fontFace": "Fira Code", // 推荐字体
      "fontSize": 11,
      "historySize": 9001,
      "padding": "5, 5, 20, 25",
      "snapOnInput": true,
      "useAcrylic": false,
    }
    ```
  - [windowsterminalthemes](https://windowsterminalthemes.dev/) terminal主题网站
  - window资源管理器ALT+l开始编辑地址栏，输入wt在次目录打开terminal

