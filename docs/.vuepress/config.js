module.exports = {
  title: 'note',
  description: 'note',
  themeConfig: {
    nav: [
      { text: '日常笔记', link: '/note/package-yarn' },
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