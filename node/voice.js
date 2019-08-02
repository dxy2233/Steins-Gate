const superagent = require('superagent') // ajax
const fs = require('fs')
const crypto = require('crypto')

let fileInfo = fs.statSync('./audio/20190801100538970716822236.mp3') // 同步获取文件信息
let appid = '5d4281fe'
let key = 'f90cbe0ea81ddf98a134c3963f7114c1'
let ts = Date.parse(new Date()).toString().slice(0, -3)
let signa = appid + ts // 拼接id和时间
signa = crypto.createHash('md5').update(signa).digest('hex') // md5
signa = crypto.createHmac('sha1', key).update(signa).digest().toString('base64') // sha1后base64

// 预请求获得id
const getId = async () => {
  let temp
  await superagent
    .post('https://raasr.xfyun.cn/api/prepare')
    .set('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    .send({ app_id: appid })
    .send({ signa: signa })
    .send({ ts: ts })
    .send({ file_len: fileInfo.size })
    .send({ file_name: '20190801100538970716822236.mp3' })
    .send({ slice_num: 1 })
    .send({ has_seperate: true }) // 转写结果中是否包含发音人分离信息
    .then(res => {
      temp = JSON.parse(res.text).data
    })
  return temp
}

// 上传
const upload = async (id) => {
  await superagent
    // .post('http://192.168.0.108:8082/excel/import')
    .post('https://raasr.xfyun.cn/api/upload')
    .set('Content-Type', 'multipart/form-data')
    // .set('Authorization', 'eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJhZG1pbiIsImV4cCI6MTU2NTI1MDAxOSwiaWF0IjoxNTY0NjQ1MjE5fQ.WLI66uhPWx89ScO6eJJA1vT-hbj3K3U2Dgg6GvNikdiHgw-SIQunn2rs902ajunew621kyyv-XuvGjIOx8LgQw')
    .field('app_id', appid)
    .field('signa', signa)
    .field('ts', ts)
    .field('task_id', id)
    .field('slice_id', 'aaaaaaaaaa')
    .attach('content', './audio/20190801100538970716822236.mp3')
    .then(res => {
      console.log(res.text + '上传')
    })
}

// 合并
const merge = async (id) => {
  await superagent
    .post('https://raasr.xfyun.cn/api/merge')
    .set('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    .send({ app_id: appid })
    .send({ signa: signa })
    .send({ ts: ts })
    .send({ task_id: id })
    .then(res => {
      console.log(res.text + '合并')
    })
}

// 查询进度
const getProgress = async (id) => {
  let temp
  await superagent
    .post('https://raasr.xfyun.cn/api/getProgress')
    .set('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    .send({ app_id: appid })
    .send({ signa: signa })
    .send({ ts: ts })
    .send({ task_id: id })
    .then(res => {
      console.log(res.text + '查询')
      temp = JSON.parse(res.text).data.status
    })
  return temp
}

// 获取结果
const getResult = async (id) => {
  let temp
  await superagent
    .post('https://raasr.xfyun.cn/api/getResult')
    .set('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    .send({ app_id: appid })
    .send({ signa: signa })
    .send({ ts: ts })
    .send({ task_id: id })
    .then(res => {
      temp = JSON.parse(res.text).data
    })
  return temp
}

const start = async () => {
  // const taskId = await getId()
  // console.log(taskId)
  // await upload(taskId)
  // await merge(taskId)
  // await getProgress('979742eec92c4d6dad79e99d47945445')
  const res = await getResult('979742eec92c4d6dad79e99d47945445')
  let text = ''
  JSON.parse(res).map(item => {
    text = text + (item.bg / 1000) + ':' + item.onebest + '\n'
  })
  console.log(text)
}

module.exports = {
  start
}
