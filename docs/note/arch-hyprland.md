# hyprland的一些问题

## edge

- waylnd启动时，解决输入法问题
  创建文件`~/.config/microsoft-edge-stable-flags.conf`, 加入内容
  ```
  --ozone-platform-hint=auto
  --enable-wayland-ime
  ```
