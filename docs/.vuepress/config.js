module.exports = {
  title: 'Pensieve',
  description: '一些记录与碎片提示',
  head: [
    ['link', { rel: 'icon', href: '/img/cat.ico?v2' }]
  ],
  themeConfig: {
    nav: [
      { text: '日常记录', link: '/note/package-yarn' },
    ],
    sidebar: {
      '/note/': [
        {
          title: 'tool',
          collapsable: false,
          children: [
            ['/note/package-yarn', 'yarn'],
            ['/note/package-powershell', 'powershell'],
            ['/note/package-editor', '编辑器'],
            ['/note/package-git', 'git'],
            ['/note/package-vim', 'vim'],
          ]
        },
        {
          title: 'html',
          collapsable: false,
          children: [
            ['/note/html-tip', '不常用功能'],
          ]
        },
        {
          title: 'js',
          collapsable: false,
          children: [
            ['/note/js-math', 'math相关'],
            ['/note/js-date', '日期相关'],
            ['/note/js-api', 'api参考'],
            ['/note/js-vue', 'vue'],
          ]
        },
        {
          title: 'css',
          collapsable: false,
          children: [
            ['/note/css-effect', '一些效果'],
          ]
        },
        {
          title: 'node',
          collapsable: false,
          children: [
            ['/note/node-file', '文件操作'],
          ]
        },
        {
          title: 'go',
          collapsable: false,
          children: [
            ['/note/go-mod', 'go mod'],
            ['/note/go-file', '文件操作'],
            ['/note/go-http', '网络相关'],
            ['/note/go-dirStruc', '目录结构推荐'],
            ['/note/go-house', '常用三方库'],
          ]
        },
      ]
    }
 }
}