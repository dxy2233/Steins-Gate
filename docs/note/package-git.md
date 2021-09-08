# git命令提示

## 删除本地、远程分支
`git branch -D <分支名>`

`git push origin --delete <name>`

## 重命名分支
`git branch -m <oldName> <newName>`

## 只拉取某个分支
`git clone --branch <分支名> --single-branch -- <url>`

## crlf、lf
`git config --global core.autocrlf  [true | input | false]  # 全局设置`

`git config --local core.autocrlf  [true | input | false] # 针对本项目设置`

* true 提交时转换为LF，检出时转换为CRLF
* input 提交时转换为LF，检出时不转换
* false 提交与检出的代码都保持文件原有的换行符不变（不转换）

## 合并上一次提交
`git commit --amend`

* 本地直接合并上一个commit，可连接 `-m '提示'` 直接更改提示语
* 远程使用 `-f` 强制提交也可直接合并，个人分支可用