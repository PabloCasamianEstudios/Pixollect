<template>
    <div>
        <header class="navComponent">
            <nav class="navBar">
                <LinkTo href="/" class="navBar__logo">
                    <img
                        src="../../../public/images/icon.png"
                        alt="Pixollect"
                    />
                    <h1>Pixollect</h1>
                </LinkTo>
                <button class="navBar__toggle" @click="toggleMenu">☰</button>

                <ul
                    :class="[
                        'navBar__links',
                        { 'navBar__links--open': menuOpen },
                    ]"
                >
                    <li><LinkTo href="/">{{ $t('HOME') }}</LinkTo></li>
                    <li><LinkTo href="/gameList">{{ $t('GAMES') }}</LinkTo></li>
                    <li><LinkTo href="/collections">{{ $t('COLLECTIONS') }}</LinkTo></li>
                    <li><LinkTo href="/recommend">{{ $t('RECOMMEND') }}</LinkTo></li>
                    <li><LinkTo href="/compare">{{ $t('COMPARE') }}</LinkTo></li>
                </ul>

                <div
                    v-if="currentUser"
                    class="navBar__user"
                    ref="userMenuRef"
                    @click="toggleUserMenu"
                >
                    <span class="userName">
                        {{ currentUser.name }}
                        <span
                            class="dropdownIcon"
                            :class="{ open: userMenuOpen }"
                            >▼</span
                        >
                    </span>

                    <ul v-if="userMenuOpen" class="userMenu">
                        <li>
                            <LinkTo :href="`/user/${currentUser.name}`"
                                >{{ $t('YOUR PROFILE') }}</LinkTo
                            >
                        </li>
                        <li>
                            <LinkTo @click.stop="logout">{{ $t('LOGOUT') }}</LinkTo>
                        </li>
                        <li v-if="currentUser.role === 'admin'">
                            <LinkTo href="/admin-panel">{{ $t('ADMIN PANEL') }}</LinkTo>
                        </li>
                        <li
                            class="languageMenuItem"
                            @click.stop="toggleLanguageMenu"
                        >
                            <div class="languageTrigger">
                                LANGUAGE
                                <span
                                    class="languageDropdownIcon"
                                    :class="{ open: languageMenuOpen }"
                                    >▼</span
                                >
                            </div>
                            <ul
                                v-if="languageMenuOpen"
                                class="languageDropdown"
                            >
                                <li
                                    v-for="(lang, code) in languages"
                                    :key="code"
                                >
                                    <LinkTo
                                        href="#"
                                        @click.prevent="changeLanguage(code)"
                                        class="languageLink"
                                        :class="{
                                            active: currentLanguage === code,
                                        }"
                                    >
                                        {{ lang.name }} {{ lang.flag }}
                                    </LinkTo>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div v-else class="authButtons">
                    <LinkTo href="/login">
                        <button class="authBtn">{{ $t('LOGIN') }}</button>
                    </LinkTo>
                    <LinkTo href="/register">
                        <button class="authBtn">{{ $t('REGISTER') }}</button>
                    </LinkTo>
                    <button
                        class="authBtn languageBtn"
                        @click="languageMenuOpenGuest = !languageMenuOpenGuest"
                    >
                        🌐
                    </button>
                    <ul
                        v-if="languageMenuOpenGuest"
                        class="languageDropdownGuest"
                    >
                        <li v-for="(lang, code) in languages" :key="code">
                            <LinkTo
                                href="#"
                                v-model="locale"
                                @click.prevent="changeLanguage(code)"
                                class="languageLink"
                                :class="{ active: currentLanguage === code }"
                            >
                                {{ lang.name }} {{ lang.flag }}
                            </LinkTo>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>
</template>

<script>
import { Link as LinkTo, usePage, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import { useI18n } from 'vue-i18n';

export default {
    components: {
        LinkTo,
    },
     setup() {
        const { t } = useI18n();
        return {
                t,
                $t: t
            };

    },
    data() {
        return {
            menuOpen: false,
            userMenuOpen: false,
            languageMenuOpen: false,
            currentLanguage: 'en', // DE ALGUN MODO TENGO QUE SACAR EL LOCAL
            languages: {
                en: { name: this.t('English'), flag: '🇬🇧', letras: 'en' },
                es: { name: this.t('Español'), flag: '🇪🇸', letras: 'es' },
            },
            languageMenuOpenGuest: false,
        };
    },
    computed: {
        currentUser() {
            return usePage().props.auth.user;
        },
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },
        toggleUserMenu() {
            this.userMenuOpen = !this.userMenuOpen;
            if (!this.userMenuOpen) {
                this.languageMenuOpen = false;
            }
        },
        toggleLanguageMenu() {
            this.languageMenuOpen = !this.languageMenuOpen;
        },
        handleClickOutside(e) {
            if (
                this.$refs.userMenuRef &&
                !this.$refs.userMenuRef.contains(e.target)
            ) {
                this.userMenuOpen = false;
                this.languageMenuOpen = false;
            }
            const guestLangBtn = this.$el.querySelector('.languageBtn');
            const guestLangDropdown = this.$el.querySelector(
                '.languageDropdownGuest',
            );
            if (
                guestLangBtn &&
                guestLangDropdown &&
                !guestLangBtn.contains(e.target) &&
                !guestLangDropdown.contains(e.target)
            ) {
                this.languageMenuOpenGuest = false;
            }
        },
        async logout() {
            const result = await Swal.fire({
                title: 'Close session?',
                text: 'Are you sure you want to close session?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'YES',
                cancelButtonText: 'NO',
                confirmButtonColor: '#ff1540',
                cancelButtonColor: '#ff1540',
                customClass: {
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn',
                    popup: 'swal-custom-popup',
                    title: 'swal-custom-title',
                    htmlContainer: 'swal-custom-text',
                    actions: 'swal-custom-actions',
                },
                background: '#262626',
                color: '#fff',
                iconColor: '#ff1540',
            });

            if (result.isConfirmed) {
                await router.post(
                    '/logout',
                    {},
                    {
                        onSuccess: () => router.reload({ only: ['auth'] }),
                        onError: () => console.error('ERROR'),
                    },
                );
            }
        },
        changeLanguage(code) {
            localStorage.setItem('locale', code);
            window.$i18n.locale = code;
            this.$root.$i18n.locale = code;
            this.locale = code;
            window.locale = code;

            this.currentLanguage = code;
            this.languageMenuOpen = false;
        },
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
        this.user = usePage().props.auth.user;
        router.on('success', (event) => {
            if (event.detail.page.props.auth) {
                this.$forceUpdate();
            }
        });
    },
    beforeUnmount() {
        document.removeEventListener('click', this.handleClickOutside);
        router.off('success');
    },
};
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.navComponent {
    background-color: #121212;
    color: white;
    width: 100%;
    height: 67px;
    border-bottom: 1px solid #2e2e2e;
    font-family: 'Orbitron', sans-serif;

    .navBar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        flex-wrap: wrap;

        &__logo {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;

            img {
                width: 24px;
                height: 24px;
            }

            h1 {
                font-size: 1.5rem;
                margin: 0;
                color: $main-color;
                text-shadow: 1px 1px 2px #000;
            }

            transition: all 0.4s ease-in-out;
            &:hover {
                transform: scale(1.1);
            }

            @media (max-width: 432px) {
                display: none;
            }
        }

        &__toggle {
            display: none;
            background: none;
            color: white;
            font-size: 1.5rem;
            border: none;
            cursor: pointer;

            @media (max-width: 1200px) {
                display: block;
            }
        }

        &__links {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            z-index: 100;
            width: 10%;

            li a {
                color: white;
                text-decoration: none;
                font-size: 1rem;
                transition: color 0.3s ease-in-out;

                &:hover {
                    color: $main-color;
                }
            }

            @media (max-width: 1200px) {
                flex-direction: column;
                width: 100%;
                margin-top: 1rem;
                display: none;

                &--open {
                    display: flex;
                    margin-bottom: 30px;
                    background-color: #000;
                    padding: 1rem;
                    border-radius: 0 0 10px 10px;
                }
            }
        }

        &__user {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;

            .userMenu {
                position: absolute;
                top: 2rem;
                right: 0;
                background-color: #1c1c1c;
                border: 1px solid #2e2e2e;
                border-radius: 0.5rem;
                min-width: 160px;
                padding: 0.5rem 0;
                margin-top: 0.25rem;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                z-index: 1000;

                li {
                    padding: 0.5rem 1rem;
                    list-style: none;
                    position: relative;

                    a {
                        color: white;
                        padding: 0.5rem;
                        border-radius: 5px;
                        text-decoration: none;
                        font-size: 0.9rem;
                        display: block;
                        transition: background 0.2s;

                        &:hover {
                            background-color: $main-color;
                            color: black;
                        }

                        &.active {
                            background-color: rgba($main-color, 0.7);
                            color: black;
                        }
                    }
                }

                .languageMenuItem {
                    cursor: pointer;

                    .languageTrigger {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 0.5rem;
                        border-radius: 5px;
                        transition: background 0.2s;

                        &:hover {
                            background-color: rgba(255, 255, 255, 0.1);
                        }
                    }

                    .languageDropdownIcon {
                        transition: transform 0.3s;
                        font-size: 0.7rem;
                        margin-left: 0.5rem;

                        &.open {
                            transform: rotate(180deg);
                        }
                    }

                    .languageDropdown {
                        list-style: none;
                        padding: 0.5rem 0;
                        margin: 0.5rem -0.5rem -0.5rem -0.5rem;
                        background-color: #252525;
                        border-radius: 0 0 5px 5px;
                        gap: 10px;

                        li {
                            padding: 0;

                            .languageLink {
                                padding: 0.5rem 1rem;
                                display: block;

                                &:hover {
                                    background-color: $main-color;
                                }
                            }
                        }
                    }
                }
            }

            .userName {
                cursor: pointer;
                padding: 0.2rem 0.4rem;
                border-radius: 4px;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                gap: 0.3rem;

                &:hover {
                    background-color: rgba(255, 255, 255, 0.774);
                }

                .dropdownIcon {
                    transition: transform 0.3s;
                    display: inline-block;
                    font-size: 0.7rem;

                    &.open {
                        transform: rotate(180deg);
                    }
                }
            }
        }

        .authButtons {
            display: flex;
            gap: 1rem;
        }

        .authBtn {
            background-color: #1c1c1c;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;

            &:hover {
                background-color: $main-color;
            }
        }
    }
}

.languageDropdownGuest {
    position: absolute;
    top: 70px;
    right: 2rem;
    background-color: #1c1c1c;
    border: 1px solid #2e2e2e;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    list-style: none;
    padding: 0.5rem 0;
    margin: 0;
    z-index: 1000;
    min-width: 160px;

    li {
        padding: 0;

        .languageLink {
            display: block;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            border-radius: 5px;
            margin: 10px;

            &:hover {
                background-color: $main-color;
                color: black;
            }

            &.active {
                background-color: rgba($main-color, 0.7);
                color: black;
            }
        }
    }
}

.swal-cancel-btn {
    transition: all 0.4s ease;
    &:hover {
        background-color: #A1001EFF;
    }
}


</style>
