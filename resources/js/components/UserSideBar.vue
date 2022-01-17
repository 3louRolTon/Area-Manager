
<template>
    <sidebar-menu :menu="menu" />
</template>

<script>
    export default {
        data () {
            return {
                menu: [
                    {
                        href: '/',
                        title: 'Главная',
                        icon: 'fa fa-cog',
                    },
                    {
                        title: 'Адреса',
                        icon: 'fas fa-ellipsis-v',
                        child: [
                            {
                                href: '/user',
                                title: 'Привязать'
                            },
                            {
                                href: '/user/unbindHouse',
                                title: 'Отвязать дом'
                            },
                            {
                                href: '/user/unbindCity',
                                title: 'Отвязать город'
                            },
                            // {
                            //     href: '',
                            //     title: 'Привязать участок'
                            // },
                            // {
                            //     href: '',
                            //     title: 'Отвязать участок'
                            // }
                        ]
                    },
                    {
                        title: 'Добавить',
                        icon: 'fas fa-plus-circle',
                        child: [
                            // {
                            //     href: '/user/create/area',
                            //     title: 'Область'
                            // },
                            // {
                            //     href: '/user/create/district',
                            //     title: 'Район'
                            // },
                            {
                                href: '/user/create/city',
                                title: 'Город'
                            },
                            {
                                href: '/user/create/street',
                                title: 'Улица'
                            },
                            {
                                href: '/user/create/house',
                                title: 'Дом'
                            },
                            {
                                href: '/user/create/spot',
                                title: 'Участок'
                            },
                            // {
                            //     href: '/user/create/deputat',
                            //     title: 'Депутат'
                            // },
                            // {
                            //     href: '/user/create/helper',
                            //     title: 'Помошник'
                            // }
                        ]
                    },
                    {
                        title: 'Изменить',
                        icon: 'fas fa-edit',
                        child: [
                            // {
                            //     href: '/user/update/area',
                            //     title: 'Область'
                            // },
                            // {
                            //     href: '/user/update/district',
                            //     title: 'Район'
                            // },
                            {
                                href: '/user/update/city',
                                title: 'Город'
                            },
                            {
                                href: '/user/update/street',
                                title: 'Улица'
                            },
                            {
                                href: '/user/update/house',
                                title: 'Дом'
                            },
                            {
                                href: '/user/update/spot',
                                title: 'Участок'
                            },
                            // {
                            //     href: '/user/update/deputat',
                            //     title: 'Депутат'
                            // },
                            // {
                            //     href: '/user/update/helper',
                            //     title: 'Помошник'
                            // }
                        ]
                    },
                    // {
                    //     href: '/statistics',
                    //     title: 'Статистика',
                    //     icon: 'fa fa-user',
                    // }
                ],
                collapsed: true,
                themes: [
                    {
                        name: 'Default theme',
                        input: ''
                    },
                    {
                        name: 'White theme',
                        input: 'white-theme'
                    }
                ],
                selectedTheme: 'white-theme',
                isOnMobile: false
            }
        },
        mounted () {
            this.onResize()
            window.addEventListener('resize', this.onResize)
        },
        methods: {
            onToggleCollapse (collapsed) {
                console.log(collapsed)
                this.collapsed = collapsed
            },
            onItemClick (event, item, node) {
                console.log('onItemClick')
                // console.log(event)
                // console.log(item)
                // console.log(node)
            },
            onResize () {
                if (window.innerWidth <= 767) {
                    this.isOnMobile = true
                    this.collapsed = true
                } else {
                    this.isOnMobile = false
                    this.collapsed = false
                }
            }
        }
    }
</script>
