module.exports = {
  title: 'Note',
  description: '一些记录与碎片提示',
  head: [
    ['link', { rel: 'icon', href: '/img/cat.ico' }]
  ],
  themeConfig: {
    nav: [
      { text: '日常记录', link: '/note/package-yarn' },
    ],
    sidebar: {
      '/note/': [
        {
          title: '包管理',
          collapsable: false,
          children: [
            ['/note/package-yarn', 'yarn'],
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
            ['/note/go-file', '文件操作'],
          ]
        },
      ]
    }
 }
}