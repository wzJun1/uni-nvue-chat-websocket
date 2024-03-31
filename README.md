# Archived
本仓库已经停止维护，你仍然继续阅读源码及创建分叉，但本仓库不会继续更新，也不会回答任何 issue。

推荐uni-app项目使用开源IMSDK：[YeIM-Uni-SDK](https://github.com/wzJun1/YeIM-Uni-SDK)

This repo has stopped maintenance, you can still continue to read the source code and create forks, but this repo will not continue to be updated, nor will it answer any issues.

It is recommended to use the open source IMSDK: [YeIM-Uni-SDK](https://github.com/wzJun1/YeIM-Uni-SDK) for uni-app projects.

![微信公众号.png](https://s2.loli.net/2024/03/31/MHE1CD3WtP2nUOQ.jpg)

# uni-nvue-chat-websocket



本项目需要搭配 [uni-nvue-chat](https://github.com/wzJun1/uni-nvue-chat) 使用，基于 https://github.com/walkor/workerman-chat 二次修改



# 下载安装

1、git clone https://github.com/wzJun1/uni-nvue-chat-websocket



# 项目端口

start_gateway.php

```php
new Gateway("Websocket://0.0.0.0:6621")
```



# 启动停止(Linux系统)

以debug方式启动
`php start.php start`



以daemon方式启动
`php start.php start -d`



# 启动(windows系统)

双击start_for_win.bat

注意：
windows系统下无法使用 stop reload status 等命令
如果无法打开页面请尝试关闭服务器防火墙

