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

- 安装vscode后命令行输入`code $profile`打开powershell初始化配置
  ```
  Import-Module posh-git
  Import-Module oh-my-posh
  Set-PoshPrompt -Theme Powerlevel10k_Lean
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
  - [配置项目官方文档](https://docs.microsoft.com/zh-cn/windows/terminal/customize-settings/profile-settings)
  - [windowsterminalthemes](https://windowsterminalthemes.dev/) terminal主题网站
  - window资源管理器中ctrl+l光标跳转到地址栏，输入wt回车在此目录打开terminal

