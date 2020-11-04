const fs = require('fs')
const path = require('path')
const COS = require('cos-nodejs-sdk-v5')
const local = require('./local.js')

const cos = new COS({
    SecretId: local.id,
    SecretKey: local.key,
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

const cosGet = () => new Promise((resolve, reject) => {
    cos.getBucket({
        Bucket: local.bucket,
        Region: local.region,
    }, (err, data) => {
        err ? reject(err) : resolve(data)
    })
}) 

const cosDelObjects = objects => new Promise((resolve, reject) => {
    cos.deleteMultipleObject({
        Bucket: local.bucket,
        Region: local.region,
        Objects: objects,
    }, (err, data) => {
        err ? reject(err) : resolve(data)
        console.log(data)
    })
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
    cosDelObjects(delFiles)
})

const main = async () => {
    try {
        await uploadFile('./docs/.vuepress/dist') 
        const bucketInfo = await cosGet()
        removeFiles(bucketInfo)
    } catch(err) {
        console.log(err)
    }
}
main()