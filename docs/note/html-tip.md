# 不常用功能

## 图片懒加载
* 滚动到才开始加载
* can i use: 73.98% (2021/06/22)
``` html
<img src='image.jpg' loading='lazy' alt='Alternative Text'> 
```

## 电子邮件、电话和短信链接
``` html
<a href="mailto:{email}?subject={subject}&body={content}">
  Send us an email
</a>

<a href="tel:{phone}">
  Call us
</a>

<a href="sms:{phone}?body={content}">
  Send us a message
</a>
```

## ol更改起点
``` html
<!-- 从11开始计数 -->
<ol start="11">
  <li>html</li>
  <li>css</li>
  <li>js</li>
</ol>
```

## 仪表元素
``` html
<label for="value1">Low</label>
<meter id="value1" min="0" max="100" low="30" high="75" optimum="80" value="25"></meter>
<!-- meter无需css即可展示进度等 -->
```

## 刷新网站收藏夹
``` html
<link rel="icon" href="/favicon.ico?v=2" />
```

## 视频缩略图
``` html
<video poster="path/to/image"> 
```