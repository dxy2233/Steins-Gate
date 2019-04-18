var fs = require("fs")
var cats = [
  {
    name: ['one'],
    child: [
      {
        name: ['aaa', 'bbb.js'],
        child: [
          {
            name: ['ccc']
          }
        ]
      }
    ]
  },
  {
    name: ['two']
  }
]
// function deep(array, node) {
//   for (let i = 0; i < array.length; i++) {
//     array[i].name.forEach((item, index) => {
//       if (index === 0) {
//         fs.mkdirSync(`${node}/${item}`, function (err) { if (err) console.log(err) })
//         fs.writeFile(`${node}/${item}/index.vue`, 'sss', function (err) { if (err) console.log(err) })
//       }
//     })
//     if (array[i].child) {
//       deep(array[i].child, `${node}/${array[i].name[0]}`)
//     }
//   }
// }
// deep(cats, '.')

const cc = `<style>
  .app {
    color: red;
  }
</style>
`
fs.writeFile('index.vue', cc, function (err) { if (err) console.log(err)  })