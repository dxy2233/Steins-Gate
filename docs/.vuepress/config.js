module.exports = {
  title: 'Note',
  // description: 'note',
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