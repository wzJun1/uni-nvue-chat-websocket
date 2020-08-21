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

