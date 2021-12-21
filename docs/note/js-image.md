# 图片相关

## URL

* [URL.createObjectURL()](https://developer.mozilla.org/zh-CN/docs/Web/API/URL/createObjectURL)

* URL.revokeObjectURL()，URL对象生命周期跟随document，不需要时可通过该方法主动释放。

## jpg编码

常见标识段，每个字段都由ff开头 

| 名称 | 描述 | 编码 |
| ---- | ---- | ---- |
| SOI | 图像开始 | 0xffd8 |
| APPn | APP信息，都是可选信息 | 0xffe0~0xffef |
| SOS | 扫描开始 | 0xffda |
| EOI | 图像结束 | 0xffd9 |
| ...

* Exif信息在APP1(0xffe1)中，使用TIFF格式存储，需要区分字节序

| APP1 | 长度 | Exif的ASCII码+结束符 | 字节序标识 | 第一个IFD的偏移量(通常为8，从字节序开始计算) | DE数量 | ...IFD | offset to next IFD |
|---- | ---- | ---- | ---- | ---- | ---- | ---- | ---- |
| FF E1 | 3A 59 | 45 78 69 66 00 00 | 49 49 2A 00(小) / 4D 4D 00 2A(大) | 08 00 00 00(小) / 00 00 00 08(大) | 0F 00 | 每12字节一个DE | 4字节，为0代表已经是最后一个IFD，只有一副图像时就只有一个IFD |

DE结构

| 名称 | 字节数 | 数据类型 | 说明 |
| ---- | ---- | ---- | ---- |
| tag | 2 | Integer | 属性名 |
| type | 2 | Integer | 本属性的数据结构类型 |
| length | 4 | Long | 本属性值的字节数 |
| value/offset | 4 | Long | 属性值够放就是值，不够放则为偏移量，从字节序开始计算 |

* offset最大对应4个字节，因此不能超过4G；超过需要使用BigTiff格式