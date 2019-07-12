var shell = require('shelljs')
const fs = require('fs')
const path = require('path')

try {
  process.chdir(`d:/projects/关基监控前端/bt.cii.war`)
  console.log(`New directory: ${process.cwd()}`)

  const data = `ENV = 'development'
VUE_APP_BASE_API = 'http://192.168.0.108:8082'`
  fs.writeFile('.env.development', data, (err) => {
    if (err) throw err
    console.log('saved1')
    shell.exec('npm run serve')
  })

//   const data1 = `ENV = 'development'
// VUE_APP_BASE_API = 'http://192.168.0.176:8082'`
//   fs.writeFile('.env.development', data1, (err) => {
//     if (err) throw err
//     console.log('saved2')
//     shell.exec('npm run serve')
//   })
} catch (err) {
  console.error(err)
}