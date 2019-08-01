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
    .then(res => {
      temp = JSON.parse(res.text).data
    })
  return temp
}

// 上传
const upload = async (id) => {
  await superagent
    .post('https://raasr.xfyun.cn/api/upload')
    .set('Content-Type', 'multipart/form-data')
    .field('app_id', appid)
    .field('signa', signa)
    .field('ts', ts)
    .field('task_id', id)
    .field('slice_id', 'aaaaaaaaa')
    .attach('content', './audio/20190801100538970716822236.mp3')
    .then(res => {
      console.log(res)
    })
}

const start = async () => {
  const taskId = await getId()
  console.log(taskId)
  await upload(taskId)
}

start()

