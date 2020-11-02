const COS = require('cos-nodejs-sdk-v5')
const { request } = require('http')
const Cos = new COS({
    SecretId: '',
    SecretKey: ''
})
const cos = new Cos({
    getAuthorization:function(options, callback) {
        request({

        })
    }
})