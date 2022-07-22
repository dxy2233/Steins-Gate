module.exports = {
  title: 'Pensieve',
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
          title: 'tool',
          collapsable: false,
          children: [
            ['/note/package-yarn', 'yarn'],
            ['/note/package-powershell', 'powershell'],
            ['/note/package-editor', '编辑器'],
            ['/note/package-git', 'git'],
            ['/note/package-vim', 'vim'],
            ['/note/package-gitlab', 'gitlab'],
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
            ['/note/js-algorithm', '算法相关'],
            ['/note/js-image', '图片相关'],
            ['/note/js-event', '事件相关'],
            ['/note/js-vue', 'vue'],
            ['/note/js-rxjs', 'rxjs'],
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
            ['/note/node-svg', 'svg压缩工具'],
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
            ['/note/go-wasm', 'wasm'],
          ]
        },
        {
          title: 'rust',
          collapsable: false,
          children: [
            ['/note/rust-hello', 'rust入门'],
            ['/note/rust-wasm', 'wasm'],
          ]
        },
        {
          title: '杂项',
          collapsable: false,
          children: [
            ['/note/sundry-m3u8', '视频流下载'],
          ]
        }
      ]
    }
 }
}