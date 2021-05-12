
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
                                href: '',
                                title: 'Привязать'
                            },
                            {
                                href: '',
                                title: 'Отвязать'
                            },
                            {
                                href: '',
                                title: 'Привязать участок'
                            },
                            {
                                href: '',
                                title: 'Отвязать участок'
                            }
                        ]
                    },
                    {
                        title: 'Добавить',
                        icon: 'fas fa-plus-circle',
                        child: [
                            {
                                href: '',
                                title: 'Область'
                            },
                            {
                                href: '',
                                title: 'Район'
                            },
                            {
                                href: '',
                                title: 'Город'
                            },
                            {
                                href: '',
                                title: 'Улица'
                            },
                            {
                                href: '',
                                title: 'Дом'
                            },
                            {
                                href: '',
                                title: 'Участок'
                            },
                            {
                                href: '',
                                title: 'Депутат'
                            },
                            {
                                href: '',
                                title: 'Помошник'
                            }
                        ]
                    },
                    {
                        title: 'Изменить',
                        icon: 'fas fa-edit',
                        child: [
                            {
                                href: '',
                                title: 'Область'
                            },
                            {
                                href: '',
                                title: 'Район'
                            },
                            {
                                href: '',
                                title: 'Город'
                            },
                            {
                                href: '',
                                title: 'Улица'
                            },
                            {
                                href: '',
                                title: 'Дом'
                            },
                            {
                                href: '',
                                title: 'Участок'
                            },
                            {
                                href: '',
                                title: 'Депутат'
                            },
                            {
                                href: '',
                                title: 'Помошник'
                            }
                        ]
                    },
                    {
                        title: 'User',
                        icon: 'fas fa-grip-vertical',
                        child: [
                            {
                                href: '',
                                title: 'Admin'
                            },
                            {
                                href: '',
                                title: 'Validate'
                            }
                        ]
                    },
                    {
                        href: '/profile',
                        title: 'Профиль',
                        icon: 'fa fa-user',
                    },
                    {
                        href: '/logout',
                        title: 'Выйти',
                        icon: 'fas fa-sign-out-alt',
                    }
                ],
                collapsed: false,
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
