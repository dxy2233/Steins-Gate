//判断浏览器是否支持FileReader接口
if (typeof FileReader == 'undefined') {
  document.getElementById('...').InnerHTML =
    '<h1>当前浏览器不支持FileReader接口</h1>'
  //使选择控件不可操作
  document.getElementById('...').setAttribute('disabled', 'disabled')
}

//选择图片，马上预览
function xmTanUploadImg(obj) {
  var file = obj.files[0]

  console.log(obj)
  console.log(file)
  console.log('file.size = ' + file.size) //file.size 单位为byte

  var reader = new FileReader()

  //读取文件过程方法
  reader.onloadstart = function (e) {
    console.log('开始读取....')
  }
  reader.onprogress = function (e) {
    console.log('正在读取中....')
  }
  reader.onabort = function (e) {
    console.log('中断读取....')
  }
  reader.onerror = function (e) {
    console.log('读取异常....')
  }
  reader.onload = function (e) {
    console.log('成功读取....')

    var img = document.getElementById('...')
    img.src = e.target.result
    //或者 img.src = this.result;  //e.target == this
  }

  reader.readAsDataURL(file)
}
