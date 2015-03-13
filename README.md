potato
===
####flask风格的PHP框架
------------

###起子
flask是我最喜欢的Python的web框架，在PHP中我并没有找到一款能让我满意的web框架，所以我实现了一个API风格与flask类似的web框架，那就是potato

potato给开发者提供的接口与flask相似，这使得从flask转用php的同学能够最短时间内上手和开发，同时potato增加了一些我对flask的设计中并不满意的部分.如果您在使用的过程中发现问题,欢迎在github上给我提issue

这款框架适合web入门的新手和中等水平的开发者

###目录
+ [安装](potato/doc/1.安装.md)
    + 下载代码
    + Nginx配置
+ [快速开始](potato/doc/2.快速开始.md)
    + Hello world
    + 路由控制
    + 命名规范
    + 响应POST与GET
    + 数据库查询
    + 渲染视图
+ 配置(potato/doc/3.配置.md)
    + 选项解释
+ 路由(potato/doc/4.路由.md)
    + POST/GET的绑定
    + any绑定
    + 过滤器
+ 控制器
    + baseController
    + 响应json
    + 重定向
+ 模型
    + baseModel
    + query与queryOne
    + $echo参数
    + raw方法
+ 视图
    + 为什么是php后缀
    + static与media
    + 控制器到视图之间的变量传递
    + 前端开发规范建议
+ 工具
    + plugin与utils
    + 加密与解密类
    + 邮件类
    + 上传类
    + 增强的json
    + 调试工具
+ 日志(未完成)
+ 源码走读
    + 为什么如此多的静态类
    + 一次请求经历的流程
    + 从index开始
    + request类
    + 路由分发
    + response类