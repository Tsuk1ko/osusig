<html>
    <head>
        <title>osu!next 签名生成器</title>

        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/app.css">

        <link rel="icon" href="favicon.ico">

        <meta charset='UTF-8'>
        <meta name='keywords' content='osu, next, signature, generator, forum, sig'>
        <meta name='description' content='一个 osu!next 风格的签名生成器！'>
        <meta name='author' content='Lemmmy / JindaiKirin'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#bb1177">
        <meta name='handheldfriendly' content='true'>
        <meta name='mobileoptimized' content='480'>

        <script src="js/jquery.min.js"></script>
        <script src="js/prefixfree.min.js"></script>
        <script src="js/spectrum.js"></script>
        <script src="js/app.min.js"></script>
    </head>
    <body>
        <div class="page-header">
            <span class="title">osu!next 签名生成器</span><br>
            <span class="shameless-self-promotion">原作 by <a href="https://github.com/Lemmmy/osusig" target="_blank">Lemmmy</a> - 获取源代码请点击<a href="https://github.com/YKilin/osusig" target="_blank">这里</a> - 翻译&amp;修改 by <a href="https://lolico.moe" target="_blank">神代绮凛</a></span>
        </div>
        <header>选择一个颜色</header>
        <article>
            <ul class="colours">
                <li style="background-color: #e33" id="colour-red">红色</li>
                <li style="background-color: #e83" id="colour-orange">橙色</li>
                <li style="background-color: #fc2" id="colour-yellow">黄色</li>
                <li style="background-color: #ad0" id="colour-green">原谅色</li>
                <li style="background-color: #6cf" id="colour-blue">阿库娅色</li>
              	<li style="background-color: #25e" id="colour-darkblue">深阿库娅色</li>
                <br>
                <li style="background-color: #86e" id="colour-purple">紫色</li>
                <li style="background-color: #f6a" id="colour-bpink">粉色</li>
                <li style="background-color: #b17" id="colour-pink" class="selected">深紫色</li>
                <li style="background-color: #000" id="colour-black">Deep♂Dark♂Fantasy</li>
                <br>
                <br>
                <li style="background-color: #b17; background-repeat: no-repeat; background-position: center; text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4), 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px 1px rgba(0, 0, 0, 0.6)" id="colour-hex">自定义</li>
                <br>
                <br>
                <input type="text" id="hex-picker" />
            </ul>
        </article>
        <header>设置</header>
        <article style="text-align: center;">
            <label for="uname">游戏内名字</label>
            <input type="text" placeholder="-Kilin-" name="uname" id="uname" />
            <br><br>
            <label for="mode">Mode</label>
            <ul class="modes">
                <li class="osu selected" id="mode-osu"><img src="img/osu.png"><span>戳饼饼</span></li>
                <li class="taiko" id="mode-taiko"><img src="img/taiko.png"><span>敲鼓鼓</span></li>
                <li class="ctb" id="mode-ctb"><img src="img/ctb.png"><span>接果果</span></li>
                <li class="mania" id="mode-mania"><img src="img/mania.png"><span>弹琴琴</span></li>
            </ul>
            <br><br>
            <label for="ppmode">PP 显示</label>
            <ul class="ppmodes">
                <li id="ppmode--1" class="selected">不显示</li>
                <li id="ppmode-0">替换等级显示</li>
                <li id="ppmode-1">在 Acc 后显示</li>
                <li id="ppmode-2">在排名后显示</li>
            </ul>
            <br><br>
            <input type="checkbox" name="country-rank" /> 显示你的国家排名
        </article>
        <header>你的签名</header>
        <article style="text-align: center;">
            <div id="previewarea">
                <img src="sig.php?colour=pink&uname=-Kilin-" class="preview lazy" width="338" height="94">
            </div>
            <br>
            <label for="out">签名图片地址</label>
            <input type="text" name="out" id="out" value="https://osusig.lolico.moe/sig.php?colour=pink&uname=-Kilin-" style="width: 100%; text-align: center" readonly />
            <br><br>
            <a href="#" id="regen" class="button">生成</a>
        </article>
        <header>进阶选项</header>
        <article style="text-align: center;" class="twocol">
            <div class="twocol-col">
                <span>
                    <input type="checkbox" name="adv-av-margin" /> 移除头像额外的外边距
                </span>
                <span>
                    <input type="checkbox" name="adv-flag-shadow" /> 为国旗添加阴影
                </span>
                <span>
                    <input type="checkbox" name="adv-flag-stroke" /> 为国旗添加白色的描边
                </span>
                <span>
                    <input type="checkbox" name="adv-opaque-avatar" /> 为头像添加一个背景（头像含有透明部分时才有效果）
                </span>
               <span>
                    <input type="checkbox" name="adv-dark-triangles" /> 将标题背景中的三角形变暗
                </span>
            </div>
            <div class="twocol-col">
                <span>
                    <input type="checkbox" name="adv-dark-header" /> 使用在标题上使用暗色文字
                </span>
                <span>
                    <input type="checkbox" name="adv-avatar-rounding" /> 自定义头像的圆角半径
                    <input type="number" name="adv-avatar-rounding-num" min="0" value="4" disabled class="smallnumber"/>像素
                </span>
                <span>
                    <input type="checkbox" name="adv-ranked-score" /> 显示你的 Ranked 分数（替换 Play Count）
                </span>
                <span>
                    <input type="checkbox" name="adv-xp-bar" /> 在底部显示经验条
	            </span>
                <span>
                    <input type="checkbox" name="adv-xp-bar-hex" /> 将经验条的颜色换成你选择的颜色
	            </span>
            </div>
        </article>
    </body>
</html>
