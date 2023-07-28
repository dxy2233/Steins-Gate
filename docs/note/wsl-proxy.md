# 本机代理

## 查看本机ip
  `cat /etc/resolv.conf`

## 设置环境变量
  查询到的IP设置到本机工具的端口号

  `export HTTP_PROXY=socks5://127.0.0.1:1080`

  `export HTTPS_PROXY=socks5://127.0.0.1:1080`
