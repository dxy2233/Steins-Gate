const fs = require('fs')
const path = require('path')
const COS = require('cos-nodejs-sdk-v5')
const { local } = require('./local.js')

const cos = new COS({
  SecretId: local.id,
  SecretKey: local.key,
})

// type是cos对象的内置方法 文档地址: https://cloud.tencent.com/document/product/436/8629
// getBucket 获取存储桶信息
// putObject 简单上传
// deleteMultipleObject 批量删除
const cosObject = (type, parame) => new Promise((resolve, reject) => {
  cos[type](Object.assign({
    Bucket: local.bucket,
    Region: local.region,
  }, parame), (err, data) => {
    err ? reject(err) : resolve(data)
  })
})

const uploadFile = filePath => new Promise((resolve, reject) => {
  let targetNum = 0 // 异步计数
  const resList = [] // 上传结果的统计
  const loop = filePath => {
    fs.readdir(filePath, (err, list) => {
      list.forEach(item => {
        const itemPath = path.resolve(filePath, item).replace(/\\/g, '\/')
        fs.stat(itemPath, (err, data) => {
          if (data.isFile()) {
            targetNum++
            cosObject('putObject', {
              Key: itemPath.slice(itemPath.indexOf('dist') + 5),
              Body: fs.createReadStream(itemPath),
            })
              .then(res => {
                resList.push(res)
                targetNum--
                if (targetNum === 0) resolve(resList)
              }).catch(err => reject(err))
          }
          else loop(itemPath)
        })
      })
    })
  }
  loop(filePath)
})

const removeFiles = bucketInfo => new Promise((resolve, reject) => {
  const allFile = bucketInfo.Contents
  // 按上传时间分类出不同的版本
  let typeArray = []
  const gapMax = 2 * 60 * 1000 // 上传间隔以2分钟为一类
  allFile.forEach((file, index) => {
    if (index === 0) {
      typeArray[0] = []
      typeArray[0].push(file)
      return
    }
    for (let i = 0; i < typeArray.length; i++) {
      const gap = new Date(file.LastModified).getTime() -
        new Date(typeArray[i][0].LastModified).getTime()
      if (Math.abs(gap) < gapMax) {
        typeArray[i].push(file)
        break
      }
      // 非同一时间段的文件创建添加到下一个数组
      if (i === typeArray.length - 1) {
        typeArray[i + 1] = []
        typeArray[i + 1].push(file)
        break
      }
    }
  })
  // 排序、删除最新2个版本之外的文件
  typeArray = typeArray.sort((a, b) => new Date(b[0].LastModified).getTime() -
    new Date(a[0].LastModified).getTime())
  if (typeArray.length < 3) {
    resolve('无过期版本')
    return
  }
  typeArray.splice(0, 2)
  const delFiles = typeArray.flat().map(file => {
    return { Key: file.Key }
  })
  cosObject('deleteMultipleObject', { Objects: delFiles }).then(res => resolve(res))
    .catch(err => reject(err))
})

const main = async () => {
  try {
    const uploadRes = await uploadFile('./docs/.vuepress/dist')
    console.log(uploadRes.map(item => item.Location))
    // const bucketInfo = await cosObject('getBucket')
    // const removeInfo = await removeFiles(bucketInfo)
    // console.log(removeInfo)
  } catch (err) {
    console.log(err)
  }
}
main()
