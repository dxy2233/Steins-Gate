const fs = require('fs')
const path = require('path')
const COS = require('cos-nodejs-sdk-v5')
const local = require('./local.js')

const cos = new COS({
    SecretId: local.id,
    SecretKey: local.key,
})

const uploadFile = filePath => {
    fs.readdir(filePath, (err, list) => {
        list.forEach(item => {
            const itemPath = path.resolve(filePath, item)
            fs.stat(itemPath, (err, data) => {
                if (data.isFile()) cosPut(itemPath)
                else uploadFile(itemPath)
            })
        })
    })
}

const cosPut = filePath => {
    filePath = filePath.replace(/\\/g, '\/')
    cos.putObject({
        Bucket: local.bucket,
        Region: local.region,
        Key: filePath.slice(filePath.indexOf('dist') + 5),
        Body: fs.createReadStream(filePath),
        // onProgress: progressData => {
        //     console.log(JSON.stringify(progressData))
        // }
    }, (err, data) => {
        console.log(err || data)
    })
}

// uploadFile('./docs/.vuepress/dist')

const cosGet = () => {
    cos.getBucket({
        Bucket: local.bucket,
        Region: local.region,
    }, (err, data) => {
        if (err) return err
        const allFile = data.Contents
    })
}

cosGet()