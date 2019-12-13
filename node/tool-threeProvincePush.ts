import * as shell from 'shelljs'
import * as path from 'path'
import * as fs from 'fs'
import * as readline from 'readline'
import * as nodemailer from 'nodemailer'

const dir1 = 'd:/october' // 工作地址
const dir2 = 'd:/three-province/code' // svn内code地址

let cp = {
  // 验证路径
  testAdress: (adress1: string = dir1, adress2: string = dir2) => {
    try {
      fs.accessSync(adress1, fs.constants.R_OK | fs.constants.W_OK)
      fs.accessSync(adress2, fs.constants.R_OK | fs.constants.W_OK)
      return true
    } catch (error) {
      console.log('地址不正确')
      return false
    }
  },
  // 拷贝文件
  dir1ToDir2: (adress1: string = dir1, adress2: string = dir2) => {
    shell.cd(adress1)
    shell.echo('源文件目录：' + path.resolve('./'))
    shell.echo('开始拷贝')
    shell.ls('-A').forEach(item => {
      if (item === '.git' || item === 'node_modules') return
      shell.cp('-r', item, adress2)
    })
    shell.echo('拷贝结束')
  },
  // 打包&&提交svn
  uploadSvn: (adress1: string = dir1, adress2: string = dir2) => {
    shell.cd(adress2)
    shell.cd('..')
    // svn更新
    console.log('snv更新:' + path.resolve('./'))
    shell.exec('svn update')
    // 有冲突时停止
    if (shell.exec('svn status|grep ^C').length > 0) return
    console.log('无冲突')
    // 切换到code目录打包后提交
    shell.cd('code')
    console.log('打包目录：' + path.resolve('./'))
    shell.exec('npm run build', () => {
      shell.cd('..')
      const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout,
        prompt: '请输入commit: '
      })
      rl.prompt()
      rl.on('line', line => {
        // 添加文件
        shell.exec('svn add * --force')
        // 删除文件
        let delData: any = shell.exec('svn status|grep ^!')
        delData = delData.stdout.split('\r\n')
        delData.forEach(item => {
          let delUrl = item.slice(1).trim()
          shell.exec(`svn delete ${delUrl}`)
        })
        // 提交
        shell.exec(`svn commit -m ${line}`)
        // 邮件
        cp.sendEmail(line)
          .then(() => process.exit())
          .catch(console.error)
      })
    })
  },
  // email
  sendEmail: async message => {
    // let testAccount = await nodemailer.createTestAccount()
    // 设置邮箱配置
    let transporter = nodemailer.createTransport({
      host: 'smtp.qq.com',
      port: 587, // 对应的端口号
      secure: false,
      auth: {
        user: '691369338@qq.com',
        pass: 'xojmmxnhqqwgbcgc'
      }
    })
    // 设置收件人信息
    let info = await transporter.sendMail({
      from: '"三同步svn更新" <dxy5395@qq.com>',
      to: '708968251@qq.com',
      subject: '三同步省级项目',
      text: message,
      html: `<div>${message}</div>`
    })
    console.log('Message sent: %s', info.messageId)
  },
  run: () => {
    if (!cp.testAdress()) return
    cp.dir1ToDir2()
    cp.uploadSvn()
  }
}
cp.run()
