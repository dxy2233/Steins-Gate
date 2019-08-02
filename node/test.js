const Koa = require('koa')
const Router = require('koa-router')
const cheerio = require('cheerio')
const superagent = require('superagent') // ajax
const fs = require("fs")
const XLSX = require('xlsx') // excel
const async = require('async')
const voice = require('./voice')

const cook ='global_cookie=ds7jcrh8va0pmwoji6yy4c6zw1gju13qzge; newhouse_user_guid=DD60A92F-13EF-BE67-E53A-FA6B941A06A5; vh_newhouse=1_1554289355_1010%5B%3A%7C%40%7C%3A%5D953cf1adb4deabbf8e0f358b09238859; Integrateactivity=notincludemc; lastscanpage=1; _sf_group_flag=xf; new_search_uid=ec665c5ecf71bf30320b9afc2aeeabe6; city=cq; newhouse_chat_guid=7E064831-319E-8B77-32DE-51761A28E999; Captcha=484D4F4855783766525663772F684F454E2F4F46336A474D346B51663961594E443636453035383668686F424A4B4F6E7669354C58594C754775666D71796370434D6370353539726633733D; __utma=147393320.996047671.1556542547.1563799566.1564407521.17; __utmc=147393320; __utmz=147393320.1564407521.17.14.utmcsr=baidu|utmccn=(organic)|utmcmd=organic; unique_cookie=U_lddoxvvc5s9ldomzfwbhcucy71zjyofu9ps*1; route=4b4f06a73088080a32aa3eda08d524b8; sfut=347731973629C3497FB08F4C916CFB1BDC1189679A11D16DA66EEA7A9B66598A3297BC266718E66769403C4058736811CA75BC4FEE7564B377CABCE6126FC723467B3DEC0A488717364B3A99E20B8022FA117969E262C1D6F5863C238736A056; sfyt=2D9-olGHEtawNH-E-P93cJrrrJZnU3RJ1XwSse5YZN_YDxkF9zJrbvYFH6dhSzFQF2GHRe01aggWMzXs0THd2w==; unique_cookie=U_lddoxvvc5s9ldomzfwbhcucy71zjyofu9ps*2; sourcepage=wszx_gwgl_kfypc%7Cb_bmgl%5Elb_kfypc'
superagent
  .get('https://m.fang.com/house/ec/customer/_AjaxCustomerList')
  .query({
    NewCode: 3110122580,
    PageSize: 30,
    PageIndex: 1,
    CallStatus: '',
    CustomerNameOrPhone: '',
    SalerNameOrPhone: '',
    CreateTimeFrom: '开始时间',
    CreateTimeTo: '结束时间'
  })
  .set('cookie', cook)
  .then(async res => {
    let $ = cheerio.load(res.text)
    let arrayData = [
      ['用户编号', '购房者姓名', '购房者手机号', '置业顾问', '通话状态', '客户产生时间', '客户来源', '操作', '音频地址', '通话时长',  '跟进记录', '意向', '通话记录']
    ]

    // 获取主列表
    $('#dateListTable tbody tr').each((i, elem) => {
      let temp = [
        $(elem).children().eq(1).text(),
        $(elem).children().eq(2).text(),
        $(elem).children().eq(3).text(),
        $(elem).children().eq(4).text(),
        $(elem).children().eq(5).text(),
        $(elem).children().eq(6).text(),
        $(elem).children().eq(7).text(),
        { v: '查看', 
          l: { 
            Target: 'https://m.fang.com/house/ec/customer/' + $(elem).children().eq(8).children().attr('href'),
            Tooltip: 'https://m.fang.com/house/ec/customer/' + $(elem).children().eq(8).children().attr('href')
          }
        },
        $(elem).children().eq(8).children().attr('href')
      ]
      arrayData.push(temp)
    })

    // 音频详情页
    for (let i = 1; i < arrayData.length; i++) {
      // 未接么有数据
      if (arrayData[i][4] === '未呼' || arrayData[i][4] === '已呼未接通') {
        arrayData[i].splice(8, 1)
        continue
      }
      // 接听后有数据
      await superagent
        .get('https://m.fang.com/house/ec/customer/' + arrayData[i][8])
        .set('cookie', cook)
        .then(res => {
          let $ = cheerio.load(res.text)
          arrayData[i].splice(8, 1) // 删除详情页地址
          let url = {} // mp3地址
          let duration = [] // 通话时长
          $('.table tbody tr').each((k, elem) => {
            url = { ...url,
              v: '链接',
              l: {
                Target: $(elem).children().eq(5).children().eq(0).attr('url'),
                Tooltip: $(elem).children().eq(5).children().eq(0).attr('url')
              }
            }
            // url.push({
            //   v: '链接',
            //   l: {
            //     Target: $(elem).children().eq(5).children().eq(0).attr('url'),
            //     Tooltip: $(elem).children().eq(5).children().eq(0).attr('url')
            //   }
            // })
            duration.push($(elem).children().eq(2).text())
          })
          arrayData[i].push(url)
          arrayData[i].push(duration.join())
          let remake = '' // 跟进记录
          $('.tab-content .new-timeline ul li').each((j, elem) => {
            remake = remake + $(elem).children().eq(2).text()
          })
          arrayData[i].push(remake)
        })
    }

    // 输出excel
    console.log(arrayData)
    let arrayWorkSheet = XLSX.utils.aoa_to_sheet(arrayData)
    let cc = {
      SheetNames: ['arrayWorkSheet'],
      Sheets: {
        'arrayWorkSheet': arrayWorkSheet
      }
    }
    XLSX.writeFile(cc, './cc.xlsx')
  }).catch(err => {
    console.log(err);
  })


