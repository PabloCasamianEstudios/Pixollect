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
                    <li><LinkTo href="/">HOME</LinkTo></li>
                    <li><LinkTo href="/welcome">GAMES</LinkTo></li>
                    <li><LinkTo href="/about">COLLECTIONS</LinkTo></li>
                    <li><LinkTo href="/about">RECOMMEND</LinkTo></li>
                    <li><LinkTo href="/about">COMPARE</LinkTo></li>
                </ul>

                <div
                    class="navBar__user"
                    ref="userMenuRef"
                    @click="toggleUserMenu"
                >
                    <button class="logoutBtn" @click.stop="logout">⛔</button>
                    <span class="userName">
                        USERNAME
                        <span
                            class="dropdownIcon"
                            :class="{ open: userMenuOpen }"
                            >▼</span
                        >
                    </span>

                    <ul v-if="userMenuOpen" class="userMenu">
                        <li>
                            <LinkTo href="/profile/edit">EDIT PROFILE</LinkTo>
                        </li>
                        <li>
                            <LinkTo href="/profile/stats">USER STATS</LinkTo>
                        </li>
                        <li>
                            <LinkTo href="/profile/settings"
                                >CONFIGURATION</LinkTo
                            >
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>
</template>

<script>
import { Link as LinkTo } from '@inertiajs/vue3';

export default {
    components: {
        LinkTo,
    },
    data() {
        return {
            menuOpen: false,
            userMenuOpen: false,
        };
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },
        toggleUserMenu() {
            this.userMenuOpen = !this.userMenuOpen;
        },
        handleClickOutside(e) {
            if (
                this.$refs.userMenuRef &&
                !this.$refs.userMenuRef.contains(e.target)
            ) {
                this.userMenuOpen = false;
            }
        },
        logout() {
            console.log('Logout');
        },
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener('click', this.handleClickOutside);
    },
};
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.navComponent {
    background-color: #121212;
    color: white;
    width: 100%;
    border-bottom: 1px solid #2e2e2e;
    font-family: 'Orbitron', sans-serif;

    .navBar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        flex-wrap: wrap;

        &__logo {
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
        }

        &__toggle {
            display: none;
            background: none;
            color: white;
            font-size: 1.5rem;
            border: none;
            cursor: pointer;

            @media (max-width: 768px) {
                display: block;
            }
        }

        &__links {
            display: flex;
            list-style: none;
            gap: 1.5rem;

            li a {
                color: white;
                text-decoration: none;
                font-size: 1rem;
                transition: color 0.3s ease-in-out;

                &:hover {
                    color: $main-color;
                }
            }

            @media (max-width: 768px) {
                flex-direction: column;
                width: 100%;
                margin-top: 1rem;
                display: none;

                &--open {
                    display: flex;
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
                    }
                }
            }

            .logoutBtn {
                background-color: #e53935;
                border: none;
                color: white;
                padding: 0.3rem 0.6rem;
                margin-right: 0.5rem;
                border-radius: 6px;
                font-weight: bold;
                cursor: pointer;
                transition: background 0.2s;
                font-size: 0.9rem;

                &:hover {
                    background-color: #c62828;
                }
            }
            .userName {
                cursor: pointer;
                padding: 0.2rem 0.4rem;
                border-radius: 4px;
                transition: background 0.2s;
                display: flex;
                align-items: center;
                gap: 0.3rem;

                &:hover {
                    background-color: rgba(255, 255, 255, 0.1);
                }

                .dropdownIcon {
                    transition: transform 0.3s;
                    display: inline-block;

                    &.open {
                        transform: rotate(180deg); // o usa ▲ si prefieres
                    }
                }
            }
        }
    }
}
</style>
