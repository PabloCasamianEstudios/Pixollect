<template>
    <div class="user-profile-container">
        <div class="profile-header">
            <img
                :src="user.avatar_url || '/images/default-avatar.png'"
                class="profile-avatar"
                alt="User avatar"
            />
            <div class="profile-info">
                <h1>{{ user.name }}</h1>
                <p class="role-badge">{{ user.role.toUpperCase() }}</p>
            </div>
        </div>

        <div class="profile-tabs">
            <Link
                :href="`/user/${user.name}`"
                :class="{ 'active-tab': $page.url === `/user/${user.id}` }"
            >
                PROFILE
            </Link>
            <Link
                :href="`/user/${user.name}/games`"
                :class="{
                    'active-tab': $page.url === `/user/${user.name}/games`,
                }"
            >
                COLLECTION
            </Link>
            <Link
                :href="`/user/${user.name}/achievements`"
                :class="{
                    'active-tab': $page.url === `/user/${user.name}/achievements`,
                }"
            >
                ACHIEVEMENTS
            </Link>
        </div>

        <div class="profile-content">
            <slot />
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: { Link },
    props: {
        user: Object,
    },
};
</script>

<style lang='scss' scoped>
@use '../../css/variables.scss' as *;

.user-profile-container {
    max-width: 1200px;
    margin: 0 auto;
    background: #1a1a1a;
    color: white;
}

.profile-header {
    display: flex;
    align-items: center;
    padding: 2rem;
    gap: 2rem;
    background: linear-gradient(to right, #121212, #1e1e1e);
    border-bottom: 1px solid #333;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid $main-color;
}

.profile-info h1 {
    margin: 0;
    font-size: 2rem;
    color: $main-color;
    text-transform: uppercase;
}

.role-badge {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    background: rgba(255, 0, 64, 0.1);
    border-radius: 4px;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.profile-tabs {
    display: flex;
    border-bottom: 1px solid #333;
    background: #121212;
}

.profile-tabs a {
    padding: 1rem 2rem;
    color: #aaa;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
    transition: all 0.3s;
}

.profile-tabs a:hover {
    color: white;
    background: rgba(255, 255, 255, 0.05);
}

.active-tab {
    color: $main-color;
    position: relative;
}

.active-tab::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background: $main-color;
}

.profile-content {
    padding: 2rem;
}
</style>
