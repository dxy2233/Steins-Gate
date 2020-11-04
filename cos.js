const fs = require('fs')
const path = require('path')
const COS = require('cos-nodejs-sdk-v5')
const local = require('./local.js')
const { resolve } = require('path')

const cos = new COS({
    SecretId: local.id,
    SecretKey: local.key,
})

const uploadFile = filePath => new Promise((resolve, reject) => {
    let targetNum = 0
    const loop = filePath => {
        fs.readdir(filePath, (err, list) => {
            list.forEach(item => {
                const itemPath = path.resolve(filePath, item)
                fs.stat(itemPath, (err, data) => {
                    if (data.isFile()) {
                        targetNum++
                        cosPutFile(itemPath).then(res => {
                            console.log(res)
                            targetNum--
                            if (targetNum === 0) resolve()
                        })
                    }
                    else loop(itemPath)
                })
            })
        })
    }
    loop(filePath)
})

const cosPutFile = filePath => new Promise((resolve, reject) => {
    filePath = filePath.replace(/\\/g, '\/')
    cos.putObject({
        Bucket: local.bucket,
        Region: local.region,
        Key: filePath.slice(filePath.indexOf('dist') + 5),
        Body: fs.createReadStream(filePath),
    }, (err, data) => {
        err ? reject(err) : resolve(data)
    })
})

// const uploadFile = filePath => {
//     fs.readdir(filePath, (err, list) => {
//         list.forEach(item => {
//             const itemPath = path.resolve(filePath, item)
//             fs.stat(itemPath, (err, data) => {
//                 if (data.isFile()) cosPut(itemPath)
//                 else uploadFile(itemPath)
//             })
//         })
//     })
// }

// const cosPut = filePath => {
//     filePath = filePath.replace(/\\/g, '\/')
//     cos.putObject({
//         Bucket: local.bucket,
//         Region: local.region,
//         Key: filePath.slice(filePath.indexOf('dist') + 5),
//         Body: fs.createReadStream(filePath),
//         // onProgress: progressData => {
//         //     console.log(JSON.stringify(progressData))
//         // }
//     }, (err, data) => {
//         console.log(err || data)
//     })
// }

// const cosGet = () => {
//     cos.getBucket({
//         Bucket: local.bucket,
//         Region: local.region,
//     }, (err, data) => {
//         if (err) return err
//         const allFile = data.Contents
//         let typeArray = []
//         const gapMax = 2 * 60 * 1000 // 2分钟的毫秒数
//         allFile.forEach((file, index) => {
//             if (index === 0) {
//                 typeArray[0] = []
//                 typeArray[0].push(file)
//                 return
//             }
//             for (let i = 0;i < typeArray.length;i++) {
//                 const gap = new Date(file.LastModified).getTime() -
//                  new Date(typeArray[i][0].LastModified).getTime()
//                  if (Math.abs(gap) < gapMax) {
//                     typeArray[i].push(file)
//                     break
//                 }
//                 // 非同一时间段的文件创建添加到下一个数组
//                 if (i === typeArray.length - 1) {
//                     typeArray[i + 1] = []
//                     typeArray[i + 1].push(file)
//                     break
//                 }
//             }
//         })
//         // 排序、删除最新2个版本之外的文件
//         typeArray = typeArray.sort((a, b) => new Date(b[0].LastModified).getTime() -
//          new Date(a[0].LastModified).getTime())
//         typeArray.splice(0, 2)
//         const delFiles = typeArray.flat().map(file => {
//             return { Key: file.Key }
//         })
//         cosDel(delFiles)
//     })
// }

// const cosDel = (objects) => {
//     cos.deleteMultipleObject({
//         Bucket: local.bucket,
//         Region: local.region,
//         Objects: objects,
//     }, (err, data) => {
//         console.log(err || data);
//     })
// }

const removeFiles = () => new Promise((resolve, reject) => {
    const allFile = data.Contents
    let typeArray = []
    const gapMax = 2 * 60 * 1000 // 2分钟的毫秒数
    allFile.forEach((file, index) => {
        if (index === 0) {
            typeArray[0] = []
            typeArray[0].push(file)
            return
        }
        for (let i = 0;i < typeArray.length;i++) {
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
    typeArray.splice(0, 2)
    const delFiles = typeArray.flat().map(file => {
        return { Key: file.Key }
    })
    cosDel(delFiles)
})

const cosGet = () => new Promise((resolve, reject) => {
    reject()
    // cos.getBucket({
    //     Bucket: local.bucket,
    //     Region: local.region,
    // }, (err, data) => {
    //     err ? reject(err) : resolve(data)
    // })
}) 

const cosDelObjects = objects => new Promise((resolve, reject) => {
    cos.deleteMultipleObject({
        Bucket: local.bucket,
        Region: local.region,
        Objects: objects,
    }, (err, data) => {
        err ? reject(err) : resolve(data)
    })
}) 

uploadFile('./docs/.vuepress/dist').then(() => {
    console.log('over upload')
    try {
        return cosGet()
    } catch (error) {
        console.log(error)
    }
}).then(res => {
    console.log(res);
})
