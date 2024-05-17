import { defaultTheme } from 'vuepress'

export default {
  title: 'Pensieve',
  description: '一些记录与碎片提示',
  head: [
    ['link', { rel: 'icon', href: '/img/cat.ico' }]
  ],
  theme: defaultTheme({
    navbar: [
      { text: '日常记录', link: '/note/package-yarn' },
    ],
    sidebar: {
      '/note/': [
        {
          text: 'tool',
          collapsable: false,
          children: [
            '/note/package-yarn',
            '/note/package-powershell',
            '/note/package-editor',
            '/note/package-git',
            '/note/package-vim',
            '/note/package-gitlab',
            '/note/package-husky',
          ]
        },
        {
          text: 'wsl',
          collapsable: false,
          children: [
            '/note/wsl-proxy',
          ]
        },
        {
          text: 'html',
          collapsable: false,
          children: [
            '/note/html-tip'
          ]
        },
        {
          text: 'js',
          collapsable: false,
          children: [
            '/note/js-math',
            '/note/js-date',
            '/note/js-api',
            '/note/js-algorithm',
            '/note/js-image',
            '/note/js-event',
            '/note/js-data',
            '/note/js-vue',
            '/note/js-rxjs',
          ]
        },
        // {
        //   text: 'css',
        //   collapsable: false,
        //   children: [
        //     '/note/css-effect',
        //   ]
        // },
        {
          text: 'node',
          collapsable: false,
          children: [
            '/note/node-file',
            '/note/node-svg',
          ]
        },
        {
          text: 'go',
          collapsable: false,
          children: [
            '/note/go-mod',
            '/note/go-file',
            '/note/go-http',
            '/note/go-dirStruc',
            '/note/go-house',
            '/note/go-wasm',
          ]
        },
        {
          text: 'rust',
          collapsable: false,
          children: [
            '/note/rust-hello',
            '/note/rust-wasm',
            '/note/rust-house',
            '/note/rust-note',
          ]
        },
        {
          text: 'linux',
          collapsable: false,
          children: [
            '/note/arch-hyprland',
          ]
        },
        {
          text: '杂项',
          collapsable: false,
          children: [
            '/note/sundry-m3u8',
          ]
        }
      ]
    }
  })
}
