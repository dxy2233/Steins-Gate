const XLSX = require('xlsx') // excel

const toExcel = (arrayData, workName, fileName) => {
  let data = XLSX.utils.aoa_to_sheet(arrayData)
  let work = {
    SheetNames: ['`${workName}`'],
    Sheets: {
      '`${workName}`': data
    }
  }
  XLSX.writeFile(work, `./${fileName}.xlsx`)
}

module.exports = {
  toExcel
}