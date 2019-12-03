"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const fs = require("fs");
const dir1 = 'd:/october/'; // 工作地址
const dir2 = 'd:/com.better.synchro/src/main/resources/code'; // svn地址
let cp = {
    testAdress: (adress1 = dir1, adress2 = dir2) => {
        try {
            fs.accessSync(adress1, fs.constants.R_OK | fs.constants.W_OK);
            fs.accessSync(adress2, fs.constants.R_OK | fs.constants.W_OK);
            return true;
        }
        catch (error) {
            console.log('地址不正确');
            return false;
        }
    }
};
console.log(cp.testAdress());
// // 拷贝文件
// shell.cd('d:/october/')
// shell.echo('源文件目录：' + path.resolve('./'))
// shell.echo('开始拷贝')
// shell.ls('-A').forEach(item => {
//   if (item === '.git' || item === 'node_modules') return
//   shell.cp('-r', item, 'd:/com.better.synchro/src/main/resources/code')
// })
// shell.echo('拷贝结束')
// // 打包&&提交svn
// shell.cd('d:/com.better.synchro/src/main/resources/code')
// shell.echo('打包目录：' + path.resolve('./'))
// shell.exec('npm run build', () => {
//   shell.echo('打包完毕')
//   shell.cd('..')
//   shell.echo('提交svn目录：' + path.resolve('./'))
//   // svn更新
//   shell.exec('svn update')
//   // 无冲突键入commit后提交
//   if (shell.exec('svn status|grep ^C').length === 0) {
//     shell.echo('无冲突')
//     const rl = readline.createInterface({
//       input: process.stdin,
//       output: process.stdout,
//       prompt: '请输入commit\n'
//     })
//     rl.prompt()
//     rl.on('line', line => {
//       shell.exec('svn add * --force', () => {
//         shell.exec(`svn commit -m ${line}`, () => process.exit(0))
//       })
//     })
//   } else {
//     shell.echo('有冲突!!!')
//   }
// })
//# sourceMappingURL=tool-threeAsyn.js.map