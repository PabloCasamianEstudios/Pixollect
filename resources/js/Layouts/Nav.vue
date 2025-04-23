<template>

    <div>
        <header class="navComponent">
            <nav class="navBar">
                <div class="navBar__logo">
                    <h1>Pixollect</h1>
                    <img
                        src="../../../public/images/icon.png"
                        alt="Pixollect"
                        width="20px"
                        height="20px"
                    />
                </div>

                <ul class="navBar__links">
                    <li>
                        <Link href="/">HOME</Link>
                    </li>
                    <li>
                        <Link href="/welcome">GAMES</Link>
                    </li>
                    <li>
                        <Link href="/about">COLLECTIONS</Link>
                    </li>
                    <li>
                        <Link href="/about">RECOMMEND</Link>
                    </li>
                    <li>
                        <Link href="/about">COMPARE</Link>
                    </li>
                </ul>
                <div class="navBar__user">USERNAME</div>
            </nav>
        </header>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.navComponent {
    background-color: $main-color;
    color: white;
    display: flex;
    align-items: center;
    // DIMENSIONES
    width: auto;
    min-width: max-content;
    .navBar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        width: 100%;

        &__logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            h1 {
                font-size: 1.5rem;
                font-weight: bold;
            }
        }

        &__links {
            display: flex;
            list-style: none;

            li {
                margin: 0 1rem;

                a {
                    color: white;
                    text-decoration: none;
                    font-size: 1rem;
                    transition: color 0.3s;

                    &:hover {
                        color: $main-color;
                    }
                }
            }
        }

        &__user {
            font-size: 1rem;
            font-weight: bold;
        }

    }
}
</style>
