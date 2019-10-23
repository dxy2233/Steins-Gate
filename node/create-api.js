const cheerio = require('cheerio')
const superagent = require('superagent') // ajax
const fs = require('fs')
const path = require('path')

let baseText = {} // 全部文档
const apiPath = 'D:/october/src/api/' // 文件夹路径

// 获取文档
const getData = async () => {
await superagent
  .get('http://192.168.0.108:8084/v2/api-docs')
  .then(res => {
    baseText = JSON.parse(res.text)
  })
}

const create = async () => {
  baseText.tags.forEach(item => {
    // 生成文件名
    let name = item.description.split(' ')
    name.pop()
    name[0] = name[0].toLowerCase()
    name = name.join('').replace()
    // 写入文件
    // fs.access(apiPath + 'Login.js', fs.constants.F_OK, err => {
    //  let has = err ? false : true
    //  if (has) {
    //    console.log('存在')
    //  } else {
    //    console.log('不存在')
    //  }
    // })
    fs.writeFile(`../${name}.js`, 'test', err => {
      console.log(err)
    })
  })
}

// 运行
const run = async () => {
  await getData()
  create()
}

run()