# osu!next 签名生成器 v3

这是一个用 PHP 开发的 osu!next 风格的签名生成器。这个签名的设计是基于 flyte 的。

查看效果以及生成签名请点击 https://osusig.lolicon.app

## 使用方法

签名是通过提交请求到`sig.php`生成的，作者原文此处仅仅讲解了参数，如果只是想生成签名的话直接访问上面给出的站点在线生成即可。

想看作者原文档请点击[这里](https://github.com/Lemmmy/osusig)

## 属性示例

| 颜色      | 用户名      | 模式               |                                    签名图像                                     |
| --------- | ----------- | ------------------ | :-----------------------------------------------------------------------------: |
| 黄色      | `Mashir0`   | 未定义（默认戳饼） |      ![1](https://osusig.lolicon.app/sig.php?colour=yellow&uname=Mashir0)       |
| 深紫色    | `sobatsuyu` | `1`（太鼓）        |   ![2](https://osusig.lolicon.app/sig.php?colour=pink&uname=sobatsuyu&mode=1)   |
| `#EE3333` | `hvick225`  | `0`（戳饼）        | ![3](https://osusig.lolicon.app/sig.php?colour=hexEE3333&uname=hvick225&mode=0) |

### 在线生成示例

| URL                                                                            |                                      签名图像                                      |
| ------------------------------------------------------------------------------ | :--------------------------------------------------------------------------------: |
| `https://osusig.lolicon.app/sig.php?colour=purple&uname=Mashir0`               |        ![4](https://osusig.lolicon.app/sig.php?colour=purple&uname=Mashir0)        |
| `https://osusig.lolicon.app/sig.php?colour=blue&uname=rrtyui&pp=2`             |       ![5](https://osusig.lolicon.app/sig.php?colour=blue&uname=rrtyui&pp=2)       |
| `https://osusig.lolicon.app/sig.php?colour=yellow&uname=jhlee0133&mode=3&pp=1` | ![6](https://osusig.lolicon.app/sig.php?colour=yellow&uname=jhlee0133&mode=3&pp=1) |

## 部署项目需求

如果你使用的 PHP 版本在 7.2 以下并且部署完发现有问题无法正常使用，请尝试使用`under-php-72`分支

这个项目需要 ImageMagick 以及 memcached 这两个 PHP 扩展  
你还需要在项目根目录新建一个名字为`p`的文件夹，并在里面新建一个名为`.priv.php`的文件，然后在里面写入如下 PHP 代码：

```php
<?php
define("AKEY", "your-osu!-api-key");
```

这个文件夹中的内容最好通过`.htaccess`或者 nginx 的配置来阻止他人访问

如果你还没有 api-key，你可以到这个链接去申请 https://osu.ppy.sh/p/api

## 感谢

网站图标(favicon)由皮皮 peppy 提供。模式(mode)图标是由 Flyte 设计的，你可以在[这里](https://www.pixelapse.com/flyte/projects/osu!designs/files/)查看（貌似打不开了）。`triangles.png`以及`triangles2.png`是由原作者 Lemmmy 自制的。

整个程序由 Lemmmy 开发。

## 许可

除了以下文件外都遵循 GPL-v3 许可：

```text
fonts/*
flags/*
modes/*
img/ctb.png
img/mania.png
img/taiko.png
img/osu.png
img/tris.png
```

以下文件遵循 AGPL-v3 许可，并且来自于皮皮的 [osu-web](https://github.com/ppy/osu-web) 项目：

```text
fonts/osu!font.ttf
img/ctb.png
img/mania.png
img/taiko.png
img/osu.png
```

在`flags`目录中的国旗图片由 Muharrem Şenyıl 制作，你可以到 [Dribbble](https://dribbble.com/shots/1211759-Free-195-Flat-Flags) 网站查看。
